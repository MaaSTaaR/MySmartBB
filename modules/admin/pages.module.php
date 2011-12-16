<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartPagesMOD');
	
class MySmartPagesMOD extends _func
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
		    $MySmartBB->loadLanguage( 'admin_pages' );
		    
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
		
		$MySmartBB->template->display('page_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['text']) 
			or empty($MySmartBB->_POST['name']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 		= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['html_code'] 	= 	$MySmartBB->func->cleanVariable( $MySmartBB->_POST['text'], 'unhtml' );
				
		$insert = $MySmartBB->rec->insert();
		
		if ($insert)
		{
			$MySmartBB->func->msg('تم اضافة الصفحه بنجاح !');
			$MySmartBB->func->move('admin.php?page=pages&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('pages_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->assign('Inf',$MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('page_edit');		
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($PageInfo);
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		
		$MySmartBB->rec->fields		=	array();
		
		$MySmartBB->rec->fields['title'] 		= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['html_code'] 	= 	$MySmartBB->_POST['text'];
		
		$MySmartBB->rec->filter = "id='" . $PageInfo['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث الاعلان بنجاح !');
			$MySmartBB->func->move('admin.php?page=pages&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('page_del');		
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($PageInfo);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg('تم حذف الصفحه بنجاح !');
			$MySmartBB->func->move('admin.php?page=pages&amp;control=1&amp;main=1');
		}
	}
}

// TODO : KILL ME
class _func
{
	function check_by_id(&$PageInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$PageInfo = $MySmartBB->rec->getInfo();
		
		if ($PageInfo == false)
		{
			$MySmartBB->func->error('الصفحه المطلوبه غير موجوده');
		}
	}
}

?>
