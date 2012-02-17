<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartChangeStyleMOD');

class MySmartChangeStyleMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'change_style' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'change_style' ] );
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->func->addressBar( $MySmartBB->lang[ 'change_style' ] );
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		if ($MySmartBB->_GET['change'])
		{
		    $MySmartBB->plugin->runHooks( 'change_style_start' );
		    
			if ( $MySmartBB->_CONF['member_permission'] )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
				$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
				$MySmartBB->rec->fields = array(	'style'	=>	$MySmartBB->_GET[ 'id' ]	);
				
				$change = $MySmartBB->rec->update();
			}
			else
			{
				setcookie( $MySmartBB->_CONF['style_cookie'], $MySmartBB->_GET[ 'id' ], time() + 31536000 );
			}
			
			if ($change)
			{
			    $MySmartBB->plugin->runHooks( 'change_style_success' );
			    
				$MySmartBB->func->msg( $MySmartBB->lang[ 'style_changed' ] );
				$MySmartBB->func->move('index.php');
			}
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter();
	}
}

?>
