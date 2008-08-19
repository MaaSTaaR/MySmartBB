<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['MODERATORS'] 	= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;

include('common.php');
	
define('CLASS_NAME','MySmartModeratorsMOD');
	
class MySmartModeratorsMOD extends _functions
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		
		if ($MySmartBB->_GET['add'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_AddMain();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_AddStart();
			}
		}
		elseif ($MySmartBB->_GET['control'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_ControlMain();
			}
			elseif ($MySmartBB->_GET['section'])
			{
				$this->_ControlSection();
			}
		}
		elseif ($MySmartBB->_GET['edit'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_EditMain();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_EditStart();
			}
		}
		elseif ($MySmartBB->_GET['del'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_DelMain();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_DelStart();
			}
		}
		
		$MySmartBB->template->display('footer');
	}
	
	function _AddMain()
	{
		global $MySmartBB;
		
		//////////
		
		$ForumArr 				= 	array();
		$ForumArr['get_from'] 	=	'cache';
		$ForumArr['type'] 		= 	'normal';
		
		$MySmartBB->_CONF['template']['foreach']['forums'] = $MySmartBB->section->GetSectionsList($ForumArr);
		
		//////////
		
		$GroupArr 							= 	array();
		
		$GroupArr['where'] 					= 	array();
		$GroupArr['where'][0] 				= 	array();
		$GroupArr['where'][0]['name'] 		= 	'group_mod';
		$GroupArr['where'][0]['oper'] 		= 	'=';
		$GroupArr['where'][0]['value']		= 	1;
		
		$GroupArr['order'] 					= 	array();
		$GroupArr['order']['field'] 		= 	'group_order';
		$GroupArr['order']['type'] 			= 	'ASC';
		
		$MySmartBB->_CONF['template']['while']['GroupList'] = $MySmartBB->group->GetGroupList($GroupArr);
		
		//////////
		
		$MySmartBB->template->display('moderator_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['username']) 
			or empty($MySmartBB->_POST['section']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
 		$MemberArr 			= 	array();
		$MemberArr['get']	= 	'*';
		
		$MemberArr['where']	=	array();
		
		$MemberArr['where'][0]				=	array();
		$MemberArr['where'][0]['name']		=	'username';
		$MemberArr['where'][0]['oper']		=	'=';
		$MemberArr['where'][0]['value']		=	$MySmartBB->_POST['username'];
		
		$Member = $MySmartBB->member->GetMemberInfo($MemberArr);
		
		if ($Member != false)
		{
			$ModArr 			= 	array();
			$ModArr['field']	=	array();
			
			$ModArr['field']['username'] 	= 	$MySmartBB->_POST['username'];
			$ModArr['field']['section_id'] 	= 	$MySmartBB->_POST['section'];
			$ModArr['field']['member_id'] 	= 	$Member['id'];
			
			$insert = $MySmartBB->moderator->InsertModerator($ModArr);
			
			if ($insert)
			{
				//////////
				
				$GroupArr 			= 	array();
				$GroupArr['where'] 	= 	array('id',$Member['group']);
				
				$Group = $MySmartBB->group->GetGroupInfo($GroupArr);
				
				// If the user isn't admin, so change the group
				if (!$Group['admincp_allow']
					and !$Group['vice']
					and !$Group['group_mod'])
				{
					$ChangeArr 					= 	array();
					$ChangeArr['field']			=	array();
					
					$ChangeArr['field']['usergroup']	=	$MySmartBB->_POST['group'];
					$ChangeArr['where'] 				= 	array('id',$Member['id']);
					
					$change = $MySmartBB->member->UpdateMember($ChangeArr);
				}
				
				//////////
				
				$CacheArr 			= 	array();
				$CacheArr['where'] 	= 	array('section_id',$MySmartBB->_POST['section']);
			
				$cache = $MySmartBB->moderator->CreateModeratorsCache($CacheArr);
				
				//////////
				
				$SecArr 				= 	array();
				$SecArr['moderators'] 	= 	$cache;
			
				$update = $MySmartBB->section->UpdateSection($SecArr);
			
				if ($update)
				{
					$cache = $MySmartBB->section->UpdateSectionsCache(array('type'=>'normal'));
				
					if ($cache)
					{
						$MySmartBB->functions->msg('تم اضافة المشرف بنجاح !');
						$MySmartBB->functions->goto('admin.php?page=moderators&amp;control=1&amp;main=1');
					}
				}
			}
		}
		else
		{
			$MySmartBB->functions->error('المستخدم غير موجود');
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;
		
		$ForumArr 				= 	array();
		$ForumArr['get_from'] 	=	'cache';
		$ForumArr['type'] 		= 	'normal';
		
		$forums = $MySmartBB->section->GetSectionsList($ForumArr);
		
		//////////
				
		$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
		
		//////////
		
		foreach ($forums as $forum)
		{
			//////////
			
			$MySmartBB->functions->CleanVariable($forum,'html');
			
			//////////

			if (empty($forum['from_main_section']))
			{
				if (isset($forum['moderators'])
					and $forum['moderators'] != 'a:0:{}')
				{
					$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_m'] = $forum;
				}
			}
			
			//////////
			
			elseif (!empty($forum['from_main_section']))
			{
				if (isset($forum['moderators'])
					and $forum['moderators'] != 'a:0:{}')
				{
					$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_f'] = $forum;
				}
			}
			
			//////////
		}
		
		//////////
		
		$MySmartBB->template->display('moderators_main');
	}

	function _ControlSection()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$SecArr 			= 	array();
		$SecArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$MySmartBB->_CONF['template']['Section'] = $MySmartBB->section->GetSectionInfo($SecArr);
		
		if (!is_array($MySmartBB->_CONF['template']['Section']))
		{
			$MySmartBB->functions->error('القسم المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['Section'],'html');
		
		$ModArr 			= 	array();
		$ModArr['where'] 	= 	array('section_id',$MySmartBB->_CONF['template']['Section']['id']);
		
		$MySmartBB->_CONF['template']['while']['ModeratorsList'] = $MySmartBB->moderator->GetModeratorList($ModArr);
		
		$MySmartBB->template->display('moderators_section_control');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		//////////
		
		$ForumArr 				= 	array();
		$ForumArr['get_from'] 	=	'cache';
		$ForumArr['type'] 		= 	'normal';
		
		$MySmartBB->_CONF['template']['foreach']['forums'] = $MySmartBB->section->GetSectionsList($ForumArr);
		
		//////////
		
		$GroupArr 							= 	array();
		
		$GroupArr['where'] 					= 	array();
		$GroupArr['where'][0] 				= 	array();
		$GroupArr['where'][0]['name'] 		= 	'group_mod';
		$GroupArr['where'][0]['oper'] 		= 	'=';
		$GroupArr['where'][0]['value']		= 	1;
		
		$GroupArr['order'] 					= 	array();
		$GroupArr['order']['field'] 		= 	'group_order';
		$GroupArr['order']['type'] 			= 	'ASC';
		
		$MySmartBB->_CONF['template']['while']['GroupList'] = $MySmartBB->group->GetGroupList($GroupArr);
		
		//////////

		$SecArr 			= 	array();
		$SecArr['where'] 	= 	array('id',$MySmartBB->_CONF['template']['Inf']['section_id']);
		
		$MySmartBB->_CONF['template']['while']['Section'] = $MySmartBB->section->GetSectionInfo($SecArr);
		
		if (!is_array($MySmartBB->_CONF['template']['while']['Section']))
		{
			$MySmartBB->functions->error('القسم المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['Section'],'html');
		
		//////////
		
		$MySmartBB->template->display('moderator_edit');
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($ModInfo);
				
 		$MemberArr 			= 	array();
		$MemberArr['get']	= 	'*';
		
		$MemberArr['where']	=	array();
		
		$MemberArr['where'][0]				=	array();
		$MemberArr['where'][0]['name']		=	'username';
		$MemberArr['where'][0]['oper']		=	'=';
		$MemberArr['where'][0]['value']		=	$MySmartBB->_POST['username'];
		
		$Member = $MySmartBB->member->GetMemberInfo($MemberArr);
		
		if ($Member != false)
		{
			$ModArr 				= 	array();
			$ModArr['field'] 		= 	array();
			
			$ModArr['field']['username'] 	= 	$MySmartBB->_POST['username'];
			$ModArr['field']['section_id'] 	= 	$MySmartBB->_POST['section'];
			$ModArr['field']['member_id'] 	= 	$Member['id'];
			$ModArr['where']				=	array('id',$MySmartBB->_GET['id']);
			
			$update = $MySmartBB->moderator->UpdateModerator($ModArr);
			
			if ($update)
			{
				//////////
				
				$GroupArr 			= 	array();
				$GroupArr['where'] 	= 	array('id',$Member['group']);
				
				$Group = $MySmartBB->group->GetGroupInfo($GroupArr);
				
				// If the user isn't admin, so change the group
				if (!$Group['admincp_allow'])
				{
					$ChangeArr 				= 	array();
					$ChangeArr['field']		=	array();
					
					$ChangeArr['field']['usergroup']	=	$MySmartBB->_POST['group'];
					$ChangeArr['where'] 				= 	array('id',$Member['id']);
					
					$change = $MySmartBB->member->UpdateMember($ChangeArr);
				}
				
				//////////
				
				$CacheArr 			= 	array();
				$CacheArr['where'] 	= 	array('section_id',$MySmartBB->_POST['section']);
			
				$cache = $MySmartBB->moderator->CreateModeratorsCache($CacheArr);
				
				//////////
				
				$SecArr 						= 	array();
				$SecArr['field']				=	array();
				$SecArr['field']['moderators'] 	= 	$cache;
			
				$update = $MySmartBB->section->UpdateSection($SecArr);
			
				if ($update)
				{
					$cache = $MySmartBB->section->UpdateSectionsCache(array('type'=>'normal'));
				
					if ($cache)
					{
						$MySmartBB->functions->msg('تم تحديث المشرف بنجاح !');
						$MySmartBB->functions->goto('admin.php?page=moderators&amp;control=1&amp;main=1');
					}
				}
			}
		}
		else
		{
			$MySmartBB->functions->error('المستخدم غير موجود');
		}

	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		//////////

		$SecArr 			= 	array();
		$SecArr['where'] 	= 	array('id',$MySmartBB->_CONF['template']['Inf']['section_id']);
		
		$MySmartBB->_CONF['template']['while']['Section'] = $MySmartBB->section->GetSectionInfo($SecArr);
		
		if (!is_array($MySmartBB->_CONF['template']['while']['Section']))
		{
			$MySmartBB->functions->error('القسم المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['Section'],'html');
		
		//////////
		
		$MySmartBB->template->display('moderator_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($ModInfo);
		
		$DelArr 			= 	array();
		$DelArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$del = $MySmartBB->moderator->DeleteModerator($DelArr);
		
		if ($del)
		{
			$ModArr = array();
			$ModArr['where'] = array('username',$ModInfo['username']);
			
			$IsMod = $MySmartBB->moderator->GetModeratorInfo($ModArr);
			
			if (!$IsMod)
			{
				//////////
				
				$GroupArr 			= 	array();
				$GroupArr['where'] 	= 	array('id',$Member['group']);
				
				$Group = $MySmartBB->group->GetGroupInfo($GroupArr);
				
				// If the user isn't admin, so change the group
				if (!$Group['admincp_allow']
					and !$Group['vice'])
				{
					$ChangeArr 							= 	array();
					$ChangeArr['field']					=	array();
					$ChangeArr['field']	['usergroup']	=	'7';
					$ChangeArr['where'] 				= 	array('id',$ModInfo['member_id']);
					
					$change = $MySmartBB->member->UpdateMember($ChangeArr);
				}
				
				//////////
				
				$CacheArr 			= 	array();
				$CacheArr['where'] 	= 	array('section_id',$ModInfo['section_id']);
			
				$cache = $MySmartBB->moderator->CreateModeratorsCache($CacheArr);
				
				//////////
				
				$SecArr 						= 	array();
				$SecArr['field']				=	array();
				$SecArr['field']['moderators'] 	= 	$cache;
			
				$update = $MySmartBB->section->UpdateSection($SecArr);
			
				if ($update)
				{
					$cache = $MySmartBB->section->UpdateSectionsCache(array('type'=>'normal'));
				
					if ($cache)
					{
						$MySmartBB->functions->msg('تم إلغاء الاشراف بنجاح');
						$MySmartBB->functions->goto('admin.php?page=moderators&amp;control=1&amp;section=1&amp;id=' . $ModInfo['section_id']);
					}
				}
			}
		}
	}
}

class _functions
{	
	function check_by_id(&$ModeratorInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$ModArr 			= 	array();
		$ModArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$ModeratorInfo = $MySmartBB->moderator->GetModeratorInfo($ModArr);
		
		if ($ModeratorInfo == false)
		{
			$MySmartBB->functions->error('المشرف المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($ModeratorInfo,'html');
	}
}

?>
