<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;

include('common.php');
	
define('CLASS_NAME','MySmartAjaxMOD');

class MySmartAjaxMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['sections'])
		{	
			if ($MySmartBB->_GET['rename'])
			{
				$this->_SectionRename();
			}
		}
	}
	
	function _SectionRename()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['title'])
			or empty($MySmartBB->_POST['id']))
		{
			$MySmartBB->functions->error('المسار المُتبع غير صحيح');
		}
		
		$SecArr 			= 	array();
		$SecArr['field'] 	= 	array();
		
		$SecArr['field']['title'] 	= 	$MySmartBB->_POST['title'];
		$SecArr['where']			= 	array('id',$MySmartBB->_POST['id']);
				
		$update = $MySmartBB->section->UpdateSection($SecArr);
		
		if ($update)
		{
			echo $MySmartBB->_POST['title'];
		}
	}
}

?>
