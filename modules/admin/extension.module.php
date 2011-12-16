<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartExtensionMOD');
	
class MySmartExtensionMOD extends _func
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
		    $MySmartBB->loadLanguage( 'admin_extension' );
		    
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['add'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_addExtensionMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_addExtensionStart();
				}
			}
			elseif ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_controlExtensionMain();
				}
			}
			elseif ($MySmartBB->_GET['edit'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_editExtensionMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_editExtensionStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_delExtensionMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_delExtensionStart();
				}
			}
			elseif ($MySmartBB->_GET['search'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_searchAttachMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_searchAttachStart();
				}
		   }
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _addExtensionMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('extension_add');
	}
	
	private function _addExtensionStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['extension']) 
			or empty($MySmartBB->_POST['max_size']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!strstr($MySmartBB->_POST['extension'],'.'))
		{
			$MySmartBB->_POST['extension'] = '.' . $MySmartBB->_POST['extension'];
		}
		
		$MySmartBB->_POST['extension'] = strtolower($MySmartBB->_POST['extension']);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'extension' ];
		$MySmartBB->rec->fields			=	array();
		
		$MySmartBB->rec->fields['Ex'] 			= 	$MySmartBB->_POST['extension'];
		$MySmartBB->rec->fields['max_size'] 	= 	$MySmartBB->_POST['max_size'];
		$MySmartBB->rec->fields['mime_type'] 	= 	$MySmartBB->_POST['mime_type'];
		
		$insert = $MySmartBB->rec->insert();
			
		if ($insert)
		{
			$MySmartBB->func->msg('تم اضافة الامتداد بنجاح !');
			$MySmartBB->func->move('admin.php?page=extension&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlExtensionMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'extension' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('extenstions_main');
	}
	
	private function _editExtensionMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('extenstion_edit');
	}

	private function _editExtensionStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		
		if (empty($MySmartBB->_POST['extension']) 
			or empty($MySmartBB->_POST['max_size']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'extension' ];
		
		$MySmartBB->rec->fields		=	array();
		
		$MySmartBB->rec->fields['Ex'] 			= 	$MySmartBB->_POST['extension'];
		$MySmartBB->rec->fields['max_size'] 	= 	$MySmartBB->_POST['max_size'];
		$MySmartBB->rec->fields['mime_type'] 	= 	$MySmartBB->_POST['mime_type'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث الامتداد بنجاح !');
			$MySmartBB->func->move('admin.php?page=extension&amp;control=1&amp;main=1');
		}
	}
	
	private function _delExtensionMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('extenstion_del');
	}
	
	private function _delExtensionStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'extension' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg('تم حذف الامتداد بنجاح !');
			$MySmartBB->func->move('admin.php?page=extension&amp;control=1&amp;main=1');
		}
	}
	
	private function _searchAttachMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('extension_search_main');
	}
	
	
	private function _searchAttachStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['keyword']))
		{
			$MySmartBB->func->error('يرجى كتابة كلمة البحث المطلوبه');
		}
		
		$field = 'filename';
		
		if ($MySmartBB->_POST['search_by'] == 'filename')
		{
			$field = 'filename';
		}
		elseif ($MySmartBB->_POST['search_by'] == 'filesize')
		{
			$field = 'filesize';
		}
		elseif ($MySmartBB->_POST['search_by'] == 'visitor')
		{
			$field = 'visitor';
		}
		else
		{
			$field = 'filename';
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
		$MySmartBB->rec->filter = $field;
		
		if ( $field == 'filename' )
		{
			$MySmartBB->rec->filter .= " filename LIKE %" . $MySmartBB->_POST['keyword'] . "%";
		}
		else
		{
			$MySmartBB->rec->filter .= "='" . $MySmartBB->_POST['keyword'] . "'";
		}
		
		$MySmartBB->_CONF['template']['Inf'] = $MySmartBB->rec->getInfo();
		
		if ($MySmartBB->_CONF['template']['Inf'] == false)
		{
			$MySmartBB->func->error('لا يوجد نتائج');
		}
		
		$MySmartBB->template->display('extension_search_result');
	}
}

// TODO : KILL ME
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
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'extension' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		if ($Inf == false)
		{
			$MySmartBB->func->error('الامتداد المطلوب غير موجود');
		}
	}
}

?>
