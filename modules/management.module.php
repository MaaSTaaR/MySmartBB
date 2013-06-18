<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'JAVASCRIPT_SMARTCODE', true );

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartManagementMOD' );

class MySmartManagementMOD
{
	private $subject_info;
	private $section_id;
	private $reply_info;
		
	public function run()
	{
		global $MySmartBB;
				
		// ... //
		
		if ( $MySmartBB->moderator->moderatorCheck( $section_id ) )
		{
			$MySmartBB->load( 'cache,moderator,pm,reply,section,subject' );
			
			if ( $MySmartBB->_GET[ 'subject' ] )
			{
				$this->_subject();
			}
			elseif ( $MySmartBB->_GET[ 'move' ] )
			{
				$this->_moveStart();
			}
			elseif ( $MySmartBB->_GET[ 'subject_edit' ] )
			{
				$this->_subjectEditStart();
			}
			elseif ( $MySmartBB->_GET[ 'repeat' ] )
			{
				$this->_subjectRepeatStart();
			}
			elseif ( $MySmartBB->_GET[ 'close' ] )
			{
				$this->_closeStart();
			}
			elseif ( $MySmartBB->_GET[ 'delete' ] )
			{
				$this->_deleteStart();
			}
			elseif ( $MySmartBB->_GET[ 'reply' ] )
			{
				$this->_reply();
			}
			elseif ( $MySmartBB->_GET[ 'reply_edit' ] )
			{
				$this->_replyEditStart();
			}
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission' ] );
		}		
	}
		
	private function _subject()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_GET[ 'operator' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
				
		// ... //
		
		if ( $MySmartBB->_GET['operator'] == 'stick' )
		{
			$this->__stick();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'unstick' )
		{
			$this->__unStick();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'close' )
		{
			$this->__close();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'open' )
		{
			$this->__open();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'delete' )
		{
			$this->__subjectDelete();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'move' )
		{
			$this->__moveIndex();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'edit' )
		{
			$this->__subjectEdit();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'repeated' )
		{
			$this->__subjectRepeat();
		}
		/*
		 * Freezed for 2.0.0, will be back later.
		elseif ( $MySmartBB->_GET['operator'] == 'up' )
		{
			$this->__upStart();
		}
		elseif ( $MySmartBB->_GET['operator'] == 'down' )
		{
			$this->__downStart();
		}
		*/
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
	}
		
	private function _reply()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_GET[ 'operator' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		if ( $MySmartBB->_GET[ 'operator' ] == 'delete' )
		{
			$this->__replyDelete();
		}
		elseif ($MySmartBB->_GET[ 'operator' ] == 'edit' )
		{
			$this->__replyEdit();
		}
	}
	
	private function __replyDelete()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->reply->moveReplyToTrash( $this->reply_info[ 'id' ], $this->reply_info[ 'subject_id' ], $this->reply_info[ 'section' ] );
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'reply_deleted' ] );
			$MySmartBB->func->move( 'topic/' . $this->reply_info[ 'subject_id' ] );
		}
	}
	
	private function __replyEdit()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->template->assign('edit_page','index.php?page=management&amp;reply_edit=1&amp;reply_id=' . $this->reply_info[ 'id' ] . '&amp;section=' . $this->reply_info[ 'section' ] . '&amp;subject_id=' . $this->reply_info[ 'subject_id' ]);
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'ReplyInfo' ] = $this->reply_info;
		
		// ... //
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->template->display( 'reply_edit' );
	}
	
	private function _replyEditStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->fields = array(	'title'	=>	$MySmartBB->_POST[ 'title' ],
											'text'	=>	$MySmartBB->_POST[ 'text' ],
											'icon'	=>	$MySmartBB->_POST[ 'icon' ]	);
											
		$MySmartBB->rec->filter = "id='" . $this->reply_info[ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		// ... //
		
		if ( $update )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('topic/' . $this->reply_info[ 'subject_id' ]);
		}
	}
}
?>
