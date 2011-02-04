<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['USERTITLE'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartUsertitleMOD');
	
class MySmartUsertitleMOD extends _func
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
		
		$MySmartBB->template->display('usertitle_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['posts']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['usertitle'] 	= 	$MySmartBB->_POST['title'];
		$MySmartBB->rec->fields['posts'] 		= 	$MySmartBB->_POST['posts'];
		
		$insert = $MySmartBB->rec->insert();
		
		if ($insert)
		{
			$MySmartBB->func->msg('تم اضافة المسمى بنجاح !');
			$MySmartBB->func->move('admin.php?page=usertitle&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('usertitles_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
				
		$MySmartBB->template->display('usertitle_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($UTInfo);
				
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['posts']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['usertitle'] 	= 	$MySmartBB->_POST['title'];
		$MySmartBB->rec->fields['posts'] 		= 	$MySmartBB->_POST['posts'];
		
		$MySmartBB->rec->filter = "id='" . $UTInfo['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث المسمى بنجاح !');
			$MySmartBB->func->move('admin.php?page=usertitle&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('usertitle_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($UTInfo);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg('تم حذف المسمى بنجاح !');
			$MySmartBB->func->move('admin.php?page=usertitle&amp;control=1&amp;main=1');
		}
	}
}

class _func
{
	function check_by_id(&$UTInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$UTInfo = $MySmartBB->rec->getInfo();
		
		if ($UTInfo == false)
		{
			$MySmartBB->func->error('الاسم المطلوب غير موجود');
		}
	}
}

?>
