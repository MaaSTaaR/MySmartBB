<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartProfileMOD' );

class MySmartProfileMOD
{
	public function id( $member_id )
	{
		$this->run( $member_id, true );
	}
	
	public function run( $member_id, $get_by_id = false )
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'profile' );
		
		// ... //

		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'view_member_info' ] );
		
		// ... //
		
		$MySmartBB->load( 'icon' );
		
		$MySmartBB->plugin->runHooks( 'show_profile_start' );
		
		// ... //
		
		// To save some of server's resources when the member shows his/her own profile
		// we don't execute a new query because we already have the information
		// of the member stored in $MySmartBB->_CONF['member_row']
		$do_query = true;
		
		if ( $get_by_id )
		{
			$id = (int) $member_id;
			
			$MySmartBB->rec->filter = "id='" . $id . "'";
			
			if ( $MySmartBB->_CONF[ 'member_permission' ] )
				$do_query = ( $MySmartBB->_CONF[ 'member_row' ][ 'id' ] == $id ) ? false : true;
			
			$numeric_param = true;
		}
		else
		{
			$MySmartBB->rec->filter = "username='" . $member_id . "'";
			
			if ( $MySmartBB->_CONF[ 'member_permission' ] )
				$do_query = ( $MySmartBB->_CONF[ 'member_row' ][ 'username' ] == $member_id ) ? false : true;
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		
		$MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ] = ( $do_query ) ? $MySmartBB->rec->getInfo() : $MySmartBB->_CONF[ 'member_row' ];
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_doesnt_exist' ] );
		
		// ... //
		
		// Where is the member now?
     	$MySmartBB->online->updateMemberLocation( $MySmartBB->lang[ 'viewing_member_profile' ] . $MySmartBB->lang_common[ 'colon' ] . ' ' . $MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ][ 'username' ] );
     	
     	// ... //
     	
     	$MySmartBB->member->processMemberInfo( $MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ] );
		
		// ... //
		
		// If the member who we are showing his/her profile belongs to the same
		// group of the current member (that is, the member who are showing the profile)
		// don't do a query, we already have the information of the group stored in $MySmartBB->_CONF['group_info']
		if ( $MySmartBB->_CONF[ 'member_permission' ] 
			and $MySmartBB->_CONF[ 'member_row' ][ 'usergroup' ] == $MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ][ 'usergroup' ] )
		{
			$GroupInfo = $MySmartBB->_CONF[ 'group_info' ];
		}
		else
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ][ 'usergroup' ] . "'";
			
			$GroupInfo = $MySmartBB->rec->getInfo();
		}
			
		$MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ][ 'usergroup' ] = $GroupInfo[ 'title' ];
		
		if ( $MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ][ 'posts' ] > 0 )
		{
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
			$MySmartBB->rec->filter = "writer='" . $MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ][ 'username' ] . "' AND delete_topic<>'1' AND sec_subject<>'1'";
			$MySmartBB->rec->order = "id DESC";
			$MySmartBB->rec->limit = '0,1';
			
			$MySmartBB->_CONF[ 'template' ][ 'LastSubject' ] = $MySmartBB->rec->getInfo();
			
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
			$MySmartBB->rec->filter = "writer='" . $MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ][ 'username' ] . "' AND delete_topic<>'1'";
			$MySmartBB->rec->order = "id DESC";
			$MySmartBB->rec->limit = '1';
			
			$GetLastReplyInfo = $MySmartBB->rec->getInfo();
		
			if ( $GetLastReplyInfo != false )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
				$MySmartBB->rec->filter = "id='" . $GetLastReplyInfo[ 'subject_id' ] . "'";
				
				$MySmartBB->_CONF[ 'template' ][ 'LastReply' ] = $MySmartBB->rec->getInfo();				
			}
		}
		
		// ... //
		
		// TODO : For what?
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ][ 'username' ] . "'";
		
		$MySmartBB->_CONF[ 'template' ][ 'Location' ] = $MySmartBB->rec->getInfo();
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'show_profile_end' );
		
		$MySmartBB->template->display( 'profile' );
		
		$MySmartBB->func->getFooter();
	}
}
	
?>