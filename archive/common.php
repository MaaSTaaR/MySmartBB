<?php

class MySmartCommon
{
	var $action = 'index';
	var $url_base = 'index.php/';
	var $id = 0;
	
	/**
	 * The main function
	 */
	function run()
	{
		// huh? URL FRIENDLY! :\
		$this->_ProcessPath();
		
		$this->_CheckVisitor();
		
		$this->_CheckClose();
	}
	
	function _ProcessPath()
	{
		global $MySmartBB;
		
		if (isset($MySmartBB->_SERVER['PATH_INFO']))
		{
			$url = explode('/',$MySmartBB->_SERVER['PATH_INFO']);
			
			if (!empty($url[1]))
			{
				$page_info = explode('-',$url[1]);
				
				$this->action = $page_info[0];
				$this->id = $page_info[1];
			}
		}
		
		if (strstr($MySmartBB->_SERVER['REQUEST_URI'],'index.php/') != false)
		{
			$this->url_base = '';
		}
	}
	
	function _CheckVisitor()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['member_permission'] = false;
		
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
			$CheckMember = $MySmartBB->member->GetMemberInfo($MemberArr);
			
			////////////
				
			// This is a member :)										
			if ($CheckMember != false)
			{
				$MySmartBB->_CONF['member_permission'] = true;
				
				$MySmartBB->_CONF['member_row'] = $CheckMember;
				
				$GroupInfo 			= array();
				$GroupInfo['where'] = array('id',$MySmartBB->_CONF['member_row']['usergroup']);
		
				$MySmartBB->_CONF['group_info'] = $MySmartBB->group->GetGroupInfo($GroupInfo);
			}
			else
			{
				$GroupInfo 			= array();
				$GroupInfo['where'] = array('id',7);
		
				$MySmartBB->_CONF['group_info'] = $MySmartBB->group->GetGroupInfo($GroupInfo);
			}
		}
		
		// Sorry visitor you can't visit this forum today :(
		if (!$MySmartBB->_CONF['info_row'][$MySmartBB->_CONF['day']]
			and !$MySmartBB->_CONF['member_permission'])
   		{
   			$MySmartBB->functions->error('المعذره .. هذا اليوم غير مخصص للزوار');
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
    		$MySmartBB->functions->error($MySmartBB->_CONF['info_row']['board_msg']);
 		}
	}
}
	
?>
