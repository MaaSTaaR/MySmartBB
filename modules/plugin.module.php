<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartPluginMOD');

class MySmartPluginMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$this->_runPluginPage();
	}
	
	private function _runPluginPage()
	{
	    global $MySmartBB;
	    
	    if ( empty( $MySmartBB->_GET[ 'name' ] ) or empty( $MySmartBB->_GET[ 'action' ] ) )
	        $MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
	    
	    $MySmartBB->rec->table = $MySmartBB->table[ 'plugin' ];
	    $MySmartBB->rec->filter = "path='" . $MySmartBB->_GET[ 'name' ] . "'";
	    
	    $plugin_info = $MySmartBB->rec->getInfo();
	    
	    if ( !$plugin_info )
	        $MySmartBB->func->error( 'The required page doesn\'t exist' );
	    
	    if ( !$plugin_info[ 'active' ] )
	        $MySmartBB->func->error( 'The page is not active' );
	    
	    $plugin_obj = $MySmartBB->plugin->createPluginObject( $plugin_info[ 'path' ] );
	    
	    $available_pages = $plugin_obj->pages();
	    
	    // The plugin doesn't use pages
	    if ( !is_array( $available_pages ) or sizeof( $available_pages ) <= 0 )
	        $MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
	    
	    if ( !array_key_exists( $MySmartBB->_GET[ 'action' ], $available_pages ) )
	        $MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
	    
	    include( 'plugins/' . $plugin_info[ 'path' ] . '/' . $available_pages[ $MySmartBB->_GET[ 'action' ] ] );
	    
	    unset( $available_page, $plugin_info, $plugin_obj );
	    
	    $class_name = PLUGIN_ACTION_CLASS_NAME;
	    
	    $obj = new $class_name;
	    
	    $obj->run();
	    
	    $MySmartBB->template->unsetAltTemplateDir();
	}
}
	
?>
