<?php

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
	function run()
	{
		global $MySmartBB;
		
		// Show header with page title
		$MySmartBB->functions->ShowHeader('التصويت');
		
		if ($MySmartBB->_GET['start'])
		{
			$this->_Start();
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	function _Start()
	{
		global $MySmartBB;
		
		// Clean the id from any strings
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$PollArr = array();
		$PollArr['where'] = array('id',$MySmartBB->_GET['id']);
		
		$Poll = $MySmartBB->poll->GetPollInfo($PollArr);
		
		if (!$Poll)
		{
			$MySmartBB->functions->error('الاقتراع المطلوب غير موجود');
		}
		
		if (!isset($MySmartBB->_POST['answer']))
		{
			$MySmartBB->functions->error('يجب عليك الاختيار من اجل قبول اقتراعك');
		}
		
		$CheckArr 						= 	array();
		
		$CheckArr['where'][0] 			= 	array();
		$CheckArr['where'][0]['name'] 	= 	'id';
		$CheckArr['where'][0]['oper'] 	= 	'=';
		$CheckArr['where'][0]['value'] 	= 	$MySmartBB->_GET['id'];
		

		$CheckArr['where'][1] 			= 	array();
		$CheckArr['where'][1]['con'] 	= 	'AND';
		$CheckArr['where'][1]['name'] 	= 	'username';
		$CheckArr['where'][1]['oper'] 	= 	'=';
		$CheckArr['where'][1]['value'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		
		$Vote = $MySmartBB->vote->GetVoteInfo($CheckArr);
		
		if ($Vote != false)
		{
			$MySmartBB->functions->error('غير مسموح لك بالتصويت اكثر من مرّه');
		}
		
		$VoteArr 				= 	array();
		$VoteArr['field']		=	array();
		
		$VoteArr['answers'] 			= 	$Poll['answers'];
		$VoteArr['answer'] 				= 	$MySmartBB->_POST['answer'];
		$VoteArr['where'] 				= 	array('id',$MySmartBB->_GET['id']);
		$VoteArr['field']['poll_id'] 	= 	$MySmartBB->_GET['id'];
		$VoteArr['field']['member_id'] 	= 	$MySmartBB->_CONF['member_row']['id'];
		$VoteArr['field']['username'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		
		$insert = $MySmartBB->vote->DoVote($VoteArr);
		
		if ($insert)
		{
			$MySmartBB->functions->msg('تم احتساب تصويتك');
			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $Poll['subject_id']);
		}
	}
}

?>
