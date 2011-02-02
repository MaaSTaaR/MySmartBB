<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['ATTACH'] 		= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;
$CALL_SYSTEM['ICONS'] 		= 	true;
$CALL_SYSTEM['TOOLBOX'] 	= 	true;
$CALL_SYSTEM['MODERATORS'] 	= 	true;
$CALL_SYSTEM['POLL'] 		= 	true;
$CALL_SYSTEM['TAG'] 		= 	true;

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
		
		$MySmartBB->func->ShowHeader('عرض موضوع');
		
		// Show the topic
		if ($MySmartBB->_GET['show'])
		{
			// Get subject information
			$this->_getSubject();
		
			// Get subject's section information
			$this->_getSection();
		
			$this->_moderatorCheck();
			
			// Get visitor/member group info 
			$this->_getGroup();
		
			// Check about everything
			$this->_checkSystem();
		
			// Get subject's writer information
			$this->_getWriterInfo();
		
			$this->_checkTags();
		
			$this->_checkPoll();
		
			// Make subject text as a nice text
			$this->_subjectTextFormat();
		
			// Show subject
			$this->_subjectEnd();
		
			// Get the replies
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
		
		/* ... */
		
		// Clean id from any string, that will protect us
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		// If the id is empty stop the page
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره المسار المتبع غير صحيح');
		}
		
		/* ... */
		
		// Get the subject and the subject's writer information
		$this->Info = $MySmartBB->subject->getSubjectWriterInfo( $MySmartBB->_GET['id'] );
		
		// There is no subject, so show error message
		if (!$this->Info)
		{
			$MySmartBB->func->error('المعذره، الموضوع المطلوب غير موجود');
		}
		
		// The ID of subject
		$this->Info['subject_id'] = $MySmartBB->_GET['id'];
		
		/* ... */
		
		// hmmmmmmm , this subject deleted , so the members and visitor can't show it
		if ($this->Info['delete_topic'] 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			$MySmartBB->func->error('الموضوع المطلوب منقول إلى سلّة المحذوفات');
		}
		
		/* ... */
		
		// Kill SQL Injection
		$MySmartBB->func->CleanArray( $this->Info, 'sql' );
		
		/* ... */
		
		// Send subject id to template engine
		$MySmartBB->template->assign('subject_id',$MySmartBB->_GET['id']);
		$MySmartBB->template->assign('section_id',$this->Info['section']);
		
		/* ... */
		
		// Where is the member now?
		if ($MySmartBB->_CONF['member_permission'])
     	{
			$MySmartBB->rec->fields = array(	'user_location'	=>	'يطلع على الموضوع : ' . $this->Info['title']	);
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
			
			$update = $MySmartBB->online->updateOnline();
     	}
     	
     	/* ... */
	}
		
	private function _getSection()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->filter = "id='" . $this->Info['section'] . "'";
		
		$this->SectionInfo = $MySmartBB->section->getSectionInfo();
		
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
		
		$MySmartBB->rec->filter = "section_id='" . $this->SectionInfo['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		$this->SectionGroup = $MySmartBB->group->getSectionGroupInfo();
	}
		
	private function _checkSystem()
	{
		global $MySmartBB;
		
		// The visitor can't show this section , so stop the page
		if (!$this->SectionGroup['view_section'])
		{
			$MySmartBB->func->error('المعذره لا يمكنك عرض هذا الموضوع');
		}
		
		// If the member isn't the writer , so register a new visit for the subject
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
		
		// Make register date in nice format to show it
		if (is_numeric($this->Info['register_date']))
		{
			$this->Info['register_date'] = $MySmartBB->func->date($this->Info['register_date']);
		}
		
		// Make writer gender as readable text
		$this->Info['user_gender'] 	= 	str_replace('m','ذكر',$this->Info['user_gender']);
		$this->Info['user_gender'] 	= 	str_replace('f','انثى',$this->Info['user_gender']);

		// Is writer online ?
		$CheckOnline = ($this->Info['logged'] < $MySmartBB->_CONF['timeout']) ? false : true;
		
		// If the member is online , so store that in status variable					
		($CheckOnline) ? $MySmartBB->template->assign('status',"<font class='online'>متصل</font>") : $MySmartBB->template->assign('status',"<font class='offline'>غير متصل</font>");
		
		$MySmartBB->smartparse->replace_smiles($this->Info['away_msg']);
		
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
		
		$MySmartBB->rec->filter = "subject_id='" . $MySmartBB->_GET['id'] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['tags_res'];
		
		$MySmartBB->tag->getSubjectList();
		
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
		
		$MySmartBB->rec->filter = "subject_id='" . $MySmartBB->_GET['id'] . "'";
		
		$Poll = $MySmartBB->poll->getPollInfo();
		
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
		
		// If the SmartCode is allow , so use it :)
		if ($this->SectionInfo['usesmartcode_allow'])
		{
			$this->Info['text'] = $MySmartBB->smartparse->replace($this->Info['text']);
		}
		// The SmartCode isn't allow , don't use it :(
		else
		{
			$this->Info['text'] = nl2br($this->Info['text']);
		}
		
		// Convert smiles in subject to nice images :)
		$MySmartBB->smartparse->replace_smiles($this->Info['text']);
	}
		
	private function _subjectEnd()
	{
		global $MySmartBB;
		
		// We have attachment in this subject
		if ($this->Info['attach_subject'])
		{
			$MySmartBB->_CONF['template']['res']['attach_res'] = '';
			
			$MySmartBB->rec->filter = "subject_id='" . $MySmartBB->_GET['id'] . "'";
			$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['attach_res'];
			
			// Get the attachment information
			$MySmartBB->attach->getAttachList();
			
			/*if ($MySmartBB->_CONF['template']['while']['AttachList'] != false)
			{
				$MySmartBB->template->assign('ATTACH_SHOW',true);
				
				$MySmartBB->func->CleanVariable($MySmartBB->_CONF['template']['while']['AttachList'],'html');
			}*/
		}
			
		// The writer signture isn't empty 
		if (!empty($this->Info['user_sig']))
		{
			// So , use the SmartCode in it
			$this->Info['user_sig'] = $MySmartBB->smartparse->replace($this->Info['user_sig']);
			$MySmartBB->smartparse->replace_smiles($this->Info['user_sig']);
		}
		
		if (!empty($this->Info['subject_sig']))
		{
			// So , use the SmartCode in it
			$this->Info['subject_sig'] = $MySmartBB->smartparse->replace($this->Info['subject_sig']);
			$MySmartBB->smartparse->replace_smiles($this->Info['subject_sig']);
		}
		
		/** TODO:: Why??? **/
		if (!empty($this->Info['reply_sig']))
		{
			// So , use the SmartCode in it
			$this->Info['reply_sig'] = $MySmartBB->smartparse->replace($this->Info['reply_sig']);
			$MySmartBB->smartparse->replace_smiles($this->Info['reply_sig']);
		}
		
		/* ... */
		
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
		
		/* ... */
		
		$MySmartBB->rec->filter = "subject_id='" . $this->Info['subject_id'] . "' AND delete_topic<>'1'";
		
		$reply_number = $MySmartBB->reply->getReplyNumber();
		
		/* ... */
		
		// Pager setup
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$reply_number;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=topic&amp;show=1&amp;id=' . $this->Info['subject_id'];
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->filter = "delete_topic<>'1'";
		
		$this->RInfo = $MySmartBB->reply->getReplyWriterInfo( $this->Info['subject_id'] );
		
		$n = sizeof($this->RInfo);
		$this->x = 0;
		
		while ($n > $this->x)
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
		if (is_numeric($this->RInfo[$this->x]['register_date']))
		{
			$this->RInfo[$this->x]['register_date'] = $MySmartBB->func->date($this->RInfo[$this->x]['register_date']);
		}
		
		// Make member gender as a readable text
		$this->RInfo[$this->x]['user_gender'] 	= 	str_replace('m','ذكر',$this->RInfo[$this->x]['user_gender']);
		$this->RInfo[$this->x]['user_gender'] 	= 	str_replace('f','انثى',$this->RInfo[$this->x]['user_gender']);
				
		$CheckOnline = ($this->RInfo[$this->x]['logged'] < $MySmartBB->_CONF['timeout']) ? false : true;
											
		($CheckOnline) ? $MySmartBB->template->assign('status',"<font class='online'>متصل</font>") : $MySmartBB->template->assign('status',"<font class='offline'>غير متصل</font>");
		
		$MySmartBB->smartparse->replace_smiles($this->RInfo[$this->x]['away_msg']);
		
		if (empty($this->RInfo[$this->x]['username_style_cache']))
		{
			$this->RInfo[$this->x]['display_username'] = $this->RInfo[$this->x]['username'];
		}
		else
		{
			$this->RInfo[$this->x]['display_username'] = $this->RInfo[$this->x]['username_style_cache'];
			
			$this->RInfo[$this->x]['display_username'] = $MySmartBB->func->cleanVariable($this->RInfo[$this->x]['display_username'],'unhtml');
		}
		
		$this->RInfo[$this->x]['reply_number'] = $this->reply_number;
		
		$this->reply_number += 1;
	}
		
	private function __replyFormat()
	{
		global $MySmartBB;
		
		// If the SmartCode is allow , use it
		if ($this->SectionInfo['usesmartcode_allow'])
		{
			$this->RInfo[$this->x]['text'] = $MySmartBB->smartparse->replace($this->RInfo[$this->x]['text']);
		}
		// It's not allow , don't use it
		else
		{
			$this->RInfo[$this->x]['text'] = nl2br($this->RInfo[$this->x]['text']);
		}
		
		// Convert the smiles to image
		$MySmartBB->smartparse->replace_smiles($this->RInfo[$this->x]['text']);
			
		// Member signture is not empty , show make it nice with SmartCode
		if (!empty($this->RInfo[$this->x]['user_sig']))
		{
			$this->RInfo[$this->x]['user_sig'] = $MySmartBB->smartparse->replace($this->RInfo[$this->x]['user_sig']);
			$MySmartBB->smartparse->replace_smiles($this->RInfo[$this->x]['user_sig']);
		}
	}
		
	private function __replyEnd()
	{
		global $MySmartBB;
					
		$reply_date = $MySmartBB->func->date($this->RInfo[$this->x]['write_time']);
		$reply_time = $MySmartBB->func->time($this->RInfo[$this->x]['write_time']);
		
		$this->RInfo[$this->x]['write_time'] = $reply_date . ' ; ' . $reply_time;
		
		// We have attachment in this reply
		if ($this->RInfo[$this->x]['attach_reply'])
		{
			$MySmartBB->_CONF['template']['res']['reply_attach_res'] = '';
			
			$MySmartBB->rec->filter = "subject_id='" . $this->RInfo[$this->x]['reply_id'] . "' AND reply='1'";
			$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['reply_attach_res'];
			
			// Get the attachment information
			$MySmartBB->attach->getAttachList();
		}
		
		// $RInfo to templates
		$MySmartBB->template->assign('Info',$this->RInfo[$this->x]);
		$MySmartBB->template->assign('section',$this->Info['section']);
		
		// $x = $x + 1
		$this->x += 1;
		
		// Show the reply :)
		$MySmartBB->template->display('show_reply');
	}
	
	private function _sameTopics()
	{
		global $MySmartBB;
		
		/* ... */
		
		$MySmartBB->_CONF['template']['res']['same_subjects_res'] = '';
		
		$MySmartBB->rec->filter = "title LIKE %" . $this->Info['title'] . "% AND delete_topic<>'1' AND id<>'" . $this->Info['subject_id'] . "'";
		$MySmartBB->rec->order = 'write_time DESC';
		$MySmartBB->rec->limit = '5';
		$MySmartBB->rec->reslut = &$MySmartBB->_CONF['template']['res']['same_subjects_res'];
		
		/*$SubjectArr['proc'] 						= 	array();
		$SubjectArr['proc']['*'] 					= 	array('method'=>'clean','param'=>'html'); 
		$SubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$SubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);*/
		
		$MySmartBB->subject->getSubjectList();
		
		/*if (!$MySmartBB->_CONF['template']['while']['SameSubject'])
		{
			$MySmartBB->_CONF['template']['NO_SAME'] = true;
		}*/
	}
	
	private function __pageEnd()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->func->getEditorTools();
		
     	$MySmartBB->template->assign('id',$MySmartBB->_GET['id']);
     	
     	$MySmartBB->template->assign('Admin',$this->moderator);
     	
     	$MySmartBB->template->assign('stick',$this->Info['stick']);
     	$MySmartBB->template->assign('close',$this->Info['close']);
     	$MySmartBB->template->assign('special',$this->Info['special']);
     	
     	$MySmartBB->template->display('topic_end');
	}
}

?>
