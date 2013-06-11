<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include( 'common.module.php' );

define('CLASS_NAME','MySmartUserCPSubjectMOD');

class MySmartUserCPSubjectMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_option_subject' );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		$this->_subjectListMain();
		
		$MySmartBB->func->getFooter();
	}
	
	private function _subjectListMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'your_subjects' ] );
		
		$MySmartBB->_CONF['template']['res']['subject_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		
		$MySmartBB->rec->filter = "writer='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		$MySmartBB->rec->order = 'id DESC';
		$MySmartBB->rec->limit = '5';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['subject_res'];
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->plugin->runHooks( 'usercp_subject_start' );
		
		$MySmartBB->template->display('usercp_options_subjects');
	}
}

?>
