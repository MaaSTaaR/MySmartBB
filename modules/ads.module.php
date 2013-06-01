<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include( 'common.module.php' );

define('CLASS_NAME','MySmartAdsPageMOD');

class MySmartAdsPageMOD
{
	private $id;
	
	public function run( $id )
	{
		global $MySmartBB;
		
		$this->id = (int) $id;
		
		$MySmartBB->loadLanguage( 'ads' );
		
		$this->_goToSite();
		
		$MySmartBB->func->getFooter();
	}
	
	private function _goToSite()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'move_to_site' ] );
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'move_to_site' ] );
		
		// ... //
		
		if ( empty( $this->id ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "'";
		
		$AdsRows = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$AdsRows )
			$MySmartBB->func->error( $MySmartBB->lang[ 'ads_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'ads_goto_start' );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		$MySmartBB->rec->fields = array(	'clicks'	=> $AdsRows['clicks'] + 1	);
		$MySmartBB->rec->filter = "id='" . $AdsRows['id'] . "'";
		
		$query = $MySmartBB->rec->update();
		
		// ... //
		
		$MySmartBB->func->msg( $MySmartBB->lang[ 'please_wait' ] . $AdsRows[ 'sitename' ] );
		$MySmartBB->func->move( $AdsRows[ 'site' ] );
		
		// ... //
	}
}
	
?>
