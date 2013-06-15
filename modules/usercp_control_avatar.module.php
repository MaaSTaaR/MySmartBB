<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartUserCPAvatarMOD' );

class MySmartUserCPAvatarMOD
{
	private $allowed = array( '.jpg', '.gif', '.png' );
	private $curr_page;
	
	public function run( $curr_page = 1 )
	{
		global $MySmartBB;
		
		$this->curr_page = (int) $curr_page;
		
		$this->commonProcesses();
		
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
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
			
			$MySmartBB->rec->pager 					= 	array();
			$MySmartBB->rec->pager[ 'total' ]		= 	$avatar_num;
			$MySmartBB->rec->pager[ 'perpage' ] 	= 	$MySmartBB->_CONF[ 'info_row' ][ 'avatar_perpage' ];
			$MySmartBB->rec->pager[ 'curr_page' ] 	= 	$this->curr_page;
			$MySmartBB->rec->pager[ 'prefix' ] 		= 	$MySmartBB->_CONF[ 'init_path' ] . 'usercp_control_avatar/';
			
			$MySmartBB->rec->order = 'id DESC';
			
			$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'avatar_res' ];
			
			$MySmartBB->rec->getList();
			
			$MySmartBB->template->assign( 'pager', $MySmartBB->pager->show() );
			$MySmartBB->template->assign( 'SHOW_AVATAR_LIST', true );
		}
		
		$MySmartBB->plugin->runHooks( 'usercp_control_avatar_main' );
		
		$MySmartBB->template->display('usercp_control_avatar');
		
		$MySmartBB->func->getFooter();
	}
	
	public function start()
	{
		global $MySmartBB;
		
		$this->commonProcesses();
		
		$MySmartBB->load( 'attach' );
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'update_process' ] );
		$MySmartBB->func->addressBar( '<a href="' . $MySmartBB->_CONF[ 'init_path' ] . 'usercp">' . $MySmartBB->lang[ 'template' ][ 'usercp' ] . '</a> ' . $MySmartBB->_CONF[ 'info_row' ][ 'adress_bar_separate' ] . ' ' . $MySmartBB->lang[ 'update_process' ] );
		
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
			$MySmartBB->rec->fields[ 'avater_path' ] = '';
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
		    $MySmartBB->plugin->runHooks( 'usercp_control_avatar_action_success' );
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move( 'usercp_control_avatar' );
		}
		
		$MySmartBB->func->getFooter();
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
	
	private function commonProcesses()
	{
		global $MySmartBB;
	
		$MySmartBB->loadLanguage( 'usercp_control_avatar' );
	
		// ... //
	
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
			
		if ( !$MySmartBB->_CONF[ 'info_row' ][ 'allow_avatar' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_this_feature' ] );
	
		// ... //
	}
}

?>
