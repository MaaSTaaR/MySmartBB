<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartSectionSortMOD');
	
class MySmartSectionSortMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_sections_sort' );
		    
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_changeSort();
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _changeSort()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent='0'";
		
		$MySmartBB->rec->getList();
		
		$x = 0;
		$s = array();
		
		while ( $row = $MySmartBB->rec->getInfo() )
		{
			$name = 'order-' . $row[ 'id' ];
			
			$MySmartBB->rec->table 				= 	$MySmartBB->table[ 'section' ];
			$MySmartBB->rec->fields				=	array();
			$MySmartBB->rec->fields['sort'] 	= 	$MySmartBB->_POST[$name];
			
			$MySmartBB->rec->filter = "id='" . $row[ 'id' ] . "'";
			
			$update = $MySmartBB->rec->update();
			
			$s[$SecList[$x]['id']] = ($update) ? 'true' : 'false';

			$x += 1;
		}
		
		if (in_array('false',$s))
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'process_failed' ] );
		}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=sections&amp;control=1&amp;main=1');
		}
	}
}

?>
