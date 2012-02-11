<?php

define( 'PLUGIN_ACTION_CLASS_NAME', 'AddMicroblog' );

class AddMicroblog
{
    private $lang;
    private $api;
    
    public function run()
    {
        global $MySmartBB;
        
        if ( !$MySmartBB->_CONF[ 'member_permission' ] )
            $MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
        
        $MySmartBB->template->setAltTemplateDir( 'plugins/MySmartMicroblog/templates' );
        
        // ... //
        
        $this->api = getAPI();
        
        $this->lang = $this->api->loadLanguage( 'add' );
        
        // ... //
        
        if ( $MySmartBB->_GET[ 'main' ] )
        {
            $MySmartBB->loadLanguage( 'usercp' );
            
            $this->_addMain();
        }
        elseif ( $MySmartBB->_GET[ 'start' ] )
        {
            $this->_addStart();
        }
    }
    
    private function _addMain()
    {
        global $MySmartBB;
        
        $MySmartBB->func->showHeader( $this->lang[ 'template' ][ 'add_new_post' ]  );
        
        $MySmartBB->template->assign( 'plugin_lang', $this->lang[ 'template' ] );
        
        $MySmartBB->template->display( 'mysmartmicroblog_add_new_post', true );
        
        $MySmartBB->func->getFooter();
    }
    
    private function _addStart()
    {
        global $MySmartBB;
        
        $MySmartBB->func->showHeader( $this->lang[ 'template' ][ 'add_new_post' ] );
        
        if ( empty( $MySmartBB->_POST[ 'context' ] ) )
            $MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
        
        if ( strlen( $MySmartBB->_POST[ 'context' ] ) > $MySmartBB->_CONF[ 'info_row' ][ 'mysmartmicroblog_post_max_len' ] )
            $MySmartBB->func->error( $this->lang[ 'reached_max_length' ] );
        
        $MySmartBB->rec->table = $MySmartBB->getPrefix() . 'MySmartMicroblog_posts';
        $MySmartBB->rec->fields = array(    'member_id'     =>  $MySmartBB->_CONF[ 'member_row' ][ 'id' ] ,
                                            'context'       =>  $MySmartBB->_POST[ 'context' ],
                                            'date'          =>  time()   );
                                            
        $insert = $MySmartBB->rec->insert();
        
        if ( $insert )
        {
            $MySmartBB->func->msg( $this->lang[ 'post_added' ] );
            $MySmartBB->func->move( 'index.php?page=plugin&amp;name=MySmartMicroblog&amp;action=show&amp;id=' . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] );
        }
        
        $MySmartBB->func->getFooter();
    }
}

?>
