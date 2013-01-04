<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'IN_ADMIN', true );

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartPagesMOD' );

class MySmartPagesMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_pages' );
		    
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'add' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_addMain();
				}
				elseif ( $MySmartBB->_GET[ 'start' ] )
				{
					$this->_addStart();
				}
			}
			elseif ( $MySmartBB->_GET[ 'control' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_controlMain();
				}
			}
			elseif ( $MySmartBB->_GET[ 'edit' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_editMain();
				}
				elseif ( $MySmartBB->_GET[ 'start' ] )
				{
					$this->_editStart();
				}
			}
			elseif ( $MySmartBB->_GET[ 'del' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_delMain();
				}
				elseif ( $MySmartBB->_GET[ 'start' ] )
				{
					$this->_delStart();
				}
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display( 'page_add' );
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'text' ] ) or empty( $MySmartBB->_POST[ 'name' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 		= 	$MySmartBB->_POST[ 'name' ];
		$MySmartBB->rec->fields['html_code'] 	= 	$MySmartBB->func->cleanVariable( $MySmartBB->_POST[ 'text' ], 'unhtml' );
				
		$insert = $MySmartBB->rec->insert();
		
		if ( $insert )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'page_added' ] );
			$MySmartBB->func->move( 'admin.php?page=pages&amp;control=1&amp;main=1' );
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display( 'pages_main' );
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'Inf' ] = false;
		
		$this->__checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		$MySmartBB->template->display( 'page_edit' );		
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$info = false;
		
		$this->__checkID( $info );
		
		if ( empty( $MySmartBB->_POST[ 'text' ] ) or empty( $MySmartBB->_POST[ 'name' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		
		$MySmartBB->rec->fields		=	array();
		
		$MySmartBB->rec->fields['title'] 		= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['html_code'] 	= 	$MySmartBB->_POST['text'];
		
		$MySmartBB->rec->filter = "id='" . $info['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'page_updated' ] );
			$MySmartBB->func->move( 'admin.php?page=pages&amp;control=1&amp;main=1' );
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'Inf' ] = false;
		
		$this->__checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		$MySmartBB->template->display( 'page_del' );		
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$info = false;
		
		$this->__checkID( $info );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		$MySmartBB->rec->filter = "id='" . $info[ 'id' ] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'page_deleted' ] );
			$MySmartBB->func->move( 'admin.php?page=pages&amp;control=1&amp;main=1' );
		}
	}
	
	private function __checkID( &$PageInfo )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pages' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$PageInfo = $MySmartBB->rec->getInfo();
		
		if ( !$PageInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'page_doesnt_exist' ] );
	}
}

?>
