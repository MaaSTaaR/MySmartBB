<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SEARCH'] 	= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;

include('common.php');

define('CLASS_NAME','MySmartSearchEngineMOD');

class MySmartSearchEngineMOD
{
	function run()
	{
		global $MySmartBB;
		
		/** Show search form **/
		if ($MySmartBB->_GET['index'])
		{
			$this->_SearchForm();
		}
		/** **/
		
		/** Show the results of search **/
		elseif ($MySmartBB->_GET['start'])
		{
			$this->_StartSearch();
		}
		/** **/
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		if (!$MySmartBB->_CONF['info_row']['ajax_search'])
		{
			if (!isset($MySmartBB->_POST['ajax']))
			{
				$MySmartBB->functions->GetFooter();
			}
		}
		else
		{
			$MySmartBB->functions->GetFooter();
		}
	}
	
	/**
	 * Get the list of sections to show it in a list , and show search form
	 */
	function _SearchForm()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('البحث');
		
		//////////
		
		$ForumArr 				= 	array();
		$ForumArr['get_from'] 	=	'cache';
		$ForumArr['type'] 		= 	'normal';
		
		$forums = $MySmartBB->section->GetSectionsList($ForumArr);
		
		//////////
		
		$GroupArr 				= 	array();
		$GroupArr['get_from'] 	=	'cache';
		
		$groups = $MySmartBB->group->GetSectionGroupList($GroupArr);
		
		//////////
				
		$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
		
		//////////
		
		foreach ($forums as $forum)
		{
			//////////
			
			$MySmartBB->functions->CleanVariable($forum,'html');
			
			//////////
			
			foreach ($groups as $group)
			{	
				//////////
				
				$MySmartBB->functions->CleanVariable($group,'html');
				
				//////////
				
				if ($group['section_id'] == $forum['cat_id'] 
					and $group['main_section'] == 1)
				{
					if ($group['group_id'] == $MySmartBB->_CONF['group_info']['id'])
					{
						if ($group['view_section'])
						{
							if (empty($forum['from_main_section']))
							{
								$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_m'] = $forum;
							}
						}
					}
				}
				
				//////////
				
				elseif ($group['section_id'] == $forum['id'] 
						and $group['main_section'] != 1)
				{
					if ($group['group_id'] == $MySmartBB->_CONF['group_info']['id'])
					{	
						if ($group['view_section'])
						{
							if (!empty($forum['from_main_section']))
							{
								$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_f'] = $forum;
							}
						}
					}
				}
				
				//////////
				
			}
			
			//////////
		}
		
		//////////
				
		$MySmartBB->template->display('search');
		
		//////////
	}
		
	/**
	 * Get the results of search
	 */
	function _StartSearch()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('نتائج البحث');
		
		//////////
		
		$keyword 	= 	(isset($MySmartBB->_GET['keyword'])) ? $MySmartBB->_GET['keyword'] : $MySmartBB->_POST['keyword'];
		$username 	= 	(isset($MySmartBB->_GET['username'])) ? $MySmartBB->_GET['username'] : $MySmartBB->_POST['username'];
		$section 	= 	(isset($MySmartBB->_GET['section'])) ? $MySmartBB->_GET['section'] : $MySmartBB->_POST['section'];
		
		//////////
		
		if (empty($keyword))
		{
			$MySmartBB->functions->error('يرجى كتابة كلمة البحث المطلوبه');
		}
		
		//////////
		
		$MySmartBB->_CONF['template']['while']['SearchResult'] = $MySmartBB->search->Search(array(	'keyword'	=>	$keyword,
															'username'	=>	$username,
															'section'	=>	$section));
															
		
		if (!$MySmartBB->_CONF['template']['while']['SearchResult'])
		{
			$MySmartBB->functions->error('لا يوجد نتائج');
		}
		
		//////////
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['SearchResult'],'html');
				
		$MySmartBB->template->assign('highlight',$keyword);
		
		$MySmartBB->template->display('search_results');
	}
}
	
?>
