<?php

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
	var $Section;
	var $SectionGroup;
	
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign('SECTION_RSS',true);
		$MySmartBB->template->assign('SECTION_ID',$MySmartBB->_GET['id']);
		
		$MySmartBB->functions->ShowHeader('تصفح منتدى');
		
		/** Browse the forum **/
		if ($MySmartBB->_GET['show'])
		{
			$this->_BrowseForum();
		}
		/** **/
		elseif ($MySmartBB->_GET['password_check'])
		{
			$this->_PasswordCheck();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	/**
	 * Get all things about section , subjects of the sections , announcement and sub sections to show it
	 * Yes it's long list :\
	 */
	function _BrowseForum()
	{
		global $MySmartBB;
		
		$this->_GeneralProcesses();
		
		$this->_SectionOnline();
		
		$this->_GetModeratorsList();
		
		$this->_GetAnnouncementList();
		
		$this->_GetSubSection();
		
		$this->_GetSubjectList();
		
		$this->_CallTemplate();
	}
	
	function _PasswordCheck()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['password']))
		{
			$MySmartBB->functions->error('يجب عليك كتابة الكلمه السريه حتى يتم فحصها');
		}
		
		$this->_GeneralProcesses(true);
		
		$PassArr 				= 	array();
     	$PassArr['id'] 			= 	$this->Section['id'];
     	$PassArr['password'] 	= 	$MySmartBB->_POST['password'];
     	
     	$IsTruePassword = $MySmartBB->section->CheckPassword($PassArr);
     																		
     	if (!$IsTruePassword)
     	{
     		$MySmartBB->functions->error('المعذره .. كلمة المرور غير صحيحه');
     	}
     	else
     	{
     		$MySmartBB->functions->msg('يرجى الانتظار ...');
     		$MySmartBB->functions->goto('index.php?page=forum&amp;show=1&amp;id=' . $this->Section['id'] . '&amp;password=' . base64_encode($MySmartBB->_POST['password']));
     	}
	}
	
	function _GeneralProcesses($check=false)
	{
		global $MySmartBB;
		
		// Clean id from any strings
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		// No _GET['id'] , so ? show a small error :)
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		// Get section information and set it in $this->Section
		$SecArr 			= 	array();
		$SecArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$this->Section = $MySmartBB->section->GetSectionInfo($SecArr);
		
		// Clear section information from any denger
		$MySmartBB->functions->CleanVariable($this->Section,'html');
		
		$MySmartBB->template->assign('section_info',$this->Section);
		
		// Temporary array to save the parameter of GetSectionGroupList() in nice way
		$SecGroupArr 						= 	array();
		$SecGroupArr['where'] 				= 	array();
		
		$SecGroupArr['where'][0]			=	array(	'name' 	=> 'section_id',
														'oper'	=>	'=',
														'value'	=>	$this->Section['id']);
		
		$SecGroupArr['where'][1]			=	array();
		$SecGroupArr['where'][1]['con']		=	'AND';
		$SecGroupArr['where'][1]['name']	=	'group_id';
		$SecGroupArr['where'][1]['oper']	=	'=';
		$SecGroupArr['where'][1]['value']	=	$MySmartBB->_CONF['group_info']['id'];
		
			
		// Ok :) , the permssion for this visitor/member in this section
		$this->SectionGroup = $MySmartBB->group->GetSectionGroupInfo($SecGroupArr);
					
		// This section isn't exists
		if (!$this->Section)
		{
			$MySmartBB->functions->error('القسم المطلوب غير موجود');
		}	
		
		// This member can't view this section
		if ($this->SectionGroup['view_section'] != 1)
		{
			$MySmartBB->functions->error('المعذره ... غير مسموح لك بعرض هذا القسم');
		}
			
		// This is main section , so we can't get subjects list from it 
		if ( isset( $this->Section[ 'main_section' ] )
			and $this->Section[ 'main_section' ] )
		{
			$MySmartBB->functions->error('المعذره .. هذا المنتدى قسم رئيسي');
		}
		
		// This section is link , so we should go to another site
		if ($this->Section['linksection'])
		{
			$MySmartBB->functions->msg('يرجى الانتظار سوف يتم تحويلك إلى ' . $this->Section['linksite']);
			$MySmartBB->functions->goto($this->Section['linksite'],3);
			$MySmartBB->functions->stop();
		}
		
		// hmmmm , this section protect by password so request the password
		if (!$check)
		{
			if (!empty($this->Section['section_password']) 
				and !$MySmartBB->_CONF['group_info']['admincp_allow'])
			{
     			if (empty($MySmartBB->_GET['password']))
        		{
      				$MySmartBB->template->display('forum_password');
      				$MySmartBB->functions->stop();
     			}
     			else
     			{
     				$PassArr = array();
     				$PassArr['id'] 			= 	$this->Section['id'];
     				$PassArr['password'] 	= 	base64_decode($MySmartBB->_GET['password']);
     			
     				$IsTruePassword = $MySmartBB->section->CheckPassword($PassArr);
     																		
     				if (!$IsTruePassword)
     				{
     					$MySmartBB->functions->error('المعذره .. كلمة المرور غير صحيحه');
     				}
     				
     				$MySmartBB->_CONF['template']['password'] = '&amp;password=' . $MySmartBB->_GET['password'];
     			}
     		}
     	}
     	
     	if ($MySmartBB->_CONF['member_permission'])
     	{
     		$UpdateOnline 			= 	array();
			$UpdateOnline['field']	=	array();
			
			$UpdateOnline['field']['user_location']		=	'يطلع على : ' . $this->Section['title'];
			$UpdateOnline['where']						=	array('username',$MySmartBB->_CONF['member_row']['username']);
			
			$update = $MySmartBB->online->UpdateOnline($UpdateOnline);
     	}
	}
		
	/**
	 * Know who is in section ?
	 */
	function _SectionOnline()
	{
		global $MySmartBB;
		
		// Finally we get Who is in section
		$SecArr 						= 	array();
		$SecArr['proc'] 				= 	array();
		$SecArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		$SecArr['where']				=	array();
		
		$SecArr['where'][0]				=	array();
		$SecArr['where'][0]['name'] 	= 	'path';
		$SecArr['where'][0]['oper'] 	= 	'=';
		$SecArr['where'][0]['value'] 	= 	$MySmartBB->_SERVER['QUERY_STRING'];
		
		$SecArr['order'] 				= 	array();
		$SecArr['order']['field'] 		= 	'user_id';
		$SecArr['order']['type'] 		= 	'DESC';
		
		$x = 1;
		
		if (!$MySmartBB->_CONF['info_row']['show_onlineguest'])
		{
			$SecArr['where'][$x]				=	array();
			$SecArr['where'][$x]['con']			=	'AND';
			$SecArr['where'][$x]['name']		=	'username';
			$SecArr['where'][$x]['oper']		=	'<>';
			$SecArr['where'][$x]['value']		=	'Guest';
			
			$x += 1;
		}
		
		// This member can't see hidden member
		if (!$MySmartBB->_CONF['group_info']['show_hidden'])
		{
			$SecArr['where'][$x] 			= 	array();
			$SecArr['where'][$x]['con'] 	= 	'AND';
			$SecArr['where'][$x]['name'] 	= 	'hide_browse';
			$SecArr['where'][$x]['oper'] 	= 	'<>';
			$SecArr['where'][$x]['value'] 	= 	'1';
		}
		
		$MySmartBB->_CONF['template']['while']['SectionVisitor'] = $MySmartBB->online->GetOnlineList($SecArr);
		
		$GuestNumberArr 						= 	array();
		$GuestNumberArr['where'] 				= 	array();
		
		$GuestNumberArr['where'][0] 			= 	array();
		$GuestNumberArr['where'][0]['name'] 	= 	'username';
		$GuestNumberArr['where'][0]['oper'] 	= 	'=';
		$GuestNumberArr['where'][0]['value'] 	= 	'Guest';
		
		$GuestNumberArr['where'][1] 			= 	array();
		$GuestNumberArr['where'][1]['con'] 		= 	'AND';
		$GuestNumberArr['where'][1]['name'] 	= 	'path';
		$GuestNumberArr['where'][1]['oper'] 	= 	'=';
		$GuestNumberArr['where'][1]['value'] 	= 	$MySmartBB->_SERVER['QUERY_STRING'];
		
		$MySmartBB->_CONF['template']['GuestNumber'] = $MySmartBB->online->GetOnlineNumber($GuestNumberArr);
		
		$MemberNumberArr 						= 	array();
		$MemberNumberArr['where'] 				= 	array();
		
		$MemberNumberArr['where'][0] 			= 	array();
		$MemberNumberArr['where'][0]['name'] 	= 	'username';
		$MemberNumberArr['where'][0]['oper'] 	= 	'<>';
		$MemberNumberArr['where'][0]['value'] 	= 	'Guest';
		
		$MemberNumberArr['where'][1] 			= 	array();
		$MemberNumberArr['where'][1]['con'] 	= 	'AND';
		$MemberNumberArr['where'][1]['name'] 	= 	'path';
		$MemberNumberArr['where'][1]['oper'] 	= 	'=';
		$MemberNumberArr['where'][1]['value'] 	= 	$MySmartBB->_SERVER['QUERY_STRING'];
		
		$MySmartBB->_CONF['template']['MemberNumber'] = $MySmartBB->online->GetOnlineNumber($MemberNumberArr);
	}
	
	function _GetModeratorsList()
	{
		global $MySmartBB;
		
		$ModArr 			= 	array();
		$ModArr['where'] 	= 	array('section_id',$this->Section['id']);
		
		$MySmartBB->_CONF['template']['while']['ModeratorsList'] = $MySmartBB->moderator->GetModeratorList($ModArr);
		
		if (is_array($MySmartBB->_CONF['template']['while']['ModeratorsList'])
			and sizeof($MySmartBB->_CONF['template']['while']['ModeratorsList']) > 0)
		{			
			$MySmartBB->template->assign('STOP_MODERATOR_TEMPLATE',false);
		}
		else
		{
			$MySmartBB->template->assign('STOP_MODERATOR_TEMPLATE',true);
		}
	}
	
	/**
	 * Get announcement list
	 */
	function _GetAnnouncementList()
	{
		global $MySmartBB;
		
		$AnnArr 					= 	array();
		
		$AnnArr['proc'] 			= 	array();
		$AnnArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		$AnnArr['proc']['date'] 	= 	array('method'=>'date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		
		$AnnArr['order']			=	array();
		$AnnArr['order']['field']	=	'id';
		$AnnArr['order']['type']	=	'DESC';
		
		$AnnArr['limit']			=	'1';
		
		$MySmartBB->_CONF['template']['while']['AnnouncementList'] = $MySmartBB->announcement->GetAnnouncementList($AnnArr); 
		
		if ($MySmartBB->_CONF['template']['while']['AnnouncementList'] != false)
		{
			$MySmartBB->template->assign('STOP_ANNOUNCEMENT_TEMPLATE',false);
		}
		else
		{
			$MySmartBB->template->assign('STOP_ANNOUNCEMENT_TEMPLATE',true);
		}
	}
	
	function _GetSubSection()
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
		
	function _GetSubjectList()
	{
		global $MySmartBB;
		
		/**
		 * Ok , are you ready to get subjects list ? :)
		 */
		$TotalArr 				= 	array();
		$TotalArr['get_from'] 	= 	'db';
		$TotalArr['where'] 		= 	array('section',$this->Section['id']);
		
		$SubjectArr = array();
		
		$SubjectArr['where'] 				= 	array();
		
		$SubjectArr['where'][0] 			= 	array();
		$SubjectArr['where'][0]['name'] 	= 	'section';
		$SubjectArr['where'][0]['oper'] 	= 	'=';
		$SubjectArr['where'][0]['value'] 	= 	$this->Section['id'];
		
		$SubjectArr['where'][1] 			= 	array();
		$SubjectArr['where'][1]['con']		=	'AND';
		$SubjectArr['where'][1]['name'] 	= 	'stick';
		$SubjectArr['where'][1]['oper'] 	= 	'<>';
		$SubjectArr['where'][1]['value'] 	= 	'1';
		
		$SubjectArr['where'][2] 			= 	array();
		$SubjectArr['where'][2]['con']		=	'AND';
		$SubjectArr['where'][2]['name'] 	= 	'delete_topic';
		$SubjectArr['where'][2]['oper'] 	= 	'<>';
		$SubjectArr['where'][2]['value'] 	= 	'1';
		
		$SubjectArr['where'][2] 			= 	array();
		$SubjectArr['where'][2]['con']		=	'AND';
		$SubjectArr['where'][2]['name'] 	= 	'review_subject';
		$SubjectArr['where'][2]['oper'] 	= 	'<>';
		$SubjectArr['where'][2]['value'] 	= 	'1';
		
		if ($this->Section['hide_subject'] 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{			
			$SubjectArr['where'][3] 			= 	array();
			$SubjectArr['where'][3]['con'] 		= 	'AND';
			$SubjectArr['where'][3]['name'] 	= 	'writer';
			$SubjectArr['where'][3]['oper'] 	= 	'=';
			$SubjectArr['where'][3]['value'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		}
		
		$SubjectArr['order'] = array();
		
		if ($this->Section['subject_order'] == 2)
		{
			$SubjectArr['order']['field'] 	= 	'id';
			$SubjectArr['order']['type'] 	= 	'DESC';
		}
		elseif ($this->Section['subject_order'] == 3)
		{
			$SubjectArr['order']['field'] 	= 	'id';
			$SubjectArr['order']['type'] 	= 	'ASC';
		}
		else
		{
			$SubjectArr['order']['field'] 	= 	'write_time';
			$SubjectArr['order']['type'] 	= 	'DESC';
		}
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$SubjectArr['proc'] 						= 	array();
		// Ok Mr.XSS go to hell !
		$SubjectArr['proc']['*'] 					= 	array('method'=>'clean','param'=>'html'); 
		$SubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$SubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		
		// Pager setup
		$SubjectArr['pager'] 				= 	array();
		$SubjectArr['pager']['total']		= 	$MySmartBB->subject->GetSubjectNumber($TotalArr);
		$SubjectArr['pager']['perpage'] 	= 	$MySmartBB->_CONF['info_row']['subject_perpage'];
		$SubjectArr['pager']['count'] 		= 	$MySmartBB->_GET['count'];
		$SubjectArr['pager']['location'] 	= 	'index.php?page=forum&amp;show=1&amp;id=' . $this->Section['id'];
		$SubjectArr['pager']['var'] 		= 	'count';
		
		$MySmartBB->_CONF['template']['while']['subject_list'] = $MySmartBB->subject->GetSubjectList($SubjectArr);
		
		//////////
		
		$StickSubjectArr = array();
		
		$StickSubjectArr['where'] 				= 	array();
		
		$StickSubjectArr['where'][0] 			= 	array();
		$StickSubjectArr['where'][0]['name'] 	= 	'section';
		$StickSubjectArr['where'][0]['oper'] 	= 	'=';
		$StickSubjectArr['where'][0]['value'] 	= 	$this->Section['id'];
		
		$StickSubjectArr['where'][1] 			= 	array();
		$StickSubjectArr['where'][1]['con']		=	'AND';
		$StickSubjectArr['where'][1]['name'] 	= 	'stick';
		$StickSubjectArr['where'][1]['oper'] 	= 	'=';
		$StickSubjectArr['where'][1]['value'] 	= 	'1';
		
		$StickSubjectArr['where'][2] 			= 	array();
		$StickSubjectArr['where'][2]['con']		=	'AND';
		$StickSubjectArr['where'][2]['name'] 	= 	'delete_topic';
		$StickSubjectArr['where'][2]['oper'] 	= 	'<>';
		$StickSubjectArr['where'][2]['value'] 	= 	'1';
		
		$StickSubjectArr['order'] = array();
		$StickSubjectArr['order']['field'] 	= 	'write_time';
		$StickSubjectArr['order']['type'] 	= 	'DESC';
		
		$StickSubjectArr['proc'] 						= 	array();
		// Ok Mr.XSS go to hell !
		$StickSubjectArr['proc']['*'] 					= 	array('method'=>'clean','param'=>'html'); 
		$StickSubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$StickSubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		
		$MySmartBB->_CONF['template']['while']['stick_subject_list'] = $MySmartBB->subject->GetSubjectList($StickSubjectArr);
		
		if (sizeof($MySmartBB->_CONF['template']['while']['stick_subject_list']) <= 0)
		{
			$MySmartBB->template->assign('NO_STICK_SUBJECTS',true);
		}
		else
		{
			$MySmartBB->template->assign('NO_STICK_SUBJECTS',false);
		}
		
		//////////
		
		// Get the list of subjects that need review
		
		if ($MySmartBB->functions->ModeratorCheck($this->Section['id']))
		{
			$ReviewSubjectArr = array();

			$ReviewSubjectArr['where'] 				= 	array();

			$ReviewSubjectArr['where'][0] 			= 	array();
			$ReviewSubjectArr['where'][0]['name'] 	= 	'section';
			$ReviewSubjectArr['where'][0]['oper'] 	= 	'=';
			$ReviewSubjectArr['where'][0]['value'] 	= 	$this->Section['id'];

			$ReviewSubjectArr['where'][1] 			= 	array();
			$ReviewSubjectArr['where'][1]['con']	=	'AND';
			$ReviewSubjectArr['where'][1]['name'] 	= 	'review_subject';
			$ReviewSubjectArr['where'][1]['oper'] 	= 	'=';
			$ReviewSubjectArr['where'][1]['value'] 	= 	'1';

			$ReviewSubjectArr['where'][2] 			= 	array();
			$ReviewSubjectArr['where'][2]['con']	=	'AND';
			$ReviewSubjectArr['where'][2]['name'] 	= 	'delete_topic';
			$ReviewSubjectArr['where'][2]['oper'] 	= 	'<>';
			$ReviewSubjectArr['where'][2]['value'] 	= 	'1';

			$ReviewSubjectArr['order'] 				= 	array();
			$ReviewSubjectArr['order']['field'] 	= 	'write_time';
			$ReviewSubjectArr['order']['type'] 		= 	'DESC';

			$ReviewSubjectArr['proc'] 						= 	array();
			// Ok Mr.XSS go to hell !
			$ReviewSubjectArr['proc']['*'] 					= 	array('method'=>'clean','param'=>'html');
			$ReviewSubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
			$ReviewSubjectArr['proc']['write_time'] 		= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);

			$MySmartBB->_CONF['template']['while']['review_subject_list'] = $MySmartBB->subject->GetSubjectList($ReviewSubjectArr);

			if (sizeof($MySmartBB->_CONF['template']['while']['review_subject_list']) <= 0)
			{
				$MySmartBB->template->assign('NO_REVIEW_SUBJECTS',true);
			}
			else
			{
				$MySmartBB->template->assign('NO_REVIEW_SUBJECTS',false);
			}
		}
		else
		{
			$MySmartBB->template->assign('NO_REVIEW_SUBJECTS',true);
		}
		
		//////////
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		$MySmartBB->template->assign('section_id',$this->Section['id']);
	}
	
	function _CallTemplate()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('forum');
	}
}

?>
