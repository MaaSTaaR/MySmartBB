<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPrivateMassegeListMOD');

class MySmartPrivateMassegeListMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'pm_list' );
		
		if (!$MySmartBB->_CONF['info_row']['pm_feature'])
			$MySmartBB->func->error( $MySmartBB->lang[ 'pm_feature_stopped' ] );
		
		if (!$MySmartBB->_CONF['group_info']['use_pm'])
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_pm' ] );

		if (!$MySmartBB->_CONF['member_permission'])
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		$MySmartBB->load( 'pm' );
		
		if ($MySmartBB->_GET['list'])
		{
			$this->_showList();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _showList()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'pm_list' ] );
		
		// ... //
		
		if ( empty( $MySmartBB->_GET[ 'folder' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->filter = ($MySmartBB->_GET['folder'] == 'inbox') ? 'user_to' : 'user_from';
		$MySmartBB->rec->filter .= "='" . $MySmartBB->_CONF['member_row']['username'] . "' AND folder='";
		$MySmartBB->rec->filter .= ($MySmartBB->_GET['folder'] == 'inbox') ? 'inbox' : 'sent';
		$MySmartBB->rec->filter .= "'";
		
		$number = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->_CONF['template']['res']['pmlist_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$number;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=pm_list&amp;list=1&amp;folder=' . $MySmartBB->_GET[ 'folder' ];
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['pmlist_res'];
		
		if ($MySmartBB->_GET['folder'] == 'sent')
		{
			$MySmartBB->template->assign( 'SENT_FOLDER', true );
			
			$GetMassegeList = $MySmartBB->pm->getSentList( $MySmartBB->_CONF['member_row']['username'] );
		}
		else
		{
			$MySmartBB->template->assign( 'INBOX_FOLDER', true );
			
			$GetMassegeList = $MySmartBB->pm->getInboxList( $MySmartBB->_CONF['member_row']['username'] );
		}
				
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->rec->setInfoCallback( array( 'MySmartPrivateMassegeListMOD', 'rowsProcessCB' ) );
		
		$MySmartBB->plugin->runHooks( 'pm_list_main' );
		
		$MySmartBB->template->display('pm_list');
		
		$MySmartBB->rec->removeInfoCallback();
	}
	
	public function rowsProcessCB( $row )
	{
		global $MySmartBB;
		
		$row[ 'date' ] = $MySmartBB->func->date( $row[ 'date' ] );
	}
}

?>
