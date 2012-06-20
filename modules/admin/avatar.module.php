<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartAvatarMOD');
	
class MySmartAvatarMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
		    $MySmartBB->loadLanguage( 'admin_avatar' );
		    
			$MySmartBB->template->display('header');
		
			if ($MySmartBB->_GET['add'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_addMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_addStart();
				}
			}
			elseif ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_controlMain();
				}
			}
			elseif ($MySmartBB->_GET['edit'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_editMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_editStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_delMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_delStart();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('avatar_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'path' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		$MySmartBB->rec->fields	= array( 'avatar_path' => $MySmartBB->_POST['path'] );
		
		$insert = $MySmartBB->rec->insert();
		
		// ... //
			
		if ($insert)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'avatar_added' ] );
			$MySmartBB->func->move('admin.php?page=avatar&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('avatars_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->__checkID($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('avatar_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->__checkID( $MySmartBB->_CONF['template']['Inf'] );
		
		if ( empty( $MySmartBB->_POST[ 'path' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		$MySmartBB->rec->fields = array( 'avatar_path' => $MySmartBB->_POST['path'] );
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'avatar_updated' ] );
			$MySmartBB->func->move('admin.php?page=avatar&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->__checkID($MySmartBB->_CONF['template']['Inf']);
				
		$MySmartBB->template->display('avatar_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->__checkID($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'avatar_deleted' ] );
			$MySmartBB->func->move('admin.php?page=avatar&amp;control=1&amp;main=1');
		}
	}
	
	private function __checkID( &$Inf )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'avatar_doesnt_exit' ] );
	}
}

?>
