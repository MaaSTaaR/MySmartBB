<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['MISC'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;

include('common.php');

define('CLASS_NAME','MySmartStaticMOD');

class MySmartStaticMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_ShowStatic();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter(); 
	}
	
	function _ShowStatic()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('الاحصائيات');
		
		$StaticInfo = array();
		
		/**
		 * Get the age of forums and install date
		 */
		/*$GetAge = $MySmartBB->misc->GetForumAge();
		$GetAge = explode('|',$GetAge);
		
		$StaticInfo['Age'] 			= $GetAge[0];
		$StaticInfo['InstallDate'] 	= $GetAge[1];
		*/
		/**
		 * Get the number of members , subjects , replies , active members and sections
		 */
		$SecArr 						= 	array();
		$SecArr['where'] 				= 	array();
		$SecArr['where'][0] 			= 	array();
		$SecArr['where'][0]['name'] 	= 	'main_section';
		$SecArr['where'][0]['oper'] 	= 	'<>';
		$SecArr['where'][0]['value'] 	= 	'1';
		
		$StaticInfo['GetMemberNumber']	= $MySmartBB->member->GetMemberNumber(array('get_from'	=>	'cache'));
		$StaticInfo['GetSubjectNumber'] = $MySmartBB->subject->GetSubjectNumber(array('get_from'	=>	'cache'));
		$StaticInfo['GetReplyNumber']	= $MySmartBB->reply->GetReplyNumber(array('get_from'	=>	'cache'));
		$StaticInfo['GetActiveMember']	= $MySmartBB->member->GetActiveMemberNumber();
		$StaticInfo['GetSectionNumber']	= $MySmartBB->section->GetSectionNumber($SecArr);
			
		/**
		 * Get the writer of oldest subject , the most subject of riplies and the newer subject
		 * should be in cache
		 */
		$OldestArr 						= 	array();
		$OldestArr['order'] 			= 	array();
		$OldestArr['order']['field'] 	= 	'id';
		$OldestArr['order']['type'] 	= 	'ASC';
		$OldestArr['limit'] 			= 	'1';
		
		$GetOldest = $MySmartBB->subject->GetSubjectInfo($OldestArr);
		$StaticInfo['OldestSubjectWriter'] = $GetOldest['writer'];
		
		$NewerArr 						= 	array();
		$NewerArr['order'] 				= 	array();
		$NewerArr['order']['field'] 	= 	'id';
		$NewerArr['order']['type'] 		= 	'DESC';
		$NewerArr['limit'] 				= 	'1';
		
		$GetNewer = $MySmartBB->subject->GetSubjectInfo($NewerArr);
		$StaticInfo['NewerSubjectWriter'] = $GetNewer['writer'];

		$MostVisitArr 						= 	array();
		$MostVisitArr['order'] 			= 	array();
		$MostVisitArr['order']['field'] 	= 	'visitor';
		$MostVisitArr['order']['type'] 	= 	'DESC';
		$MostVisitArr['limit'] 			= 	'1';
		
		$GetMostVisit = $MySmartBB->subject->GetSubjectInfo($MostVisitArr);
		$StaticInfo['MostSubjectWriter'] = $GetMostVisit['writer'];
		
		$MySmartBB->functions->CleanVariable($StaticInfo,'html');
		
		$MySmartBB->template->assign('StaticInfo',$StaticInfo);
		
		/**
		 * Get top ten list of member who have big posts
		 */
		$TopTenArr 						= 	array();
		
		// Order data
		$TopTenArr['order'] 			= 	array();
		$TopTenArr['order']['field'] 	= 	'posts';
		$TopTenArr['order']['type'] 	= 	'DESC';
		
		// Ten rows only
		$TopTenArr['limit']				=	'10';
		
		// Clean data
		$TopTenArr['proc'] 				= 	array();
		$TopTenArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['TopTenList'] = $MySmartBB->member->GetMemberList($TopTenArr);
		
		/**
		 * Get top ten list of subjects which have big replies
		 */
		$TopSubjectArr 						= 	array();
				
		// Order data
		$TopSubjectArr['order'] 			= 	array();
		$TopSubjectArr['order']['field'] 	= 	'reply_number';
		$TopSubjectArr['order']['type'] 	= 	'DESC';
		
		// Ten rows only
		$TopTenArr['limit']					=	'10';
		
		// Clean data
		$TopSubjectArr['proc'] 				= 	array();
		$TopSubjectArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['TopSubject'] = $MySmartBB->subject->GetSubjectList($TopSubjectArr);
		
		/**
		 * Get top ten list of subjects which have big visitors
		 */
		$TopSubjectVisitorArr 							= 	array();
		
		// Order data
		$TopSubjectVisitorArr['order'] 				= 	array();
		$TopSubjectVisitorArr['order']['field'] 	= 	'visitor';
		$TopSubjectVisitorArr['order']['type'] 		= 	'DESC';
		
		// Ten rows only
		$TopSubjectVisitorArr['limit']				=	'10';
		
		// Clean data
		$TopSubjectVisitorArr['proc'] 				= 	array();
		$TopSubjectVisitorArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['TopSubjectVisitor'] = $MySmartBB->subject->GetSubjectList($TopSubjectVisitorArr);
		
		$MySmartBB->template->display('static');
	}
}

?>
