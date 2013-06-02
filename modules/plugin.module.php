<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.module.php');

define('CLASS_NAME','MySmartPluginMOD');

class MySmartPluginMOD
{
	private $name;
	private $action;
	
	public function run( $name, $action )
	{
		global $MySmartBB;
		
		$this->name = $name;
		$this->action = $action;
		
		$MySmartBB->loadLanguage( 'plugin' );
		
		$this->_runPluginPage();
	}
	
	private function _runPluginPage()
	{
	    global $MySmartBB;
	    
	    // ... //
	    
	    if ( empty( $this->name ) or empty( $this->action ) )
	        $MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
	    
	    // ... //
	    
	    $MySmartBB->rec->table = $MySmartBB->table[ 'plugin' ];
	    $MySmartBB->rec->filter = "path='" . $this->name . "'";
	    
	    $plugin_info = $MySmartBB->rec->getInfo();
	    
	    // ... //
	    
	    if ( !$plugin_info )
	        $MySmartBB->func->error( $MySmartBB->lang[ 'page_doesnt_exist' ] );
	    
	    if ( !$plugin_info[ 'active' ] )
	        $MySmartBB->func->error( $MySmartBB->lang[ 'not_active_page' ] );
	    
	    // ... //
	    
	    $plugin_obj = $MySmartBB->plugin->createPluginObject( $plugin_info[ 'path' ] );
	    
	    $available_pages = $plugin_obj->pages();
	    
	    // ... //
	    
	    // The plugin doesn't use pages
	    if ( !is_array( $available_pages ) or sizeof( $available_pages ) <= 0 )
	        $MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
	    
	    if ( !array_key_exists( $this->action, $available_pages ) )
	        $MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
	    
	    // ... //
	    
	    include( 'plugins/' . $plugin_info[ 'path' ] . '/' . $available_pages[ $this->action ] );
	    
	    unset( $available_page, $plugin_info, $plugin_obj );
	    
	    $class_name = PLUGIN_ACTION_CLASS_NAME;
	    
	    $obj = new $class_name;
	    
	    $obj->run();
	    
	    $MySmartBB->template->unsetAltTemplateDir();
	}
}
	
?>
