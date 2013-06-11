<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartSmileMOD' );

class MySmartSmileMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_smile' );
		    
			$MySmartBB->load( 'icon' );
			
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

		$MySmartBB->template->display( 'smile_add' );
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'short' ] ) or empty( $MySmartBB->_POST[ 'path' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields[ 'smile_short' ] 	= 	$MySmartBB->_POST[ 'short' ];
		$MySmartBB->rec->fields[ 'smile_path' ] 	= 	$MySmartBB->_POST[ 'path' ];
		
		$insert = $MySmartBB->icon->insertSmile();
			
		if ( $insert )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'smile_added' ] );
			$MySmartBB->func->move( 'admin.php?page=smile&amp;control=1&amp;main=1' );
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->icon->getSmileList();
		
		$MySmartBB->template->display( 'smiles_main' );
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'Inf' ] = false;
		
		$this->__checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		$MySmartBB->template->display( 'smile_edit' );
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$Inf = false;
		
		$this->__checkID( $Inf );
		
		if ( empty( $MySmartBB->_POST[ 'short' ] ) or empty( $MySmartBB->_POST[ 'path' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );

		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields[ 'smile_short' ] 	= 	$MySmartBB->_POST[ 'short' ];
		$MySmartBB->rec->fields[ 'smile_path' ] 	= 	$MySmartBB->_POST[ 'path' ];
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$update = $MySmartBB->icon->updateSmile();
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'smile_updated' ] );
			$MySmartBB->func->move( 'admin.php?page=smile&amp;control=1&amp;main=1' );
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$this->__checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		$MySmartBB->template->display( 'smile_del' );
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$this->__checkID( $Inf );
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$del = $MySmartBB->icon->deleteSmile();
		
		if ( $del )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'smile_deleted' ] );
			$MySmartBB->func->move( 'admin.php?page=smile&amp;control=1&amp;main=1' );
		}
	}
	
	private function __checkID( &$Inf )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->icon->getSmileInfo();
		
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'smile_doesnt_exist' ] );
	}
}

?>
