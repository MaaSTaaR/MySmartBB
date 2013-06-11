<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartMemberMOD' );

class MySmartMemberMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_member_merge' );
		    
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_mergeMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_mergeStart();
			}
				
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _mergeMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display( 'merge_users' );
	}

	private function _mergeStart()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_POST[ 'user_get' ] = 	trim( $MySmartBB->_POST[ 'user_get' ] );
		$MySmartBB->_POST[ 'user_to' ] 	= 	trim( $MySmartBB->_POST[ 'user_to' ] );

		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'user_get' ] ) or empty( $MySmartBB->_POST[ 'user_to' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['user_get'] . "'";
		
		$GetMemInfo = $MySmartBB->rec->getInfo();
		
		if ( !$GetMemInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'from_member_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['user_to'] . "'";
		
		$ToMemInfo = $MySmartBB->rec->getInfo();
		
		if ( !$ToMemInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'to_member_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->fields = array( 'writer' => $ToMemInfo['username'] );
		$MySmartBB->rec->filter = "writer='" . $GetMemInfo['username'] . "'";
		
		$u_subject = $MySmartBB->rec->update();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->fields = array( 'writer' => $ToMemInfo['username'] );;
		$MySmartBB->rec->filter = "writer='" . $GetMemInfo['username'] . "'";

		$u_reply = $MySmartBB->rec->update();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		
		$MySmartBB->rec->fields 				= 	array();
		$MySmartBB->rec->fields['posts'] 		= 	$ToMemInfo['posts']+$GetMemInfo['posts'];
		$MySmartBB->rec->fields['visitor'] 		= 	$ToMemInfo['visitor']+$GetMemInfo['visitor'];
		
		$MySmartBB->rec->filter = "username='" . $ToMemInfo['username'] . "'";
		
		$u_member = $MySmartBB->rec->update();
		
		// ... //
		
		// Announcements
		$MySmartBB->rec->table = $MySmartBB->table[ 'announcement' ];
		$MySmartBB->rec->fields = array( 'writer'=>$ToMemInfo['username'] );
		$MySmartBB->rec->filter = "writer='" . $GetMemInfo['username'] . "'";

		$update = $MySmartBB->rec->update();

		// Moderators
		$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
		$MySmartBB->rec->fields = array( 'username'=>$ToMemInfo['username'] );
		$MySmartBB->rec->filter = "username='" . $GetMemInfo['username'] . "'";

		$update = $MySmartBB->rec->update();

		// PM from
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->fields = array( 'user_from'=>$ToMemInfo['username'] );
		$MySmartBB->rec->filter = "user_from='" . $GetMemInfo['username'] . "'";

		$update = $MySmartBB->rec->update();

		// PM to
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->fields = array( 'user_to'=>$ToMemInfo['username'] );
		$MySmartBB->rec->filter = "user_to='" . $GetMemInfo['username'] . "'";

		$update = $MySmartBB->rec->update();

		// Requests
		$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
		$MySmartBB->rec->fields = array( 'username'=>$ToMemInfo['username'] );
		$MySmartBB->rec->filter = "username='" . $GetMemInfo['username'] . "'";

		$update = $MySmartBB->rec->update();

		// Subjects last replier
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->fields = array( 'last_replier'=>$ToMemInfo['username'] );
		$MySmartBB->rec->filter = "last_replier='" . $GetMemInfo['username'] . "'";

		$update = $MySmartBB->rec->update();

		// Vote
		$MySmartBB->rec->table = $MySmartBB->table[ 'vote' ];
		$MySmartBB->rec->fields = array( 'username'=>$ToMemInfo['username'] );
		$MySmartBB->rec->filter = "username='" . $GetMemInfo['username'] . "'";

		$update = $MySmartBB->rec->update();		
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $GetMemInfo['id'] . "'";
		
		$del = $MySmartBB->rec->delete();

		if ($u_subject and $u_reply and $u_member and $del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'member_merged' ] );
			$MySmartBB->func->move('admin.php?page=member&control=1&main=1');
		}
	}
}

?>
