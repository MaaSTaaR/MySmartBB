<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

class MySmartCommon
{
	private $CheckMember;
			
	public function run()
	{
	    global $MySmartBB;
	    
		$this->_generalProc();
		$this->_checkMember();
		$this->_setInformation();
		$this->_showAds();
		$this->_getStylePath();
		$this->_checkClose();
		$this->_templateAssign();
		
		$MySmartBB->plugin->runHooks( 'common_end' );
	}
	
	private function _generalProc()
	{
		global $MySmartBB;
		
		// ~ Delete unnecessary rows ~ //
		
 		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
 		$MySmartBB->rec->filter = 'logged<' . $MySmartBB->_CONF['timeout'];
 		
 		$MySmartBB->rec->delete();
 		
 		// ... //
 		
 		$MySmartBB->rec->table = $MySmartBB->table[ 'today' ];
 		$MySmartBB->rec->filter = "user_date<>'" . $MySmartBB->_CONF['date'] . "'";
 	 	
 	 	$MySmartBB->rec->delete();
	}
		
	private function _checkMember()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->func->isCookie( $MySmartBB->_CONF[ 'username_cookie' ] ) 
			and $MySmartBB->func->isCookie( $MySmartBB->_CONF[ 'password_cookie' ] ) )
		{
			// ... //
			
			$username = trim( $MySmartBB->_COOKIE[ $MySmartBB->_CONF[ 'username_cookie' ] ] );
			$password = trim( $MySmartBB->_COOKIE[ $MySmartBB->_CONF[ 'password_cookie' ] ] );
			
			// ... //
			
			// ~ Check if the visitor is a member or not ? ~ //
			
			// If the information does'nt valid CheckMember's value will be false
			// otherwise the value will be an array
			$this->CheckMember = $MySmartBB->member->checkMember( $username, $password );
			
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
	}
		
	/**
	 * If the Guest is member , call this function
	 */
	private function __memberProcesses()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_CONF[ 'member_row' ] 			= 	$this->CheckMember;	
		$MySmartBB->_CONF[ 'member_permission' ]	= 	true;
		
		unset( $this->CheckMember );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['usergroup'] . "'";
		
		$MySmartBB->_CONF[ 'group_info' ] = $MySmartBB->rec->getInfo();
		
		// ... //
		
		// Get member style
		$MySmartBB->_CONF[ 'style_info' ] = $MySmartBB->member->getMemberStyle();
		
		// ... //
		
		if ( $MySmartBB->_CONF[ 'group_info' ][ 'banned' ] )
		{
			die( $MySmartBB->lang_common[ 'cant_show_board' ] );
		}
		
		// ... //
		
		// Insert the member into online table
		$MySmartBB->online->onlineMember();
		
		// Insert the member into today's visitor table
		$MySmartBB->online->todayMember();
		
		// ... //
		
		// Can't find last visit cookie , so register it
		if ( !$MySmartBB->func->isCookie( 'MySmartBB_lastvisit' ) )
		{
			$last_visit = ( empty( $MySmartBB->_CONF[ 'member_row' ][ 'lastvisit' ] ) ) ? $MySmartBB->_CONF[ 'date' ] : $MySmartBB->_CONF[ 'member_row' ][ 'lastvisit' ];
			
			$MySmartBB->member->lastVisitCookie( $last_visit, $MySmartBB->_CONF[ 'date' ], $MySmartBB->_CONF[ 'member_row' ][ 'id' ]);
		}
		
		// ... //
		
		if ( $MySmartBB->_CONF['member_row']['logged'] < $MySmartBB->_CONF['timeout'] )
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
		
		// ... //
		
		$MySmartBB->_CONF[ 'member_permission' ] = false;
		
		// ... //
		
		// Get the visitor's group info and store it in _CONF['group_info']
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='7'";
		
		$MySmartBB->_CONF['group_info'] = $MySmartBB->rec->getInfo();
		
		// ... //
		
		// Insert the visitor into online table
		$MySmartBB->online->onlineVisitor();
		
		// ... //
				
		// Get visitor's style
		// Check first if the visitor selected a specific style, otherwise set the default style to show.
		$style_id = (int) ( $MySmartBB->func->isCookie( $MySmartBB->_CONF[ 'style_cookie' ] ) ) ? $MySmartBB->_COOKIE[ $MySmartBB->_CONF[ 'style_cookie' ] ] : $MySmartBB->_CONF[ 'info_row' ][ 'def_style' ];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->filter = "id='" . $style_id . "'";
		
		$MySmartBB->_CONF[ 'style_info' ] = $MySmartBB->rec->getInfo();
		
		if ( !$MySmartBB->_CONF[ 'style_info' ] )
			die();
		
		// ... //
		
		// Sorry visitor you can't visit this forum today :(
		if ( !$MySmartBB->_CONF[ 'info_row' ][ $MySmartBB->_CONF[ 'day' ] ] )
   		{
   			echo 11;
   			$MySmartBB->func->error( $MySmartBB->lang_common[ 'visitor_pervented' ] );
   		}
	}
	
	private function _setInformation()
	{
		global $MySmartBB;
		
		if ( !is_array($MySmartBB->_CONF[ 'style_info' ])
			or empty($MySmartBB->_CONF[ 'style_info' ]['template_path'])
			or empty($MySmartBB->_CONF[ 'style_info' ]['cache_path']) )
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'cant_find_style' ] );
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
  		
		$MySmartBB->pager->setOutput( $pager_html );
	}	
		
	/**
	 * Show ads
	 */
	private function _showAds()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['temp']['ads_show'] = false;
		
		// Get random ads
		if ( $MySmartBB->_CONF['info_row']['ads_num'] > 0 )
		{			
			$MySmartBB->_CONF['rows']['AdsInfo'] = $MySmartBB->func->getRandomAds();
			
			$MySmartBB->_CONF['temp']['ads_show'] = true;
		}
	}


	/**
	 * Get the style path
	 */
	private function _getStylePath()
	{
		global $MySmartBB;
		
		if ( !strstr( $MySmartBB->_CONF[ 'style_info' ][ 'style_path' ], 'http://www.' ) )
		{
			$filename = explode( '/', $MySmartBB->_CONF[ 'style_info' ]['style_path'] );
			
			$MySmartBB->template->assign('style_path',$MySmartBB->_CONF[ 'style_info' ][ 'style_path' ]);
		}
		else
		{
			die();
		}
	}
	
	/**
	 * Close the forums
	 */
	private function _checkClose()
	{
		global $MySmartBB;
			
		// if the forum close by admin , stop the page
		if ( $MySmartBB->_CONF['info_row']['board_close'] )
    	{
  			if ( $MySmartBB->_CONF[ 'group_info' ][ 'admincp_allow' ] != 1
  				and !defined( 'LOGIN' ) )
        	{
        		$MySmartBB->func->showHeader( $MySmartBB->lang_common[ 'closed' ] );
    			$MySmartBB->func->error( $MySmartBB->_CONF[ 'info_row' ][ 'board_msg' ] );
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
		
		$MySmartBB->template->assign('_COOKIE',$MySmartBB->_COOKIE);
	}
}
	
?>
