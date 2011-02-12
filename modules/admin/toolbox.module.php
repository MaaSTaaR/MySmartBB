<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('CALL_TOOLBOX_SYSTEM',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartToolboxMOD');
	
class MySmartToolboxMOD extends _func
{
	public function run()
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
						$this->_addFontsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_addFontsStart();
					}
				}
				elseif ($MySmartBB->_GET['control'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_controlFontsMain();
					}
				}
				elseif ($MySmartBB->_GET['edit'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_editFontsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_editFontsStart();
					}
				}
				elseif ($MySmartBB->_GET['del'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_delFontsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_delFontsStart();
					}
				}
			}
			
			if ($MySmartBB->_GET['colors'])
			{
				if ($MySmartBB->_GET['add'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_addColorsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_addColorsStart();
					}
				}
				elseif ($MySmartBB->_GET['control'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_controlColorsMain();
					}
				}
				elseif ($MySmartBB->_GET['edit'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_editColorsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_editColorsStart();
					}
				}
				elseif ($MySmartBB->_GET['del'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_delColorsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_delColorsStart();
					}
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	/**
	 * Fonts functions
	 */
	private function _addFontsMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('font_add');
	}
	
	private function _addFontsStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['name'] 	= 	$MySmartBB->_POST['name'];
		
		$insert = $MySmartBB->toolbox->insertFont();
			
		if ($insert)
		{
			$MySmartBB->func->msg('تم اضافة الخط بنجاح !');
			$MySmartBB->func->move('admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlFontsMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->toolbox->getFontsList();
		
		$MySmartBB->template->display('fonts_main');
	}
	
	private function _editFontsMain()
	{
		global $MySmartBB;
		
		$this->check_font_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('font_edit');
	}
	
	private function _editFontsStart()
	{
		global $MySmartBB;
		
		$this->check_font_by_id($Inf);
		
		if (empty($MySmartBB->_POST['name']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['name'] 	= 	$MySmartBB->_POST['name'];
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$update = $MySmartBB->toolbox->updateFont();
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث الخط بنجاح !');
			$MySmartBB->func->move('admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1');
		}
	}
	
	private function _delFontsMain()
	{
		global $MySmartBB;
		
		$this->check_font_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('font_del');
	}
	
	private function _DelFontsStart()
	{
		global $MySmartBB;
		
		$this->check_font_by_id($Inf);
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$del = $MySmartBB->toolbox->deleteFont();
		
		if ($del)
		{
			$MySmartBB->func->msg('تم حذف الخط بنجاح !');
			$MySmartBB->func->move('admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1');
		}
	}
	
	/**
	 * Colors func
	 */
	private function _addColorsMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('color_add');
	}
	
	private function _addColorsStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['name'] = $MySmartBB->_POST['name'];
		
		$insert = $MySmartBB->toolbox->insertColor();
		
		if ($insert)
		{
			$MySmartBB->func->msg('تم اضافة اللون بنجاح !');
			$MySmartBB->func->move('admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlColorsMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->filter = 'id DESC';
		
		$MySmartBB->toolbox->getColorsList();
		
		$MySmartBB->template->display('colors_main');
	}
	
	private function _editColorsMain()
	{
		global $MySmartBB;
		
		$this->check_color_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('color_edit');
	}

	private function _editColorsStart()
	{
		global $MySmartBB;
		
		$this->check_color_by_id($Inf);
		
		if (empty($MySmartBB->_POST['name']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['name'] 	= 	$MySmartBB->_POST['name'];
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$update = $MySmartBB->toolbox->updateColor();
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث اللون بنجاح !');
			$MySmartBB->func->move('admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1');
		}
	}
	
	private function _delColorsMain()
	{
		global $MySmartBB;
		
		$this->check_color_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('color_del');
	}
	
	private function _delColorsStart()
	{
		global $MySmartBB;
		
		$this->check_color_by_id($Inf);
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$del = $MySmartBB->toolbox->deleteColor();
		
		if ($del)
		{
			$MySmartBB->func->msg('تم حذف اللون بنجاح !');
			$MySmartBB->func->move('admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1');
		}
	}
}

class _func
{	
	function check_font_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$Inf = $MySmartBB->toolbox->getFontInfo();
		
		if ($Inf == false)
		{
			$MySmartBB->func->error('الخط المطلوب غير موجود');
		}
	}
	
	function check_color_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->toolbox->getColorInfo(array('id'	=>	$MySmartBB->_GET['id']));
		
		if ($Inf == false)
		{
			$MySmartBB->func->error('الخط المطلوب غير موجود');
		}
	}
}

?>
