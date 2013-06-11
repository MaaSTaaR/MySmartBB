<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartSubjectMOD' );
	
class MySmartSubjectMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_subject' );
		    
			$MySmartBB->template->display( 'header' );
			
			$MySmartBB->load( 'reply,subject,section' );
			
			if ( $MySmartBB->_GET[ 'close' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_closeSubject();
				}
			}
			elseif ( $MySmartBB->_GET[ 'attach' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_attachSubject();
				}
			}
			elseif ( $MySmartBB->_GET[ 'mass_del' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_massDelMain();
				}
				elseif ( $MySmartBB->_GET[ 'confirm' ] )
				{
					$this->_massDelConfirm();
				}
				elseif ( $MySmartBB->_GET[ 'start' ] )
				{
					$this->_massDelStart();
				}
			}
			elseif ( $MySmartBB->_GET[ 'mass_move' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_massMoveMain();
				}
				elseif ( $MySmartBB->_GET[ 'start' ] )
				{
					$this->_massMoveStart();
				}
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _closeSubject()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "close='1'";
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display( 'subjects_closed' );
	}
	
	private function _attachSubject()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "attach_subject='1'";
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display( 'subjects_attach' );		
	}
	
	private function _massDelMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList( false );
		
		$MySmartBB->template->display( 'subjects_mass_del' );
	}
	
	private function _massDelConfirm()
	{
		global $MySmartBB;
		
		$this->__checkDelID( $MySmartBB->_CONF[ 'template' ][ 'Inf' ] );
		
		$MySmartBB->template->display( 'subjects_mass_del_confirm' );
	}
	
	private function _massDelStart()
	{
		global $MySmartBB;
		
		$info = false;
		
		$this->__checkDelID( $info );
		
		$del = $MySmartBB->subject->massDeleteSubject( $info['id'] );
		
		if ( $del )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'topics_deleted' ] );
			$MySmartBB->func->move( 'admin.php?page=subject&amp;mass_del=1&amp;main=1' );
		}
	}
	
	private function _massMoveMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->section->getForumsList( false );
		
		$MySmartBB->template->display( 'subjects_mass_move' );
	}
		
	private function _massMoveStart()
	{
		global $MySmartBB;
		
		$from_info = false;
		$to_info = false;
		
		$this->__checkMoveID( $from_info,$to_info );
		
		$move = $MySmartBB->subject->massMoveSubject( $to_info['id'], $from_info['id'] );
		
		if ( $move )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'topics_moved' ] );
			$MySmartBB->func->move( 'admin.php?page=subject&amp;mass_move=1&amp;main=1' );
		}
	}
	
	private function __checkMoveID( &$Inf, &$ToInf )
	{
		global $MySmartBB;
		
		$MySmartBB->_POST[ 'from' ] = (int) $MySmartBB->_POST[ 'from' ];
		$MySmartBB->_POST[ 'to' ] = (int) $MySmartBB->_POST[ 'to' ];
			
		if ( empty( $MySmartBB->_POST[ 'from' ] ) or empty( $MySmartBB->_POST[ 'to' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
			
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST[ 'from' ] . "'";
			
		$Inf = $MySmartBB->rec->getInfo();
			
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
			
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST[ 'to' ] . "'";
			
		$ToInf = $MySmartBB->rec->getInfo();
			
		if ( !$ToInf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
	}
	
	private function __checkDelID( &$Inf )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'id' ] = (int) $MySmartBB->_GET[ 'id' ];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'forum_doesnt_exist' ] );
	}
}

?>
