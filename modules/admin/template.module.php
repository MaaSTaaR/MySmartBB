<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['STYLE'] 		= 	true;
$CALL_SYSTEM['TEMPLATE'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartTemplateMOD');

class MySmartTemplateMOD extends _functions
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

				elseif ($MySmartBB->_GET['show'])
				{
					$this->_ControlShow();
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
					$this->_DelStart();
				}

			}

			$MySmartBB->template->display('footer');
		}
	}

	function _AddMain()
	{
		global $MySmartBB;

		$StyArr 					= 	array();
		$StyArr['order'] 			=	array();
		$StyArr['order']['field'] 	= 	'id';
		$StyArr['order']['type']	=	'DESC';
		$StyArr['proc'] 			= 	array();
		$StyArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');

		$MySmartBB->_CONF['template']['while']['StyleList'] = $MySmartBB->style->GetStyleList($StyArr);

		$MySmartBB->template->display('template_add');
	}

	function _AddStart()
	{
		global $MySmartBB;

		if (empty($MySmartBB->_POST['filename'])
			or empty($MySmartBB->_POST['style'])
			or empty($MySmartBB->_POST['context']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}

		$StyleArr 			= 	array();
		$StyleArr['where'] 	= 	array('id',$MySmartBB->_POST['style']);

		$StyleInfo = $MySmartBB->style->GetStyleInfo($StyleArr);

		if (!$StyleInfo)
		{
			$MySmartBB->functions->error('النمط المطلوب غير مسجل في قواعد البيانات');
		}

	     $MySmartBB->_POST['context'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['context'],'unhtml');
	     $MySmartBB->_POST['context'] = stripslashes($MySmartBB->_POST['context']);
	     
	     $fp = fopen('./' . $StyleInfo['template_path'] . '/' . $MySmartBB->_POST['filename'],'w');
	     $fw = fwrite($fp,$MySmartBB->_POST['context']);
	     
	     fclose($fp);
	     
	     if ($fw)
	     {
	     	$MySmartBB->functions->msg('تم اضافة القالب بنجاح !');
	     	$MySmartBB->functions->goto('admin.php?page=template&amp;&amp;control=1&amp;main=1');
	     }
	}

	function _ControlMain()
	{
		global $MySmartBB;

		$StyleArr 					= 	array();
		$StyleArr['order'] 			=	array();
		$StyleArr['order']['field']	= 	'style_order';
		$StyleArr['order']['type']	=	'ASC';
		$StyleArr['proc'] 			= 	array();
		$StyleArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');

		$MySmartBB->_CONF['template']['while']['StyleList'] = $MySmartBB->style->GetStyleList($StyleArr);

		$MySmartBB->template->display('templates_main');
	}

	function _ControlShow()
	{
		global $MySmartBB;

		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}

		$StyleArr 				= 	array();
		$StyleArr['where'] 		= 	array('id',$MySmartBB->_GET['id']);

		$StyleInfo = $MySmartBB->style->GetStyleInfo($StyleArr);

		if (!$StyleInfo)
		{
			$MySmartBB->functions->error('النمط غير موجود في السجلات');
		}

		$MySmartBB->functions->CleanVariable($StyleInfo,'html');

		$TemplatesList = array();

		if (is_dir($StyleInfo['template_path']))
		{
			$dir = opendir($StyleInfo['template_path']);

			if ($dir)
			{
				while (($file = readdir($dir)) !== false)
				{
					if ($file == '.'
						or $file == '..')
					{
						continue;
					}

					$TemplatesList[]['filename'] = $file;
				}

				closedir($dir);
			}
		}

		$MySmartBB->_CONF['template']['foreach']['TemplatesList'] = $TemplatesList;

		$MySmartBB->template->assign('StyleInfo',$StyleInfo);

		$MySmartBB->template->display('templates_show_templates_list');

	}

    function _EditMain()
    {
    	global $MySmartBB;
    	
    	$MySmartBB->_CONF['template']['Inf'] = false;
    	
    	$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
    	
    	if (empty($MySmartBB->_GET['filename']))
    	{
    		$MySmartBB->functions->error('المسار المتبع غير صحيح');
    	}
    	
    	$MySmartBB->_GET['filename'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['filename'],'html');
    	
    	$path = './' . $MySmartBB->_CONF['template']['Inf']['template_path'] . '/' . $MySmartBB->_GET['filename'];

    	if (!file_exists($path))
    	{
    		$MySmartBB->functions->error('القالب المطلوب غير موجود');
    	}
    	
    	$lines = file($path);
    	$context = '';
    	
    	foreach ($lines as $line)
    	{
    		$context .= $line;
    	}
    	
    	$context = $MySmartBB->functions->CleanVariable($context,'unhtml');
    	
    	$last_edit = date("d. M. Y", filectime($path));
    	
    	$MySmartBB->template->assign('filename',$MySmartBB->_GET['filename']);
    	$MySmartBB->template->assign('last_edit',$last_edit);
    	$MySmartBB->template->assign('context',$context);
    	
    	$MySmartBB->template->display('template_edit');
	}

	function _EditStart()
	{
		global $MySmartBB;

    	$StyleInfo = false;
    	
    	$this->check_by_id($StyleInfo);
    	
    	if (empty($MySmartBB->_GET['filename']))
    	{
    		$MySmartBB->functions->error('المسار المتبع غير صحيح');
    	}
    	
    	$MySmartBB->_GET['filename'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['filename'],'html');
    	
    	$path = './' . $StyleInfo['template_path'] . '/' . $MySmartBB->_GET['filename'];

    	if (!file_exists($path))
    	{
    		$MySmartBB->functions->error('القالب المطلوب غير موجود');
    	}
    	
    	// To be more advanced :D
    	if (!is_writable($path))
    	{
    		$MySmartBB->functions->error('المعذره .. هذا القالب غير قابل للكتابه');
    	}
    	
    	$MySmartBB->_POST['context'] = stripslashes($MySmartBB->_POST['context']);
    	
    	$fp = fopen($path,'w+');
    	$fw = fwrite($fp,$MySmartBB->_POST['context']);
    	
    	if ($fw)
    	{
    		$compiled_filename = str_replace('.tpl','-compiler.php',$MySmartBB->_GET['filename']);
    		
    		// Use @ to avoid error messages such as (No such file or directory)
    		// Simply we can't ensure we have $compiled_filename in $StyleInfo['cache_path'] or not
    		$del = @unlink('./' . $StyleInfo['cache_path'] . '/' . $compiled_filename);
    		
    		$MySmartBB->functions->msg('تم تحديث القالب بنجاح');
			$MySmartBB->functions->goto('admin.php?page=template&amp;control=1&amp;show=1&amp;id=' . $StyleInfo['id']);
    	}
    }


	function _DelStart()
	{
		global $MySmartBB;

    	$StyleInfo = false;
    	
    	$this->check_by_id($StyleInfo);
    	
    	if (empty($MySmartBB->_GET['filename']))
    	{
    		$MySmartBB->functions->error('المسار المتبع غير صحيح');
    	}
    	
    	$MySmartBB->_GET['filename'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['filename'],'html');
    	
    	$path = './' . $StyleInfo['template_path'] . '/' . $MySmartBB->_GET['filename'];

    	if (!file_exists($path))
    	{
    		$MySmartBB->functions->error('القالب المطلوب غير موجود');
    	}
    	
    	$del = unlink($path);

		if ($del)
		{
			$MySmartBB->functions->msg('تم الحذف بنجاح');
			$MySmartBB->functions->goto('admin.php?page=template&amp;control=1&amp;show=1&amp;id=' . $StyleInfo['id']);
		}
	}
}

class _functions
{
	function check_by_id(&$StyleInfo)
	{
		global $MySmartBB;

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}

		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');

		$StyleArr 			= 	array();
		$StyleArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);

		$StyleInfo = $MySmartBB->style->GetStyleInfo($StyleArr);

		if ($StyleInfo == false)
		{
			$MySmartBB->functions->error('الستايل المطلوب غير موجود');
		}

		$MySmartBB->functions->CleanVariable($StyleInfo,'html');
	}
}

?>
