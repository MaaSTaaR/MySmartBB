<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartChangeStyleMOD' );

class MySmartChangeStyleMOD
{
	public function run( $id )
	{
		global $MySmartBB;
		
		$id = (int) $id;
		
		$MySmartBB->loadLanguage( 'change_style' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'change_style' ] );
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'change_style' ] );
		
		if ( empty( $id ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		if ( $MySmartBB->_GET[ 'change' ] )
		{
		    $MySmartBB->plugin->runHooks( 'change_style_start' );
		    
			if ( $MySmartBB->_CONF[ 'member_permission' ] )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
				$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
				$MySmartBB->rec->fields = array(	'style'	=>	$id	);
				
				$change = $MySmartBB->rec->update();
			}
			else
			{
				$change = setcookie( $MySmartBB->_CONF['style_cookie'], $id, time() + 31536000 );
			}
			
			if ($change)
			{
			    $MySmartBB->plugin->runHooks( 'change_style_success' );
			    
				$MySmartBB->func->msg( $MySmartBB->lang[ 'style_changed' ] );
				$MySmartBB->func->move( '' );
			}
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}		
	}
}

?>
