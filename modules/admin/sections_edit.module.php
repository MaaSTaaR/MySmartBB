<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartSectionEditMOD');
	
class MySmartSectionEditMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_editMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_editStart();
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}

	private function _editMain()
	{
		global $MySmartBB;
		
		$this->checkID($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('section_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		// ... //
		
		$this->checkID($Inf);
		
		// ... //
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['sort']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 	= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['sort'] 	= 	$MySmartBB->_POST['sort'];
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		// ... //
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث القسم بنجاح !');
			$MySmartBB->func->move('admin.php?page=sections&amp;control=1&amp;main=1');
		}
		
		// ... //
	}
	
	private function checkID(&$Inf)
	{
		global $MySmartBB;
		
		// ... //
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		// ... //
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ($Inf == false)
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		// ... //
	}
}

?>
