<?php

// TODO :   1- Audit this file (there is a duplicate code)
//          2- For now, this page expect from the user to provide the URL of the topic, it should get it automatically.

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartReportMOD');

class MySmartReportMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'report' );
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_memberReportIndex();
		}
		elseif ($MySmartBB->_GET['start'])
		{
			$this->_memberReportStart();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _memberReportIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'send_report' ] );
		
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission_visitors' ] );
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->template->assign( 'id', $MySmartBB->_GET[ 'id' ] );
		
		$MySmartBB->template->display('send_report');
	}
	
	private function _memberReportStart()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'send_report' ] );
		
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission_visitors' ] );
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		// ... //
		
		if (empty($MySmartBB->_POST['title'])
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$Report = $MySmartBB->func->mail(	$MySmartBB->_CONF['info_row']['admin_email'],
											$MySmartBB->_POST['title'],
											$MySmartBB->_POST['text'],
											$MySmartBB->_CONF['member_row']['email'] );
		
		if ($Report)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'report_sent' ] );
			$MySmartBB->func->goto('index.php');
		}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'send_failed' ] );
		}
	}
}

?>
