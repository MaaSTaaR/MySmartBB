<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartIconMOD' );
	
class MySmartIconMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_icon' );
		    
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

		$MySmartBB->template->display( 'icon_add' );
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'path' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->fields	=array( 'smile_path' => $MySmartBB->_POST[ 'path' ] );
		
		$insert = $MySmartBB->icon->insertIcon();
			
		if ( $insert )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'icon_added' ] );
			$MySmartBB->func->move( 'admin.php?page=icon&amp;control=1&amp;main=1' );
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->icon->getIconList();
		
		$MySmartBB->template->display( 'icons_main' );
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'Inf' ] = false;
		
		$this->__checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		$MySmartBB->template->display( 'icon_edit' );
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$info = false;
		
		if ( empty( $MySmartBB->_POST[ 'path' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$this->__checkID( $info );
		
		$MySmartBB->rec->filter = "id='" . $info[ 'id' ] . "'";
		$MySmartBB->rec->fields	= array( 'smile_path' => $MySmartBB->_POST[ 'path' ] );
				
		$update = $MySmartBB->icon->updateIcon();
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'icon_updated' ] );
			$MySmartBB->func->move( 'admin.php?page=icon&amp;control=1&amp;main=1' );
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'Inf' ] = false;
		
		$this->__checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		$MySmartBB->template->display( 'icon_del' );
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$info = false;
		
		$this->__checkID( $info );
		
		$MySmartBB->rec->filter = "id='" . $info[ 'id' ] . "'";
		
		$del = $MySmartBB->icon->deleteIcon();
		
		if ( $del )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'icon_deleted' ] );
			$MySmartBB->func->move( 'admin.php?page=icon&amp;control=1&amp;main=1' );
		}
	}
	
	private function __checkID( &$Inf )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->icon->getIconInfo();
		
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'icon_doesnt_exist' ] );
	}
}

?>
