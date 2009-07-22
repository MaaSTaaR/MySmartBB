<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['STYLE'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartStyleMOD');
	
class MySmartStyleMOD extends _functions
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		
		if ($MySmartBB->_CONF['member_permission'])
		{
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

		$MySmartBB->template->display('style_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['style_on']) 
			or empty($MySmartBB->_POST['order']) 
			or empty($MySmartBB->_POST['style_path']) 
			or empty($MySmartBB->_POST['image_path']) 
			or empty($MySmartBB->_POST['template_path']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$StlArr 					= 	array();
		$StlArr['field']			=	array();
		
		$StlArr['field']['style_title'] 	= 	$MySmartBB->_POST['name'];
		$StlArr['field']['style_path'] 		= 	$MySmartBB->_POST['style_path'];
		$StlArr['field']['style_order'] 	= 	$MySmartBB->_POST['order'];
		$StlArr['field']['style_on'] 		= 	$MySmartBB->_POST['style_on'];
		$StlArr['field']['image_path'] 		= 	$MySmartBB->_POST['image_path'];
		$StlArr['field']['template_path'] 	= 	$MySmartBB->_POST['template_path'];
		$StlArr['field']['cache_path'] 		= 	$MySmartBB->_POST['cache_path'];
		
		$insert = $MySmartBB->style->InsertStyle($StlArr);
			
		if ($insert)
		{
			$MySmartBB->functions->msg('تم اضافة النمط بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=style&amp;control=1&amp;main=1');
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;

		$StlArr 					= 	array();
		$StlArr['proc'] 			= 	array();
		$StlArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		$StlArr['order']			=	array();
		$StlArr['order']['field']	=	'id';
		$StlArr['order']['type']	=	'DESC';
		
		$MySmartBB->_CONF['template']['while']['StlList'] = $MySmartBB->style->GetStyleList($StlArr);
		
		$MySmartBB->template->display('styles_main');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('style_edit');
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($Inf);
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['style_on']) 
			or empty($MySmartBB->_POST['order']) 
			or empty($MySmartBB->_POST['style_path']) 
			or empty($MySmartBB->_POST['image_path']) 
			or empty($MySmartBB->_POST['template_path']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		//////////
		
		$StlArr 			= 	array();
		$StlArr['field']	=	array();
		
		$StlArr['field']['style_title'] 	= 	$MySmartBB->_POST['name'];
		$StlArr['field']['style_path'] 		= 	$MySmartBB->_POST['style_path'];
		$StlArr['field']['style_order'] 	= 	$MySmartBB->_POST['order'];
		$StlArr['field']['style_on'] 		= 	$MySmartBB->_POST['style_on'];
		$StlArr['field']['image_path'] 		= 	$MySmartBB->_POST['image_path'];
		$StlArr['field']['template_path'] 	= 	$MySmartBB->_POST['template_path'];
		$StlArr['field']['cache_path'] 		= 	$MySmartBB->_POST['cache_path'];
		$StlArr['where']					= 	array('id',$Inf['id']);
				
		$update = $MySmartBB->style->UpdateStyle($StlArr);
		
		//////////
		
		if ($update)
		{
			//////////
			
			$UpdateArr 				= 	array();
			$UpdateArr['field']		=	array();
			
			$UpdateArr['field']['should_update_style_cache'] 	= 	1;
			$UpdateArr['where'] 								= 	array('style',$Inf['id']);
			
			$cache_update = $MySmartBB->member->UpdateMember($UpdateArr);
			
			//////////
			
			$MySmartBB->functions->msg('تم تحديث النمط بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=style&amp;control=1&amp;main=1');
			
			//////////
		}
		
		//////////
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('style_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($Inf);
		
		$DelArr 			= 	array();
		$DelArr['where'] 	= 	array('id',$Inf['id']);
		
		$del = $MySmartBB->style->DeleteStyle($DelArr);
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف النمط بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=style&amp;control=1&amp;main=1');
		}
	}
}

class _functions
{
	function check_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$StyleArr 			= 	array();
		$StyleArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$Inf = $MySmartBB->style->GetStyleInfo($StyleArr);
		
		if ($Inf == false)
		{
			$MySmartBB->functions->error('النمط المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($Inf,'html');
	}
}

?>
