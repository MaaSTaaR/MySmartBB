<?php

/** PHP5 **/

// TODO :: groups, visitor

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['POLL'] 		= 	true;
$CALL_SYSTEM['VOTE'] 		= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartVoteMOD');

class MySmartVoteMOD
{
	public function run()
	{
		global $MySmartBB;
		
		// Show header with page title
		$MySmartBB->func->showHeader('التصويت');
		
		if ($MySmartBB->_GET['start'])
		{
			$this->_start();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _start()
	{
		global $MySmartBB;
		
		// Clean the id from any strings
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'poll' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$Poll = $MySmartBB->rec->getInfo();
		
		if (!$Poll)
		{
			$MySmartBB->func->error('الاقتراع المطلوب غير موجود');
		}
		
		if (!isset($MySmartBB->_POST['answer']))
		{
			$MySmartBB->func->error('يجب عليك الاختيار من اجل قبول اقتراعك');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'vote' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "' AND username='" . $MySmartBB->_CONF['member_row']['username'] .  "'";
		
		$Vote = $MySmartBB->rec->getInfo();
		
		if ($Vote != false)
		{
			$MySmartBB->func->error('غير مسموح لك بالتصويت اكثر من مرّه');
		}
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		$MySmartBB->rec->fields = array(	'poll_id'	=>	$MySmartBB->_GET['id'],
											'member_id'	=>	$MySmartBB->_CONF['member_row']['id'],
											'username'	=>	$MySmartBB->_CONF['member_row']['username']	);
											
		
		$insert = $MySmartBB->vote->doVote( $Poll['answers'], $MySmartBB->_POST['answer'] );
		
		if ($insert)
		{
			$MySmartBB->func->msg('تم احتساب تصويتك');
			$MySmartBB->func->goto('index.php?page=topic&amp;show=1&amp;id=' . $Poll['subject_id']);
		}
	}
}

?>
