<?php

include( 'reply_management.module.php' );

define( 'CLASS_NAME', 'MySmartReplyManagementEditMOD' );

class MySmartReplyManagementEditMOD extends MySmartReplyManagementMOD
{
	public function run( $id )
	{
		global $MySmartBB;
		
		parent::run( $id );
		
		// ... //
		
		$MySmartBB->load( 'reply,subject,section' );

		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'text' ] ) )
			die( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->fields = array(	'title'	=>	$MySmartBB->_POST[ 'title' ],
											'text'	=>	$MySmartBB->_POST[ 'text' ],
											'icon'	=>	$MySmartBB->_POST[ 'icon' ]	);
											
		$MySmartBB->rec->filter = "id='" . $this->reply_info[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		// ... //
		
		if ( $update )
			echo $MySmartBB->lang[ 'update_succeed' ];
	}
}

?>