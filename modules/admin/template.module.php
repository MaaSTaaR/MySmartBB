<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['STYLE'] 		= 	true;
$CALL_SYSTEM['TEMPLATE'] 	= 	true;

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
				
		$StyArr 					= 	array();
		$StyArr['order'] 			=	array();
		$StyArr['order']['field'] 	= 	'id';
		$StyArr['order']['type']	=	'DESC';
		$StyArr['proc'] 			= 	array();
		$StyArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['StyleList'] = $MySmartBB->style->GetStyleList($StyArr);
		
//		$MySmartBB->_GET['style_id'] = (!empty($MySmartBB->_GET['style_id'])) ? $MySmartBB->_GET['style_id'] : '';
//		$MySmartBB->_GET['style_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['style_id'],'intval');
				
		$MySmartBB->template->display('template_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB,$_VARS;
		
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
			$MySmartBB->functions->error('الستايل المطلوب غير مسجل في قواعد البيانات');
		}
		
		$MySmartBB->template_c->ChangePath('./' . $StyleInfo['template_path'] . '/');
		
		$TemplateArr 				= 	array();
		$TemplateArr['filename'] 	= 	$MySmartBB->_POST['filename'] . $MySmartBB->template->GetTemplateExtention();
		$TemplateArr['context'] 	= 	$MySmartBB->_POST['context'];
		
		$add = $MySmartBB->template_c->AddTemplate($TemplateArr);
		
		if ($add)
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
		
		$this->check_by_id($StyleInfo);
		
		if (empty($MySmartBB->_GET['filename']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		if (!file_exists('./' . $StyleInfo['template_path'] . '/' . $MySmartBB->_GET['filename']))
		{
			$MySmartBB->functions->error('القالب المطلوب غير موجود');
		}
		
		$StyArr 					= 	array();
		$StyArr['order'] 			=	array();
		$StyArr['order']['field'] 	= 	'id';
		$StyArr['order']['type']	=	'DESC';
		$StyArr['proc'] 			= 	array();
		$StyArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$StyleList = $MySmartBB->style->GetStyleList($StyArr);

		$context = $MySmartBB->functions->CleanVariable($context,'unhtml');
		
		$filename = str_replace('.tpl','',$MySmartBB->_GET['filename']);
		
/*		$this->make_path('تحرير ' . $filename . ' في ' . $StyleInfo['style_title']);
		
		$MySmartBB->html->open_form('admin.php?page=template&amp;edit=1&amp;start=1&amp;id=' . $StyleInfo['id'] . '&amp;filename=' . $MySmartBB->_GET['filename']);
		$MySmartBB->html->open_table('60%','t_style_b',1);
		
		$MySmartBB->html->cells('تحرير قالب','main1');
		$MySmartBB->html->row('اسم ملف القالب',$MySmartBB->html->input('filename',$filename));
		$MySmartBB->html->row('القالب للستايل',$MySmartBB->html->select('style',$StyleArr,$StyleInfo['id']));
		$MySmartBB->html->cells('محتوى القالب');
		$MySmartBB->html->cells($MySmartBB->html->textarea('context',$context,20,70,true,'ltr'));
		
		$MySmartBB->html->close_table();
		$MySmartBB->html->close_form();*/
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($StyleInfo);
		
		if (empty($MySmartBB->_GET['filename']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		if (!file_exists('./' . $StyleInfo['template_path'] . '/' . $MySmartBB->_GET['filename']))
		{
			$MySmartBB->functions->error('القالب المطلوب غير موجود');
		}
				
		$MySmartBB->template_c->ChangePath('./' . $StyleInfo['template_path'] . '/');
		
		$edit = $MySmartBB->template_c->EditTemplate(array('filename'=>$MySmartBB->_GET['filename'],'context'=>$MySmartBB->_POST['context']));
		
		if ($edit)
		{
			$MySmartBB->functions->msg('تم تحديث القالب بنجاح');
			$MySmartBB->functions->goto('admin.php?page=template&amp;control=1&amp;show=1&amp;id=' . $StyleInfo['id']);
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($StyleInfo);
		
		if (empty($MySmartBB->_GET['filename']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		if (!file_exists('./' . $StyleInfo['template_path'] . '/' . $MySmartBB->_GET['filename']))
		{
			$MySmartBB->functions->error('القالب المطلوب غير موجود');
		}
		
		$MySmartBB->functions->DeleteConfirm('template&amp;filename=' . $MySmartBB->_GET['filename'],$StyleInfo['id']);
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$this->check_by_id($StyleInfo);
		
		if (empty($MySmartBB->_GET['filename']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		if (!file_exists('./' . $StyleInfo['template_path'] . '/' . $MySmartBB->_GET['filename']))
		{
			$MySmartBB->functions->error('القالب المطلوب غير موجود');
		}
		
		$MySmartBB->template_c->ChangePath('./' . $StyleInfo['template_path'] . '/');
		
		$del = $MySmartBB->template_c->DeleteTemplate(array('filename'=>$MySmartBB->_GET['filename']));
		
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
