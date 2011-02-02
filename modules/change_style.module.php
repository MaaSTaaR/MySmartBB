<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);

$CALL_SYSTEM			=	array();
$CALL_SYSTEM['STYLE'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartChangeStyleMOD');

class MySmartChangeStyleMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تغيير النمط');
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->func->addressBar('تغيير النمط');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المُتبع غير صحيح!');
		}
				
		if ($MySmartBB->_GET['change'])
		{
			if ($MySmartBB->_CONF['member_permission'])
			{
				$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
				
				$MySmartBB->rec->fields = array(	'style'	=>	$MySmartBB->_GET[ 'id' ]	);
				
				$change = $MySmartBB->member->updateMember();
			}
			else
			{
				$change = $MySmartBB->style->changeStyle( $MySmartBB->_GET[ 'id' ], time() + 31536000 );
			}
			
			if ($change)
			{
				$MySmartBB->func->msg('تم تغيير النمط بنجاح');
				$MySmartBB->func->goto('index.php');
			}
		}
		else
		{
			$MySmartBB->func->error('مسار غير صحيح');
		}
	}
}

?>
