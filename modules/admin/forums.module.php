<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartForumsMOD');
	
class MySmartForumsMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ( $MySmartBB->_GET[ 'control' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_controlMain();
				}
			}
			elseif ($MySmartBB->_GET['forum'])
			{
				if ($MySmartBB->_GET['index'])
				{
					$this->_forumMain();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
		
	private function _controlMain()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->func->getForumsList( false );
		
		// ... //
		
		$MySmartBB->template->display('forums_main');
	}
	
	
	// TODO :: It's seem this function don't work properly, check it and separate it to another file
	function _ForumMain()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		// ... //
		
		if (!empty($MySmartBB->_CONF['template']['Inf']['forums_cache']))
		{
			$MySmartBB->_CONF['template']['foreach']['forums_list'] = unserialize(base64_decode($MySmartBB->_CONF['template']['Inf']['forums_cache']));
		
			$size = sizeof($MySmartBB->_CONF['template']['foreach']['forums_list']);
		
			// No information!
			if ($size <= 0)
			{
				$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
			}
		}
		else
		{
			$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
		}
		
		// ... //
		
		$MySmartBB->template->display('forums_forum_main');
	}
}

?>
