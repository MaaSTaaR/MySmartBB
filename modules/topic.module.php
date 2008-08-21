<?php

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

include('common.php');

define('CLASS_NAME','MySmartTopicMOD');

class MySmartTopicMOD
{
	var $Info;
	var $SectionInfo;
	var $SectionGroup;
	var $RInfo;
	var $x = 0;
	
	/**
	 * The main function , will require from kernel file "index.php"
	 */
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('عرض موضوع');
		
		// Show the topic
		if ($MySmartBB->_GET['show'])
		{
			$this->_ShowTopic();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		// Can live without footer :) ?
		$MySmartBB->functions->GetFooter();
	}
	
	function _ShowTopic()
	{
		// Get subject information
		$this->__GetSubject();
		
		// Get subject's section information
		$this->__GetSection();
		
		$this->__ModeratorCheck();
			
		// Get visitor/member group info 
		$this->__GetGroup();
		
		// Check about everything
		$this->__CheckSystem();
		
		// Get subject's writer information
		$this->__GetWriterInfo();
		
		$this->__CheckTags();
		
		$this->__CheckPoll();
		
		// Make subject text as a nice text
		$this->__SubjectTextFormat();
		
		// Show subject
		$this->__SubjectEnd();
		
		// Get the replies
		$this->__GetReply();
		
		// The End of page
		$this->__PageEnd();
	}
	
	function __GetSubject()
	{
		global $MySmartBB;
		
		//////////
		
		// Clean id from any string, that will protect us
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
			
		// If the id is empty, so stop the page
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره المسار المتبع غير صحيح');
		}
		
		//////////
		
		// Get the subject and the subject's writer information
		$this->Info = $MySmartBB->subject->GetSubjectWriterInfo(array('id'	=>	$MySmartBB->_GET['id']));
		
		// There is no subject, so show error message
		if (!$this->Info)
		{
			$MySmartBB->functions->error('المعذره، الموضوع المطلوب غير موجود');
		}
		
		// The ID of subject
		$this->Info['id'] = $MySmartBB->_GET['id'];
		
		//////////
		
		// hmmmmmmm , this subject deleted , so the members and visitor can't show it
		if ($this->Info['delete_topic'] 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			$MySmartBB->functions->error('الموضوع المطلوب منقول إلى سلّة المحذوفات');
		}
		
		//////////
		
		// Kill XSS
		$MySmartBB->functions->CleanVariable($this->Info,'html');
		// Kill SQL Injection
		$MySmartBB->functions->CleanVariable($this->Info,'sql');
		
		//////////
		
		// Send subject id to template engine
		$MySmartBB->template->assign('subject_id',$MySmartBB->_GET['id']);
		
