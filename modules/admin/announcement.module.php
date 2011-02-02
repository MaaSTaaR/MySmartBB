<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['ANNOUNCEMENT'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartAnnouncementMOD');
	
class MySmartAnnouncementMOD extends _func
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
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
		
		$MySmartBB->template->display('announcement_add');
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 	= 	$MySmartBB->_POST['title'];
		$MySmartBB->rec->fields['text'] 	= 	$MySmartBB->_POST['text'];
		$MySmartBB->rec->fields['writer'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		$MySmartBB->rec->fields['date'] 	= 	$MySmartBB->_CONF['now'];
		
		$insert = $MySmartBB->announcement->insertAnnouncement();
		
		if ($insert)
		{
			$MySmartBB->func->msg('تم اضافة الاعلان بنجاح !');
			$MySmartBB->func->goto('admin.php?page=announcement&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		//$AnnArr['proc']['date'] 	= 	array('method'=>'date','store'=>'date');
		
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->announcement->getAnnouncementList();
		
		$MySmartBB->template->display('announcements_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AnnInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AnnInfo']);
		
		$MySmartBB->template->display('announcement_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AnnInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AnnInfo']);
		
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 	= 	$MySmartBB->_POST['title'];
		$MySmartBB->rec->fields['text'] 	= 	$MySmartBB->_POST['text'];
		$MySmartBB->rec->fields['writer'] 	= 	$MySmartBB->_CONF['template']['AnnInfo']['writer'];
		$MySmartBB->rec->fields['date'] 	= 	$MySmartBB->_CONF['template']['AnnInfo']['date'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['AnnInfo']['id'] . "'";
		
		$update = $MySmartBB->announcement->updateAnnouncement();
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث الاعلان بنجاح !');
			$MySmartBB->func->goto('admin.php?page=announcement&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AnnInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AnnInfo']);
		
		$MySmartBB->template->display('announcement_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['AnnInfo'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['AnnInfo']);
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$del = $MySmartBB->announcement->deleteAnnouncement();
		
		if ($del)
		{
			$MySmartBB->func->msg('تم حذف الاعلان بنجاح !');
			$MySmartBB->func->goto('admin.php?page=announcement&amp;control=1&amp;main=1');
		}
	}
}

class _func
{
	function check_by_id(&$AnnInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$AnnInfo = $MySmartBB->announcement->getAnnouncementInfo();
		
		if ($AnnInfo == false)
		{
			$MySmartBB->func->error('الاعلان المطلوب غير موجود');
		}
	}
}

?>
