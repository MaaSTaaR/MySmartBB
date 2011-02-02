<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartProfileMOD');

class MySmartProfileMOD
{
	public function run()
	{
		global $MySmartBB;
		
		/** Show the profile of member **/
		if ($MySmartBB->_GET['show'])
		{
			$this->_showProfile();
		}
		/** **/
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
					
		$MySmartBB->func->getFooter();
	}
	
	/** Get member information and show it **/
	private function _showProfile()
	{
		global $MySmartBB;
		
		/* ... */
		
		// Show the header

		$MySmartBB->func->showHeader('عرض معلومات العضو');
		
		/* ... */
		
		// Get the member information
		
		$MemArr = array();
		
		$MemArr['get'] 	= 'id,username,usergroup,user_info,user_sig,user_country,user_gender,user_website,';
		$MemArr['get']  .= 'lastvisit,user_time,register_date,posts,user_title,visitor,avater_path,away,away_msg';
		
		$do_query = true;
		
		// Well I think we are the biggest sneaky in the world after wrote these lines :D
		if (!empty($MySmartBB->_GET['id']))
		{
			$id = (int) $MySmartBB->_GET['id'];
			
			$MySmartBB->rec->filter = "id='" . $id . "'";
			
			if ( $MySmartBB->_CONF[ 'member_permission' ] )
			{
				$do_query = ($MySmartBB->_CONF['member_row']['id'] == $MySmartBB->_GET['id']) ? false : true;
			}
		}
		elseif (!empty($MySmartBB->_GET['username']))
		{
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_GET['username'] . "'";
			
			if ( $MySmartBB->_CONF[ 'member_permission' ] )
			{
				$do_query = ($MySmartBB->_CONF['member_row']['username'] == $MySmartBB->_GET['username']) ? false : true;
			}
		}
		else
		{
			$MySmartBB->func->error('مسار غير صحيح');
		}
		
		$MySmartBB->_CONF['template']['MemberInfo'] = ($do_query) ? $MySmartBB->member->getMemberInfo() : $MySmartBB->_CONF['member_row'];
		
		/* ... */
		
		if (!$MySmartBB->_CONF['template']['MemberInfo'])
		{
			$MySmartBB->func->error('المعذره .. العضو المطلوب غير موجود في سجلاتنا');
		} 
		
		$MySmartBB->func->CleanVariable($MySmartBB->_CONF['template']['MemberInfo'],'sql');
		
		/* ... */
		
		// Where is the member now?
		if ($MySmartBB->_CONF['member_permission'])
     	{
			$MySmartBB->rec->fields = array(	'user_location'	=>	'يطلع على الملف الشخصي للعضو : ' . $MySmartBB->_CONF['template']['MemberInfo']['username']	);
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
			
			$update = $MySmartBB->online->updateOnline();			
     	}
     	
     	/* ... */
     	
		$MySmartBB->_CONF['template']['MemberInfo']['user_gender'] 	= 	($MySmartBB->_CONF['template']['MemberInfo']['user_gender'] == 'm') ? 'ذكر' : 'انثى';
		//$MemberInfo['user_time']		=	$MySmartBB->member->GetMemberTime($MemberInfo['user_time']);
		
		if (is_numeric($MySmartBB->_CONF['template']['MemberInfo']['register_date']))
		{
			$MySmartBB->_CONF['template']['MemberInfo']['register_date'] = $MySmartBB->func->date($MySmartBB->_CONF['template']['MemberInfo']['register_date']);
		}
		
		// We should be sneaky sometime ;)
		if ( $MySmartBB->_CONF[ 'member_permission' ] 
			and $MySmartBB->_CONF['member_row']['usergroup'] == $MySmartBB->_CONF['template']['MemberInfo']['usergroup'])
		{
			$GroupInfo = $MySmartBB->_CONF['group_info'];
		}
		else
		{
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['MemberInfo']['usergroup'] . "'";
			
			$GroupInfo = $MySmartBB->group->getGroupInfo($GroupInfo);
		}
			
		$MySmartBB->_CONF['template']['MemberInfo']['usergroup'] = $GroupInfo['title'];
			
		$IsOnline = $MySmartBB->online->isOnline( $MySmartBB->_CONF['timeout'], 'username', $MySmartBB->_CONF['template']['MemberInfo']['username'] );
		
		$MySmartBB->_CONF['template']['MemberInfo']['IsOnline'] = $IsOnline; 
		
		if ($MySmartBB->_CONF['template']['MemberInfo']['posts'] > 0)
		{
			/* ... */
			
			$MySmartBB->rec->filter = "writer='" . $MySmartBB->_CONF['template']['MemberInfo']['username'] . "' AND delete_topic<>'1' AND sec_subject<>'1'";
			
			$MySmartBB->rec->filter = "id DESC";
			
			$MySmartBB->rec->limit = '0,1';
			
			$MySmartBB->_CONF['template']['LastSubject'] = $MySmartBB->subject->getSubjectInfo();
			
			/* ... */
			
			$MySmartBB->rec->filter = "writer='" . $MySmartBB->_CONF['template']['MemberInfo']['username'] . "' AND delete_topic<>'1'";
			
			$MySmartBB->rec->order = "id DESC";
			
			$MySmartBB->rec->limit = '1';
			
			$GetLastReplyInfo = $MySmartBB->reply->getReplyInfo();
		
			$MySmartBB->func->cleanArray($GetLastReplyInfo,'sql');
			
			if ($GetLastReplyInfo != false)
			{
				$MySmartBB->rec->filter = "id='" . $GetLastReplyInfo['subject_id'] . "'";
				
				$MySmartBB->_CONF['template']['LastReply'] = $MySmartBB->subject->GetSubjectInfo($SubjectArr);				
			}
		}
		
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['template']['MemberInfo']['username'] . "'";
		
		$MySmartBB->_CONF['template']['Location'] = $MySmartBB->online->getOnlineInfo();
		
		$MySmartBB->template->display('profile');
	}
}
	
?>