		//////////
	}
		
	function __GetSection()
	{
		global $MySmartBB;
		
		/** Get the section information **/
		$SecArr 			= 	array();
		$SecArr['where'] 	= 	array('id',$this->Info['section']);
		
		$this->SectionInfo = $MySmartBB->section->GetSectionInfo($SecArr);
		
		// Kill XSS
		$MySmartBB->functions->CleanVariable($this->SectionInfo,'html');
		// Kill SQL Injection
		$MySmartBB->functions->CleanVariable($this->SectionInfo,'sql');
		/** **/
		
		$MySmartBB->template->assign('section_info',$this->SectionInfo);
	}
	
	function __ModeratorCheck()
	{
		global $MySmartBB;
		
		$Mod = false;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			if ($MySmartBB->_CONF['group_info']['admincp_allow'] 
				or $MySmartBB->_CONF['group_info']['vice'])
			{
				$Mod = true;
			}
			else
			{
				if (isset($this->SectionInfo))
				{
					$ModArr = array();
					$ModArr['username'] 	= 	$MySmartBB->_CONF['member_row']['username'];
					$ModArr['section_id']	=	$this->SectionInfo['id'];
				
					$Mod = $MySmartBB->moderator->IsModerator($ModArr);
				}
			}
		}
		
		$MySmartBB->template->assign('Mod',$Mod);
	}
	
	function __GetGroup()
	{
		global $MySmartBB;
				
		/** Get section's group information and make some checks **/
		$SecGroupArr 						= 	array();
		$SecGroupArr['where'] 				= 	array();
		$SecGroupArr['where'][0]			=	array();
		$SecGroupArr['where'][0]['name'] 	= 	'section_id';
		$SecGroupArr['where'][0]['value'] 	= 	$this->SectionInfo['id'];
		$SecGroupArr['where'][1]			=	array();
		$SecGroupArr['where'][1]['con']		=	'AND';
		$SecGroupArr['where'][1]['name']	=	'group_id';
		$SecGroupArr['where'][1]['value']	=	$MySmartBB->_CONF['group_info']['id'];
			
		// Finally get the permissions of group
		$this->SectionGroup = $MySmartBB->group->GetSectionGroupInfo($SecGroupArr);
	}
		
	function __CheckSystem()
	{
		global $MySmartBB;
		
		// The visitor can't show this section , so stop the page
		if (!$this->SectionGroup['view_section'])
		{
			$MySmartBB->functions->error('المعذره لا يمكنك عرض هذا الموضوع');
		}
		/** **/
		
		// If the member isn't the writer , so register a new visit for the subject
		if ($MySmartBB->_CONF['member_row']['username'] != $this->Info['writer'])
		{
			$UpdateArr 				= 	array();
			$UpdateArr['visitor'] 	= 	$this->Info['visitor'];
			$UpdateArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
			
			$NewVisitor = $MySmartBB->subject->UpdateSubjectVisitor($UpdateArr);
		}
			
		// We have password in the subject's section , so check the password
		if (!empty($this->SectionInfo['section_password']) 
			and !$MySmartBB->_CONF['rows']['group_info']['admincp_allow'])
		{
			// The visitor don't give me password , so require it
     		if (empty($MySmartBB->_GET['password']))
        	{
      			$MySmartBB->template->display('forum_password');
      			$MySmartBB->functions->stop();
     		}
     		// The visitor give me password , so check
     		elseif (!empty($MySmartBB->_GET['password']))
     		{
     			$PassArr = array();
     			
     			// Section id
     			$PassArr['id'] 		= $this->SectionInfo['id'];
     			
     			// The password to check
     			$PassArr['password'] 	= base64_decode($MySmartBB->_GET['password']);
     			
     			$IsTruePassword = $MySmartBB->section->CheckPassword($PassArr);
     			
     			// Stop ! it's don't true password															
     			if (!$IsTruePassword)
     			{
     				$MySmartBB->functions->error('المعذره .. كلمة المرور غير صحيحه');
     			}
     			
     			$MySmartBB->_CONF['template']['password'] = '&amp;password=' . $MySmartBB->_GET['password'];
     		}
     	}
	}
		
	function __GetWriterInfo()
	{
		global $MySmartBB;
		
		// Make register date in nice format to show it
		if (is_numeric($this->Info['register_date']))
		{
			$this->Info['register_date'] = $MySmartBB->functions->date($this->Info['register_date']);
		}
		
		// Make writer gender as readable text
		$this->Info['user_gender'] 	= 	str_replace('m','ذكر',$this->Info['user_gender']);
		$this->Info['user_gender'] 	= 	str_replace('f','انثى',$this->Info['user_gender']);

		// Is writer online ?
		$CheckOnline = ($this->Info['logged'] < $MySmartBB->_CONF['timeout']) ? false : true;
		
		// If the member is online , so store that in status variable					
		($CheckOnline) ? $MySmartBB->template->assign('status',"<font class='online'>متصل</font>") : $MySmartBB->template->assign('status',"<font class='offline'>غير متصل</font>");
	}
	
	function __CheckTags()
	{
		global $MySmartBB;
		
		$TagArr 			= 	array();
		$TagArr['where'] 	= 	array('subject_id',$MySmartBB->_GET['id']);
		
		$MySmartBB->_CONF['template']['while']['tags'] = $MySmartBB->tag->GetSubjectList($TagArr);
		
		// Aha, there are tags in this subject
		if ($MySmartBB->_CONF['template']['while']['tags'] != false)
		{
			$MySmartBB->template->assign('SHOW_TAGS',true);
		}
		else
		{
			$MySmartBB->template->assign('SHOW_TAGS',false);
		}
	}
	
	function __CheckPoll()
	{
		global $MySmartBB;
		
		$PollArr 			= 	array();
		$PollArr['where'] 	= 	array('subject_id',$MySmartBB->_GET['id']);
		
		$Poll = $MySmartBB->poll->GetPollInfo($PollArr);
		
		// Aha, there is poll in this subject
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
		
	function __SubjectTextFormat()
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
		
	function __SubjectEnd()
	{
		global $MySmartBB;
		
		// We have attachment in this subject
		if ($this->Info['attach_subject'])
		{
			$AttachInfoArr = array();
			
			$AttachInfoArr['way'] 	= 	'subject';
			$AttachInfoArr['id']	= 	$MySmartBB->_GET['id'];
			
			// Get the attachment information
			$MySmartBB->_CONF['template']['AttachInfo'] = $MySmartBB->attach->GetAttachInfo($AttachInfoArr);
			
			if ($MySmartBB->_CONF['template']['AttachInfo'] != false)
			{
				$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['AttachInfo'],'html');
			}
		}
			
		// The writer signture isn't empty 
		if (!empty($this->Info['user_sig']))
		{
			// So , use the SmartCode in it
			$this->Info['user_sig'] = $MySmartBB->smartparse->replace($this->Info['user_sig']);
			$MySmartBB->smartparse->replace_smiles($this->Info['user_sig']);
		}
		
		$topic_date = $MySmartBB->functions->date($this->Info['native_write_time']);
		$topic_time = $MySmartBB->functions->time($this->Info['native_write_time']);
		
		$this->Info['native_write_time'] = $topic_date . ' ; ' . $topic_time;
		
		// Finally $this->Info to templates
		$MySmartBB->template->assign('Info',$this->Info);
		
		// Show subject
		$MySmartBB->template->display('show_subject');
	}
	
	function __GetReply()
	{
		global $MySmartBB;
				
		// Show the replies
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$ReplyNumArr 					= 	array();
		$ReplyNumArr['get_from'] 		= 	'db';
		
		$ReplyNumArr['where'] 		= 	array('subject_id',$this->Info['id']);
		/*
		$ReplyNumArr['where'][1] 			= 	array();
		$ReplyNumArr['where'][1]['con']		=	'AND';
		$ReplyNumArr['where'][1]['name']	=	'delete_topic';
		$ReplyNumArr['where'][1]['oper']	=	'<>';
		$ReplyNumArr['where'][1]['value']	=	'1';
		*/
		$ReplyArr = array();
		
		$ReplyArr['proc'] 				= 	array();
		$ReplyArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html'); 
		
		// Pager setup
		$ReplyArr['pager'] 				= 	array();
		$ReplyArr['pager']['total']		= 	$MySmartBB->reply->GetReplyNumber($ReplyNumArr);
		$ReplyArr['pager']['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$ReplyArr['pager']['count'] 	= 	$MySmartBB->_GET['count'];
		$ReplyArr['pager']['location'] 	= 	'index.php?page=topic&amp;show=1&amp;id=' . $this->Info['id'];
		$ReplyArr['pager']['var'] 		= 	'count';
		
		/*$ReplyArr['where'][0] 			= 	array();
		$ReplyArr['where'][0]['name']	=	'delete_topic';
		$ReplyArr['where'][0]['oper']	=	'<>';
		$ReplyArr['where'][0]['value']	=	'1';
		*/
		$ReplyArr['subject_id'] 		= 	$this->Info['id'];

		$this->RInfo = $MySmartBB->reply->GetReplyWriterInfo($ReplyArr);
		
		// Kill XSS
		$MySmartBB->functions->CleanVariable($this->RInfo,'html');
		
		$n = sizeof($this->RInfo);
		$this->x = 0;
		
		// Nice loop :D
		while ($n > $this->x)
		{
			// Get the replier info
			$this->___GetReplierInfo();
			
			// Make reply text as a nice format
			$this->___ReplyFormat();
			
			// The end of reply
			$this->___ReplyEnd();
		}
	}
	
	function ___GetReplierInfo()
	{
		global $MySmartBB;
		
		// Make register date in nice format to show it
		if (is_numeric($this->RInfo[$this->x]['register_date']))
		{
			$this->RInfo[$this->x]['register_date'] = $MySmartBB->functions->date($this->RInfo[$this->x]['register_date']);
		}
		
		// Make member gender as a readable text
		$this->RInfo[$this->x]['user_gender'] 	= 	str_replace('m','ذكر',$this->RInfo[$this->x]['user_gender']);
		$this->RInfo[$this->x]['user_gender'] 	= 	str_replace('f','انثى',$this->RInfo[$this->x]['user_gender']);
				
		$CheckOnline = ($this->RInfo[$this->x]['logged'] < $MySmartBB->_CONF['timeout']) ? false : true;
											
		($CheckOnline) ? $MySmartBB->template->assign('status',"<font class='online'>متصل</font>") : $MySmartBB->template->assign('status',"<font class='offline'>غير متصل</font>");
	}
		
	function ___ReplyFormat()
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
		
	function ___ReplyEnd()
	{
		global $MySmartBB;
					
		$reply_date = $MySmartBB->functions->date($this->RInfo[$this->x]['write_time']);
		$reply_time = $MySmartBB->functions->time($this->RInfo[$this->x]['write_time']);
		
		$this->RInfo[$this->x]['write_time'] = $reply_date . ' ; ' . $reply_time;
		
		// $RInfo to templates
		$MySmartBB->template->assign('Info',$this->RInfo[$this->x]);
		$MySmartBB->template->assign('section',$this->Info['section']);
		
		// $x = $x + 1
		$this->x += 1;
		
		// Show the reply :)
		$MySmartBB->template->display('show_reply');
	}			
	
	function __PageEnd()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->functions->GetEditorTools();
		
     	$MySmartBB->template->assign('id',$MySmartBB->_GET['id']);
     	
     	$MySmartBB->template->display('topic_end');
	}
}

?>
