<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['STYLE'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartChangeStyleMOD');

class MySmartChangeStyleMOD
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تغيير النمط');
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$MySmartBB->functions->AddressBar('تغيير النمط');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المسار المُتبع غير صحيح!');
		}
				
		if ($MySmartBB->_GET['change'])
		{
			$StyleArr 				= 	array();
			$StyleArr['field']		=	array();
			
			$StyleArr['field']['style'] = $MySmartBB->_GET['id'];
						
			if ($MySmartBB->_CONF['member_permission'])
			{
				$StyleArr['where'] = array('id',$MySmartBB->_CONF['member_row']['id']);
				
				$change = $MySmartBB->member->UpdateMember($StyleArr);
			}
			else
			{
				$StyleArr['expire'] = time() + 31536000;
				
				$change = $MySmartBB->style->ChangeStyle($StyleArr);
			}
			
			if ($change)
			{
				$MySmartBB->functions->msg('تم تغيير النمط بنجاح');
				$MySmartBB->functions->goto('index.php');
			}
		}
		else
		{
			$MySmartBB->functions->error('مسار غير صحيح');
		}
	}
}

?>
