<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPInfoMOD');

class MySmartUserCPInfoMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->func->error( 'المعذره .. هذه المنطقه للاعضاء فقط' );
		}
		
		if ( $MySmartBB->_GET[ 'main' ] )
		{
			$this->_infoMain();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_infoChange();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _infoMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( 'تحرير المعلومات الشخصيه' );
		
		$MySmartBB->template->display( 'usercp_control_info' );
	}
	
	private function _infoChange()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تنفيذ عملية التحديث');
		
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'user_country'	=>	$MySmartBB->_POST['country'],
											'user_website'	=>	$MySmartBB->_POST['website'],
											'user_info'	=>	$MySmartBB->_POST['info'],
											'away'	=>	$MySmartBB->_POST['away'],
											'away_msg'	=>	$MySmartBB->_POST['away_msg']	);
		
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
			$MySmartBB->func->msg('تم التحديث بنجاح');
			$MySmartBB->func->move('index.php?page=usercp_control_info&amp;main=1');
		}
	}
}
