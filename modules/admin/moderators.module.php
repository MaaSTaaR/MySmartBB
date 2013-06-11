<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartModeratorsMOD' );

class MySmartModeratorsMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_moderators' );
		    
			$MySmartBB->load( 'moderator,section' );
			
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
				elseif ( $MySmartBB->_GET[ 'section' ] )
				{
					$this->_controlSection();
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
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList( false );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "group_mod='1'";
		$MySmartBB->rec->order = "group_order ASC";
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->template->display( 'moderator_add' );
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'username' ] ) or empty( $MySmartBB->_POST[ 'section' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST[ 'username' ] . "'";
		
		$Member = $MySmartBB->rec->getInfo();
		
		if ( !$Member )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST[ 'section' ] . "'";
		
		$SectionInfo = $MySmartBB->rec->getInfo();
		
		if ( !$SectionInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
		
		// ... //
		
		// Check if the member is already a moderator on the same forum, if yes show an error
		$IsModerator = $MySmartBB->moderator->isModerator( $MySmartBB->_POST['username'], 'username', $MySmartBB->_POST['section'] );
		
		if ( $IsModerator )
			$MySmartBB->func->error( $MySmartBB->lang[ 'duplicate_addition' ] );
		
		// ... //
		
		$usertitle = ( empty( $MySmartBB->_POST[ 'usertitle' ] ) ) ? null : $MySmartBB->_POST[ 'usertitle' ];
		
		$set = $MySmartBB->moderator->setModerator( $Member, $SectionInfo, $MySmartBB->_POST[ 'group' ], $usertitle );
		    
		if ( $set )
		{
			$MySmartBB->func->msg(  $MySmartBB->lang[ 'moderator_added' ]  );
			$MySmartBB->func->move( 'admin.php?page=moderators&amp;control=1&amp;section=1&amp;id=' . $SectionInfo[ 'id' ] );
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList( false );
		
		$MySmartBB->template->display( 'moderators_main' );
	}

	private function _controlSection()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$MySmartBB->_CONF[ 'template' ][ 'Section' ] = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'template' ][ 'Section' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
		$MySmartBB->rec->filter = "section_id='" . $MySmartBB->_CONF[ 'template' ][ 'Section' ][ 'id' ] . "'";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display( 'moderators_section_control' );
	}
		
	private function _delMain()
	{
		global $MySmartBB;
		
		$this->__checkID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'template' ][ 'Inf' ][ 'section_id' ] . "'";
		
		$MySmartBB->_CONF[ 'template' ][ 'Section' ] = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'template' ][ 'Section' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->template->display( 'moderator_del' );
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$ModInfo = null;
		
		$this->__checkID( $ModInfo );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $ModInfo[ 'member_id' ] . "'";
		
		$member_info = $MySmartBB->rec->getInfo();
		
		$unset = $MySmartBB->moderator->unsetModerator( $ModInfo, $member_info );
				
		if ( $unset )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'moderator_deleted' ] );
			$MySmartBB->func->move('admin.php?page=moderators&amp;control=1&amp;section=1&amp;id=' . $ModInfo['section_id']);
		}
	}
	
	private function __checkID( &$ModeratorInfo )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$ModeratorInfo = $MySmartBB->rec->getInfo();
		
		if ( !$ModeratorInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'moderator_doesnt_exist' ] );
	}
}

?>
