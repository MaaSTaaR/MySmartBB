<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

class MySmartCommon
{
	private $CheckMember;
			
	/**
	 * The main function
	 */
	public function run()
	{
		$this->_generalProc();
		$this->_checkMember();
		$this->_setInformation();
		$this->_showAds();
		$this->_getStylePath();
		$this->_checkClose();
		$this->_templateAssign();
	}
					
	/**
	 * Clean not important information
	 */
	private function _generalProc()
	{
		global $MySmartBB;
		
		/* ... */
		
 		// Delete not important rows in online table
 		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
 		$MySmartBB->rec->filter = 'logged<' . $MySmartBB->_CONF['timeout'];
 		
 		$MySmartBB->rec->delete();
 		
 		/* ... */
 		
 		// Delete not important rows in today table
 		$MySmartBB->rec->table = $MySmartBB->table[ 'today' ];
 		$MySmartBB->rec->filter = 'user_date<>' . $MySmartBB->_CONF['date'];
 	 	
 	 	$MySmartBB->rec->delete();
 	 	
 	 	/* ... */
 	 	
		if ( $MySmartBB->_CONF[ 'info_row' ][ 'today_date_cache' ] != $MySmartBB->_CONF[ 'date' ] )
		{
			// [WE NEED A SYSTEM]
			$MySmartBB->info->updateInfo( 'today_number_cache', '1' );
			$MySmartBB->info->updateInfo( 'today_date_cache', $MySmartBB->_CONF[ 'date' ] );
		}
		
		/* ... */
	}
		
	private function _checkMember()
	{
		global $MySmartBB;
		
		/* ... */
		
		if ($MySmartBB->func->isCookie( $MySmartBB->_CONF[ 'username_cookie' ] ) 
			and $MySmartBB->func->isCookie( $MySmartBB->_CONF[ 'password_cookie' ] ) )
		{
			/* ... */
			
			$username = $MySmartBB->_COOKIE[ $MySmartBB->_CONF[ 'username_cookie' ] ];
			$password = $MySmartBB->_COOKIE[ $MySmartBB->_CONF[ 'password_cookie' ] ];
			
			/* ... */
		
			// Check if the visitor is a member or not ?		
			$MySmartBB->rec->filter = "username='" . $username . "' AND password='" . $password . "'";
			
			// If the information isn't valid CheckMember's value will be false
			// otherwise the value will be an array
			// [WE NEED A SYSTEM]
			$this->CheckMember = $MySmartBB->member->getMemberInfo();
			
			/* ... */
			
			// This is a member :)										
			if ($this->CheckMember != false)
			{
				$this->__memberProcesses();
			}
			// This is a visitor
			else
			{
				$this->__visitorProcesses();
			}
		}
		else
		{
			$this->__visitorProcesses();
		}
		
		/* ... */
	}
		
