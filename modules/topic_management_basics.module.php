<?php

include( 'topic_management.module.php' );

define( 'CLASS_NAME', 'MySmartManagementBasicsMOD' );

class MySmartManagementBasicsMOD extends MySmartManagementMOD
{
	public function run( $id )
	{
		global $MySmartBB;
		
		parent::run( $id );

		// ... //
		
		$MySmartBB->load( 'subject' );
		
		// ... //
		
		if ( $MySmartBB->_POST[ 'stick' ] == 'on' )
			$MySmartBB->subject->stickSubject( $this->subject_info[ 'id' ] );
		else
			$MySmartBB->subject->unStickSubject( $this->subject_info[ 'id' ] );
		
		// ... //
		
		if ( $MySmartBB->_POST[ 'close' ] == 'on' )
			$MySmartBB->subject->closeSubject( null, $this->subject_info[ 'id' ] );
		else
			$MySmartBB->subject->openSubject( $this->subject_info[ 'id' ] );
		
		// ... //
		
		echo $MySmartBB->lang[ 'update_succeed' ];
	}
}

?>