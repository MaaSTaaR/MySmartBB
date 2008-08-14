<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;

include('common.php');

define('CLASS_NAME','MySmartIndexMOD');

class MySmartIndexMOD
{
	function run()
	{
		// Who can live without $MySmartBB ? ;)
		global $MySmartBB;
		
		/**
		 * Show header
		 */
		$MySmartBB->functions->ShowHeader();
		
		/**
		 * Firstly we get sections list
		 */
		$this->_GetSections();
		
		/**
		 * Get who are online
		 */
		$this->_GetOnline();
		 
		/**
		 * Now we get 'Who visit site today'
		 */
		$this->_GetToday();
		
		/**
		 * Show main template
		 */
		$this->_CallTemplate();
		
		/**
		 * Show footer
		 */
		$MySmartBB->functions->GetFooter();
	}
	
	/**
	 * Get sections list from cache and show it.
	 */
	function _GetSections()
	{
		global $MySmartBB;
		
		//////////
				
		$SecArr 						= 	array();
		$SecArr['get_from']				=	'db';
		
		$SecArr['proc'] 				= 	array();
		$SecArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		$SecArr['order']				=	array();
		$SecArr['order']['field']		=	'sort';
		$SecArr['order']['type']		=	'ASC';
		
		$SecArr['where']				=	array();
		$SecArr['where'][0]['name']		= 	'parent';
		$SecArr['where'][0]['oper']		= 	'=';
		$SecArr['where'][0]['value']	= 	'0';
		
		// Get main sections
		$cats = $MySmartBB->section->GetSectionsList($SecArr);
		
		// We will use forums_list to store list of forums which will view in main page
		$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
		
		// Loop to read the information of main sections
		foreach ($cats as $cat)
		{
			// Get the groups information to know view this section or not
			$groups = unserialize(base64_decode($cat['sectiongroup_cache']));
			
			if (is_array($groups[$MySmartBB->_CONF['group_info']['id']]))
			{
				if ($groups[$MySmartBB->_CONF['group_info']['id']]['view_section'])
				{
					$MySmartBB->_CONF['template']['foreach']['forums_list'][$cat['id'] . '_m'] = $cat;
				}
			}
			
			unset($groups);
			
			if (!empty($cat['forums_cache']))
			{
				$forums = unserialize(base64_decode($cat['forums_cache']));
				
				foreach ($forums as $forum)
				{
					if (is_array($forum['groups'][$MySmartBB->_CONF['group_info']['id']]))
					{
						if ($forum['groups'][$MySmartBB->_CONF['group_info']['id']]['view_section'])
						{
							$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_f'] = $forum;
						}
					} // end if is_array
				} // end foreach ($forums)
			} // end !empty($forums_cache)
		} // end foreach ($cats)
		
		//////////
	}
		
