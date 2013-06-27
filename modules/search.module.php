<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include( 'common.module.php' );

define('CLASS_NAME','MySmartSearchEngineMOD');

class MySmartSearchEngineMOD
{
	private function commonProcesses()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'search' );
	}
	
	public function run()
	{
		global $MySmartBB;
		
		$this->commonProcesses();
		
		$MySmartBB->load( 'section' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'the_search' ] );
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList();
		
		$MySmartBB->plugin->runHooks( 'search_main' );
		
		$MySmartBB->template->display( 'search' );		
	}
	
	public function start()
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'subject' );
		
		$this->commonProcesses();
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'search_result' ] );
		
		// ... //
		
		// TODO : I don't think we still need these lines
		$keyword 	= 	$MySmartBB->func->cleanVariable( $MySmartBB->_POST[ 'keyword' ], 'html' );
		$username 	= 	$MySmartBB->func->cleanVariable( $MySmartBB->_POST[ 'username' ], 'html' );
		$section 	= 	$MySmartBB->func->cleanVariable( $MySmartBB->_POST[ 'section' ], 'html' );
		
		// ... //
		
		if ( empty( $keyword ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'please_write_keyword' ] );
		
		// ... //
		
		$filter = "(title LIKE '%" . $keyword . "%' OR text LIKE '%" . $keyword . "%')";
		
		if ( !empty( $username ) )
			$filter .= " AND writer='" . $username . "'";
		
		if ( !empty( $section ) and $section != 'all' )
			$filter .= " AND section='" . $section . "'";
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'search_res' ] = '';
		
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'search_res' ];
		
		$MySmartBB->subject->getPublicTopicList( $filter );
		
		// ... //
		
		$MySmartBB->rec->setInfoCallback( array( 'MySmartSearchEngineMOD', 'rowsProcessCB' ) );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'search_action_start' );
		
		// ... //
		
		//$MySmartBB->template->assign( 'highlight', $keyword );
		
		$MySmartBB->template->display( 'search_results' );
		
		$MySmartBB->rec->removeInfoCallback();		
	}
	
	public function rowsProcessCB( $row )
	{
		global $MySmartBB;
		
		$row[ 'write_date' ] = $MySmartBB->func->date( $row[ 'native_write_time' ] );
	}
}
	
?>
