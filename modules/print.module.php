<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;
$CALL_SYSTEM['ICONS'] 		= 	true;
$CALL_SYSTEM['MODERATORS'] 	= 	true;
$CALL_SYSTEM['POLL'] 		= 	true;

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPrintMOD');

class MySmartPrintMOD
{
	var $Info;
	var $SectionInfo;
	var $SectionGroup;
	var $RInfo;
	var $x = 0;
	var $reply_number = 0;

	/**
	 * The main function , will require from kernel file "index.php"
	 */
	function run()
	{
		global $MySmartBB;


		// Show the topic
		if ($MySmartBB->_GET['show'])
		{
			$this->_ShowTopic();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
	}

	function _ShowTopic()
	{
		global $MySmartBB;

		// Get subject information
		$this->__GetSubject();

		// Get subject's section information
		$this->__GetSection();

		// Get visitor/member group info
		$this->__GetGroup();

		// Check about everything
		$this->__CheckSystem();

		// Get subject's writer information
		$this->__GetWriterInfo();

		// Make subject text as a nice text
		$this->__SubjectTextFormat();

		// Show subject
		$this->__SubjectEnd();

		// Get the replies
		$this->__GetReply();
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
		$this->Info['subject_id'] = $MySmartBB->_GET['id'];

		//////////

		// Kill XSS
		$MySmartBB->functions->CleanVariable($this->Info,'html');
		// Kill SQL Injection
		$MySmartBB->functions->CleanVariable($this->Info,'sql');

		//////////

		// Send subject id to template engine
		$MySmartBB->template->assign('subject_id',$MySmartBB->_GET['id']);
		$MySmartBB->template->assign('section_id',$this->Info['section']);

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
			$MySmartBB->functions->error('المعذره لا يمكنك طباعة هذا موضوع');
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


		if (empty($this->Info['username_style_cache']))
		{
			$this->Info['display_username'] = $this->Info['username'];
		}
		else
		{
			$this->Info['display_username'] = $this->Info['username_style_cache'];

			$this->Info['display_username'] = $MySmartBB->functions->CleanVariable($this->Info['display_username'],'unhtml');
		}
	}
	
	function __SubjectTextFormat()
	{
		global $MySmartBB;

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

		$topic_date = $MySmartBB->functions->date($this->Info['native_write_time']);
		$topic_time = $MySmartBB->functions->time($this->Info['native_write_time']);

		$this->Info['native_write_time'] = $topic_date . ' ; ' . $topic_time;

		// Finally $this->Info to templates
		$MySmartBB->template->assign('Info',$this->Info);

		// Show subject
		$MySmartBB->template->display('print_subject');
	}

	function __GetReply()
	{
		global $MySmartBB;

		// Show the replies
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];

		$ReplyNumArr 					= 	array();
		$ReplyNumArr['get_from'] 		= 	'db';

		$ReplyNumArr['where'] 		= 	array('subject_id',$this->Info['subject_id']);

		$ReplyNumArr['where'][1] 			= 	array();
		$ReplyNumArr['where'][1]['con']		=	'AND';
		$ReplyNumArr['where'][1]['name']	=	'delete_topic';
		$ReplyNumArr['where'][1]['oper']	=	'<>';
		$ReplyNumArr['where'][1]['value']	=	'1';

		$ReplyArr = array();

		$ReplyArr['proc'] 				= 	array();
		$ReplyArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');

		// Pager setup
		$ReplyArr['pager'] 				= 	array();
		$ReplyArr['pager']['total']		= 	$MySmartBB->reply->GetReplyNumber($ReplyNumArr);
		$ReplyArr['pager']['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$ReplyArr['pager']['count'] 	= 	$MySmartBB->_GET['count'];
		$ReplyArr['pager']['location'] 	= 	'index.php?page=topic&amp;show=1&amp;id=' . $this->Info['subject_id'];
		$ReplyArr['pager']['var'] 		= 	'count';

		$ReplyArr['where']				=	array();
		$ReplyArr['where'][0] 			= 	array();
		$ReplyArr['where'][0]['name']	=	'delete_topic';
		$ReplyArr['where'][0]['oper']	=	'<>';
		$ReplyArr['where'][0]['value']	=	'1';

		$ReplyArr['subject_id'] 		= 	$this->Info['subject_id'];

		$this->RInfo = $MySmartBB->reply->GetReplyWriterInfo($ReplyArr);

		// Kill XSS
		// TODO :: it's better to kill XSS inside the loop
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

		if (empty($this->RInfo[$this->x]['username_style_cache']))
		{
			$this->RInfo[$this->x]['display_username'] = $this->RInfo[$this->x]['username'];
		}
		else
		{
			$this->RInfo[$this->x]['display_username'] = $this->RInfo[$this->x]['username_style_cache'];

			$this->RInfo[$this->x]['display_username'] = $MySmartBB->functions->CleanVariable($this->RInfo[$this->x]['display_username'],'unhtml');
		}

		$this->RInfo[$this->x]['reply_number'] = $this->reply_number;

		$this->reply_number += 1;
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
		$MySmartBB->template->display('print_reply');
	}
}

?>
