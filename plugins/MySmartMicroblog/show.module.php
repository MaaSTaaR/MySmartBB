<?php

define( 'PLUGIN_ACTION_CLASS_NAME', 'ShowMicroblog' );

class ShowMicroblog
{
    public function run()
    {
        global $MySmartBB;
        
        if ( empty( $MySmartBB->_GET[ 'id' ] ) )
            $MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
        
        $this->_showMicroblog();
    }
    
    private function _showMicroblog()
    {
        global $MySmartBB;
        
        $MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
        
        // ... //
        
        $MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
        $MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
        
        $member_info = $MySmartBB->rec->getInfo();
        
        // ... //
        
        if ( !$member_info )
            $MySmartBB->func->error( 'Sorry, no such member' );
        
        // ... //
        
        $MySmartBB->rec->table = $MySmartBB->getPrefix() . 'MySmartMicroblog_posts';
        $MySmartBB->rec->filter = "member_id='" . $MySmartBB->_GET[ 'id' ] . "'";
        $MySmartBB->rec->order = 'id DESC';
        
        $posts_res = &$MySmartBB->func->setResource();
        
        $MySmartBB->rec->getList();
        
        $MySmartBB->rec->setInfoCallback( 'ShowMicroblog::rowsProcessCB' );
        
        // ... //
        
        if ( $MySmartBB->rec->getNumber( $posts_res ) <= 0 )
            $MySmartBB->template->assign( 'NO_POST', 'true' );
        else
            $MySmartBB->template->assign( 'NO_POST', 'false' );
        
        // ... //
        
        $MySmartBB->func->showHeader( $member_info[ 'username' ] . '\'s Microblog' );
        
        // Set the alternative directory of the templates
        $MySmartBB->template->setAltTemplateDir( 'plugins/MySmartMicroblog/templates' );
        
        $MySmartBB->template->assign( 'username', $member_info[ 'username' ] );
        
        $MySmartBB->template->display( 'mysmartmicroblog_show_blog', true );
        
        $MySmartBB->rec->removeInfoCallback();
        
        $MySmartBB->func->getFooter();
        
        // ... //
    }
    
	public function rowsProcessCB( $row )
	{
		global $MySmartBB;
		
		if ( !empty( $row[ 'date' ] ) )
		    $row[ 'date' ] = $MySmartBB->func->date( $row[ 'date' ] );
	}
}

?>
