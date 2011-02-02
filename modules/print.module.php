<?php

/** PHP5 **/

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
	private $Info;
	private $SectionInfo;
	private $SectionGroup;
	private $RInfo;
	private $x = 0;
	private $reply_number = 0;

	/**
	 * The main function , will require from kernel file "index.php"
	 */
	public function run()
	{
		global $MySmartBB;

		// Show the topic
		if ($MySmartBB->_GET['show'])
		{
			$this->_showTopic();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
	}

	private function _showTopic()
	{
		global $MySmartBB;

		// Get subject information
		$this->__getSubject();

		// Get subject's section information
		$this->__getSection();

		// Get visitor/member group info
		$this->__getGroup();

		// Check about everything
		$this->__checkSystem();

		// Get subject's writer information
		$this->__getWriterInfo();

		// Make subject text as a nice text
		$this->__subjectTextFormat();

		// Show subject
		$this->__subjectEnd();

		// Get the replies
		$this->__getReply();
	}

	private function __getSubject()
	{
		global $MySmartBB;

		/* ... */

		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره المسار المتبع غير صحيح');
		}

		/* ... */

		// Get the subject and the subject's writer information
		// [WE NEED A SYSTEM]
		$this->Info = $MySmartBB->subject->getSubjectWriterInfo( $MySmartBB->_GET['id'] );

		// There is no subject, so show error message
		if (!$this->Info)
		{
			$MySmartBB->func->error('المعذره، الموضوع المطلوب غير موجود');
		}

		// The ID of subject
		$this->Info['subject_id'] = $MySmartBB->_GET['id'];

		/* ... */
		
		$MySmartBB->func->cleanArray( $this->Info, 'sql' );

		/* ... */
		
		$MySmartBB->template->assign('subject_id',$MySmartBB->_GET['id']);
		$MySmartBB->template->assign('section_id',$this->Info['section']);

		/* ... */

	}

	private function __getSection()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $this->Info['section'] . "'";
		
		$this->SectionInfo = $MySmartBB->rec->getInfo();

		$MySmartBB->func->cleanArray($this->SectionInfo,'sql');

		$MySmartBB->template->assign('section_info',$this->SectionInfo);
	}

	private function __getGroup()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->SectionInfo['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
				
		$this->SectionGroup = $MySmartBB->rec->getInfo();
	}

	private function __checkSystem()
	{
		global $MySmartBB;

		if (!$this->SectionGroup['view_section'])
		{
			$MySmartBB->func->error('المعذره لا يمكنك طباعة هذا موضوع');
		}

		// If the member isn't the writer , so register a new visit for the subject
		if ($MySmartBB->_CONF['member_row']['username'] != $this->Info['writer'])
		{
			// [WE NEED A SYSTEM]
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
     			$IsTruePassword = $MySmartBB->section->checkPassword( base64_decode($MySmartBB->_GET['password']), $this->SectionInfo['id'] );

     			// Stop ! it's don't true password
     			if (!$IsTruePassword)
     			{
     				$MySmartBB->func->error('المعذره .. كلمة المرور غير صحيحه');
     			}

     			$MySmartBB->_CONF['template']['password'] = '&amp;password=' . $MySmartBB->_GET['password'];
     		}
     	}
	}

	private function __getWriterInfo()
	{
		global $MySmartBB;

		if (is_numeric($this->Info['register_date']))
		{
			$this->Info['register_date'] = $MySmartBB->func->date($this->Info['register_date']);
		}


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
	
	private function __subjectTextFormat()
	{
		global $MySmartBB;

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

	private function __subjectEnd()
	{
		global $MySmartBB;

		$topic_date = $MySmartBB->func->date($this->Info['native_write_time']);
		$topic_time = $MySmartBB->func->time($this->Info['native_write_time']);

		$this->Info['native_write_time'] = $topic_date . ' ; ' . $topic_time;
		
		$MySmartBB->template->assign('Info',$this->Info);
		
		$MySmartBB->template->display('print_subject');
	}

	private function __getReply()
	{
		global $MySmartBB;

		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->filter = "subject_id='" . $this->Info['subject_id'] . "' AND delete_topic<>'1'";
		
		$reply_number = $MySmartBB->rec->getNumber();

		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$reply_number;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=topic&amp;show=1&amp;id=' . $this->Info['subject_id'];
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->filter = "delete_topic<>'1'";
		
		// [WE NEED A SYSTEM]
		$this->RInfo = $MySmartBB->reply->getReplyWriterInfo( $this->Info['subject_id'] );
		
		$n = sizeof($this->RInfo);
		$this->x = 0;

		while ($n > $this->x)
		{
			$this->___getReplierInfo();
			$this->___replyFormat();
			$this->___replyEnd();
		}
	}

	private function ___getReplierInfo()
	{
		global $MySmartBB;

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

	private function ___replyFormat()
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

	private function ___replyEnd()
	{
		global $MySmartBB;

		$reply_date = $MySmartBB->func->date($this->RInfo[$this->x]['write_time']);
		$reply_time = $MySmartBB->func->time($this->RInfo[$this->x]['write_time']);

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
