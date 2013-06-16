<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartLatestMOD' );

class MySmartLatestMOD
{	
	public function today()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'latest' );
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang_common[ 'todays_topics' ] );
		
		// ... //
		
		$day 	= 	date( 'j' );
		$month 	= 	date( 'n' );
		$year 	= 	date( 'Y' );
		
		$from 	= 	mktime( 0, 0, 0, $month, $day, $year );
		$to 	= 	mktime( 23, 59, 59, $month, $day, $year );
		
		// ... //
		
		$MySmartBB->_CONF['template']['res']['latest_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "native_write_time BETWEEN " . $from . " AND " . $to . " AND delete_topic<>'1'";
		$MySmartBB->rec->order = "id DESC";
		$MySmartBB->rec->result = 	&$MySmartBB->_CONF['template']['res']['latest_res'];
				
		$MySmartBB->rec->getList();
				
		$number = $MySmartBB->rec->getNumber( $MySmartBB->_CONF['template']['res']['latest_res'] );
		
		if ( $number <= 0 )
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_new_topics' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'today_topic_start' );
		
		$MySmartBB->template->display( 'today_subject' );		
	}
}

?>
