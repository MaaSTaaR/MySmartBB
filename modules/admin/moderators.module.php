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
			$MySmartBB->load( 'moderator,section' );
			
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
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList( false );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "group_mod='1'";
		$MySmartBB->rec->order = "group_order ASC";
		
		$MySmartBB->rec->getList();
		
		// ... //
		
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
		
		$IsModerator = $MySmartBB->moderator->isModerator( $MySmartBB->_POST['username'], 'username', $MySmartBB->_POST['section'] );
		
		if ($IsModerator)
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك اضافة نفس العضو مشرفاً على القسم مرتين');
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST['section'] . "'";
		
		$SectionInfo = $MySmartBB->rec->getInfo();
		
		if ($SectionInfo == false)
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['username'] . "'";
		
		$Member = $MySmartBB->rec->getInfo();
		
		if ($Member != false)
		{
		    $set = $MySmartBB->moderator->setModerator( $Member, $SectionInfo, $MySmartBB->_POST[ 'group' ], $MySmartBB->_POST[ 'usertitle' ] );
		    
		    if ( $set )
		    {
		        $MySmartBB->func->msg( 'تم إضافة العضو إلى قائمة المشرفين' );
		        $MySmartBB->func->move( 'admin.php?page=moderators&amp;control=1&amp;section=1&amp;id=' . $SectionInfo[ 'id' ] );
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
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList( false );
		
		// ... //
		
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
		
	private function _delMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['section_id'] . "'";
		
		$MySmartBB->_CONF['template']['while']['Section'] = $MySmartBB->rec->getInfo();
		
		if (!is_array($MySmartBB->_CONF['template']['while']['Section']))
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		// ... //
		
		$MySmartBB->template->display('moderator_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($ModInfo);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $ModInfo['member_id'] . "'";
		
		$member_info = $MySmartBB->rec->getInfo();
		
		$unset = $MySmartBB->moderator->unsetModerator( $ModInfo, $member_info );
				
		if ( $unset )
		{
			$MySmartBB->func->msg('تم إلغاء الاشراف بنجاح');
			$MySmartBB->func->move('admin.php?page=moderators&amp;control=1&amp;section=1&amp;id=' . $ModInfo['section_id']);
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
