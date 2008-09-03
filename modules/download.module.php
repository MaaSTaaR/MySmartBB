<?php

$CALL_SYSTEM = array();
$CALL_SYSTEM['SUBJECT'] = true;
$CALL_SYSTEM['SECTION'] = true;

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.php');

define('CLASS_NAME','MySmartDownloadMOD');

class MySmartDownloadMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['subject'])
		{
			$this->_DownloadSubject();
		}
	}
	
	function _DownloadSubject()
	{
		global $MySmartBB;
		
		//////////
		
		// Clean id from any string, that will protect us
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
			
		// If the id is empty, so stop the page
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره المسار المتبع غير صحيح');
		}
		
		//////////
		
		$SubjectArr = array();
		
		$SubjectArr['where'] 				= 	array();

		$SubjectArr['where'][0] 			= 	array();
		$SubjectArr['where'][0]['name'] 	= 	'id';
		$SubjectArr['where'][0]['oper'] 	= 	'=';
		$SubjectArr['where'][0]['value'] 	= 	$MySmartBB->_GET['id'];

		$SubjectInfo = $MySmartBB->subject->GetSubjectInfo($SubjectArr);
		
		$MySmartBB->functions->CleanVariable($SubjectInfo,'html');
		
		if ($SubjectInfo['delete_topic'] 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			$MySmartBB->functions->error('الموضوع المطلوب منقول إلى سلّة المحذوفات');
		}
		
		$SecArr 			= 	array();
		$SecArr['where'] 	= 	array('id',$SubjectInfo['section']);
		
		$SectionInfo = $MySmartBB->section->GetSectionInfo($SecArr);
		
		$SecGroupArr 						= 	array();
		$SecGroupArr['where'] 				= 	array();
		$SecGroupArr['where'][0]			=	array();
		$SecGroupArr['where'][0]['name'] 	= 	'section_id';
		$SecGroupArr['where'][0]['value'] 	= 	$SectionInfo['id'];
		$SecGroupArr['where'][1]			=	array();
		$SecGroupArr['where'][1]['con']		=	'AND';
		$SecGroupArr['where'][1]['name']	=	'group_id';
		$SecGroupArr['where'][1]['value']	=	$MySmartBB->_CONF['group_info']['id'];
			
		// Finally get the permissions of group
		$SectionGroup = $MySmartBB->group->GetSectionGroupInfo($SecGroupArr);
		
		if (!$SectionGroup['view_section'])
		{
			$MySmartBB->functions->error('المعذره لا يمكنك عرض هذا الموضوع');
		}
		
		header('Content-Disposition: attachment;filename=' . $SubjectInfo['title'] . '.txt');
		header('Content-type: application/download');
		
		echo $SubjectInfo['text'];
	}
}

?>
