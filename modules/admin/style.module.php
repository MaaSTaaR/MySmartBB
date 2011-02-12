<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartStyleMOD');
	
class MySmartStyleMOD extends _func
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		
		if ($MySmartBB->_CONF['member_permission'])
		{
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

		$MySmartBB->template->display('style_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['style_on']) 
			or empty($MySmartBB->_POST['order']) 
			or empty($MySmartBB->_POST['style_path']) 
			or empty($MySmartBB->_POST['image_path']) 
			or empty($MySmartBB->_POST['template_path']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		
		$MySmartBB->rec->fields = array();
		
		$MySmartBB->rec->fields['style_title'] 		= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['style_path'] 		= 	$MySmartBB->_POST['style_path'];
		$MySmartBB->rec->fields['style_order'] 		= 	$MySmartBB->_POST['order'];
		$MySmartBB->rec->fields['style_on'] 		= 	$MySmartBB->_POST['style_on'];
		$MySmartBB->rec->fields['image_path'] 		= 	$MySmartBB->_POST['image_path'];
		$MySmartBB->rec->fields['template_path'] 	= 	$MySmartBB->_POST['template_path'];
		$MySmartBB->rec->fields['cache_path'] 		= 	$MySmartBB->_POST['cache_path'];
		
		$insert = $MySmartBB->rec->insert();
			
		if ($insert)
		{
			$MySmartBB->func->msg('تم اضافة النمط بنجاح !');
			$MySmartBB->func->move('admin.php?page=style&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->filter = 'id DESC';
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('styles_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('style_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($Inf);
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['style_on']) 
			or empty($MySmartBB->_POST['order']) 
			or empty($MySmartBB->_POST['style_path']) 
			or empty($MySmartBB->_POST['image_path']) 
			or empty($MySmartBB->_POST['template_path']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		/* ... */
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['style_title'] 		= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['style_path'] 		= 	$MySmartBB->_POST['style_path'];
		$MySmartBB->rec->fields['style_order'] 		= 	$MySmartBB->_POST['order'];
		$MySmartBB->rec->fields['style_on'] 		= 	$MySmartBB->_POST['style_on'];
		$MySmartBB->rec->fields['image_path'] 		= 	$MySmartBB->_POST['image_path'];
		$MySmartBB->rec->fields['template_path'] 	= 	$MySmartBB->_POST['template_path'];
		$MySmartBB->rec->fields['cache_path'] 		= 	$MySmartBB->_POST['cache_path'];
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		/* ... */
		
		if ($update)
		{
			/* ... */
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			
			$MySmartBB->rec->fields		=	array();
			
			$MySmartBB->rec->fields['should_update_style_cache'] 	= 	1;
			
			$MySmartBB->rec->filter = "style='" . $Inf['id'] . "'";
			
			$MySmartBB->rec->update();
			
			/* ... */
			
			$MySmartBB->func->msg('تم تحديث النمط بنجاح !');
			$MySmartBB->func->move('admin.php?page=style&amp;control=1&amp;main=1');
			
			/* ... */
		}
		
		/* ... */
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('style_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($Inf);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg('تم حذف النمط بنجاح !');
			$MySmartBB->func->move('admin.php?page=style&amp;control=1&amp;main=1');
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
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		if ($Inf == false)
		{
			$MySmartBB->func->error('النمط المطلوب غير موجود');
		}
	}
}

?>
