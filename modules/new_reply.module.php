<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartReplyAddMOD');

class MySmartReplyAddMOD
{
	private $SectionInfo;
	private $SectionGroup;
	private $SubjectInfo;
	private $moderator = false;
	private $reply_id;
	
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'cache,moderator,reply,section,subject,icon,toolbox,attach,usertitle' );
		
		$MySmartBB->func->showHeader('اضافة رد');
		
		$this->_commonCode();
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_index();
		}
		elseif ($MySmartBB->_GET['start'])
		{
			$this->_start();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		if (!isset($MySmartBB->_POST['ajax']))
		{
			$MySmartBB->func->getFooter();
		}
	}
	
	private function _commonCode()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];

		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !', false);
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$this->SubjectInfo = $MySmartBB->rec->getInfo();

		if ( !$this->SubjectInfo )
		{
			$MySmartBB->func->error( 'المعذره .. الموضوع المطلوب غير موجود', false );
		}
		
		$MySmartBB->func->cleanArray( $this->SubjectInfo, 'sql' );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $this->SubjectInfo['section'] . "'";
		
		$this->SectionInfo = $MySmartBB->rec->getInfo();
		
		$MySmartBB->func->cleanArray( $this->SectionInfo, 'sql' );
		
		// ... //
		
		$this->moderator = $MySmartBB->moderator->moderatorCheck( $this->SectionInfo['id'], $MySmartBB->_CONF['member_row']['username'] );
		
		// ... //

		if ( !$this->moderator )
		{
			if ( $this->SubjectInfo[ 'close' ] )
			{
				$MySmartBB->func->error('المعذره .. هذا الموضوع مغلق', false);
			}
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->SectionInfo['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		$this->SectionGroup = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$this->SectionGroup['view_section']
			or !$this->SectionGroup['write_reply'] )
		{
			$MySmartBB->func->error('المعذره لا يمكنك الكتابه في هذا القسم', false);
		}
		
		// ... //
		
		$MySmartBB->section->forumPassword( $this->SectionInfo[ 'id' ], $this->SectionInfo[ 'section_password' ], $MySmartBB->_GET[ 'password' ] );
		
		// ... //
		
		// Where is the member now?
		$MySmartBB->online->updateMemberLocation( 'يكتب رداً على : ' . $this->SubjectInfo['title'] );
		
		// ... //
		
		$MySmartBB->template->assign('section_info',$this->SectionInfo);
		$MySmartBB->template->assign('subject_info',$this->SubjectInfo);
	}
	
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->template->assign('id',$MySmartBB->_GET['id']);
				
		// Instead of send a whole version of $this->SectionGroup to template engine
		// We just send options which we really need, we use this way to save memory
		$MySmartBB->template->assign('upload_attach',$this->SectionGroup['upload_attach']);
		
		$MySmartBB->template->assign('Admin',$this->moderator);
		
		$MySmartBB->template->display('new_reply');
	}
		
	private function _start()
	{
		global $MySmartBB;
		
		$MySmartBB->_POST['title'] = trim( $MySmartBB->_POST[ 'title' ] );
		$MySmartBB->_POST['text'] = trim( $MySmartBB->_POST[ 'text' ] );
		
		$MySmartBB->func->addressBar('<a href="index.php?page=forum&amp;show=1&amp;id=' . $this->SectionInfo['id'] . $MySmartBB->_CONF['template']['password'] . '">' . $this->SectionInfo['title'] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' <a href="index.php?page=topic&amp;show=1&amp;id=' . $this->SubjectInfo['id'] . $MySmartBB->_CONF['template']['password'] . '">' . $this->SubjectInfo['title'] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية اضافة الرد');
		
		if (empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$this->_checkContextLength();
		
		if ( $this->moderator )
		{
			if ( $MySmartBB->_POST[ 'stick' ] )
			{
				$update = $MySmartBB->subject->stickSubject( $this->SubjectInfo['id'] );
			}
		
			if ( $MySmartBB->_POST[ 'close' ] )
			{
				$update = $MySmartBB->subject->closeSubject( null, $this->SubjectInfo['id'] );
			}
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->fields = array(	'title'			=>	$MySmartBB->_POST['title'],
											'text'			=>	$MySmartBB->_POST['text'],
											'writer'		=>	$MySmartBB->_CONF['member_row']['username'],
											'subject_id'	=>	$this->SubjectInfo['id'],
											'write_time'	=>	$MySmartBB->_CONF['now'],
											'section'		=>	$this->SubjectInfo['section'],
											'icon'			=>	$MySmartBB->_POST['icon']	);
		$MySmartBB->rec->get_id = true;
		
		$insert = $MySmartBB->rec->insert();
		$this->reply_id = $MySmartBB->rec->id;
		
		if ( $insert )
		{
			// ... //
			
			$posts = ( !$this->SectionGroup[ 'no_posts' ] ) ? $MySmartBB->_CONF['member_row']['posts'] + 1 : $MySmartBB->_CONF['member_row']['posts'];
			
			$usertitle = ( $MySmartBB->_CONF['group_info']['usertitle_change'] ) ? $MySmartBB->usertitle->getNewUsertitle( $posts ) : null;
			
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array(	'posts'	=>	$posts,
												'lastpost_time'	=>	$MySmartBB->_CONF['now'],
												'user_title'	=>	(!is_null($usertitle)) ? $usertitle : $MySmartBB->_CONF['member_row']['user_title']	);
			
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
			
   			$UpdateMember = $MySmartBB->rec->update();
			
			// ... //
			
			
			// Upload files
			if ($MySmartBB->_POST['attach'])
			{
				$MySmartBB->attach->uploadAttachments( 	$this->SectionGroup[ 'upload_attach' ], $this->SectionGroup['upload_attach_num'], 
														$this->reply_id, 'files', 'reply' );
			}
			
			// ... //
			
			$this->_updateInformation();
			
			// ... //
			
			$MySmartBB->func->msg( 'تم طرح الرد بنجاح' );
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $this->SubjectInfo['id'] . $MySmartBB->_CONF['template']['password']);
		}
	}
	
	// ... //
	
	private function _checkContextLength()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF['group_info']['admincp_allow'] )
		{
			if (isset($MySmartBB->_POST['title']{$MySmartBB->_CONF['info_row']['post_title_max']+1}))
			{
				$MySmartBB->func->error('عدد حروف عنوان الرد أكبر من (' . $info_row['post_text_max'] . ')');
			}
			
			if (isset($MySmartBB->_POST['text']{$MySmartBB->_CONF['info_row']['post_text_max']+1}))
			{
				$MySmartBB->func->error('عدد حروف الرد أكبر من (' . $MySmartBB->_CONF['info_row']['post_text_max'] . ')');
			}

			if (!isset($MySmartBB->_POST['text']{$MySmartBB->_CONF['info_row']['post_text_min']}))
			{
				$MySmartBB->func->error('عدد حروف الرد أصغر من (' . $MySmartBB->_CONF['info_row']['post_text_min'] . ')');
			}
		}
	}
	
	// ... //
	
	private function _updateInformation()
	{
		global $MySmartBB;
		
		$UpdateWriteTime = $MySmartBB->subject->updateWriteTime( $this->SubjectInfo[ 'id' ] );
			
		// ... //
		
		$MySmartBB->subject->updateReplyNumber( $this->SubjectInfo['id'], $this->SubjectInfo['reply_number'] );
		
		// Update the total of replies in the section
		$MySmartBB->section->updateReplyNumber( $this->SectionInfo['id'], $this->SectionInfo['reply_num'] );
		
		
		// ... //

		$UpdateLast = $MySmartBB->section->updateLastSubject( 	$MySmartBB->_CONF['member_row']['username'], 
																$this->SubjectInfo['title'], 
																$this->SubjectInfo['id'], 
																$MySmartBB->_CONF['date'], 
																(!$this->SectionInfo['sub_section']) ? $this->SectionInfo['id'] : $this->SectionInfo['from_sub_section'] );
		
		// ... //
			
		$UpdateLastReplier = $MySmartBB->subject->updateLastReplier( $MySmartBB->_CONF['member_row']['username'], $this->SubjectInfo['id'] );
		
		// ... //
		
		$update_cache = $MySmartBB->section->updateSectionsCache( $this->SectionInfo['parent'] );
	}
}
	
// Wooooooow , The latest modules of MySmartBB SEGMA 1 :) The THETA stage will come soon ;)
// 11/8/2006 -> 11:21 PM -> MaaSTaaR
	
?>
