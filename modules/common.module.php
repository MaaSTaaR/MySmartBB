<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

class MySmartCommon
{
	var $CheckMember;
			
	/**
	 * The main function
	 */
	function run()
	{
		$this->_GeneralProc();
			
		$this->_CheckMember();
		
		$this->_SetInformation();
			
		$this->_ShowAds();
		
		$this->_GetStylePath();
			
		$this->_CheckClose();
		
		$this->_TemplateAssign();
	}
					
	/**
	 * Clean not important information
	 */
	function _GeneralProc()
	{
		global $MySmartBB;
		
		////////////
		
 		// Delete not important rows in online table
 		$CleanArr				= 	array();
 		$CleanArr['timeout'] 	= 	$MySmartBB->_CONF['timeout'];
 		 											
 		$CleanOnline = $MySmartBB->online->CleanOnlineTable($CleanArr);
 		
 		////////////
 	
 		// Delete not important rows in today table
 		$CleanArr 			= 	array();
 		$CleanArr['date'] 	= 	$MySmartBB->_CONF['date'];
 	 	
 	 	$CleanToday = $MySmartBB->online->CleanTodayTable($CleanArr);
 	 	
 	 	////////////
 	 	
		if ($MySmartBB->_CONF['info_row']['today_date_cache'] != $MySmartBB->_CONF['date'])
		{
			$MySmartBB->info->UpdateInfo(array('value'=>'1','var_name'=>'today_number_cache'));
			$MySmartBB->info->UpdateInfo(array('value'=>$MySmartBB->_CONF['date'],'var_name'=>'today_date_cache'));
		}
		
		////////////
	}
		
	function _CheckMember()
	{
		global $MySmartBB;
		
		////////////
		
		if ($MySmartBB->functions->IsCookie($MySmartBB->_CONF['username_cookie']) 
			and $MySmartBB->functions->IsCookie($MySmartBB->_CONF['password_cookie']))
		{
			////////////
			
			$username = $MySmartBB->_COOKIE[$MySmartBB->_CONF['username_cookie']];
			$password = $MySmartBB->_COOKIE[$MySmartBB->_CONF['password_cookie']];
			
			////////////
		
			// Check if the visitor is member or not ?
 			$MemberArr 			= 	array();
			$MemberArr['get']	= 	'*';
		
			$MemberArr['where']	=	array();
		
			$MemberArr['where'][0]				=	array();
			$MemberArr['where'][0]['name']		=	'username';
			$MemberArr['where'][0]['oper']		=	'=';
			$MemberArr['where'][0]['value']		=	$username;
		
			$MemberArr['where'][1]				=	array();
			$MemberArr['where'][1]['con']		=	'AND';
			$MemberArr['where'][1]['name']		=	'password';
			$MemberArr['where'][1]['oper']		=	'=';
			$MemberArr['where'][1]['value']		=	$password;
			
			// If the information isn't valid CheckMember's value will be false
			// otherwise the value will be an array
			$this->CheckMember = $MySmartBB->member->GetMemberInfo($MemberArr);
			
			////////////
				
			// This is a member :)										
			if ($this->CheckMember != false)
			{
				$this->__MemberProcesses();
			}
			// This is visitor
			else
			{
				$this->__VisitorProcesses();
			}
		}
		else
		{
			$this->__VisitorProcesses();
		}
		
		////////////
	}
		
	/**
	 * If the Guest is member , call this function
	 */
	function __MemberProcesses()
	{
		global $MySmartBB;
		
		////////////
		
		$MySmartBB->_CONF['rows']['member_row'] 	= 	$this->CheckMember;	
		$MySmartBB->_CONF['member_permission']	 	= 	true;
		
		////////////
		
		// I hate SQL injections 
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['rows']['member_row'],'sql');
		
