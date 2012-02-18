<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPrivateMassegeCPMOD');

class MySmartPrivateMassegeCPMOD
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'pm_cp' );
		
		if (!$MySmartBB->_CONF['info_row']['pm_feature'])
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'pm_feature_stopped' ] );
		}

		if (!$MySmartBB->_CONF['group_info']['use_pm'])
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_pm' ] );
		}

		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		}

		if ($MySmartBB->_GET['cp'])
		{
			if ($MySmartBB->_GET['del'])
			{
				$this->_deletePrivateMassege();
			}
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _deletePrivateMassege()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'delete_process' ] );
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->func->addressBar('<a href="index.php?page=pm&amp;list=1&amp;folder=inbox">' . $MySmartBB->lang[ 'template' ][ 'pm' ] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $MySmartBB->lang[ 'delete_process' ] );
		
		if ( !is_array( $MySmartBB->_POST[ 'delete_list' ] ) )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_complete_process' ] );
		}
		
		$MySmartBB->plugin->runHooks( 'pm_delete_start' );
		
		$k = 1;
		$array_size = sizeof( $MySmartBB->_POST[ 'delete_list' ] );
		
		$filter = "user_to='" . $MySmartBB->_CONF['member_row']['username'] . "' AND (";
		
		foreach ( $MySmartBB->_POST[ 'delete_list' ] as $key => $id )
		{
			$id = (int) $id;
			
			if ( empty( $id ) )
				continue;
				
			$filter .= "id='" . $id . "'";
			
			if ( $k++ != $array_size )
				$filter .= ' OR ';
			else
				$filter .= ')';
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->filter = $filter;
		
		$del = $MySmartBB->rec->delete();
			
		if ($del)
		{
			// Recount the number of new messages after delete this message
			$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
			$MySmartBB->rec->filter = "user_to='" . $MySmartBB->_CONF['member_row']['username'] . "' AND folder='inbox' AND user_read<>'1'";
			
			$Number = $MySmartBB->rec->getNumber();
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array(	'unread_pm'	=>	$Number	);
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
			
			$MySmartBB->rec->update();
			
			$MySmartBB->plugin->runHooks( 'pm_delete_success' );
			
			$MySmartBB->func->msg( $MySmartBB->lang[ 'delete_succeed' ] );
			$MySmartBB->func->move('index.php?page=pm_list&list=1&folder=inbox');
		}
	}
}
