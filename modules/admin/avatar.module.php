<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartAvatarMOD');
	
class MySmartAvatarMOD extends _func
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

		$MySmartBB->template->display('avatar_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['path']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		
		$MySmartBB->rec->fields	= array();
		
		$MySmartBB->rec->fields['avatar_path'] = $MySmartBB->_POST['path'];
		
		$insert = $MySmartBB->rec->insert();
			
		if ($insert)
		{
			$MySmartBB->func->msg('تم اضافة الصوره بنجاح !');
			$MySmartBB->func->move('admin.php?page=avatar&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('avatars_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('avatar_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		if (empty($MySmartBB->_POST['path']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		
		$MySmartBB->rec->fields 	= 	array();
		
		$MySmartBB->rec->fields['avatar_path'] 	= 	$MySmartBB->_POST['path'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث الصوره بنجاح !');
			$MySmartBB->func->move('admin.php?page=avatar&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
				
		$MySmartBB->template->display('avatar_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg('تم حذف الصوره بنجاح !');
			$MySmartBB->func->move('admin.php?page=avatar&amp;control=1&amp;main=1');
		}
	}
}

class _func
{
	function check_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		if ($Inf == false)
		{
			$MySmartBB->func->error('الصوره المطلوبه غير موجود');
		}
	}
}

?>
