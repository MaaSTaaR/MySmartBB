<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartMemberMOD');
	
class MySmartMemberMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_member_edit' );
		    
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
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->checkID($MySmartBB->_CONF['template']['Inf']);
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->func->setResource( 'style_res' );
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->func->setResource( 'group_res' );
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->template->display('member_edit');
		
		// ... //
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$MemInfo = false;
		
		$this->checkID( $MemInfo );
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'email' ] ) or empty( $MySmartBB->_POST[ 'user_title' ] ) or !isset( $MySmartBB->_POST[ 'posts' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		if ( !$MySmartBB->func->checkEmail( $MySmartBB->_POST['email'] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'write_correct_email' ] );
		
		// ... //
		
		// Ensure there is no person used the same username
		if ( !empty( $MySmartBB->_POST[ 'new_username' ] ) )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['new_username'] . "'";
		
			$isMember = $MySmartBB->rec->getNumber();
		
			if ( $isMember > 0 )
				$MySmartBB->func->error( $MySmartBB->lang[ 'username_exists' ] );
		}

		if ( $MySmartBB->_POST[ 'username' ] == 'Guest' )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forbidden_username' ] );
		
		// ... //
		
		$username = ( !empty( $MySmartBB->_POST[ 'new_username' ] ) ) ? $MySmartBB->_POST[ 'new_username' ] : $MemInfo[ 'username' ];
		$old_username = $MemInfo[ 'username' ];
		
		// ... //
		
		// If the admin changed the group of this member, so we should change the cache of username style
		
		if ( $MySmartBB->_POST['usergroup'] != $MemInfo['usergroup'] or !empty( $MySmartBB->_POST[ 'new_username' ] ) )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST['usergroup'] . "'";
			
			$GroupInfo = $MySmartBB->rec->getInfo();
			
			$style = $GroupInfo['username_style'];
			$username_style_cache = str_replace('[username]',$username,$style);
		}
		else
		{
			$username_style_cache = null;
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		
		$MySmartBB->rec->fields 	= 	array();
		
		$MySmartBB->rec->fields['username'] 			= 	$username;
		$MySmartBB->rec->fields['password'] 			= 	(!empty($MySmartBB->_POST['new_password'])) ? md5($MySmartBB->_POST['new_password']) : $MemInfo['password'];
		$MySmartBB->rec->fields['email'] 				= 	$MySmartBB->_POST['email'];
		$MySmartBB->rec->fields['user_gender'] 			= 	$MySmartBB->_POST['gender'];
		$MySmartBB->rec->fields['style'] 				= 	$MySmartBB->_POST['style'];
		$MySmartBB->rec->fields['avater_path'] 			= 	$MySmartBB->_POST['avater_path'];
		$MySmartBB->rec->fields['user_info'] 			= 	$MySmartBB->_POST['user_info'];
		$MySmartBB->rec->fields['user_title'] 			= 	$MySmartBB->_POST['user_title'];
		$MySmartBB->rec->fields['posts'] 				= 	$MySmartBB->_POST['posts'];
		$MySmartBB->rec->fields['user_website'] 		= 	$MySmartBB->_POST['user_website'];
		$MySmartBB->rec->fields['user_country'] 		= 	$MySmartBB->_POST['user_country'];
		$MySmartBB->rec->fields['usergroup'] 			= 	$MySmartBB->_POST['usergroup'];
		$MySmartBB->rec->fields['username_style_cache']	=	$username_style_cache;
		
		$MySmartBB->rec->filter = "id='" . $MemInfo['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( !empty( $MySmartBB->_POST[ 'new_username' ] ) )
		{
			// Announcements
			$MySmartBB->rec->table = $MySmartBB->table[ 'announcement' ];
			$MySmartBB->rec->fields = array( 'writer'	=>	$username );
			$MySmartBB->rec->filter = "writer='" . $old_username . "'";
			
			$update = $MySmartBB->rec->update();
			
			// Moderators
			$MySmartBB->rec->table = $MySmartBB->table[ 'moderators' ];
			$MySmartBB->rec->fields = array( 'username'	=>	$username );
			$MySmartBB->rec->filter = "username='" . $old_username . "'";
			
			$update = $MySmartBB->rec->update();
			
			// PM from
			$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
			$MySmartBB->rec->fields = array( 'user_from'	=>	$username );
			$MySmartBB->rec->filter = "user_from='" . $old_username . "'";
			
			$update = $MySmartBB->rec->update();
			
			// PM to
			$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
			$MySmartBB->rec->fields = array( 'user_to'	=>	$username );
			$MySmartBB->rec->filter = "user_to='" . $old_username . "'";
			
			$update = $MySmartBB->rec->update();
			
			// Replies
			$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
			$MySmartBB->rec->fields = array( 'writer'	=>	$username );
			$MySmartBB->rec->filter = "writer='" . $old_username . "'";
			
			$update = $MySmartBB->rec->update();
			
			// Requests
			$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
			$MySmartBB->rec->fields = array( 'username'	=>	$username );
			$MySmartBB->rec->filter = "username='" . $old_username . "'";
			
			$update = $MySmartBB->rec->update();
			
			// Subjects writer
			$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
			$MySmartBB->rec->fields = array( 'writer'	=>	$username );
			$MySmartBB->rec->filter = "writer='" . $old_username . "'";
			
			$update = $MySmartBB->rec->update();
			
			// Subjects last replier
			$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
			$MySmartBB->rec->fields = array( 'last_replier'	=>	$username );
			$MySmartBB->rec->filter = "last_replier='" . $old_username . "'";
			
			$update = $MySmartBB->rec->update();
			
			// Today
			$MySmartBB->rec->table = $MySmartBB->table[ 'today' ];
			$MySmartBB->rec->fields = array( 'username'	=>	$username );
			$MySmartBB->rec->filter = "username='" . $old_username . "'";
			
			$update = $MySmartBB->rec->update();
			
			// Vote
			$MySmartBB->rec->table = $MySmartBB->table[ 'vote' ];
			$MySmartBB->rec->fields = array( 'username'	=>	$username );
			$MySmartBB->rec->filter = "username='" . $old_username . "'";
			
			$update = $MySmartBB->rec->update();
		}
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=member&amp;control=1&amp;main=1');
		}
	}
	
	private function checkID(&$MemInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$MemInfo = $MySmartBB->rec->getInfo();
		
		if ($MemInfo == false)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_doesnt_exist' ] );
		}
	}
}

?>
