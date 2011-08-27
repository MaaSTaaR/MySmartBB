<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartTopicMOD');

class MySmartTopicMOD
{
	private $Info;
	private $SectionInfo;
	private $SectionGroup;
	private $RInfo;
	private $x = 0;
	private $reply_number = 0;
	private $moderator;
	
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('عرض موضوع');
		
		$MySmartBB->load( 'moderator,reply,subject' );
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_getSubject();
			$this->_getSection();
			$this->_moderatorCheck();
			$this->_getGroup();
			$this->_checkSystem();
			$this->_getWriterInfo();
			$this->_checkTags();
			$this->_checkPoll();
			$this->_subjectTextFormat();
			$this->_subjectEnd();
			$this->_getReply();
		
			if ($MySmartBB->_CONF['info_row']['samesubject_show'])
			{
				$this->_sameTopics();
			}
		
			// The End of page
			$this->_pageEnd();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _getSubject()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره المسار المتبع غير صحيح');
		}
		
		// ... //
		
		// Get the subject and the subject's writer information
		$this->Info = $MySmartBB->subject->getSubjectWriterInfo( $MySmartBB->_GET['id'] );
		
		if (!$this->Info)
		{
			$MySmartBB->func->error('المعذره، الموضوع المطلوب غير موجود');
		}

		$this->Info['subject_id'] = $MySmartBB->_GET['id'];
		
		// ... //
		
		if ($this->Info['delete_topic'] 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			$MySmartBB->func->error('الموضوع المطلوب منقول إلى سلّة المحذوفات');
		}
		
		// ... //
		
		$MySmartBB->func->CleanArray( $this->Info, 'sql' );
		
		// ... //

		$MySmartBB->template->assign('subject_id',$MySmartBB->_GET['id']);
		$MySmartBB->template->assign('section_id',$this->Info['section']);
		
		// ... //
		
		if ($MySmartBB->_CONF['member_permission'])
     	{
     		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
			$MySmartBB->rec->fields = array(	'user_location'	=>	'يطلع على الموضوع : ' . $this->Info['title']	);
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
			
			$update = $MySmartBB->rec->update();
     	}
     	
     	// ... //
	}
		
	private function _getSection()
	{
		global $MySmartBB;
		
     	$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $this->Info['section'] . "'";
		
		$this->SectionInfo = $MySmartBB->rec->getInfo();
		
		$MySmartBB->func->cleanArray( $this->SectionInfo, 'sql' );
		
		$MySmartBB->template->assign('section_info',$this->SectionInfo);
	}
	
	private function _moderatorCheck()
	{
		global $MySmartBB;
		
		$this->moderator = $MySmartBB->func->moderatorCheck( $MySmartBB->_GET['id'] );
		
		$MySmartBB->template->assign('Mod',$this->moderator);
	}
	
	private function _getGroup()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->SectionInfo['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		$this->SectionGroup = $MySmartBB->rec->getInfo();
	}
		
	private function _checkSystem()
	{
		global $MySmartBB;
		
		if (!$this->SectionGroup['view_section'])
		{
			$MySmartBB->func->error('المعذره لا يمكنك عرض هذا الموضوع');
		}

		if ($MySmartBB->_CONF['member_row']['username'] != $this->Info['writer'])
		{
			$MySmartBB->subject->updateSubjectVisits( $this->Info['visitor'], $MySmartBB->_GET['id'] );
		}
			
		// We have password in the subject's section , so check the password
		if (!empty($this->SectionInfo['section_password']) 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			// The visitor don't give me password , so require it
     		if (empty($MySmartBB->_GET['password']))
        	{
      			$MySmartBB->template->display('forum_password');
      			$MySmartBB->func->stop();
     		}
     		// The visitor give me password , so check
     		elseif (!empty($MySmartBB->_GET['password']))
     		{
     			$IsTruePassword = $MySmartBB->section->CheckPassword( base64_decode($MySmartBB->_GET['password']), $this->SectionInfo['id'] );
     			
     			// Stop ! it's don't true password															
     			if (!$IsTruePassword)
     			{
     				$MySmartBB->func->error('المعذره .. كلمة المرور غير صحيحه');
     			}
     			
     			$MySmartBB->_CONF['template']['password'] = '&amp;password=' . $MySmartBB->_GET['password'];
     		}
     	}
	}
		
	private function _getWriterInfo()
	{
		global $MySmartBB;
		
		if (is_numeric($this->Info['register_date']))
		{
			$this->Info['register_date'] = $MySmartBB->func->date($this->Info['register_date']);
		}
		
		// Make writer's gender as readable text
		$this->Info['user_gender'] 	= 	str_replace('m','ذكر',$this->Info['user_gender']);
		$this->Info['user_gender'] 	= 	str_replace('f','انثى',$this->Info['user_gender']);

		// Is writer online ?
		$CheckOnline = ($this->Info['logged'] < $MySmartBB->_CONF['timeout']) ? false : true;
		
		// If the member is online , so store that in status variable					
		($CheckOnline) ? $MySmartBB->template->assign('status',"<font class='online'>متصل</font>") : $MySmartBB->template->assign('status',"<font class='offline'>غير متصل</font>");
		
		//$MySmartBB->smartparse->replace_smiles($this->Info['away_msg']);
		
		if (empty($this->Info['username_style_cache']))
		{
			$this->Info['display_username'] = $this->Info['username'];
		}
		else
		{
			$this->Info['display_username'] = $this->Info['username_style_cache'];
			$this->Info['display_username'] = $MySmartBB->func->cleanVariable($this->Info['display_username'],'unhtml');
		}
	}
	
	private function _checkTags()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['res']['tags_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'tag_subject' ];
		$MySmartBB->rec->filter = "subject_id='" . $MySmartBB->_GET['id'] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['tags_res'];
		
		$MySmartBB->rec->getList();
			
		// Aha, there are tags in this subject
		/*if ($MySmartBB->_CONF['template']['while']['tags'] != false)
		{
			$MySmartBB->template->assign('SHOW_TAGS',true);
		}
		else
		{
			$MySmartBB->template->assign('SHOW_TAGS',false);
		}*/
	}
	
	private function _checkPoll()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'poll' ];
		$MySmartBB->rec->filter = "subject_id='" . $MySmartBB->_GET['id'] . "'";
		
		$Poll = $MySmartBB->rec->getInfo();
		
		// Aha, there is a poll in this subject
		if ($Poll != false)
		{
			$MySmartBB->template->foreach_array['answers'] = $Poll['answers'];
			
			unset($Poll['answers']);
			
			$MySmartBB->template->assign('Poll',$Poll);
			$MySmartBB->template->assign('SHOW_POLL',true);
		}
		else
		{
			$MySmartBB->template->assign('SHOW_POLL',false);
		}
	}
		
	private function _subjectTextFormat()
	{
		global $MySmartBB;
		
		// The visitor come from search engine , I don't mean Google :/ I mean the local search engine
		// so highlight the key word
		if (!empty($MySmartBB->_GET['highlight']))
		{
			$this->Info['text'] = str_replace($MySmartBB->_GET['highlight'],"<font class='highlight'>" . $MySmartBB->_GET['highlight'] . "</font>",$this->Info['text']);
		}
		
		if ($this->SectionInfo['usesmartcode_allow'])
		{
			$this->Info['text'] = $MySmartBB->smartparse->replace($this->Info['text']);
		}
		else
		{
			$this->Info['text'] = nl2br($this->Info['text']);
		}
		
		$MySmartBB->smartparse->replace_smiles($this->Info['text']);
	}
		
	private function _subjectEnd()
	{
		global $MySmartBB;
		
		// We have attachment in this subject
		if ($this->Info['attach_subject'])
		{
			$MySmartBB->_CONF['template']['res']['attach_res'] = '';
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
			$MySmartBB->rec->filter = "subject_id='" . $MySmartBB->_GET['id'] . "'";
			$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['attach_res'];
			
			// Get the attachment information
			$MySmartBB->rec->getList();
			
			/*if ($MySmartBB->_CONF['template']['while']['AttachList'] != false)
			{
				$MySmartBB->template->assign('ATTACH_SHOW',true);
				
				$MySmartBB->func->CleanVariable($MySmartBB->_CONF['template']['while']['AttachList'],'html');
			}*/
		}
			
		// The writer signture isn't empty 
		if (!empty($this->Info['user_sig']))
		{
			$this->Info['user_sig'] = $MySmartBB->smartparse->replace($this->Info['user_sig']);
			$MySmartBB->smartparse->replace_smiles($this->Info['user_sig']);
		}
		
		// ... //
		
		$topic_date = $MySmartBB->func->date($this->Info['native_write_time']);
		$topic_time = $MySmartBB->func->time($this->Info['native_write_time']);
		
		$this->Info['native_write_time'] = $topic_date . ' ; ' . $topic_time;
		
		// Finally $this->Info to templates
		$MySmartBB->template->assign('Info',$this->Info);
		
		// Show subject
		$MySmartBB->template->display('show_subject');
	}
	
	private function _getReply()
	{
		global $MySmartBB;
				
		// Show the replies
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->filter = "subject_id='" . $this->Info['subject_id'] . "' AND delete_topic<>'1'";
		
		$reply_number = $MySmartBB->rec->getNumber();
		
		// ... //
		
		// Pager setup
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$reply_number;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=topic&amp;show=1&amp;id=' . $this->Info['subject_id'];
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->filter = "delete_topic<>'1'";
		
		$MySmartBB->reply->getReplyWriterInfo( $this->Info['subject_id'] );
		
		$n = sizeof($this->RInfo);
		$this->x = 0;
		
		//while ($n > $this->x)
		while ( $this->RInfo = $MySmartBB->rec->getInfo() )
		{
			// Get the replier info
			$this->__getReplierInfo();
			
			// Make reply text as a nice format
			$this->__replyFormat();
			
			// The end of reply
			$this->__replyEnd();
		}
	}
	
	private function __getReplierInfo()
	{
		global $MySmartBB;
		
		// Make register date in nice format to show it
		if (is_numeric($this->RInfo['register_date']))
		{
			$this->RInfo['register_date'] = $MySmartBB->func->date($this->RInfo['register_date']);
		}
		
		// Make member gender as a readable text
		$this->RInfo['user_gender'] 	= 	str_replace('m','ذكر',$this->RInfo['user_gender']);
		$this->RInfo['user_gender'] 	= 	str_replace('f','انثى',$this->RInfo['user_gender']);
				
		$CheckOnline = ($this->RInfo['logged'] < $MySmartBB->_CONF['timeout']) ? false : true;
											
		($CheckOnline) ? $MySmartBB->template->assign('status',"<font class='online'>متصل</font>") : $MySmartBB->template->assign('status',"<font class='offline'>غير متصل</font>");
		
		$MySmartBB->smartparse->replace_smiles($this->RInfo['away_msg']);
		
		if (empty($this->RInfo['username_style_cache']))
		{
			$this->RInfo['display_username'] = $this->RInfo['username'];
		}
		else
		{
			$this->RInfo['display_username'] = $this->RInfo['username_style_cache'];
			
			$this->RInfo['display_username'] = $MySmartBB->func->cleanVariable($this->RInfo['display_username'],'unhtml');
		}
		
		$this->RInfo['reply_number'] = $this->reply_number;
		
		$this->reply_number += 1;
	}
		
	private function __replyFormat()
	{
		global $MySmartBB;
		
		// If the SmartCode is allow , use it
		if ($this->SectionInfo['usesmartcode_allow'])
		{
			$this->RInfo['text'] = $MySmartBB->smartparse->replace($this->RInfo['text']);
		}
		// It's not allow , don't use it
		else
		{
			$this->RInfo['text'] = nl2br($this->RInfo['text']);
		}
		
		// Convert the smiles to image
		$MySmartBB->smartparse->replace_smiles($this->RInfo['text']);
			
		// Member signture is not empty , show make it nice with SmartCode
		if (!empty($this->RInfo['user_sig']))
		{
			$this->RInfo['user_sig'] = $MySmartBB->smartparse->replace($this->RInfo['user_sig']);
			$MySmartBB->smartparse->replace_smiles($this->RInfo['user_sig']);
		}
	}
		
	private function __replyEnd()
	{
		global $MySmartBB;
					
		$reply_date = $MySmartBB->func->date($this->RInfo['write_time']);
		$reply_time = $MySmartBB->func->time($this->RInfo['write_time']);
		
		$this->RInfo['write_time'] = $reply_date . ' ; ' . $reply_time;
		
		// We have attachment in this reply
		if ($this->RInfo['attach_reply'])
		{
			$MySmartBB->_CONF['template']['res']['reply_attach_res'] = '';
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
			$MySmartBB->rec->filter = "subject_id='" . $this->RInfo['reply_id'] . "' AND reply='1'";
			$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['reply_attach_res'];
			
			// Get the attachment information
			$MySmartBB->rec->getList();
		}
		
		// $RInfo to templates
		$MySmartBB->template->assign('Info',$this->RInfo);
		$MySmartBB->template->assign('section',$this->Info['section']);
		
		// $x = $x + 1
		$this->x += 1;
		
		// Show the reply :)
		$MySmartBB->template->display('show_reply');
	}
	
	private function _sameTopics()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['res']['same_subjects_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "title LIKE '%" . $this->Info['title'] . "%' AND delete_topic<>'1' AND id<>'" . $this->Info['subject_id'] . "'";
		$MySmartBB->rec->order = 'write_time DESC';
		$MySmartBB->rec->limit = '5';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['same_subjects_res'];
		
		$MySmartBB->rec->getList();
	}
	
	private function _pageEnd()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->func->getEditorTools();
		
     	$MySmartBB->template->assign('id',$MySmartBB->_GET['id']);
     	
     	$MySmartBB->template->assign('Admin',$this->moderator);
     	
     	$MySmartBB->template->assign('stick',$this->Info['stick']);
     	$MySmartBB->template->assign('close',$this->Info['close']);
     	
     	$MySmartBB->template->display('topic_end');
	}
}

?>
