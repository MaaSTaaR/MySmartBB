<?php

include( 'reply_management.module.php' );

define( 'CLASS_NAME', 'MySmartReplyManagementBasicsMOD' );

class MySmartReplyManagementBasicsMOD extends MySmartReplyManagementMOD
{
	public function run( $id )
	{
		global $MySmartBB;
		
		parent::run( $id );
		
		// ... //
		
		$MySmartBB->load( 'reply,subject,section' );

		// ... //
		
		if ( $MySmartBB->_POST[ 'delete' ] == 'on' )
		{
			$update = $MySmartBB->reply->moveReplyToTrash( $this->reply_info[ 'id' ], $this->reply_info[ 'subject_id' ], $this->reply_info[ 'section' ] );
		
			if ( $update )
				echo $MySmartBB->lang[ 'reply_deleted' ];
		}
	}
}

?>