	/**
	 * If the Guest is member , call this function
	 */
	private function __memberProcesses()
	{
		global $MySmartBB;
		
		/* ... */
		
		$MySmartBB->_CONF[ 'member_row' ] 			= 	$this->CheckMember;	
		$MySmartBB->_CONF[ 'member_permission' ]	= 	true;
		
		/* ... */
		
		// I hate SQL Injections
		$MySmartBB->func->cleanArray( $MySmartBB->_CONF['member_row'], 'sql' );
		
		/* ... */
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['usergroup'] . "'";
		
		$MySmartBB->_CONF[ 'group_info' ] = $MySmartBB->rec->getInfo();
		
		/* ... */
		
		if ( $MySmartBB->_CONF[ 'group_info' ][ 'banned' ] )
		{
			$MySmartBB->func->error( 'المعذره .. لا يمكنك الدخول للمنتدى' );
		}
		
		/* ... */
		
		// Check if the member is already online
		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
		$MySmartBB->rec->filter = "logged>='" . $MySmartBB->_CONF['timeout'] . "' AND username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		
		$IsOnline = $MySmartBB->rec->getInfo();
		
		/* ... */
		
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
		// [WE NEED A SYSTEM]
		$username_style = $MySmartBB->member->getUsernameWithStyle( $MySmartBB->_CONF['member_row']['username'], $MySmartBB->_CONF['group_info']['username_style']  );
		
		/* ... */
		
		if (!$IsOnline)
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
			$MySmartBB->rec->fields = array(	'username'	=>	$MySmartBB->_CONF['member_row']['username'],
												'username_style'	=>	$username_style,
												'logged'	=>	$MySmartBB->_CONF['now'],
												'path'	=>	$MySmartBB->_SERVER['QUERY_STRING'],
												'user_ip'	=>	$MySmartBB->_CONF['ip'],
												'hide_browse'	=>	$MySmartBB->_CONF['member_row']['hide_online'],
												'user_location'	=>	$MemberLocation,
												'user_id'	=>	$MySmartBB->_CONF['member_row']['id']	);
												
			$insert = $MySmartBB->rec->insert();
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
				$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
				$MySmartBB->rec->fields = array(	'username'			=>	$MySmartBB->_CONF['member_row']['username'],
													'username_style'	=>	$username_style,
													'logged'			=>	$MySmartBB->_CONF['now'],
													'path'				=>	$MySmartBB->_SERVER['QUERY_STRING'],
													'user_ip'			=>	$MySmartBB->_CONF['ip'],
													'hide_browse'		=>	$MySmartBB->_CONF['member_row']['hide_online'],
													'user_location'		=>	$MemberLocation,
													'user_id'			=>	$MySmartBB->_CONF['member_row']['id']	);
				
				$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF[ 'member_row' ][ 'username' ] . "'";
				
				$update = $MySmartBB->rec->update();
			}
		}
		
		/* ... */
		
		// Ok , now we check if this member is exists in today list
		// [WE NEED A SYSTEM]
		$IsToday = $MySmartBB->online->isToday( $MySmartBB->_CONF[ 'member_row' ][ 'username' ], $MySmartBB->_CONF[ 'date' ] );
		
		/* ... */
		
		// Member isn't exists in today table , so insert the member								  
		if (!$IsToday)
		{
			/* ... */
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'today' ];
			
			$MySmartBB->rec->fields = array(	'username'			=>	$MySmartBB->_CONF['member_row']['username'],
												'user_id'			=>	$MySmartBB->_CONF['member_row']['id'],
												'user_date'			=>	$MySmartBB->_CONF['date'],
												'hide_browse'		=>	$MySmartBB->_CONF['member_row']['hide_online'],
												'username_style'	=>	$username_style	);
			
			$InsertToday = $MySmartBB->rec->insert();
			
			/* ... */
			
			if ($InsertToday)
			{
				/* ... */
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
				$MySmartBB->rec->fields = array(	'visitor'	=>	$MySmartBB->_CONF['member_row']['visitor'] + 1	);
				$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['id'] . "'";
				
				$MySmartBB->rec->update();
				
				/* ... */
				
				if ( $MySmartBB->_CONF[ 'info_row' ][ 'today_date_cache' ] == $MySmartBB->_CONF[ 'date' ] )
				{
					$number = $MySmartBB->_CONF['info_row']['today_number_cache'] + 1;
					
					// [WE NEED A SYSTEM]
					$MySmartBB->info->updateInfo( 'today_number_cache', $number );
				}
				
				/* ... */
			}
			
			/* ... */
		}
		
		/* ... */
		
		// Can't find last visit cookie , so register it
		if ( !$MySmartBB->func->isCookie( 'MySmartBB_lastvisit' ) )
		{
			$last_visit = ( empty( $MySmartBB->_CONF[ 'member_row' ][ 'lastvisit' ] ) ) ? $MySmartBB->_CONF[ 'date' ] : $MySmartBB->_CONF[ 'member_row' ][ 'lastvisit' ];
			
			// [WE NEED A SYSTEM]
			$MySmartBB->member->lastVisitCookie( $last_visit, $MySmartBB->_CONF[ 'date' ], $MySmartBB->_CONF[ 'member_row' ][ 'id' ]);
		}
		
		/* ... */
		
		// Get member style
		if ( $MySmartBB->_CONF['member_row']['style_id_cache'] == $MySmartBB->_CONF['member_row']['style']
			and !$MySmartBB->_CONF['member_row']['should_update_style_cache'] )
		{
			$cache = unserialize( base64_decode( $MySmartBB->_CONF[ 'member_row' ][ 'style_cache' ] ) );
			
			$MySmartBB->_CONF[ 'style_info' ][ 'style_path' ] 		= 	$cache[ 'style_path' ];
			$MySmartBB->_CONF[ 'style_info' ][ 'image_path' ] 		= 	$cache[ 'image_path' ];
			$MySmartBB->_CONF[ 'style_info' ][ 'template_path' ] 	= 	$cache[ 'template_path' ];
			$MySmartBB->_CONF[ 'style_info' ][ 'cache_path' ] 		= 	$cache[ 'cache_path' ];			
			$MySmartBB->_CONF[ 'style_info' ][ 'id' ] 				= 	$MySmartBB->_CONF[ 'member_row' ][ 'style' ];
		}
		else if ( $MySmartBB->_CONF[ 'member_row' ][ 'style_id_cache' ] != $MySmartBB->_CONF[ 'member_row' ][ 'style' ] 
				or ( $MySmartBB->_CONF['member_row']['should_update_style_cache'] ) )
		{
			/* ... */
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
			$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['style']  . "'";
			
			$MySmartBB->_CONF[ 'style_info' ] = $MySmartBB->rec->getInfo();
			
			/* ... */
			
			$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['style']  . "'";
			
			// [WE NEED A SYSTEM]
			$style_cache = $MySmartBB->style->createStyleCache();
			
			/* ... */
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array(	'style_cache'	=>	$style_cache,
												'style_id_cache'	=>	$MySmartBB->_CONF['member_row']['style']	);
			
			if ( $MySmartBB->_CONF[ 'member_row' ][ 'should_update_style_cache' ] )
			{
				$MySmartBB->rec->fields['should_update_style_cache'] = 0;
			}
			
			$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['id'] . "'";
			
			$update_cache = $MySmartBB->rec->update();
			
			/* ... */
		}
				
		/* ... */
		
		if ($MySmartBB->_CONF['member_row']['logged'] < $MySmartBB->_CONF['timeout'])
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			
			$MySmartBB->rec->fields = array(	'logged'	=>	$MySmartBB->_CONF['now'],
												'member_ip'	=>	$MySmartBB->_CONF['ip']	);
			
			$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['id'] . "'";
			
			$MySmartBB->rec->update();
		}
	}
		
	/**
	 * If the visitor isn't member, call this function
	 */
	private function __visitorProcesses()
	{
		global $MySmartBB;
		
		/* ... */
		
		$MySmartBB->_CONF[ 'member_permission' ] = false;
		
		/* ... */
		
		// Get the visitor's group info and store it in _CONF['group_info']
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='7'";
		
		$MySmartBB->_CONF['group_info'] = $MySmartBB->rec->getInfo();
		
		/* ... */
		
		// Check if the visitor is already online
		// [WE NEED A SYSTEM]
		$isOnline = $MySmartBB->online->isOnline($MySmartBB->_CONF['timeout'], 'ip', $MySmartBB->_CONF['ip']);
								
		// The visitor is already online , just update information										
		if ( $isOnline )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
			$MySmartBB->rec->fields = array(	'username'	=>	'Guest',
												'logged'	=>	$MySmartBB->_CONF['now'],
												'path'		=>	$MySmartBB->_SERVER['QUERY_STRING'],
												'user_ip'	=>	$MySmartBB->_CONF['ip']	);
			
			$MySmartBB->rec->filter = "username='Guest'";
			
			$update = $MySmartBB->rec->update();
		}
		// The visitor is not exist in online table , so we insert his info
		else
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
			$MySmartBB->rec->fields = array(	'username'			=>	'Guest',
												'username_style'	=>	'Guest',
												'logged'			=>	$MySmartBB->_CONF['now'],
												'path'				=>	$MySmartBB->_SERVER['QUERY_STRING'],
												'user_ip'			=>	$MySmartBB->_CONF['ip'],
												'user_id'			=>	-1	);
			
			$insert = $MySmartBB->rec->insert(); 
		}
		
		// Get visitor's style		
		$style_id = (int) ( $MySmartBB->func->isCookie( $MySmartBB->_CONF[ 'style_cookie' ] ) ) ? $MySmartBB->_COOKIE[ $MySmartBB->_CONF[ 'style_cookie' ] ] : $MySmartBB->_CONF[ 'info_row' ][ 'def_style' ];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->filter = "id='" . $style_id . "'";
		
		$MySmartBB->_CONF[ 'style_info' ] = $MySmartBB->rec->getInfo();
										  
		// Sorry visitor you can't visit this forum today :(
		if ( !$MySmartBB->_CONF[ 'info_row' ][ $MySmartBB->_CONF[ 'day' ] ] )
   		{
   			$MySmartBB->func->error( 'المعذره .. هذا اليوم غير مخصص للزوار' );
   		}
	}
	
	private function _setInformation()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_CONF[ 'style_info' ])
			or !is_array($MySmartBB->_CONF[ 'style_info' ])
			or empty($MySmartBB->_CONF[ 'style_info' ]['template_path'])
			or empty($MySmartBB->_CONF[ 'style_info' ]['cache_path']))
		{
			$MySmartBB->func->error('لم يتم ايجاد معلومات النمط');
		}
				
		$MySmartBB->template->setInformation(	$MySmartBB->_CONF[ 'style_info' ]['template_path'] . '/',
												$MySmartBB->_CONF[ 'style_info' ]['cache_path'] . '/',
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
	private function _showAds()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['temp']['ads_show'] = false;
		
		// Get random ads
		if ($MySmartBB->_CONF['info_row']['ads_num'] > 0)
		{
			// [WE NEED A SYSTEM]
			$MySmartBB->_CONF['rows']['AdsInfo'] = $MySmartBB->ads->getRandomAds();
			$MySmartBB->_CONF['temp']['ads_show'] = true;
		}
	}


	/**
	 * Get the style path
	 */
	private function _getStylePath()
	{
		global $MySmartBB;
		
		if (!strstr($MySmartBB->_CONF[ 'style_info' ]['style_path'],'http://www.'))
		{
			$filename = explode('/',$MySmartBB->_CONF[ 'style_info' ]['style_path']);
			
			$MySmartBB->template->assign('style_path',$MySmartBB->_CONF[ 'style_info' ]['style_path']);
		}
		else
		{
			$MySmartBB->func->error('');
		}
	}
	
	/**
	 * Close the forums
	 */
	private function _checkClose()
	{
		global $MySmartBB;
			
		// if the forum close by admin , stop the page
		if ($MySmartBB->_CONF['info_row']['board_close'])
    	{
  			if ($MySmartBB->_CONF['group_info']['admincp_allow'] != 1
  				and !defined('LOGIN'))
        	{
        		$MySmartBB->func->showHeader('مغلق');
    			$MySmartBB->func->error($MySmartBB->_CONF['info_row']['board_msg']);
  			}
 		}
	}
		
	/**
	 * Assign the important variables for template
	 */
	private function _templateAssign()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign('image_path',$MySmartBB->_CONF[ 'style_info' ]['image_path']);
		
		$MySmartBB->template->assign('_CONF',$MySmartBB->_CONF);
		$MySmartBB->template->assign('_COOKIE',$MySmartBB->_COOKIE);	
		
		/** For debug only **/
		$MySmartBB->template->assign('_SERVER',$MySmartBB->_SERVER);
	}
}
	
?>
