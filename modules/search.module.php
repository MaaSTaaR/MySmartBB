<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SEARCH'] 	= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartSearchEngineMOD');

class MySmartSearchEngineMOD
{
	public function run()
	{
		global $MySmartBB;
		
		/** Show search form **/
		if ($MySmartBB->_GET['index'])
		{
			$this->_searchForm();
		}
		/** **/
		
		/** Show the results of search **/
		elseif ($MySmartBB->_GET['start'])
		{
			$this->_startSearch();
		}
		/** **/
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
	}
	
	/**
	 * Get the list of sections to show it in a list , and show search form
	 */
	private function _searchForm()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('البحث');
		
		//////////
				
		/*$SecArr 						= 	array();
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
		} // end foreach ($cats)*/
		
		//////////
				
		$MySmartBB->template->display('search');
		
		//////////
		
		$MySmartBB->func->getFooter();
	}
		
	/**
	 * Get the results of search
	 */
	private function _startSearch()
	{
		global $MySmartBB;
		
		if (!$MySmartBB->_POST['ajax'])
		{
			$MySmartBB->func->showHeader('نتائج البحث');
		}
		
		//////////
		
		$keyword 	= 	(isset($MySmartBB->_GET['keyword'])) ? $MySmartBB->_GET['keyword'] : $MySmartBB->_POST['keyword'];
		$username 	= 	(isset($MySmartBB->_GET['username'])) ? $MySmartBB->_GET['username'] : $MySmartBB->_POST['username'];
		$section 	= 	(isset($MySmartBB->_GET['section'])) ? $MySmartBB->_GET['section'] : $MySmartBB->_POST['section'];
		
		//////////
		
		if (empty($keyword))
		{
			$MySmartBB->func->error('يرجى كتابة كلمة البحث المطلوبه');
		}
		
		//////////
		
		$MySmartBB->_CONF['template']['while']['SearchResult'] = $MySmartBB->search->Search(array(	'keyword'	=>	$keyword,
															'username'	=>	$username,
															'section'	=>	$section));
															
		
		if (!$MySmartBB->_CONF['template']['while']['SearchResult'])
		{
			$stop = ($MySmartBB->_CONF['info_row']['ajax_search'] and !$MySmartBB->_POST['ajax']) ? false : true;
			
			$MySmartBB->func->error('لا يوجد نتائج',$stop,$stop);
		}
		
		//////////
		
		$MySmartBB->func->CleanVariable($MySmartBB->_CONF['template']['while']['SearchResult'],'html');
				
		$MySmartBB->template->assign('highlight',$keyword);
		
		$MySmartBB->template->display('search_results');
		
		if ($MySmartBB->_CONF['info_row']['ajax_search'])
		{
			if (!$MySmartBB->_POST['ajax'])
			{
				$MySmartBB->func->getFooter();
			}
		}
		else
		{
			$MySmartBB->func->getFooter();
		}
	}
}
	
?>
