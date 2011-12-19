<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartUsertitleMOD');
	
class MySmartUsertitleMOD extends _func
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
		    $MySmartBB->loadLanguage( 'admin_usertitle' );
		    
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
		
		$MySmartBB->template->display('usertitle_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['posts']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['usertitle'] 	= 	$MySmartBB->_POST['title'];
		$MySmartBB->rec->fields['posts'] 		= 	$MySmartBB->_POST['posts'];
		
		$insert = $MySmartBB->rec->insert();
		
		if ($insert)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'usertitle_added' ] );
			$MySmartBB->func->move('admin.php?page=usertitle&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('usertitles_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
				
		$MySmartBB->template->display('usertitle_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($UTInfo);
				
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['posts']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['usertitle'] 	= 	$MySmartBB->_POST['title'];
		$MySmartBB->rec->fields['posts'] 		= 	$MySmartBB->_POST['posts'];
		
		$MySmartBB->rec->filter = "id='" . $UTInfo['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'usertitle_updated' ] );
			$MySmartBB->func->move('admin.php?page=usertitle&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('usertitle_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($UTInfo);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'usertitle_deleted' ] );
			$MySmartBB->func->move('admin.php?page=usertitle&amp;control=1&amp;main=1');
		}
	}
}

// TODO : KILL ME
class _func
{
	function check_by_id(&$UTInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$UTInfo = $MySmartBB->rec->getInfo();
		
		if ($UTInfo == false)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'usertitle_doesnt_exist' ] );
		}
	}
}

?>
