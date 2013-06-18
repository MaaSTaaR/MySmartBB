<?php

include( 'topic_management.module.php' );

define( 'CLASS_NAME', 'MySmartManagementEditMOD' );

class MySmartManagementEditMOD extends MySmartManagementMOD
{
	public function run( $id )
	{
		global $MySmartBB;
		
		parent::run( $id );

		// ... //
		
		if ( !isset( $MySmartBB->_POST[ 'title' ] ) or !isset( $MySmartBB->_POST[ 'text' ] ) )
			die( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->fields = array(	'title'	=>	$MySmartBB->_POST[ 'title' ],
											'text'	=>	$MySmartBB->_POST[ 'text' ],
											'subject_describe'	=>	$MySmartBB->_POST[ 'describe' ]	);
		
		$MySmartBB->rec->filter = "id='" . $this->subject_info[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
			echo $MySmartBB->lang[ 'update_succeed' ];
		else
			echo $MySmartBB->lang[ 'operation_failed' ];
	}
}

?>