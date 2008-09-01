<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;

include('common.php');

define('CLASS_NAME','MySmartProfileMOD');

class MySmartProfileMOD
{
	function run()
	{
		global $MySmartBB;
		
		/** Show the profile of member **/
		if ($MySmartBB->_GET['show'])
		{
			$this->_ShowProfile();
		}
		/** **/
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
					
		$MySmartBB->functions->GetFooter();
	}
	
	/** Get member information and show it **/
	function _ShowProfile()
	{
		global $MySmartBB;
		
		//////////
		// Show the header

		$MySmartBB->functions->ShowHeader('عرض معلومات العضو');
		
		//////////
		// Get the member information
		
		$MemArr = array();
		
		$MemArr['get'] 	= 'id,username,usergroup,user_info,user_sig,user_country,user_gender,user_website,';
		$MemArr['get']  .= 'lastvisit,user_time,register_date,posts,user_title,visitor,avater_path,away,away_msg';
		
		$do_query = true;
		
		// Well I think we are the biggest sneaky in the world after wrote these lines :D
		if (!empty($MySmartBB->_GET['id']))
		{
			$id = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
			
			$MemArr['where'] = array('id',$id);
			
			$do_query = ($MySmartBB->_CONF['member_row']['id'] == $MySmartBB->_GET['id']) ? false : true;
		}
		elseif (!empty($MySmartBB->_GET['username']))
		{
			$MemArr['where'] 	= 	array('username',$MySmartBB->_GET['username']);
			
			$do_query = ($MySmartBB->_CONF['member_row']['username'] == $MySmartBB->_GET['username']) ? false : true;
		}
		else
		{
			$MySmartBB->functions->error('مسار غير صحيح');
		}
		
		$MySmartBB->_CONF['template']['MemberInfo'] = ($do_query) ? $MySmartBB->member->GetMemberInfo($MemArr) : $MySmartBB->_CONF['member_row'];
		
		//////////
		
		if (!$MySmartBB->_CONF['template']['MemberInfo'])
		{
			$MySmartBB->functions->error('المعذره .. العضو المطلوب غير موجود في سجلاتنا');
		} 
		
		// Kill XSS first
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['MemberInfo'],'html');
		// Second Kill SQL Injections
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['MemberInfo'],'sql');
		
		//////////
		
		// Where is the member now?
		if ($MySmartBB->_CONF['member_permission'])
     	{
     		$UpdateOnline 			= 	array();
			$UpdateOnline['field']	=	array();
			
			$UpdateOnline['field']['user_location']		=	'يطلع على الملف الشخصي للعضو : ' . $MySmartBB->_CONF['template']['MemberInfo']['username'];
			$UpdateOnline['where']						=	array('username',$MySmartBB->_CONF['member_row']['username']);
			
			$update = $MySmartBB->online->UpdateOnline($UpdateOnline);
     	}
     	
     	//////////
     	
		$MySmartBB->_CONF['template']['MemberInfo']['user_gender'] 	= 	($MySmartBB->_CONF['template']['MemberInfo']['user_gender'] == 'm') ? 'ذكر' : 'انثى';
		//$MemberInfo['user_time']		=	$MySmartBB->member->GetMemberTime($MemberInfo['user_time']);
		
		if (is_numeric($MySmartBB->_CONF['template']['MemberInfo']['register_date']))
		{
			$MySmartBB->_CONF['template']['MemberInfo']['register_date'] = $MySmartBB->functions->date($MySmartBB->_CONF['template']['MemberInfo']['register_date']);
		}
		
		// We should be sneaky sometime ;)
		if ($MySmartBB->_CONF['member_row']['usergroup'] == $MySmartBB->_CONF['template']['MemberInfo']['usergroup'])
		{
			$GroupInfo = $MySmartBB->_CONF['rows']['group_info'];
		}
		else
		{
			$GroupInfo 				= 	array();
			$GroupInfo['where'] 	= 	array('id',$MySmartBB->_CONF['template']['MemberInfo']['usergroup']);
		
			$GroupInfo = $MySmartBB->group->GetGroupInfo($GroupInfo);
		}
			
		$MySmartBB->_CONF['template']['MemberInfo']['usergroup'] = $GroupInfo['title'];
			
		$IsOnline = $MySmartBB->online->IsOnline(array(		'way'		=>	'username',
															'username'	=>	$MySmartBB->_CONF['template']['MemberInfo']['username'],
															'timeout'	=>	$MySmartBB->_CONF['timeout']));
		
		$MySmartBB->_CONF['template']['MemberInfo']['IsOnline'] = $IsOnline; 
		
		if ($MySmartBB->_CONF['template']['MemberInfo']['posts'] > 0)
		{
			$LastSubjectArr 						= 	array();
		
			$LastSubjectArr['where'] 				= 	array();
			$LastSubjectArr['where'][0] 			= 	array();
			$LastSubjectArr['where'][0]['name'] 	= 	'writer';
			$LastSubjectArr['where'][0]['oper'] 	= 	'=';
			$LastSubjectArr['where'][0]['value'] 	= 	$MySmartBB->_CONF['template']['MemberInfo']['username'];
		
			$LastSubjectArr['where'][1] 			= 	array();
			$LastSubjectArr['where'][1]['con'] 		= 	'AND';
			$LastSubjectArr['where'][1]['name'] 	= 	'delete_topic';
			$LastSubjectArr['where'][1]['oper'] 	= 	'<>';
			$LastSubjectArr['where'][1]['value'] 	= 	'1';
		
			$LastSubjectArr['where'][2] 			= 	array();
			$LastSubjectArr['where'][2]['con'] 		= 	'AND';
			$LastSubjectArr['where'][2]['name'] 	= 	'sec_subject';
			$LastSubjectArr['where'][2]['oper'] 	= 	'<>';
			$LastSubjectArr['where'][2]['value'] 	= 	'1';
		
			$LastSubjectArr['order'] 				= 	array();
			$LastSubjectArr['order']['field'] 		= 	'id';
			$LastSubjectArr['order']['type']	 	= 	'DESC';
		
			$LastSubjectArr['limit'] 				= 	'0,1';
		
			$MySmartBB->_CONF['template']['LastSubject'] = $MySmartBB->subject->GetSubjectInfo($LastSubjectArr);
			
			$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['LastSubject'],'html');
				
			$LastReplyArr 						= 	array();
		
			$LastReplyArr['where'] 				= 	array();
			$LastReplyArr['where'][0] 			= 	array();
			$LastReplyArr['where'][0]['name'] 	= 	'writer';
			$LastReplyArr['where'][0]['oper'] 	= 	'=';
			$LastReplyArr['where'][0]['value'] 	= 	$MySmartBB->_CONF['template']['MemberInfo']['username'];
		
			$LastReplyArr['where'][1] 			= 	array();
			$LastReplyArr['where'][1]['con'] 	= 	'AND';
			$LastReplyArr['where'][1]['name'] 	= 	'delete_topic';
			$LastReplyArr['where'][1]['oper'] 	= 	'<>';
			$LastReplyArr['where'][1]['value'] 	= 	'1';
		
			$LastReplyArr['order'] 				= 	array();
			$LastReplyArr['order']['field'] 	= 	'id';
			$LastReplyArr['order']['type']	 	= 	'DESC';
		
			$LastReplyArr['limit'] 				= 	'0,1';
		
			$GetLastReplyInfo = $MySmartBB->reply->GetReplyInfo($LastReplyArr);
		
			$MySmartBB->functions->CleanVariable($GetLastReplyInfo,'sql');
		
			if ($GetLastReplyInfo != false)
			{
				$SubjectArr 			= 	array();
				$SubjectArr['where'] 	= 	array('id',$GetLastReplyInfo['subject_id']);
		
				$MySmartBB->_CONF['template']['GetSubject'] = $MySmartBB->subject->GetSubjectInfo($SubjectArr);
		
				$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['GetSubject'],'html');
			}
		}
		
		$OnlineArr 				= 	array();
		$OnlineArr['username'] 	= 	$MySmartBB->_CONF['template']['MemberInfo']['username'];
		
		$MySmartBB->_CONF['template']['Location'] = $MySmartBB->online->GetOnlineInfo($OnlineArr);
		
		$MySmartBB->template->display('profile');
	}
}
	
?>
