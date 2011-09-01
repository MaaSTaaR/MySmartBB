<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartIndexMOD');

class MySmartIndexMOD
{
	public function run()
	{
		// Who can live without $MySmartBB ? ;)
		global $MySmartBB;
		
		$MySmartBB->func->showHeader();
		
		$MySmartBB->load( 'section' );
		
		$MySmartBB->plugin->runHooks( 'main_after_header' );
		
		$this->_getSections();
		$this->_getOnline();
		$this->_getToday();
		
		// Show the main template
		$this->_callTemplate();
		
		$MySmartBB->plugin->runHooks( 'main_before_footer' );
		
		$MySmartBB->func->getFooter();
	}
	
	/**
	 * Get sections list from cache and show it.
	 */
	private function _getSections()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList();
		
		// ... //
	}
		
	private function _getOnline()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->filter = "username='Guest'";
		
		$MySmartBB->_CONF['template']['GuestNumber'] = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->filter = "username<>'Guest'";
		
		$MySmartBB->_CONF['template']['MemberNumber'] = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'group_res' ] = '';
		
		$MySmartBB->rec->table		=	$MySmartBB->table['group'];
		$MySmartBB->rec->filter 	= 	"view_usernamestyle='1'";
		$MySmartBB->rec->order 		= 	'group_order ASC';
		$MySmartBB->rec->result 	= 	&$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'group_res' ];
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$and_statement = false;
		
		if ( !$MySmartBB->_CONF[ 'info_row' ][ 'show_onlineguest' ] )
		{
			$MySmartBB->rec->filter = "username<>'Guest'";
			
			$and_statement = true;
		}
		
		// This member can't see hidden member
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'show_hidden' ] )
		{
			if ( $and_statement )
				$MySmartBB->rec->filter .= ' AND ';
			
			$MySmartBB->rec->filter .= "hide_browse<>'1'";
		}
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'online_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->order = 'user_id DESC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'online_res' ];
		
		$MySmartBB->rec->getList();
		
		// ... //
	}
	
	private function _getToday()
	{
		global $MySmartBB;

		// ... //
		
		$MySmartBB->rec->filter = "username<>'Guest' AND user_date='" . $MySmartBB->_CONF['date'] . "'";
		
		if ( !isset( $MySmartBB->_CONF[ 'group_info' ][ 'show_hidden' ] ) 
			or !$MySmartBB->_CONF[ 'group_info' ][ 'show_hidden' ] )
		{
			$MySmartBB->rec->filter .= " AND hide_browse<>'1'";
		}
		
		$MySmartBB->_CONF['template']['res']['today_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'today' ];
		$MySmartBB->rec->order = 'user_id DESC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['today_res'];
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->_CONF['template']['TodayNumber'] = $MySmartBB->rec->getNumber( $MySmartBB->_CONF['template']['res']['today_res'] );
	}
	
	public function usernameStyleProcess( $row )
	{
		global $MySmartBB;
		
		if ( !empty( $row[ 'title' ] ) )
			$row[ 'username_style' ] = str_replace( '[username]', $row[ 'title' ], $row[ 'username_style' ] );
		
		$row[ 'username_style' ] =  $MySmartBB->func->cleanVariable( $row[ 'username_style' ], 'unhtml' );
	}
	
	private function _callTemplate()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->setInfoCallback( 'MySmartIndexMOD::usernameStyleProcess' );
		
		$MySmartBB->template->display( 'main' );
	}
}
	
// The end , Hey it's first module wrote for MySmartBB 2.0 :) , 24/5/2006 -> 4:24 PM

?>
