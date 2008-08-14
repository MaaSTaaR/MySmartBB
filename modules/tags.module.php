<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['TAG'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;

include('common.php');

define('CLASS_NAME','MySmartTagsMOD');

class MySmartTagsMOD
{
	function run()
	{
		global $MySmartBB;
		
		// Show header with page title
		$MySmartBB->functions->ShowHeader('العلامات');
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_Show();
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	function _Show()
	{
		global $MySmartBB;
		
		// Clean the id from any strings
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$TotalArr 			= 	array();
		$TotalArr['where'] 	= 	array('tag_id',$MySmartBB->_GET['id']);
		
		$TagArr 			= 	array();
		$TagArr['where'] 	= 	array('tag_id',$MySmartBB->_GET['id']);
		
		// Pager setup
		$TagArr['pager'] 				= 	array();
		$TagArr['pager']['total']		= 	$MySmartBB->tag->GetSubjectNumber($TotalArr);
		$TagArr['pager']['perpage'] 	= 	$MySmartBB->_CONF['info_row']['subject_perpage']; // TODO
		$TagArr['pager']['count'] 		= 	$MySmartBB->_GET['count'];
		$TagArr['pager']['location'] 	= 	'index.php?page=tags&amp;show=1&amp;id=' . $MySmartBB->_GET['id'];
		$TagArr['pager']['var'] 		= 	'count';
		
		$MySmartBB->_CONF['template']['while']['Subject'] = $MySmartBB->tag->GetSubjectList($TagArr);
		
		if (!$MySmartBB->_CONF['template']['while']['Subject'])
		{
			$MySmartBB->functions->error('العلامه المطلوبه غير موجوده');
		}
		
		$MySmartBB->template->assign('tag',$MySmartBB->_CONF['template']['while']['Subject'][0]['tag']);
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->template->display('tags_show_subject');
	}
}

?>
