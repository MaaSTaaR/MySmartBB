<?php

include( 'topic_management.module.php' );

define( 'CLASS_NAME', 'MySmartManagementMoveMOD' );

class MySmartManagementMoveMOD extends MySmartManagementMOD
{
	public function run( $id )
	{
		global $MySmartBB;
		
		parent::run( $id );

		// ... //
		
		$MySmartBB->load( 'subject,reply,section' );
		
		$update = $MySmartBB->subject->moveSubject( $MySmartBB->_POST[ 'section' ], $this->subject_info[ 'id' ] );
		
		if ( $update )
			echo $MySmartBB->lang[ 'subject_moved' ];
		else 
			echo $MySmartBB->lang[ 'operation_failed' ];
	}
}

?>