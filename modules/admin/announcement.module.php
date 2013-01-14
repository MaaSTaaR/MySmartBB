<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartAnnouncementMOD');

class MySmartAnnouncementMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_announcement' );
		    
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
		
		$MySmartBB->template->display( 'announcement_add' );
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'title' ] ) or empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'announcement' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 	= 	$MySmartBB->_POST['title'];
		$MySmartBB->rec->fields['text'] 	= 	$MySmartBB->_POST['text'];
		$MySmartBB->rec->fields['writer'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		$MySmartBB->rec->fields['date'] 	= 	$MySmartBB->_CONF['now'];
		
		$insert = $MySmartBB->rec->insert();
		
		if ($insert)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'announcement_added' ] );
			$MySmartBB->func->move('admin.php?page=announcement&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'announcement' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->rec->setInfoCallback( array( 'MySmartAnnouncementMOD', 'rowsProcessCB' ) );
		
		$MySmartBB->template->display( 'announcements_main' );
		
		$MySmartBB->rec->removeInfoCallback();
	}
	
	public function rowsProcessCB( $row )
	{
		global $MySmartBB;
		
		$row[ 'date' ] = $MySmartBB->func->date( $row[ 'date' ] );
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'AnnInfo' ] = null;
		
		$this->__checkID( $MySmartBB->_CONF[ 'template' ][ 'AnnInfo' ] );
		
		$MySmartBB->template->display('announcement_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'title' ] ) or empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$info = null;
		
		$this->__checkID( $info );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'announcement' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 	= 	$MySmartBB->_POST['title'];
		$MySmartBB->rec->fields['text'] 	= 	$MySmartBB->_POST['text'];
		$MySmartBB->rec->fields['writer'] 	= 	$info['writer'];
		$MySmartBB->rec->fields['date'] 	= 	$info['date'];
		
		$MySmartBB->rec->filter = "id='" . $info['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'announcement_updated' ] );
			$MySmartBB->func->move('admin.php?page=announcement&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AnnInfo'] = null;
		
		$this->__checkID($MySmartBB->_CONF['template']['AnnInfo']);
		
		$MySmartBB->template->display('announcement_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$info = null;
		
		$this->__checkID( $info );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'announcement' ];
		$MySmartBB->rec->filter = "id='" . $info[ 'id' ] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ( $del )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'announcement_deleted' ] );
			$MySmartBB->func->move('admin.php?page=announcement&amp;control=1&amp;main=1');
		}
	}
	
	private function __checkID( &$AnnInfo )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'announcement' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$AnnInfo = $MySmartBB->rec->getInfo();
		
		if ( !$AnnInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'announcement_doesnt_exist' ] );
	}
}

?>
