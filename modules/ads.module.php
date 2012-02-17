<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartAdsPageMOD');

class MySmartAdsPageMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'ads' );
		
		if ($MySmartBB->_GET['goto'])
		{
			$this->_goToSite();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _goToSite()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'move_to_site' ] );
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'move_to_site' ] );
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$AdsRows = $MySmartBB->rec->getInfo();
		
		if (!$AdsRows)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'ads_doesnt_exist' ] );
		}
		
		$MySmartBB->plugin->runHooks( 'ads_goto_start' );
		
		$MySmartBB->rec->table = $MySmartBB->table['ads'];
		$MySmartBB->rec->fields = array(	'clicks'	=> $AdsRows['clicks'] + 1	);
		$MySmartBB->rec->filter = "id='" . $AdsRows['id'] . "'";
		
		$query = $MySmartBB->rec->update();
		
		$MySmartBB->func->msg( $MySmartBB->lang[ 'please_wait' ] . $AdsRows['sitename'] );
		$MySmartBB->func->move($AdsRows['site']);
	}
}
	
?>
