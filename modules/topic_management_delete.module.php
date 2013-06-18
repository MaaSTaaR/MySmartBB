<?php

include( 'topic_management.module.php' );

define( 'CLASS_NAME', 'MySmartManagementDeleteMOD' );

class MySmartManagementDeleteMOD extends MySmartManagementMOD
{
	public function run( $id )
	{
		global $MySmartBB;
		
		parent::run( $id );

		// ... //
		
		$MySmartBB->load( 'subject,reply,section,pm' );
		
		// ... //
		
		$update = $MySmartBB->subject->moveSubjectToTrash( $MySmartBB->_POST[ 'reason' ], $this->subject_info[ 'id' ], $this->subject_info[ 'section' ] );
		
		if ( $update )
		{
			// Send a private message to the writer with the reason of deletion.
			if ( !empty( $MySmartBB->_POST[ 'reason' ] ) )
			{
				// ... //
		
				$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
				$MySmartBB->rec->filter = "id='" . $this->subject_info[ 'id' ] . "'";
		
				$Subject = $MySmartBB->rec->getInfo();
		
				// ... //
		
				$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
				$MySmartBB->rec->fields = array(	'user_from'	=>	$MySmartBB->_CONF['member_row']['username'],
						'user_to'	=>	$Subject['writer'],
						'title'	=>	$MySmartBB->lang[ 'your_subject_deleted' ] . ' ' . $Subject['title'],
						'text'	=>	$MySmartBB->lang[ 'your_subject_deleted' ] . ' : ' . $MySmartBB->_POST['reason'],
						'date'	=>	$MySmartBB->_CONF['now'],
						'icon'	=>	$Subject['icon'],
						'folder'	=>	'inbox'	);
		
				$send = $MySmartBB->rec->insert();
		
				// ... //
		
				$number = $MySmartBB->pm->newMessageNumber( $Subject['writer'] );
		
				$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
				$MySmartBB->rec->fields = array(	'unread_pm'	=>	$number	);
				$MySmartBB->rec->filter = "username='" . $Subject[ 'writer' ] . "'";
		
				$update_cache = $MySmartBB->rec->update();
		
				// ... //
			}
				
			echo $MySmartBB->lang[ 'subject_deleted' ];
		}
	}
}

?>