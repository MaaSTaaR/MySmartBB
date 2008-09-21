<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('CALL_TOOLBOX_SYSTEM',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['TOOLBOX'] 	= 	true;

include('common.php');
	
define('CLASS_NAME','MySmartToolboxMOD');
	
class MySmartToolboxMOD extends _functions
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['fonts'])
			{
				if ($MySmartBB->_GET['add'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_AddFontsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_AddFontsStart();
					}
				}
				elseif ($MySmartBB->_GET['control'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_ControlFontsMain();
					}
				}
				elseif ($MySmartBB->_GET['edit'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_EditFontsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_EditFontsStart();
					}
				}
				elseif ($MySmartBB->_GET['del'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_DelFontsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_DelFontsStart();
					}
				}
			}
			
			if ($MySmartBB->_GET['colors'])
			{
				if ($MySmartBB->_GET['add'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_AddColorsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_AddColorsStart();
					}
				}
				elseif ($MySmartBB->_GET['control'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_ControlColorsMain();
					}
				}
				elseif ($MySmartBB->_GET['edit'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_EditColorsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_EditColorsStart();
					}
				}
				elseif ($MySmartBB->_GET['del'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_DelColorsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_DelColorsStart();
					}
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	/**
	 * Fonts functions
	 */
	function _AddFontsMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('font_add');
	}
	
	function _AddFontsStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$FntArr 			= 	array();
		$FntArr['field']	=	array();
		
		$FntArr['field']['name'] 	= 	$MySmartBB->_POST['name'];
		
		$insert = $MySmartBB->toolbox->InsertFont($FntArr);
			
		if ($insert)
		{
			$MySmartBB->functions->msg('تم اضافة الخط بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1');
		}
	}
	
	function _ControlFontsMain()
	{
		global $MySmartBB;
		
		$FntArr 					= 	array();
		$FntArr['order'] 			=	array();
		$FntArr['order']['field'] 	= 	'id';
		$FntArr['order']['type']	=	'DESC';
		$FntArr['proc'] 			= 	array();
		$FntArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['FntList'] = $MySmartBB->toolbox->GetFontsList($FntArr);
		
		$MySmartBB->template->display('fonts_main');
	}
	
	function _EditFontsMain()
	{
		global $MySmartBB;
		
		$this->check_font_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('font_edit');
	}
	
	function _EditFontsStart()
	{
		global $MySmartBB;
		
		$this->check_font_by_id($Inf);
		
		if (empty($MySmartBB->_POST['name']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$FntArr 			= 	array();
		$FntArr['field']	=	array();
		
		$FntArr['field']['name'] 	= 	$MySmartBB->_POST['name'];
		$FntArr['where']			= 	array('id',$Inf['id']);
				
		$update = $MySmartBB->toolbox->UpdateFont($FntArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث الخط بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1');
		}
	}
	
	function _DelFontsMain()
	{
		global $MySmartBB;
		
		$this->check_font_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('font_del');
	}
	
	function _DelFontsStart()
	{
		global $MySmartBB;
		
		$this->check_font_by_id($Inf);
		
		$del = $MySmartBB->toolbox->DeleteFont(array('id'	=>	$Inf['id']));
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف الخط بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1');
		}
	}
	
	/**
	 * Colors functions
	 */
	function _AddColorsMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('color_add');
	}
	
	function _AddColorsStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$ClrArr 			= 	array();
		$ClrArr['field']	=	array();
		
		$ClrArr['field']['name'] = $MySmartBB->_POST['name'];
		
		$insert = $MySmartBB->toolbox->InsertColor($ClrArr);
			
		if ($insert)
		{
			$MySmartBB->functions->msg('تم اضافة اللون بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1');
		}
	}
	
	function _ControlColorsMain()
	{
		global $MySmartBB;
		
		$ClrArr 					= 	array();
		$ClrArr['proc'] 			= 	array();
		$ClrArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		$ClrArr['order']			=	array();
		$ClrArr['order']['field']	=	'id';
		$ClrArr['order']['type']	=	'DESC';
		
		$MySmartBB->_CONF['template']['while']['ClrList'] = $MySmartBB->toolbox->GetColorsList($ClrArr);
		
		$MySmartBB->template->display('colors_main');
	}
	
	function _EditColorsMain()
	{
		global $MySmartBB;
		
		$this->check_color_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('color_edit');
	}

	function _EditColorsStart()
	{
		global $MySmartBB;
		
		$this->check_color_by_id($Inf);
		
		if (empty($MySmartBB->_POST['name']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$ClrArr 			= 	array();
		$ClrArr['field']	=	array();
		
		$ClrArr['field']['name'] 	= 	$MySmartBB->_POST['name'];
		$ClrArr['where']			= 	array('id',$Inf['id']);
				
		$update = $MySmartBB->toolbox->UpdateColor($ClrArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث اللون بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1');
		}
	}
	
	function _DelColorsMain()
	{
		global $MySmartBB;
		
		$this->check_color_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('color_del');
	}
	
	function _DelColorsStart()
	{
		global $MySmartBB;
		
		$this->check_color_by_id($Inf);
		
		$del = $MySmartBB->toolbox->DeleteColor(array('id'	=>	$Inf['id']));
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف اللون بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1');
		}
	}
}

class _functions
{	
	function check_font_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$Inf = $MySmartBB->toolbox->GetFontInfo(array('id'	=>	$MySmartBB->_GET['id']));
		
		if ($Inf == false)
		{
			$MySmartBB->functions->error('الخط المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($Inf,'html');
	}
	
	function check_color_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$Inf = $MySmartBB->toolbox->GetColorInfo(array('id'	=>	$MySmartBB->_GET['id']));
		
		if ($Inf == false)
		{
			$MySmartBB->functions->error('الخط المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($Inf,'html');
	}
}

?>