	function _GetOnline()
	{
		global $MySmartBB;
		
		//////////
		
		$GuestNumberArr 						= 	array();
		$GuestNumberArr['where'] 				= 	array();
		
		$GuestNumberArr['where'][0] 			= 	array();
		$GuestNumberArr['where'][0]['name'] 	= 	'username';
		$GuestNumberArr['where'][0]['oper'] 	= 	'=';
		$GuestNumberArr['where'][0]['value'] 	= 	'Guest';
		
		$MySmartBB->_CONF['template']['GuestNumber'] = $MySmartBB->online->GetOnlineNumber($GuestNumberArr);
		
		//////////
		
		$MemberNumberArr 						= 	array();
		$MemberNumberArr['where'] 				= 	array();
		
		$MemberNumberArr['where'][0] 			= 	array();
		$MemberNumberArr['where'][0]['name'] 	= 	'username';
		$MemberNumberArr['where'][0]['oper'] 	= 	'<>';
		$MemberNumberArr['where'][0]['value'] 	= 	'Guest';
		
		$MySmartBB->_CONF['template']['MemberNumber'] = $MySmartBB->online->GetOnlineNumber($MemberNumberArr);
		
		//////////
		
		$GroupArr 							= 	array();
		
		$GroupArr['where'] 					= 	array();
		$GroupArr['where'][0] 				= 	array();
		$GroupArr['where'][0]['name'] 		= 	'view_usernamestyle';
		$GroupArr['where'][0]['oper'] 		= 	'=';
		$GroupArr['where'][0]['value']		= 	1;
		
		$GroupArr['order'] 					= 	array();
		$GroupArr['order']['field'] 		= 	'group_order';
		$GroupArr['order']['type'] 			= 	'ASC';
		
		$GroupArr['proc']					=	array();
		$GroupArr['proc']['username_style']	=	array('method'=>'replace','search'=>'[username]','replace'=>'rows{title}','store'=>'h_title');
		
		$MySmartBB->_CONF['template']['while']['GroupList'] = $MySmartBB->group->GetGroupList($GroupArr);
		
		//////////
		
		$OnlineArr 						= 	array();
		$OnlineArr['order'] 			= 	array();
		$OnlineArr['order']['field'] 	= 	'user_id';
		$OnlineArr['order']['type'] 	= 	'DESC';
		
		$OnlineArr['where'] = (!$MySmartBB->_CONF['info_row']['show_onlineguest'] 
								or !$MySmartBB->_CONF['rows']['group_info']['show_hidden']) ? array() : null;
		
		if (!$MySmartBB->_CONF['info_row']['show_onlineguest'])
		{
			$OnlineArr['where'][0] 			= 	array();
			$OnlineArr['where'][0]['name'] 	= 	'username';
			$OnlineArr['where'][0]['oper'] 	= 	'<>';
			$OnlineArr['where'][0]['value'] = 	'Guest';
		}
			
		// This member can't see hidden member
		if (!$MySmartBB->_CONF['group_info']['show_hidden'])
		{
			$OnlineArr['where'][1] 			= 	array();
			$OnlineArr['where'][1]['con'] 	= 	'AND';
			$OnlineArr['where'][1]['name'] 	= 	'hide_browse';
			$OnlineArr['where'][1]['oper'] 	= 	'<>';
			$OnlineArr['where'][1]['value'] = 	'1';
		}
		
		// Finally we get online list
		$MySmartBB->_CONF['template']['while']['OnlineList'] = $MySmartBB->online->GetOnlineList($OnlineArr);
		
		//////////
	}
	
	function _GetToday()
	{
		global $MySmartBB;

		//////////

		$TodayArr 						= 	array();
		$TodayArr['where'] 				= 	array();
		$TodayArr['where'][0] 			= 	array();
		
		$TodayArr['where'][0]['name'] 	= 	'username';
		$TodayArr['where'][0]['oper'] 	= 	'<>';
		$TodayArr['where'][0]['value'] 	= 	'Guest';
		
		$TodayArr['where'][1]			=	array();
		$TodayArr['where'][1]['con']	=	'AND';
		$TodayArr['where'][1]['name'] 	= 	'user_date';
		$TodayArr['where'][1]['oper'] 	= 	'=';
		$TodayArr['where'][1]['value'] 	= 	$MySmartBB->_CONF['date'];
		
		$TodayArr['order']				=	array();
		$TodayArr['order']['field']		=	'user_id';
		$TodayArr['order']['type']		=	'DESC';
			
		if (!$MySmartBB->_CONF['rows']['group_info']['show_hidden'])
		{
			$TodayArr['where'][2]			=	array();
			$TodayArr['where'][2]['con']	=	'AND';
			$TodayArr['where'][2]['name'] 	= 	'hide_browse';
			$TodayArr['where'][2]['oper'] 	= 	'<>';
			$TodayArr['where'][2]['value'] 	= 	'1';
		}
		
		$MySmartBB->_CONF['template']['while']['TodayList'] = $MySmartBB->online->GetTodayList($TodayArr);
		
		//////////
		
		if (!empty($MySmartBB->_CONF['info_row']['today_number_cache']))
		{
			$TodayNumber = $MySmartBB->_CONF['info_row']['today_number_cache'];
		}
		else
		{
			$NumberArr 						= 	array();
			$NumberArr['where'] 			= 	array();
			$NumberArr['where'][0] 			= 	array();
			$NumberArr['where'][0]['name'] 	= 	'user_date';
			$NumberArr['where'][0]['oper'] 	= 	'=';
			$NumberArr['where'][0]['value'] = 	$MySmartBB->_CONF['date'];
		
			$MySmartBB->_CONF['template']['TodayNumber'] = $MySmartBB->online->GetTodayNumber($NumberArr);
		}
		
		//////////
	}
	
	function _CallTemplate()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('main');
	}
}
	
// The end , Hey it's first module wrote for MySmartBB 2.0 :) , 24/5/2006 -> 4:24 PM

?>
