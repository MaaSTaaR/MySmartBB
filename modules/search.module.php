<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartSearchEngineMOD');

class MySmartSearchEngineMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'search' );
		
		if ( $MySmartBB->_GET[ 'index' ] )
		{
			$this->_searchForm();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_startSearch();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _searchForm()
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'section' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'the_search' ] );
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList();
		
		$MySmartBB->plugin->runHooks( 'search_main' );
		
		$MySmartBB->template->display( 'search' );
	}
	
	private function _startSearch()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'search_result' ] );
		
		// ... //
		
		$keyword 	= 	$MySmartBB->func->cleanVariable( $MySmartBB->_GET[ 'keyword' ], 'html' );
		$username 	= 	$MySmartBB->func->cleanVariable( $MySmartBB->_GET[ 'username' ], 'html' );
		$section 	= 	$MySmartBB->func->cleanVariable( $MySmartBB->_GET[ 'section' ], 'html' );
		
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
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'search_res' ];
		$MySmartBB->rec->filter = $filter;
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->rec->setInfoCallback( array( 'MySmartSearchEngineMOD', 'rowsProcessCB' ) );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'search_action_start' );
		
		// ... //
		
		$MySmartBB->template->assign( 'highlight', $keyword );
		
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
