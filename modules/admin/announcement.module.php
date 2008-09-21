<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['ANNOUNCEMENT'] 	= 	true;

include('common.php');
	
define('CLASS_NAME','MySmartAnnouncementMOD');
	
class MySmartAnnouncementMOD extends _functions
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
		
		$MySmartBB->template->display('announcement_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$AnnArr 			= 	array();
		$AnnArr['field']	=	array();
		
		$AnnArr['field']['title'] 	= 	$MySmartBB->_POST['title'];
		$AnnArr['field']['text'] 	= 	$MySmartBB->_POST['text'];
		$AnnArr['field']['writer'] 	= 	$MySmartBB->_CONF['rows']['member_row']['username'];
		$AnnArr['field']['date'] 	= 	$MySmartBB->_CONF['now'];
		
		$insert = $MySmartBB->announcement->InsertAnnouncement($AnnArr);
		
		if ($insert)
		{
			$MySmartBB->functions->msg('تم اضافة الاعلان بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=announcement&amp;control=1&amp;main=1');
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;
		
		$AnnArr 					= 	array();
		$AnnArr['order']			=	array();
		$AnnArr['order']['field']	=	'id';
		$AnnArr['order']['type']	=	'DESC';
		$AnnArr['proc'] 			= 	array();
		$AnnArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		$AnnArr['proc']['date'] 	= 	array('method'=>'date','store'=>'date');
		
		$MySmartBB->_CONF['template']['while']['AnnList'] = $MySmartBB->announcement->GetAnnouncementList($AnnArr);
		
		$MySmartBB->template->display('announcements_main');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AnnInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AnnInfo']);
		
		$MySmartBB->template->display('announcement_edit');
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AnnInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AnnInfo']);
		
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$AnnArr 			= 	array();
		$AnnArr['field']	=	array();
		
		$AnnArr['field']['title'] 	= 	$MySmartBB->_POST['title'];
		$AnnArr['field']['text'] 	= 	$MySmartBB->_POST['text'];
		$AnnArr['field']['writer'] 	= 	$MySmartBB->_CONF['template']['AnnInfo']['writer'];
		$AnnArr['field']['date'] 	= 	$MySmartBB->_CONF['template']['AnnInfo']['date'];
		$AnnArr['where']			=	array('id',$MySmartBB->_CONF['template']['AnnInfo']['id']);
		
		$insert = $MySmartBB->announcement->UpdateAnnouncement($AnnArr);
		
		if ($insert)
		{
			$MySmartBB->functions->msg('تم تحديث الاعلان بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=announcement&amp;control=1&amp;main=1');
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AnnInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AnnInfo']);
		
		$MySmartBB->template->display('announcement_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AnnInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AnnInfo']);
		
		$DelArr 			= 	array();
		$DelArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$del = $MySmartBB->announcement->DeleteAnnouncement($DelArr);
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف الاعلان بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=announcement&amp;control=1&amp;main=1');
		}
	}
}

class _functions
{
	function check_by_id(&$AnnInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$AnnArr 			= 	array();
		$AnnArr['where']	=	array('id',$MySmartBB->_GET['id']);
		
		$AnnInfo = $MySmartBB->announcement->GetAnnouncementInfo($AnnArr);
		
		if ($AnnInfo == false)
		{
			$MySmartBB->functions->error('الاعلان المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($AnnInfo,'html');
	}
}

?>
