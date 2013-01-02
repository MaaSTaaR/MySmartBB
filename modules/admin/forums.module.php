<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartForumsMOD');
	
class MySmartForumsMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_forums' );
		    
			$MySmartBB->load( 'section' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'control' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_controlMain();
				}
			}
			elseif ( $MySmartBB->_GET[ 'forum' ] )
			{
				if ( $MySmartBB->_GET[ 'index' ] )
				{
					$this->_forumMain();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
		
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList( false );
		
		$MySmartBB->template->display( 'forums_main' );
	}
	
	
	// Fetch sub sections of a specific section
	private function _forumMain()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'Inf' ] = false;
		
		$this->checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		// ... //
		
		if ( !empty( $MySmartBB->_CONF[ 'template' ][ 'Inf' ][ 'forums_cache' ] ) )
		{
			$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = unserialize( base64_decode( $MySmartBB->_CONF[ 'template' ][ 'Inf' ][ 'forums_cache' ] ) );
		
			$size = sizeof( $MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] );
		
			if ( $size <= 0 )
				$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = array();
		}
		else
		{
			$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = array();
		}
		
		// ... //
		
		$MySmartBB->template->display( 'forums_main' );
	}
	
	private function checkID( &$Inf )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
	}
}

?>
