<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define('CLASS_NAME','MySmartAttachStatisticsMOD');

class MySmartAttachStatisticsMOD
{
	public function run()
	{
		global $MySmartBB;

		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
			//$MySmartBB->loadLanguage( 'admin_announcement' );

			$MySmartBB->template->display( 'header' );
				
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_main();
			}
				
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _main()
	{
		global $MySmartBB;
		
		$stat = array();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
		
		$stat[ 'attach_total' ] = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->rec->select = 'SUM(filesize) AS size_total';
		$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
		
		$info = $MySmartBB->rec->getInfo();
		
		$stat[ 'size_total' ] = ( is_null( $info[ 'size_total' ] ) ) ? 0 :  $info[ 'size_total' ]; 
		
		$stat[ 'size_total' ] = $stat[ 'size_total' ] / 1048576;
		
		// ... //
		
		$MySmartBB->rec->select = 'SUM(visitor) AS downloads_total';
		$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
		
		$info = $MySmartBB->rec->getInfo();
		
		$stat[ 'downloads_total' ] = ( is_null( $info[ 'downloads_total' ] ) ) ? 0 :  $info[ 'downloads_total' ];
		
		// ... //
		
		$MySmartBB->rec->select = 'attach.*,MAX(attach.visitor),topics.title AS topic_title,topics.writer AS topic_writer';
		$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ] . ' AS attach,' . $MySmartBB->table[ 'subject' ] . ' AS topics';
		$MySmartBB->rec->filter = "attach.pm_id='0' AND attach.reply='0' AND topics.id=attach.subject_id";
		
		$info = $MySmartBB->rec->getInfo();
		
		$stat[ 'top_downloaded' ] = $info;
		
		// ... //
		
		unset( $info );
		
		$MySmartBB->template->assign( 'stat', $stat );
		
		// ... //
		
		$MySmartBB->template->display( 'attachments_statistics' );
	}
}

?>