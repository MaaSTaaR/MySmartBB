<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPSubjectMOD');

class MySmartUserCPSubjectMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_option_subject' );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		}
		
		if ( $MySmartBB->_GET[ 'main' ] )
		{
			$this->_subjectListMain();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _subjectListMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->ShowHeader( $MySmartBB->lang[ 'your_subjects' ] );
		
		/*$SubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$SubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);*/
		
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
