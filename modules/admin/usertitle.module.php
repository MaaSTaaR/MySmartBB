<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['USERTITLE'] 	= 	true;

include('common.php');
	
define('CLASS_NAME','MySmartUsertitleMOD');
	
class MySmartUsertitleMOD extends _functions
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['add'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_AddMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_AddStart();
				}
			}
			elseif ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_ControlMain();
				}
			}
			elseif ($MySmartBB->_GET['edit'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_EditMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_EditStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_DelMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_DelStart();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	function _AddMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('usertitle_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['posts']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$UTArr 			= 	array();
		$UTArr['field']	=	array();
		
		$UTArr['field']['usertitle'] 	= 	$MySmartBB->_POST['title'];
		$UTArr['field']['posts'] 		= 	$MySmartBB->_POST['posts'];
		
		$insert = $MySmartBB->usertitle->InsertUsertitle($UTArr);
		
		if ($insert)
		{
			$MySmartBB->functions->msg('تم اضافة المسمى بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=usertitle&amp;control=1&amp;main=1');
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;
		
		$UTArr 						= 	array();
		$UTArr['proc'] 				= 	array();
		$UTArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$UTArr['order']				=	array();
		$UTArr['order']['field']	=	'id';
		$UTArr['order']['type']		=	'DESC';
		
		$MySmartBB->_CONF['template']['while']['UTList'] = $MySmartBB->usertitle->GetUsertitleList($UTArr);
		
		$MySmartBB->template->display('usertitles_main');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
				
		$MySmartBB->template->display('usertitle_edit');
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($UTInfo);
				
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['posts']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$UTArr 			= 	array();
		$UTArr['field']	=	array();
		
		$UTArr['field']['usertitle'] 	= 	$MySmartBB->_POST['title'];
		$UTArr['field']['posts'] 		= 	$MySmartBB->_POST['posts'];
		$UTArr['where']					=	array('id',$UTInfo['id']);
		
		$update = $MySmartBB->usertitle->UpdateUsertitle($UTArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث المسمى بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=usertitle&amp;control=1&amp;main=1');
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('usertitle_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($UTInfo);
		
		$DelArr 			= 	array();
		$DelArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$del = $MySmartBB->usertitle->DeleteUsertitle($DelArr);
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف المسمى بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=usertitle&amp;control=1&amp;main=1');
		}
	}
}

class _functions
{
	function check_by_id(&$UTInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$UTArr 				= 	array();
		$UTArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$UTInfo = $MySmartBB->usertitle->GetUsertitleInfo($UTArr);
		
		if ($UTInfo == false)
		{
			$MySmartBB->functions->error('الاسم المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($UTInfo,'html');
	}
}

?>
