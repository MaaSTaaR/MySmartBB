<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartSectionGroupsMOD');
	
class MySmartSectionGroupsMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_sections_groups' );
		    
			$MySmartBB->load( 'group' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'index' ] )
			{
				$this->_groupControlMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_groupControlStart();
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}

	private function _groupControlMain()
	{
		global $MySmartBB;
		
		$this->checkID($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "' AND main_section='1'";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('sections_groups_control_main');
	}
	
	private function _groupControlStart()
	{
		global $MySmartBB;
		
		// ... //
		
		$this->checkID($Inf);
		
		// ... //
		
		$MySmartBB->_GET['group_id'] = (int) $MySmartBB->_GET['group_id'];
		
		// ... //
		
		$success 	= 	array();
		$fail		=	array();
		$size		=	sizeof($MySmartBB->_POST['groups']);
		
		foreach ($MySmartBB->_POST['groups'] as $id => $val)
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
			$MySmartBB->rec->fields						=	array();
			$MySmartBB->rec->fields['view_section'] 	= 	$val['view_section'];
			
			$MySmartBB->rec->filter = "group_id='" . $id . "' AND section_id='" . $Inf[ 'id' ] . "'";
			
			$update = $MySmartBB->rec->update();

			if ($update)
			{
				$success[] = $id;
			}
			else
			{
				$fail[] = $id;
			}
			
			unset($update);
		}
		
		// ... //
		
		$success_size 	= 	sizeof($success);
		$fail_size		=	sizeof($fail); // Why??
		
		// ... //
		
		if ($success_size == $size)
		{
			// ... //
			
			$MySmartBB->func->msg('تم التحديث بنجاح!');
			
			// ... //
			
			$cache = $MySmartBB->group->updateSectionGroupCache( $Inf['id'] );
			
			// ... //
			
			if ($cache)
			{
				$MySmartBB->func->msg('تم تحديث المعلومات المخبأه');
				$MySmartBB->func->move('admin.php?page=sections_groups&amp;index=1&amp;id=' . $Inf['id']);
			}
		}
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
