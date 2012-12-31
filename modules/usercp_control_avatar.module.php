<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'JAVASCRIPT_func', true );
define( 'JAVASCRIPT_SMARTCODE', true );

define( 'COMMON_FILE_PATH', dirname(__FILE__) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartUserCPAvatarMOD' );

class MySmartUserCPAvatarMOD
{
	private $allowed = array( '.jpg', '.gif', '.png' );
	
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'usercp_control_avatar' );
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
			
		if ( !$MySmartBB->_CONF[ 'info_row' ][ 'allow_avatar' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_this_feature' ] );
		
		// ... //
		
		if ( $MySmartBB->_GET[ 'main' ] )				
		{
			$this->_avatarMain();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_avatarChange();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _avatarMain()
	{
		global $MySmartBB;
		
		// This line will include jQuery (Javascript library)
		$MySmartBB->template->assign( 'JQUERY', true );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'avatar' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		
		$avatar_num = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->template->assign( 'SHOW_AVATAR_LIST', false );
		
		if ( $avatar_num > 0 )
		{
			$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'avatar_res' ] = '';
			
			$MySmartBB->_GET[ 'count' ] = ( !isset( $MySmartBB->_GET[ 'count' ] ) ) ? 0 : $MySmartBB->_GET[ 'count' ];
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
			
			$MySmartBB->rec->pager 				= 	array();
			$MySmartBB->rec->pager[ 'total' ]		= 	$avatar_num;
			$MySmartBB->rec->pager[ 'perpage' ] 	= 	$MySmartBB->_CONF[ 'info_row' ][ 'avatar_perpage' ];
			$MySmartBB->rec->pager[ 'count' ] 		= 	$MySmartBB->_GET[ 'count' ];
			$MySmartBB->rec->pager[ 'location' ] 	= 	'index.php?page=usercp&amp;control=1&amp;avatar=1&amp;main=1';
			$MySmartBB->rec->pager[ 'var' ] 		= 	'count';
			
			$MySmartBB->rec->order = 'id DESC';
			
			$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'avatar_res' ];
			
			$MySmartBB->rec->getList();
			
			$MySmartBB->template->assign( 'pager', $MySmartBB->pager->show() );
			$MySmartBB->template->assign( 'SHOW_AVATAR_LIST', true );
		}
		
		$MySmartBB->plugin->runHooks( 'usercp_control_avatar_main' );
		
		$MySmartBB->template->display('usercp_control_avatar');
	}
	
	private function _avatarChange()
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'attach' );
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'update_process' ] );
		$MySmartBB->func->addressBar( '<a href="index.php?page=usercp&index=1">' . $MySmartBB->lang[ 'template' ][ 'usercp' ] . '</a> ' . $MySmartBB->_CONF[ 'info_row' ][ 'adress_bar_separate' ] . ' ' . $MySmartBB->lang[ 'update_process' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'usercp_control_avatar_action_start' );
		
		$MySmartBB->rec->fields[ 'avater_path' ] = '';
		
		if ( $MySmartBB->_POST[ 'options' ] == 'list' )
		{
			$this->_fromList();
		}
		elseif ( $MySmartBB->_POST[ 'options' ] == 'site' )
		{
			$this->_fromSite();
		}
		elseif ( $MySmartBB->_POST[ 'options' ] == 'upload' )
		{
			$this->_upload();
    	}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'please_wait' ] );
			$MySmartBB->func->move( 'index.php?page=usercp&control=1&avatar=1&main=1' );
			$MySmartBB->func->stop();
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
		    $MySmartBB->plugin->runHooks( 'usercp_control_avatar_action_success' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move( 'index.php?page=usercp_control_avatar&main=1' );
		}
	}
	
	private function _fromList()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'avatar_list' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'please_choose_image' ] );
			
		$MySmartBB->rec->fields[ 'avater_path' ] = $MySmartBB->_POST[ 'avatar_list' ];
	}
	
	private function _fromSite()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'avatar' ] ) or $MySmartBB->_POST[ 'avatar' ] == 'http://' )
			$MySmartBB->func->error( $MySmartBB->lang[ 'please_choose_image' ] );
		
		if ( !$MySmartBB->func->isSite( $MySmartBB->_POST[ 'avatar' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'wrong_website' ] );
		
		// ... //
		
		$extension = $MySmartBB->func->getURLExtension( $MySmartBB->_POST[ 'avatar' ] );
		
		if ( !in_array( $extension, $this->allowed ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forbidden_extension' ] );
		
		// ... //
		
		$this->__checkImageSize( $MySmartBB->_POST['avatar'] );
		
		// ... //
			
		$MySmartBB->rec->fields[ 'avater_path' ] = $MySmartBB->_POST[ 'avatar' ];
	}
	
	private function _upload()
	{
		global $MySmartBB;
		
		// ... //
		
		$this->__checkImageSize( $MySmartBB->_FILES[ 'upload' ][ 'tmp_name' ] );

		// ... //
			
     	if ( !empty( $MySmartBB->_FILES[ 'upload' ][ 'name' ] ) )
     	{
     		$path = null;
     		
     		$upload = $MySmartBB->attach->uploadFile( 	$MySmartBB->_FILES[ 'upload' ], $path, 
     													$this->allowed, 
     													$MySmartBB->_CONF[ 'info_row' ][ 'download_path' ] . '/avatar' );
     			
     		if ( $upload )
     			$MySmartBB->rec->fields[ 'avater_path' ] = $path;	
     	}
     		
     	// ... //
	}
	
	private function __checkImageSize( $path )
	{
		global $MySmartBB;
		
		$size = @getimagesize( $path );
		
		if ( $size[ 0 ] > $MySmartBB->_CONF[ 'info_row' ][ 'max_avatar_width' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forbidden_width' ] );

		if ( $size[ 1 ] > $MySmartBB->_CONF[ 'info_row' ][ 'max_avatar_height' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forbidden_height' ] );
	}
}

?>
