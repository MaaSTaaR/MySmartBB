<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['SECTION'] 		= 	true;
$CALL_SYSTEM['ANNOUNCEMENT'] 	= 	true;
$CALL_SYSTEM['SUBJECT'] 		= 	true;
$CALL_SYSTEM['MODERATORS'] 		= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartForumMOD');

class MySmartForumMOD
{
	private $Section;
	private $SectionGroup;
	
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign('SECTION_RSS',true);
		$MySmartBB->template->assign('SECTION_ID',$MySmartBB->_GET['id']);
		
		$MySmartBB->func->ShowHeader('تصفح منتدى');
		
		/** Browse the forum **/
		if ($MySmartBB->_GET['show'])
		{
			$this->_browseForum();
		}
		/** **/
		elseif ($MySmartBB->_GET['password_check'])
		{
			$this->_passwordCheck();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _browseForum()
	{
		global $MySmartBB;
		
		$this->_generalProcesses();
		
		$this->_sectionOnline();
		
		$this->_getModeratorsList();
		
		$this->_getAnnouncementList();
		
		$this->_getSubSection();
		
		$this->_getSubjectList();
		
		$this->_callTemplate();
	}
	
	private function _passwordCheck()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['password']))
		{
			$MySmartBB->func->error('يجب عليك كتابة الكلمه السريه حتى يتم فحصها');
		}
		
		$this->_generalProcesses( true );
		
     	$IsTruePassword = $MySmartBB->section->checkPassword( $MySmartBB->_POST['password'], $this->Section['id'] );
     																		
     	if (!$IsTruePassword)
     	{
     		$MySmartBB->func->error('المعذره .. كلمة المرور غير صحيحه');
     	}
     	else
     	{
     		$MySmartBB->func->msg('يرجى الانتظار ...');
     		$MySmartBB->func->goto('index.php?page=forum&amp;show=1&amp;id=' . $this->Section['id'] . '&amp;password=' . base64_encode($MySmartBB->_POST['password']));
     	}
	}
	
	private function _generalProcesses( $check = false )
	{
		global $MySmartBB;
		
		/* ... */
		
		// Clean id from any strings
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		// No _GET['id'] , so ? show a small error :)
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		/* ... */
		
		// Get section information and set it in $this->Section
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$this->Section = $MySmartBB->section->getSectionInfo();
				
		$MySmartBB->template->assign('section_info',$this->Section);
		
		/* ... */
		
		// This section isn't exists
		if (!$this->Section)
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		/* ... */
		
		$MySmartBB->rec->filter = "section_id='" . $this->Section['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		// Ok :) , the permssion for this visitor/member in this section
		$this->SectionGroup = $MySmartBB->group->GetSectionGroupInfo();
		
		/* ... */
		
		// This member can't view this section
		if ($this->SectionGroup['view_section'] != 1)
		{
			$MySmartBB->func->error('المعذره ... غير مسموح لك بعرض هذا القسم');
		}
			
		// This is main section , so we can't get subjects list from it 
		if ( isset( $this->Section[ 'main_section' ] )
			and $this->Section[ 'main_section' ] )
		{
			$MySmartBB->func->error('المعذره .. هذا المنتدى قسم رئيسي');
		}
		
		// This section is link , so we should go to another site
		if ($this->Section['linksection'])
		{
			$MySmartBB->func->msg('يرجى الانتظار سوف يتم تحويلك إلى ' . $this->Section['linksite']);
			$MySmartBB->func->goto($this->Section['linksite'],3);
			$MySmartBB->func->stop();
		}
		
		/* ... */
		
		// hmmmm , this section protected by a password so request the password
		if ( !$check )
		{
			if (!empty($this->Section['section_password']) 
				and !$MySmartBB->_CONF['group_info']['admincp_allow'])
			{
     			if (empty($MySmartBB->_GET['password']))
        		{
      				$MySmartBB->template->display('forum_password');
      				$MySmartBB->func->stop();
     			}
     			else
     			{
     				$IsTruePassword = $MySmartBB->section->CheckPassword( base64_decode($MySmartBB->_GET['password']), $this->Section['id'] );
     																		
     				if (!$IsTruePassword)
     				{
     					$MySmartBB->func->error('المعذره .. كلمة المرور غير صحيحه');
     				}
     				
     				$MySmartBB->_CONF['template']['password'] = '&amp;password=' . $MySmartBB->_GET['password'];
     			}
     		}
     	}
     	
     	/* ... */
     	
		// Where is the member now?
		if ( $MySmartBB->_CONF['member_permission'] )
     	{
			$MySmartBB->rec->fields = array(	'user_location'	=>	'يطلع على : ' . $this->Section['title']	);
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
			
			$update = $MySmartBB->online->updateOnline();
     	}
	}
		
	/**
	 * Know who is in section ?
	 */
	private function _sectionOnline()
	{
		global $MySmartBB;
		
		/* ... */
		
		$MySmartBB->_CONF['template']['res']['online_res'] = '';
		
		$MySmartBB->rec->filter = "path='" . $MySmartBB->_SERVER['QUERY_STRING'] . "'";
		
		if (!$MySmartBB->_CONF['info_row']['show_onlineguest'])
		{
			$this->rec->filter .= " AND username<>'Guest'";
		}
		
		// This member can't see hidden member
		if (!$MySmartBB->_CONF['group_info']['show_hidden'])
		{
			$this->rec->filter .= " AND hide_browse<>'1'";
		}
		
		$MySmartBB->rec->order = "user_id DESC";
		
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['online_res'];
		
		$MySmartBB->online->getOnlineList();
		
		/* ... */
		
		$MySmartBB->rec->filter = "username='Guest' AND path='" . $MySmartBB->_SERVER['QUERY_STRING'] . "'";
		
		$MySmartBB->_CONF['template']['GuestNumber'] = $MySmartBB->online->getOnlineNumber();
		
		/* ... */
		
		$MySmartBB->rec->filter = "username<>'Guest' AND path='" . $MySmartBB->_SERVER['QUERY_STRING'] . "'";
		
		$MySmartBB->_CONF['template']['MemberNumber'] = $MySmartBB->online->GetOnlineNumber();
		
		/* ... */
	}
	
	private function _getModeratorsList()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['res']['moderator_res'] = '';
		
		$MySmartBB->rec->filter = "section_id='" . $this->Section['id'] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['moderator_res'];
		
		$MySmartBB->moderator->getModeratorList();
		
		/*if (is_array($MySmartBB->_CONF['template']['while']['ModeratorsList'])
			and sizeof($MySmartBB->_CONF['template']['while']['ModeratorsList']) > 0)
		{			
			$MySmartBB->template->assign('STOP_MODERATOR_TEMPLATE',false);
		}
		else
		{
			$MySmartBB->template->assign('STOP_MODERATOR_TEMPLATE',true);
		}*/
	}
	
	/**
	 * Get announcement list
	 */
	private function _getAnnouncementList()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['res']['announcement_res'] = '';
		
		$MySmartBB->rec->order = "id DESC";
		$MySmartBB->rec->limit = '1';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['announcement_res'];
		
		/*$AnnArr['proc'] 			= 	array();
		$AnnArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		$AnnArr['proc']['date'] 	= 	array('method'=>'date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);*/
		
		$MySmartBB->announcement->getAnnouncementList();
		
		/*if ($MySmartBB->_CONF['template']['while']['AnnouncementList'] != false)
		{
			$MySmartBB->template->assign('STOP_ANNOUNCEMENT_TEMPLATE',false);
		}
		else
		{
			$MySmartBB->template->assign('STOP_ANNOUNCEMENT_TEMPLATE',true);
		}*/
	}
	
	private function _getSubSection()
	{
		global $MySmartBB;
		
		if ( !empty( $this->Section[ 'forums_cache' ] ) )
		{
			$forums = unserialize( base64_decode( $this->Section[ 'forums_cache' ] ) );
			
			$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = array();
			
			foreach ( $forums as $forum )
			{
				if ( is_array( $forum[ 'groups' ][ $MySmartBB->_CONF[ 'group_info' ][ 'id' ] ] ) )
				{
					if ( $forum[ 'groups' ][ $MySmartBB->_CONF[ 'group_info' ][ 'id' ] ][ 'view_section' ] )
					{
						$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ][ $forum[ 'id' ] . '_f' ] = $forum;
					}
				} // end if is_array
			} // end foreach ($forums)
			
			$MySmartBB->template->assign('SHOW_SUB_SECTIONS',true);
		}
		else
		{
			$MySmartBB->template->assign('SHOW_SUB_SECTIONS',false);
		}
	}
		
	private function _getSubjectList()
	{
		global $MySmartBB;
		
		/* ... */
		
		$MySmartBB->rec->filter = "section='" . $this->Section[ 'id' ] . "'";
		
		$subject_total = $MySmartBB->subject->getSubjectNumber();
		
		/* ... */
		
		$MySmartBB->rec->filter = "section='" . $this->Section['id'] . "' AND stick<>'1' AND delete_topic<>'1' AND review_subject<>'1'";
		
		if ($this->Section['hide_subject'] 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			$MySmartBB->rec->filter .= " AND writer='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		}
		
		if ($this->Section['subject_order'] == 2)
		{
			$MySmartBB->rec->order = "id DESC";
		}
		elseif ($this->Section['subject_order'] == 3)
		{
			$MySmartBB->rec->order = "id ASC";
		}
		else
		{
			$MySmartBB->rec->order = "write_time DESC";
		}
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];

		/*$SubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$SubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);*/
		
		// Pager setup
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$subject_total;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['subject_perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=forum&amp;show=1&amp;id=' . $this->Section['id'];
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->_CONF['template']['res']['subject_res'] = '';
		
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['subject_res'];
		
		$MySmartBB->subject->getSubjectList();
		
		/* ... */
		
		$MySmartBB->rec->filter = "section='" . $this->Section['id'] . "' AND stick='1' AND delete_topic<>'1'";
		$MySmartBB->rec->order = "write_time DESC";
		
		/*$StickSubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$StickSubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);*/
		
		$MySmartBB->_CONF['template']['res']['stick_subject_res'] = '';
		
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['stick_subject_res'];
		
		$MySmartBB->subject->getSubjectList();
		
		/*if (sizeof($MySmartBB->_CONF['template']['while']['stick_subject_list']) <= 0)
		{
			$MySmartBB->template->assign('NO_STICK_SUBJECTS',true);
		}
		else
		{
			$MySmartBB->template->assign('NO_STICK_SUBJECTS',false);
		}*/
		
		/* ... */
		
		// Get the list of subjects that need a review
		
		if ( $MySmartBB->func->moderatorCheck( $this->Section['id'] ) )
		{
			$MySmartBB->rec->filter = "section='" . $this->Section['id'] . "' AND review_subject='1' AND delete_topic<>'1'";
			$MySmartBB->rec->order = "write_time DESC";
		
			/*$ReviewSubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
			$ReviewSubjectArr['proc']['write_time'] 		= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);*/
			
			$MySmartBB->_CONF['template']['res']['review_subject_res'] = '';
		
			$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['review_subject_res'];
		
			$MySmartBB->subject->getSubjectList();

			/*if (sizeof($MySmartBB->_CONF['template']['while']['review_subject_list']) <= 0)
			{
				$MySmartBB->template->assign('NO_REVIEW_SUBJECTS',true);
			}
			else
			{
				$MySmartBB->template->assign('NO_REVIEW_SUBJECTS',false);
			}*/
		}
		else
		{
			$MySmartBB->template->assign('NO_REVIEW_SUBJECTS',true);
		}
		
		/* ... */
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		$MySmartBB->template->assign('section_id',$this->Section['id']);
	}
	
	private function _callTemplate()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('forum');
	}
}

?>
