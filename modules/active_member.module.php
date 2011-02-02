<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['REQUEST'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartActiveMOD');

class MySmartActiveMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تفعيل العضويه');
		
		// The index page for active
		if ($MySmartBB->_GET['index'])
		{
			$this->_index();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
			
		$MySmartBB->func->getFooter();
	}
		
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->addressBar('تفعيل العضويه');
		
		// No code !
		if (empty($MySmartBB->_GET['code']))
		{
			$MySmartBB->func->error('الرابط المتبع غير صحيح');
		}
		// This isn't member
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->func->error('يرجى تسجيل دخولك اول');
		}
		
		$MySmartBB->rec->filter = "random_url='" . $MySmartBB->_GET['code'] . "' AND request_type='3' AND username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		
		// Get request information
		$RequestInfo = $MySmartBB->request->getRequestInfo();
		
		// No request , so stop the page
		if (!$RequestInfo)
		{
			$MySmartBB->func->error('المعذره الطلب غير موجود !');
		}
		
      	/* ... */
      	
      	// Get the information of default group to set username style cache
      	
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['info_row']['adef_group'] . "'";
		
		$GroupInfo = $MySmartBB->group->getGroupInfo();
		
		$style = $GroupInfo['username_style'];
		$username_style_cache = str_replace('[username]',$MySmartBB->_CONF['member_row']['username'],$style);
		
      	/* ... */
      	
		$MySmartBB->rec->fields = array(	'usergroup'	=>	$MySmartBB->_CONF['info_row']['adef_group'],
											'username_style_cache'	=>	$username_style_cache	);
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
		
		// We found the request , so active the member
		$UpdateGroup = $MySmartBB->member->updateMember();
		
		// The active is success
		if ($UpdateGroup)
		{	
			$MySmartBB->func->msg('تم تفعيل عضويتك بنجاح , شكراً لك  !');
			$MySmartBB->func->goto('index.php');
		}
	}
}
	
?>
