<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartMemberlistMOD');

class MySmartMemberlistMOD
{
	private $Section;
	
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'memberlist' );
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_getMemberList();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
		
	private function _getMemberList()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'memberlist' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		
		$members_num = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$members_num;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=member_list&amp;show=1&amp;id=' . $this->Section['id'];
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->order = "id ASC";
		
		$MySmartBB->rec->getList();

		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->template->display('show_memberlist');
	}
}
	
?>
