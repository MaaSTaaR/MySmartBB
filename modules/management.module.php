<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['MODERATORS'] 	= 	true;
$CALL_SYSTEM['ICONS'] 		= 	true;
$CALL_SYSTEM['TOOLBOX'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;
$CALL_SYSTEM['CACHE'] 		= 	true;

define('JAVASCRIPT_SMARTCODE',true);

include('common.php');

define('CLASS_NAME','MySmartManagementMOD');

class MySmartManagementMOD
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('ادارة المواضيع');
		
		if ($this->_ModeratorCheck())
		{	
			if ($MySmartBB->_GET['subject'])
			{
				$this->_Subject();
			}
			elseif ($MySmartBB->_GET['move'])
			{
				$this->_MoveStart();
			}
			elseif ($MySmartBB->_GET['subject_edit'])
			{
				$this->_SubjectEditStart();
			}
			elseif ($MySmartBB->_GET['repeat'])
			{
				$this->_SubjectRepeatStart();
			}
			elseif ($MySmartBB->_GET['close'])
			{
				$this->_CloseStart();
			}
			elseif ($MySmartBB->_GET['reply'])
			{
				$this->_Reply();
			}
			elseif ($MySmartBB->_GET['reply_edit'])
			{
				$this->_ReplyEditStart();
			}
		}
		else
		{
			$MySmartBB->functions->error('غير مسموح لك بالوصول إلى هذه الصفحه');
		}
		
		$MySmartBB->functions->GetFooter();
	}
		
	function _Subject()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_GET['operator'])
			or !isset($MySmartBB->_GET['section']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		if ($MySmartBB->_GET['operator'] == 'stick')
		{
			$this->__Stick();
		}
		elseif ($MySmartBB->_GET['operator'] == 'unstick')
		{
			$this->__UnStick();
		}
		elseif ($MySmartBB->_GET['operator'] == 'close')
		{
			$this->__Close();
		}
		elseif ($MySmartBB->_GET['operator'] == 'open')
		{
			$this->__Open();
		}
		elseif ($MySmartBB->_GET['operator'] == 'delete')
		{
			$this->__SubjectDelete();
		}
		elseif ($MySmartBB->_GET['operator'] == 'move')
		{
			$this->__MoveIndex();
		}
		elseif ($MySmartBB->_GET['operator'] == 'edit')
		{
			$this->__SubjectEdit();
		}
		elseif ($MySmartBB->_GET['operator'] == 'repeated')
		{
			$this->__SubjectRepeat();
		}
	}
	
	function __Stick()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$UpdateArr 			= array();
		$UpdateArr['where'] = array('id',$MySmartBB->_GET['subject_id']);
		
		$update = $MySmartBB->subject->StickSubject($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تثبيت الموضوع');
			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	function __UnStick()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$UpdateArr 			= array();
		$UpdateArr['where'] = array('id',$MySmartBB->_GET['subject_id']);
		
		$update = $MySmartBB->subject->UnstickSubject($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم إلغاء تثبيت الموضوع');
			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	function __Close()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->template->assign('subject',$MySmartBB->_GET['subject_id']);
		
		$MySmartBB->template->display('subject_close_index');
	}
	
	function __Open()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$UpdateArr 			= array();
		$UpdateArr['where'] = array('id',$MySmartBB->_GET['subject_id']);
		
		$update = $MySmartBB->subject->OpenSubject($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم فتح الموضوع');
			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	function __SubjectDelete()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$UpdateArr 			= array();
		$UpdateArr['where'] = array('id',$MySmartBB->_GET['subject_id']);
		
		$update = $MySmartBB->subject->MoveSubjectToTrash($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم حذف الموضوع');
			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	function __MoveIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		$MySmartBB->_GET['section'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['section'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id'])
			or empty($MySmartBB->_GET['section']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$SecArr 						= 	array();
		$SecArr['get_from']				=	'db';
		
		$SecArr['proc'] 				= 	array();
		$SecArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		$SecArr['order']				=	array();
		$SecArr['order']['field']		=	'sort';
		$SecArr['order']['type']		=	'ASC';
		
		$SecArr['where']				=	array();
		$SecArr['where'][0]['name']		= 	'parent';
		$SecArr['where'][0]['oper']		= 	'=';
		$SecArr['where'][0]['value']	= 	'0';
		
		// Get main sections
		$cats = $MySmartBB->section->GetSectionsList($SecArr);
		
		// We will use forums_list to store list of forums which will view in main page
		$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
		
		// Loop to read the information of main sections
		foreach ($cats as $cat)
		{
			// Get the groups information to know view this section or not
			$groups = unserialize(base64_decode($cat['sectiongroup_cache']));
			
			if (is_array($groups[$MySmartBB->_CONF['group_info']['id']]))
			{
				if ($groups[$MySmartBB->_CONF['group_info']['id']]['view_section'])
				{
					$MySmartBB->_CONF['template']['foreach']['forums_list'][$cat['id'] . '_m'] = $cat;
				}
			}
			
			unset($groups);
			
			if (!empty($cat['forums_cache']))
			{
				$forums = unserialize(base64_decode($cat['forums_cache']));
				
				foreach ($forums as $forum)
				{
					if (is_array($forum['groups'][$MySmartBB->_CONF['group_info']['id']]))
					{
						if ($forum['groups'][$MySmartBB->_CONF['group_info']['id']]['view_section'])
						{
							$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_f'] = $forum;
						}
					} // end if is_array
				} // end foreach ($forums)
			} // end !empty($forums_cache)
		} // end foreach ($cats)
				
		//////////
		
		$MySmartBB->template->assign('section',$MySmartBB->_GET['section']);
		$MySmartBB->template->assign('subject',$MySmartBB->_GET['subject_id']);
		
		$MySmartBB->template->display('subject_move_index');
	}
	
	function _MoveStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$UpdateArr 					= 	array();
		$UpdateArr['section_id']	=	$MySmartBB->_POST['section'];
		$UpdateArr['where'] 		= 	array('id',$MySmartBB->_GET['subject_id']);
		
		$update = $MySmartBB->subject->MoveSubject($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم نقل الموضوع');
			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	function _CloseStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$UpdateArr 				= 	array();
		$UpdateArr['reason']	=	$MySmartBB->_POST['reason'];
		$UpdateArr['where'] 	= 	array('id',$MySmartBB->_GET['subject_id']);
		
		$update = $MySmartBB->subject->CloseSubject($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم إغلاق الموضوع');
			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	function __SubjectEdit()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->template->assign('edit_page','index.php?page=management&amp;subject_edit=1&amp;subject_id=' . $MySmartBB->_GET['subject_id'] . '&amp;section=' . $MySmartBB->_GET['section']);
		
		$MySmartBB->functions->GetEditorTools();
		
		$SubjectArr = array();
		$SubjectArr['where'] = array('id',$MySmartBB->_GET['subject_id']);
		
		$MySmartBB->_CONF['template']['SubjectInfo'] = $MySmartBB->subject->GetSubjectInfo($SubjectArr);
		
		$MySmartBB->template->display('subject_edit');
	}
	
	function _SubjectEditStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		if (!isset($MySmartBB->_POST['title'])
			or !isset($MySmartBB->_POST['text']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$UpdateArr 				= 	array();
		$UpdateArr['field']		=	array();
		
		$UpdateArr['field']['title'] 				= 	$MySmartBB->_POST['title'];
		$UpdateArr['field']['text'] 				= 	$MySmartBB->_POST['text'];
		$UpdateArr['field']['icon'] 				= 	$MySmartBB->_POST['icon'];
		$UpdateArr['field']['subject_describe'] 	= 	$MySmartBB->_POST['describe'];
		$UpdateArr['where'] 						= 	array('id',$MySmartBB->_GET['subject_id']);
		
		$update = $MySmartBB->subject->UpdateSubject($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح');
			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	function _Reply()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_GET['operator'])
			or !isset($MySmartBB->_GET['section'])
			or !isset($MySmartBB->_GET['reply']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		elseif ($MySmartBB->_GET['operator'] == 'delete')
		{
			$this->__ReplyDelete();
		}
		elseif ($MySmartBB->_GET['operator'] == 'edit')
		{
			$this->__ReplyEdit();
		}
	}
	
	function __ReplyDelete()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['reply_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['reply_id'],'intval');
		
		if (empty($MySmartBB->_GET['reply_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$UpdateArr 			= array();
		$UpdateArr['where'] = array('id',$MySmartBB->_GET['reply_id']);
		
		$update = $MySmartBB->reply->MoveReplyToTrash($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم حذف الرد');
			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	function __ReplyEdit()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['reply_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['reply_id'],'intval');
		
		if (empty($MySmartBB->_GET['reply_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->template->assign('edit_page','index.php?page=management&amp;reply_edit=1&amp;reply_id=' . $MySmartBB->_GET['reply'] . '&amp;section=' . $MySmartBB->_GET['section'] . '&amp;subject_id=' . $MySmartBB->_GET['subject_id']);
		
		$MySmartBB->functions->GetEditorTools();
		
		$ReplyArr = array();
		$ReplyArr['where'] = array('id',$MySmartBB->_GET['reply_id']);
		
		$MySmartBB->_CONF['template']['ReplyInfo'] = $MySmartBB->reply->GetReplyInfo($ReplyArr);
		
		$MySmartBB->template->display('reply_edit');
	}
	
	function _ReplyEditStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['reply_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['reply_id'],'intval');
		
		if (empty($MySmartBB->_GET['reply_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		if (!isset($MySmartBB->_POST['title'])
			or !isset($MySmartBB->_POST['text']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$UpdateArr 				= 	array();
		$UpdateArr['field']		= 	array();
		
		$UpdateArr['field']['title'] 		= 	$MySmartBB->_POST['title'];
		$UpdateArr['field']['text'] 		= 	$MySmartBB->_POST['text'];
		$UpdateArr['field']['icon'] 		= 	$MySmartBB->_POST['icon'];
		$UpdateArr['where'] 				= 	array('id',$MySmartBB->_GET['reply_id']);
		
		$update = $MySmartBB->reply->UpdateReply($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح');
			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
		}
	}
	
	function __SubjectRepeat()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->template->assign('subject',$MySmartBB->_GET['subject_id']);
		
		$MySmartBB->template->display('subject_repeat_index');
	}
	
	function _SubjectRepeatStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');
		
		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$SubjectArr 			= 	array();
		$SubjectArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$Subject = $MySmartBB->subject->GetSubjectInfo($SubjectArr);
		
		if (!$Subject)
		{
			$MySmartBB->functions->error('الموضوع المطلوب غير موجود');
		}
		
		$SectionArr 			= 	array();
		$SectionArr['where'] 	= 	array('id',$Subject['section']);
		
		$Section = $MySmartBB->section->GetSectionInfo($SectionArr);
		
		if (!isset($MySmartBB->_POST['url']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$UpdateArr 				= 	array();
		$UpdateArr['reason']	=	'موضوع مُكرر';
		$UpdateArr['where'] 	= 	array('id',$MySmartBB->_GET['subject_id']);
		
		$update = $MySmartBB->subject->CloseSubject($UpdateArr);
		
		if ($update)
		{
     		$ReplyArr 			= 	array();
     		$ReplyArr['field'] 	= 	array();
     		
     		$ReplyArr['field']['text'] 			= 	'هذا الموضوع مكرر، راجع الاصل [url=' . $MySmartBB->_POST['url'] . ']هنا[/url]';
     		$ReplyArr['field']['writer'] 		= 	$MySmartBB->_CONF['member_row']['username'];
     		$ReplyArr['field']['subject_id'] 	= 	$MySmartBB->_GET['subject_id'];
     		$ReplyArr['field']['write_time'] 	= 	$MySmartBB->_CONF['now'];
     		$ReplyArr['field']['section'] 		= 	$Subject['section'];
     		$ReplyArr['get_id']					=	true;
     	
     		$insert = $MySmartBB->reply->InsertReply($ReplyArr);
     	
     		if ($insert)
     		{
	   			$MemberArr 				= 	array();
	   			$MemberArr['field'] 	= 	array();
     		
     			$MemberArr['field']['lastpost_time'] 	=	$MySmartBB->_CONF['now'];
     			$MemberArr['where']						=	array('id',$MySmartBB->_CONF['member_row']['id']);
     			
   				$UpdateMember = $MySmartBB->member->UpdateMember($MemberArr);
     			
     			$TimeArr = array();
     		
     			$TimeArr['write_time'] 	= 	$MySmartBB->_CONF['now'];
     			$TimeArr['where']		=	array('id',$MySmartBB->_GET['subject_id']);
     		
     			$UpdateWriteTime = $MySmartBB->subject->UpdateWriteTime($TimeArr);
     		
     			$RepArr 					= 	array();
     			$RepArr['reply_number']		=	$Subject['reply_number'];
     			$RepArr['where'] 			= 	array('id',$MySmartBB->_GET['subject_id']);
     		
     			$UpdateReplyNumber = $MySmartBB->subject->UpdateReplyNumber($RepArr);
     		     		
     			$LastArr = array();
     		
     			$LastArr['writer'] 		= 	$MySmartBB->_CONF['member_row']['username'];
     			$LastArr['title'] 		= 	$Subject['title'];
     			$LastArr['subject_id'] 	= 	$Subject['id'];
     			$LastArr['date'] 		= 	$MySmartBB->_CONF['date'];
     			$LastArr['where'] 		= 	(!$Section['sub_section']) ? array('id',$Section['id']) : array('id',$Section['from_sub_section']);
     		
     			$UpdateLast = $MySmartBB->section->UpdateLastSubject($LastArr);
     		
     			// Free memory
     			unset($LastArr);
     		
     			$UpdateSubjectNumber = $MySmartBB->cache->UpdateReplyNumber(array('reply_num'	=>	$MySmartBB->_CONF['info_row']['reply_number']));
     		
     			$LastArr = array();
     		
     			$LastArr['replier'] 	= 	$MySmartBB->_CONF['member_row']['username'];
     			$LastArr['where']		=	array('id',$MySmartBB->_GET['subject_id']);
     		
     			$UpdateLastReplier = $MySmartBB->subject->UpdateLastReplier($LastArr);
     		
     			// Free memory
     			unset($LastArr);
     		
     			$UpdateArr 					= 	array();
     			$UpdateArr['field']			=	array();
     			
     			$UpdateArr['field']	['reply_num'] 	= 	$Section['reply_num'] + 1;
     			$UpdateArr['where']					= 	array('id',$Section['id']);
     		
     			$UpdateSubjectNumber = $MySmartBB->section->UpdateSection($UpdateArr);
     		
     			// Free memory
     			unset($UpdateArr);
     			
				$MySmartBB->functions->msg('تم التحديث بنجاح');
				$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->_GET['subject_id']);
     		}
		}
	}
	
	function _ModeratorCheck()
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
				$ModArr = array();
				$ModArr['username'] 	= 	$MySmartBB->_CONF['member_row']['username'];
				$ModArr['section_id']	=	$MySmartBB->_POST['section'];
				
				$Mod = $MySmartBB->moderator->IsModerator($ModArr);
			}
		}
				
		return $Mod;
	}
}
?>
