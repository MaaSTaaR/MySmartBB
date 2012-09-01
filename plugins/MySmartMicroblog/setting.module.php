<?php

require_once( dirname( __FILE__ ) . '/common.php' );

define( 'PLUGIN_SETTING_CLASS_NAME', 'SettingMicroblog' );

class SettingMicroblog
{
    private $lang;
    private $api;
    
    public function run()
    {
        global $MySmartBB;
        
        // ... //
        
        $this->api = getAPI();
        
        $this->lang = $this->api->loadLanguage( 'setting' );
        
        // ... //
        
        if ( $MySmartBB->_GET[ 'main' ] )
        {
            $this->_settingMain();
        }
        elseif ( $MySmartBB->_GET[ 'start' ] )
        {
            $this->_settingStart();
        }
        else
        {
            $MySmartBB->func->error( $MySmartBB->lang[ 'wrong_path' ] );
        }
    }
    
    private function _settingMain()
    {
        global $MySmartBB;
        
        $MySmartBB->template->setAltTemplateDir( 'plugins/MySmartMicroblog/templates' );
        
        $MySmartBB->template->assign( 'plugin_lang', $this->lang[ 'template' ] );
        
        $MySmartBB->template->display( 'mysmartmicroblog_admin_setting', true );
    }
    
    private function _settingStart()
    {
        global $MySmartBB;
        
        $update = $MySmartBB->info->updateInfo( 'mysmartmicroblog_post_max_len', $MySmartBB->_POST[ 'length_of_post' ] );
        
        if ( $update )
        {
            $MySmartBB->func->msg( $this->lang[ 'update_succeed' ] );
            $MySmartBB->func->move( 'admin.php?page=plugins&amp;setting=1&amp;name=MySmartMicroblog&amp;main=1' );
        }
    }
}

?>
