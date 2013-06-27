<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartSectionEditMOD' );

class MySmartSectionEditMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_sections_edit' );
		    
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_editMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_editStart();
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}

	private function _editMain()
	{
		global $MySmartBB;
		
		$this->checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		$MySmartBB->template->display( 'section_edit' );
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		// ... //
		
		$this->checkID($Inf);
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'name' ] ) or empty( $MySmartBB->_POST[ 'sort' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields[ 'title' ] 	= 	$MySmartBB->_POST[ 'name' ];
		$MySmartBB->rec->fields[ 'sort' ] 	= 	$MySmartBB->_POST[ 'sort' ];
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		// ... //
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'section_updated' ] );
			$MySmartBB->func->move( 'admin.php?page=sections&amp;control=1&amp;main=1' );
		}
		
		// ... //
	}
	
	private function checkID( &$Inf )
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );

		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'section_doesnt_exist' ] );
		
		// ... //
	}
}

?>