		// I hate XSS
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['rows']['member_row'],'html');
		
		////////////
		
		// alias name
		// TODO : Delete this line, it's get size from memory!
		$MySmartBB->_CONF['member_row'] = $MySmartBB->_CONF['rows']['member_row'];
		
		////////////
		
		// Get the member's group info and store it in _CONF['group_info']
		$GroupInfo 				= 	array();
		$GroupInfo['where'] 	= 	array('id',$MySmartBB->_CONF['member_row']['usergroup']);
		
		$MySmartBB->_CONF['rows']['group_info'] = $MySmartBB->group->GetGroupInfo($GroupInfo);
		
		// alias name
		// TODO : Delete this line, it's get size from memory!
		$MySmartBB->_CONF['group_info'] = $MySmartBB->_CONF['rows']['group_info'];
		
		////////////
		
		// This member is banned :/
		if ($MySmartBB->_CONF['group_info']['banned'])
		{
			// Stop the page with small massege
			$MySmartBB->functions->error('المعذره .. لا يمكنك الدخول للمنتدى');
		}
		
		////////////
		
		// Check if the member is already online
		$OnlineArr				= array();
		$OnlineArr['timeout'] 	= $MySmartBB->_CONF['timeout']; 
		$OnlineArr['username']  = $MySmartBB->_CONF['member_row']['username'];
														 
		$IsOnline = $MySmartBB->online->GetOnlineInfo($OnlineArr);
		
		////////////
		
		// Where is the member now ?
		$MemberLocation = 'الصفحه الرئيسيه';
		
		$page = empty($MySmartBB->_GET['page']) ? 'index' : $MySmartBB->_GET['page'];
		
		$locations 					= 	array();
		$locations['index'] 		= 	'الصفحه الرئيسيه';
		$locations['forum'] 		= 	'يطلع على منتدى';
		$locations['profile'] 		= 	'يطلع على ملف عضو';
		$locations['static'] 		= 	'يطلع على صفحة الاحصائيات';
		$locations['member_list'] 	= 	'يطلع على قائمة الاعضاء';
		$locations['search'] 		= 	'يطلع على صفحة البحث';
		$locations['announcement'] 	= 	'يطلع على إعلان اداري';
		$locations['team'] 			= 	'يطلع على صفحة المسؤولين';
		$locations['login'] 		= 	'يسجل دخوله';
		$locations['logout'] 		= 	'يسجل خروجه';
		$locations['usercp'] 		= 	'يطلع على لوحة تحكمه';
		$locations['pm'] 			= 	'يطلع على الرسائل الخاصه';
		$locations['topic'] 		= 	'يطّلع على موضوع';
		$locations['new_topic'] 	= 	'يكتب موضوع جديد';
		$locations['new_reply'] 	= 	'يكتب رد جديد';
		$locations['vote'] 			= 	'يضع تصويت';
		$locations['tags'] 			= 	'يطلع على العلامات';
		$locations['online'] 		= 	'يطلع على المتواجدين حالياً';
		
		if (array_key_exists($page,$locations))
		{
			$MemberLocation = $locations[$page];
		}
		
		// Get username with group style
		$UStyleArr	 				= 	array();
		$UStyleArr['username'] 		= 	$MySmartBB->_CONF['member_row']['username'];
		$UStyleArr['group_style'] 	= 	$MySmartBB->_CONF['group_info']['username_style'];
		
		$username_style = $MySmartBB->member->GetUsernameByStyle($UStyleArr);
		$username_style = $MySmartBB->functions->CleanVariable($username_style,'sql');
		
		////////////
		
		// Member don't exists in online table , so we insert member info
		if (!$IsOnline)
		{
			$InsertOnline 			= 	array();
			$InsertOnline['field'] 	= 	array();
			
			$InsertOnline['field']['username'] 			= 	$MySmartBB->_CONF['member_row']['username'];
			$InsertOnline['field']['username_style'] 	= 	$username_style;
			$InsertOnline['field']['logged'] 			= 	$MySmartBB->_CONF['now'];
			$InsertOnline['field']['path'] 				= 	$MySmartBB->_SERVER['QUERY_STRING'];
			$InsertOnline['field']['user_ip'] 			= 	$MySmartBB->_CONF['ip'];
			$InsertOnline['field']['hide_browse'] 		= 	$MySmartBB->_CONF['member_row']['hide_online'];
			$InsertOnline['field']['user_location'] 	= 	$MemberLocation;
			$InsertOnline['field']['subject_show'] 		= 	$subject_show;
			$InsertOnline['field']['subject_id'] 		= 	$subject_id;
			$InsertOnline['field']['user_id'] 			= 	$MySmartBB->_CONF['member_row']['id'];
			
			$insert = $MySmartBB->online->InsertOnline($InsertOnline); 
		}
		// Member is already online , just update information
		else
		{
			$username_style_fi = str_replace('\\','',$username_style);
			
			if ($IsOnline['logged'] < $MySmartBB->_CONF['timeout'] 
				or $IsOnline['path'] != $MySmartBB->_SERVER['QUERY_STRING'] 
				or $IsOnline['username_style'] != $username_style_fi 
				or $IsOnline['hide_browse'] != $MySmartBB->_CONF['rows']['member_row']['hide_online'])
			{	
				$UpdateOnline 					= 	array();
				$UpdateOnline['field']			=	array();
				
				$UpdateOnline['field']['username'] 			= 	$MySmartBB->_CONF['member_row']['username'];
				$UpdateOnline['field']['username_style'] 	= 	$username_style;
				$UpdateOnline['field']['logged']			=	$MySmartBB->_CONF['now'];
				$UpdateOnline['field']['path']				=	$MySmartBB->_SERVER['QUERY_STRING'];
				$UpdateOnline['field']['user_ip']			=	$MySmartBB->_CONF['ip'];
				$UpdateOnline['field']['hide_browse']		=	$MySmartBB->_CONF['member_row']['hide_online'];
				$UpdateOnline['field']['user_location']		=	$MemberLocation;
				$UpdateOnline['field']['subject_show']		=	$subject_show;
				$UpdateOnline['field']['subject_id']		=	$subject_id;
				$UpdateOnline['field']['user_id']			=	$MySmartBB->_CONF['member_row']['id'];
				$UpdateOnline['where']						=	array('username',$MySmartBB->_CONF['member_row']['username']);
				
				$update = $MySmartBB->online->UpdateOnline($UpdateOnline);
			}
		}
				
		////////////
		
		// Ok , now we check if this member is exists in today list
		$IsTodayArr 				= array();
		$IsTodayArr['username'] 	= $MySmartBB->_CONF['member_row']['username'];
		$IsTodayArr['date'] 		= $MySmartBB->_CONF['date'];
													 
		$IsToday = $MySmartBB->online->IsToday($IsTodayArr);
		
		////////////
		
		// Member isn't exists in today table , so insert the member								  
		if (!$IsToday)
		{
			////////////
			
			$InsertTodayArr 			= 	array();
			$InsertTodayArr['field']	=	array();
																				
			$InsertTodayArr['field']['username'] 		= 	$MySmartBB->_CONF['member_row']['username'];
			$InsertTodayArr['field']['user_id'] 		= 	$MySmartBB->_CONF['member_row']['id'];
			$InsertTodayArr['field']['user_date'] 		= 	$MySmartBB->_CONF['date'];
			$InsertTodayArr['field']['hide_browse'] 	= 	$MySmartBB->_CONF['member_row']['hide_online'];
			$InsertTodayArr['field']['username_style'] 	= 	$username_style;
			
			$InsertToday = $MySmartBB->online->InsertToday($InsertTodayArr);
			
			////////////
			
			if ($InsertToday)
			{
				////////////
				
				$UpdateArr 				= 	array();
				$UpdateArr['field']		=	array();
				
				$UpdateArr['field']['visitor'] 	= 	$MySmartBB->_CONF['member_row']['visitor'] + 1;
				$UpdateArr['where'] 			= 	array('id',$MySmartBB->_CONF['member_row']['id']);
				
				$MySmartBB->member->UpdateMember($UpdateArr);
				
				////////////
				
				if ($MySmartBB->_CONF['info_row']['today_date_cache'] == $MySmartBB->_CONF['date'])
				{
					$number = $MySmartBB->_CONF['info_row']['today_number_cache'] + 1;
					
					$MySmartBB->info->UpdateInfo(array('value'=>$number,'var_name'=>'today_number_cache'));
				}
				
				////////////
			}
			
			////////////
		}
		
		////////////
		
		// Can't find last visit cookie , so register it
		if (!$MySmartBB->functions->IsCookie('MySmartBB_lastvisit'))
		{
			$CookieArr 					= 	array();		
			$CookieArr['last_visit'] 	= 	(empty($MySmartBB->_CONF['member_row']['lastvisit'])) ? $MySmartBB->_CONF['date'] : $MySmartBB->_CONF['member_row']['lastvisit'];
			$CookieArr['date'] 			= 	$MySmartBB->_CONF['date'];
			$CookieArr['id'] 			= 	$MySmartBB->_CONF['member_row']['id'];
			
			$MySmartBB->member->LastVisitCookie($CookieArr);
		}
		
		////////////
		
		// Get member style
		if ($MySmartBB->_CONF['member_row']['style_id_cache'] == $MySmartBB->_CONF['member_row']['style'])
		{
			$cache = unserialize(base64_decode($MySmartBB->_CONF['member_row']['style_cache']));
			
			$MySmartBB->_CONF['rows']['style']['style_path'] 		= 	$cache['style_path'];
			$MySmartBB->_CONF['rows']['style']['image_path'] 		= 	$cache['image_path'];
			$MySmartBB->_CONF['rows']['style']['template_path'] 	= 	$cache['template_path'];
			$MySmartBB->_CONF['rows']['style']['cache_path'] 		= 	$cache['cache_path'];			
			$MySmartBB->_CONF['rows']['style']['id'] 				= 	$MySmartBB->_CONF['member_row']['style'];
		}
		else if ($MySmartBB->_CONF['member_row']['style_id_cache'] != $MySmartBB->_CONF['member_row']['style'] 
				or ($MySmartBB->_CONF['member_row']['should_update_style_cache']))
		{
			////////////
			
			$GetStyleArr 			= 	array();
			$GetStyleArr['where']	=	array('id',$MySmartBB->_CONF['member_row']['style']);
		
			$MySmartBB->_CONF['rows']['style'] = $MySmartBB->style->GetStyleInfo($GetStyleArr);
			
			////////////
			
			$style_cache = $MySmartBB->style->CreateStyleCache(array('where'=>array('id',$MySmartBB->_CONF['member_row']['style'])));
			
			////////////
			
			$UpdateArr						=	array();
			$UpdateArr['field']				=	array();
			
			$UpdateArr['field']['style_cache'] 		= 	$style_cache;
			$UpdateArr['field']['style_id_cache']	=	$MySmartBB->_CONF['member_row']['style'];
			$UpdateArr['where']						=	array('id',$MySmartBB->_CONF['member_row']['id']);
			
			if ($MySmartBB->_CONF['member_row']['should_update_style_cache'])
			{
				$UpdateArr['field']['should_update_style_cache'] = 0;
			}
			
			$update_cache = $MySmartBB->member->UpdateMember($UpdateArr);
			
			////////////
		}
		
		////////////
		
		if ($MySmartBB->_CONF['member_row']['logged'] < $MySmartBB->_CONF['timeout'])
		{			
			$LoggedArr 				= 	array();
			$LoggedArr['field'] 	= 	array();
			
			$LoggedArr['field']['logged'] 		= 	$MySmartBB->_CONF['now'];
			$LoggedArr['field']['member_ip'] 	= 	$MySmartBB->_CONF['ip'];
			$LoggedArr['where']					=	array('id',$MySmartBB->_CONF['member_row']['id']);
			
			$MySmartBB->member->UpdateMember($LoggedArr);
		}
	}
		
	/**
	 * If the visitor isn't member, call this function
	 */
	function __VisitorProcesses()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['member_permission'] = false;
		
		// Get the visitor's group info and store it in _CONF['group_info']
		$GroupInfo 				= 	array();
		$GroupInfo['where'] 	= 	array('id','7');
		
		$MySmartBB->_CONF['group_info'] = $MySmartBB->group->GetGroupInfo($GroupInfo);
		
		// Check if the visitor is already online
		$IsOnlineArr = array();
														
		$IsOnlineArr['timeout'] = 	$MySmartBB->_CONF['timeout'];
		$IsOnlineArr['way'] 	= 	'ip';
		$IsOnlineArr['ip'] 		= 	$MySmartBB->_CONF['ip'];
														
		$IsOnline = $MySmartBB->online->IsOnline($IsOnlineArr);
								
		// visitor already online , just update information										
		if ($IsOnline)
		{
			$UpdateOnlineArr 			= 	array();
			$UpdateOnlineArr['field'] 	= 	array();
													  			
			$UpdateOnlineArr['field']['username'] 	= 	'Guest';
			$UpdateOnlineArr['field']['logged'] 	= 	$MySmartBB->_CONF['now'];
			$UpdateOnlineArr['field']['path'] 		= 	$MySmartBB->_SERVER['QUERY_STRING'];
			$UpdateOnlineArr['field']['user_ip'] 	= 	$MySmartBB->_CONF['ip'];
			$UpdateOnlineArr['where']				=	array('username','Guest');
													  		   
			$update = $MySmartBB->online->UpdateOnline($UpdateOnlineArr);
		}
		// visitor don't exists in online table , so we insert member info
		else
		{
			$InsertOnlineArr 			= 	array();
			$InsertOnlineArr['field'] 	= 	array();
													  			
			$InsertOnlineArr['field']['username'] 			= 	'Guest';
			$InsertOnlineArr['field']['username_style'] 	= 	'Guest';
			$InsertOnlineArr['field']['logged'] 			= 	$MySmartBB->_CONF['now'];
			$InsertOnlineArr['field']['path'] 				= 	$MySmartBB->_SERVER['QUERY_STRING'];
			$InsertOnlineArr['field']['user_ip'] 			= 	$MySmartBB->_CONF['ip'];
			$InsertOnlineArr['field']['user_id']			=	-1;
			
			$insert = $MySmartBB->online->InsertOnline($InsertOnlineArr); 
		}
		
		// Get visitor's style		
		$style_id = (!empty($MySmartBB->_COOKIE[$MySmartBB->_CONF['style_cookie']])) ? $MySmartBB->_COOKIE[$MySmartBB->_CONF['style_cookie']] : $MySmartBB->_CONF['info_row']['def_style'];
		
		$style_id = $MySmartBB->functions->CleanVariable($style_id,'intval');
		
		$StyleArr 			= 	array();
		$StyleArr['where'] 	= 	array('id',$style_id);
		
		$MySmartBB->_CONF['rows']['style'] = $MySmartBB->style->GetStyleInfo($StyleArr);
										  
		// Sorry visitor you can't visit this forum today :(
		if (!$MySmartBB->_CONF['info_row'][$MySmartBB->_CONF['day']])
   		{
   			$MySmartBB->functions->error('المعذره .. هذا اليوم غير مخصص للزوار');
   		}
	}
	
	function _SetInformation()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_CONF['rows']['style'])
			or !is_array($MySmartBB->_CONF['rows']['style'])
			or empty($MySmartBB->_CONF['rows']['style']['template_path'])
			or empty($MySmartBB->_CONF['rows']['style']['cache_path']))
		{
			$MySmartBB->functions->error('لم يتم ايجاد معلومات النمط');
		}
		
		$MySmartBB->template->SetInformation(	$MySmartBB->_CONF['rows']['style']['template_path'] . '/',
												$MySmartBB->_CONF['rows']['style']['cache_path'] . '/',
												'.tpl',
												'file');
		
  		$pager_html 	= 	array();
  		$pager_html[0] 	= 	$MySmartBB->template->content('pager_style_part1');
  		$pager_html[1] 	= 	$MySmartBB->template->content('pager_style_part2');
  		$pager_html[2] 	= 	$MySmartBB->template->content('pager_style_part3');
  		$pager_html[3] 	= 	$MySmartBB->template->content('pager_style_part4');
  		
		$MySmartBB->pager->SetInformation($pager_html);
	}	
		
	/**
	 * Show ads
	 */
	function _ShowAds()
	{
		global $MySmartBB;
				
		// Get random ads
		if ($MySmartBB->_CONF['info_row']['ads_num'] > 0)
		{
			$MySmartBB->_CONF['rows']['AdsInfo'] = $MySmartBB->ads->GetRandomAds();
			$MySmartBB->_CONF['temp']['ads_show'] = true;
		}
	}


	/**
	 * Get the style path
	 */
	function _GetStylePath()
	{
		global $MySmartBB;
		global $_VARS;
		
		if (!strstr($MySmartBB->_CONF['rows']['style']['style_path'],'http://www.'))
		{
			$filename = explode('/',$MySmartBB->_CONF['rows']['style']['style_path']);
			
			$MySmartBB->template->assign('style_path',$_VARS['path'] . $MySmartBB->_CONF['rows']['style']['style_path']);
		}
		else
		{
			$MySmartBB->functions->error('');
		}
	}
	
	/**
	 * Close the forums
	 */
	function _CheckClose()
	{
		global $MySmartBB;
			
		// if the forum close by admin , stop the page
		if ($MySmartBB->_CONF['info_row']['board_close'])
    	{
  			if ($MySmartBB->_CONF['group_info']['admincp_allow'] != 1
  				and !defined('LOGIN'))
        	{
        		$MySmartBB->functions->ShowHeader('مغلق');
    			$MySmartBB->functions->error($MySmartBB->_CONF['info_row']['board_msg']);
  			}
 		}
	}
		
	/**
	 * Assign the important variables for template
	 */
	function _TemplateAssign()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign('image_path',$_VARS['path'] . $MySmartBB->_CONF['rows']['style']['image_path']);
		
		$MySmartBB->template->assign('_CONF',$MySmartBB->_CONF);
		$MySmartBB->template->assign('_COOKIE',$MySmartBB->_COOKIE);	
		
		/** For debug only **/
		$MySmartBB->template->assign('_SERVER',$MySmartBB->_SERVER);
	}
}
	
?>
