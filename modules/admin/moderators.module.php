<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartModeratorsMOD');
	
class MySmartModeratorsMOD extends _func
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['add'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_addMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_addStart();
				}
			}
			elseif ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_controlMain();
				}
				elseif ($MySmartBB->_GET['section'])
				{
					$this->_controlSection();
				}
			}
			elseif ($MySmartBB->_GET['edit'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_editMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_editStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_delMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_delStart();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;
		
		//////////
		
		/*$SecArr 						= 	array();
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
			$MySmartBB->_CONF['template']['foreach']['forums_list'][$cat['id'] . '_m'] = $cat;
			
			if (!empty($cat['forums_cache']))
			{
				$forums = unserialize(base64_decode($cat['forums_cache']));
				
				foreach ($forums as $forum)
				{
					$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_f'] = $forum;
				}
			}
		}*/
		
		/* ... */
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "group_mod='1'";
		$MySmartBB->rec->order = "group_order ASC";
		
		$MySmartBB->rec->getList();
		
		/* ... */
		
		$MySmartBB->template->display('moderator_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['username']) 
			or empty($MySmartBB->_POST['section']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$IsModerator = $MySmartBB->moderator->isModerator( $MySmartBB->_POST['username'], $MySmartBB->_POST['section'] );
		
		if ($IsModerator)
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك اضافة نفس العضو مشرفاً على القسم مرتين');
		}
		
		/* ... */
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST['section'] . "'";
		
		$SectionInfo = $MySmartBB->rec->getInfo();
		
		if ($SectionInfo == false)
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		/* ... */
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['username'] . "'";
		
		$Member = $MySmartBB->rec->getInfo();
		
		if ($Member != false)
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
			
			$MySmartBB->rec->fields	=	array();
			
			$MySmartBB->rec->fields['username'] 	= 	$MySmartBB->_POST['username'];
			$MySmartBB->rec->fields['section_id'] 	= 	$MySmartBB->_POST['section'];
			$MySmartBB->rec->fields['member_id'] 	= 	$Member['id'];
			
			$insert = $MySmartBB->rec->insert();
			
			if ($insert)
			{
				/* ... */
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
				$MySmartBB->rec->filter = "id='" . (int) $Member['group'] . "'";
				
				$Group = $MySmartBB->rec->getInfo();
				
				// If the user isn't admin, so change the group
				if (!$Group['admincp_allow']
					and !$Group['vice']
					and !$Group['group_mod'])
				{
					$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
					
					$MySmartBB->rec->fields	= array();
					
					$MySmartBB->rec->fields['usergroup'] = $MySmartBB->_POST['group'];
					
					if (!empty($MySmartBB->_POST['usertitle']))
					{
						$MySmartBB->rec->fields['user_title'] = $MySmartBB->_POST['usertitle'];
					}
					else
					{
						$MySmartBB->rec->fields['user_title'] = 'مشرف على ' . $SectionInfo['title'];
					}
					
					$MySmartBB->rec->filter = "id='" . $Member[ 'id' ] . "'";
					
					$change = $MySmartBB->rec->update();
				}
				
				/* ... */
				
				$cache = $MySmartBB->moderator->createModeratorsCache( $MySmartBB->_POST['section'] );
				
				/* ... */
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
				$MySmartBB->rec->fields	= array();
				$MySmartBB->rec->fields['moderators'] = $cache;
				
				$update = $MySmartBB->rec->update();
			
				if ($update)
				{
					$cache = $MySmartBB->section->updateSectionsCache(array('type'=>'normal'));
				
					if ($cache)
					{
						$MySmartBB->func->msg('تم اضافة المشرف بنجاح !');
						$MySmartBB->func->move('admin.php?page=moderators&amp;control=1&amp;main=1');
					}
				}
			}
		}
		else
		{
			$MySmartBB->func->error('المستخدم غير موجود');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		/*$ForumArr 				= 	array();
		$ForumArr['get_from'] 	=	'cache';
		$ForumArr['type'] 		= 	'normal';
		
		$forums = $MySmartBB->section->GetSectionsList($ForumArr);
		
		//////////
				
		$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
		
		//////////
		
		foreach ($forums as $forum)
		{
			//////////
			
			$MySmartBB->func->CleanVariable($forum,'html');
			
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
		
		//////////*/
		
		$MySmartBB->template->display('moderators_main');
	}

	private function _controlSection()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$MySmartBB->_CONF['template']['Section'] = $MySmartBB->rec->getInfo();
		
		if (!is_array($MySmartBB->_CONF['template']['Section']))
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
		$MySmartBB->rec->filter = "section_id='" . $MySmartBB->_CONF['template']['Section']['id'] . "'";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('moderators_section_control');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		/*//////////
		
		$ForumArr 				= 	array();
		$ForumArr['get_from'] 	=	'cache';
		$ForumArr['type'] 		= 	'normal';
		
		$MySmartBB->_CONF['template']['foreach']['forums'] = $MySmartBB->section->GetSectionsList($ForumArr);
		
		//////////*/
		
		/* ... */
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "group_mod='1'";
		$MySmartBB->rec->order = "group_order ASC";
		
		$MySmartBB->rec->getList();
		
		/* ... */
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['section_id'] . "'";
		
		$MySmartBB->_CONF['template']['while']['Section'] = $MySmartBB->rec->getInfo();
		
		if (!is_array($MySmartBB->_CONF['template']['while']['Section']))
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		/* ... */
		
		$MySmartBB->template->display('moderator_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($ModInfo);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['username'] . "'";
		
		$Member = $MySmartBB->rec->getInfo();
		
		if ($Member != false)
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
			$MySmartBB->rec->fields = 	array();
			
			$MySmartBB->rec->fields['username'] 	= 	$MySmartBB->_POST['username'];
			$MySmartBB->rec->fields['section_id'] 	= 	$MySmartBB->_POST['section'];
			$MySmartBB->rec->fields['member_id'] 	= 	$Member['id'];
			
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
			
			$update = $MySmartBB->rec->update();
			
			if ($update)
			{
				/* ... */
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
				$MySmartBB->rec->filter = "id='" . $Member['group'] . "'";
				
				$Group = $MySmartBB->rec->getInfo();
				
				// If the user isn't an admin, so change the group
				if (!$Group['admincp_allow'])
				{
					$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
					$MySmartBB->rec->fields					=	array();
					$MySmartBB->rec->fields['usergroup']	=	$MySmartBB->_POST['group'];
					
					$MySmartBB->rec->filter = "id='" . $Member[ 'id' ] . "'";
					
					$change = $MySmartBB->rec->update();
				}
				
				/* ... */
				
				$cache = $MySmartBB->moderator->createModeratorsCache( $MySmartBB->_POST['section'] );
				
				/* ... */
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
				$MySmartBB->rec->fields					=	array();
				$MySmartBB->rec->fields['moderators'] 	= 	$cache;
			
				$update = $MySmartBB->rec->update();
			
				if ($update)
				{
					$cache = $MySmartBB->section->updateSectionsCache(array('type'=>'normal'));
				
					if ($cache)
					{
						$MySmartBB->func->msg('تم تحديث المشرف بنجاح !');
						$MySmartBB->func->move('admin.php?page=moderators&amp;control=1&amp;main=1');
					}
				}
			}
		}
		else
		{
			$MySmartBB->func->error('المستخدم غير موجود');
		}

	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		/* ... */
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['section_id'] . "'";
		
		$MySmartBB->_CONF['template']['while']['Section'] = $MySmartBB->rec->getInfo();
		
		if (!is_array($MySmartBB->_CONF['template']['while']['Section']))
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		/* ... */
		
		$MySmartBB->template->display('moderator_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($ModInfo);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
			$MySmartBB->rec->filter = "username='" . $ModInfo['username'] . "'";
			
			$IsMod = $MySmartBB->rec->getInfo();
			
			if (!$IsMod)
			{
				/* ... */
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
				$MySmartBB->rec->filter = "id='" . $Member['group'] . "'";
				
				$Group = $MySmartBB->rec->getInfo();
				
				// If the user isn't an admin, so change the group
				if (!$Group['admincp_allow']
					and !$Group['vice'])
				{
					$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
					$MySmartBB->rec->fields					=	array();
					$MySmartBB->rec->fields	['usergroup']	=	'7';
					
					$MySmartBB->rec->filter = "id='" . $ModInfo['member_id'] . "'";
					
					$change = $MySmartBB->rec->update();
				}
				
				/* ... */
				
				$cache = $MySmartBB->moderator->createModeratorsCache( $ModInfo['section_id'] );
				
				/* ... */
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
				$MySmartBB->rec->fields					=	array();
				$MySmartBB->rec->fields['moderators'] 	= 	$cache;
			
				$update = $MySmartBB->rec->update();
			
				if ($update)
				{
					$cache = $MySmartBB->section->updateSectionsCache(array('type'=>'normal'));
				
					if ($cache)
					{
						$MySmartBB->func->msg('تم إلغاء الاشراف بنجاح');
						$MySmartBB->func->move('admin.php?page=moderators&amp;control=1&amp;section=1&amp;id=' . $ModInfo['section_id']);
					}
				}
			}
		}
	}
}

class _func
{	
	function check_by_id(&$ModeratorInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$ModeratorInfo = $MySmartBB->rec->getInfo();
		
		if ($ModeratorInfo == false)
		{
			$MySmartBB->func->error('المشرف المطلوب غير موجود');
		}
	}
}

?>
