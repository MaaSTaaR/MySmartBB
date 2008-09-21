<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;

include('common.php');

define('CLASS_NAME','MySmartTrashMOD');
	
class MySmartTrashMOD extends _functions /** Yes it's Smart Trash :D **/
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['subject'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_SubjectTrashMain();
				}
				elseif ($MySmartBB->_GET['untrash'])
				{
					$this->_SubjectUnTrash();
				}
				elseif ($MySmartBB->_GET['del'])
				{
					if ($MySmartBB->_GET['confirm'])
					{
						$this->_SubjectDelMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_SubjectDelete();
					}
				}
			}
			elseif ($MySmartBB->_GET['reply'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_ReplyTrashMain();
				}
				elseif ($MySmartBB->_GET['untrash'])
				{
					$this->_ReplyUnTrash();
				}
				elseif ($MySmartBB->_GET['del'])
				{
					if ($MySmartBB->_GET['confirm'])
					{
						$this->_ReplyDelMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_ReplyDelete();
					}
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	function _SubjectTrashMain()
	{
		global $MySmartBB;
		
		$TrashArr 						= 	array();
		
		$TrashArr['proc'] 				= 	array();
		$TrashArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		$TrashArr['where']				=	array();
		$TrashArr['where'][0]			=	array();
		$TrashArr['where'][0]['name']	=	'delete_topic';
		$TrashArr['where'][0]['oper']	=	'=';
		$TrashArr['where'][0]['value']	=	'1';
		
		$TrashArr['order']				=	array();
		$TrashArr['order']['field']		=	'id';
		$TrashArr['order']['type']		=	'DESC';
		
		$MySmartBB->_CONF['template']['while']['TrashList'] = $MySmartBB->subject->GetSubjectList($TrashArr);
		
		$MySmartBB->template->display('trash_subjects');
	}
	
	function _SubjectUnTrash()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('طلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$UnTrash = $MySmartBB->subject->UnTrashSubject(array('id'	=>	$MySmartBB->_GET['id']));
		
		if ($UnTrash)
		{
			$MySmartBB->functions->msg('تم إعادة الموضوع بنجاح');
			$MySmartBB->functions->goto('admin.php?page=trash&amp;subject=1&amp;main=1');
		}
	}
	
	function _SubjectDelMain()
	{
		global $MySmartBB;
		
		$this->check_subject_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('trash_subject_del');
	}
	
	function _SubjectDelete()
	{
		global $MySmartBB;
		
		$this->check_subject_by_id($Inf);
		
		$del = $MySmartBB->subject->DeleteSubject(array('id'	=>	$Inf['id']));
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف الموضوع بنجاح');
			$MySmartBB->functions->goto('admin.php?page=trash&amp;subject=1&amp;main=1');
		}
	}
	
	function _ReplyTrashMain()
	{
		global $MySmartBB;
		
		$TrashArr 						= 	array();
		$TrashArr['proc'] 				= 	array();
		$TrashArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		$TrashArr['order']				=	array();
		$TrashArr['order']['field']		=	'id';
		$TrashArr['order']['type']		=	'DESC';
		
		$TrashArr['where']				=	array();
		$TrashArr['where'][0]			=	array();
		$TrashArr['where'][0]['name']	=	'delete_topic';
		$TrashArr['where'][0]['oper']	=	'=';
		$TrashArr['where'][0]['value']	=	'1';
		
		$MySmartBB->_CONF['template']['while']['TrashList'] = $MySmartBB->reply->GetReplyList($TrashArr);
		
		$MySmartBB->template->display('trash_replies');		
	}
	
	function _ReplyUnTrash()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('طلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$UnTrash = $MySmartBB->reply->UnTrashReply(array('id'	=>	$MySmartBB->_GET['id']));
		
		if ($UnTrash)
		{
			$MySmartBB->functions->msg('تم إعادة الرد بنجاح');
			$MySmartBB->functions->goto('admin.php?page=trash&amp;reply=1&amp;main=1');
		}
	}
	
	function _ReplyDelMain()
	{
		global $MySmartBB;
		
		$this->check_reply_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('trash_reply_del');
	}
	
	function _ReplyDelete()
	{
		global $MySmartBB;
		
		$this->check_reply_by_id($ReplyInf);
		
		$del = $MySmartBB->reply->DeleteReply(array('id'	=>	$ReplyInf['id']));
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف الرد بنجاح');
			$MySmartBB->functions->goto('admin.php?page=trash&amp;reply=1&amp;main=1');
		}
	}
}

class _functions
{
	function check_subject_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$InfArr 			= 	array();
		$InfArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$Inf = $MySmartBB->subject->GetSubjectInfo($InfArr);
		
		if ($Inf == false)
		{
			$MySmartBB->functions->error('الموضوع المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($Inf,'html');
	}
	
	function check_reply_by_id(&$ReplyInf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$ReplyArr = array();
		$ReplyArr['where'] = array('id',$MySmartBB->_GET['id']);
		
		$ReplyInf = $MySmartBB->reply->GetReplyInfo($ReplyArr);
		
		if ($ReplyInf == false)
		{
			$MySmartBB->functions->error('الموضوع المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($ReplyInf,'html');
	}
}

?>
