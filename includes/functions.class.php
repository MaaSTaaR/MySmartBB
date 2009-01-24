<?php

class MySmartFunctions
{
	/**
	 * Check if delicious cookie is here or another eat it mmmm :)
	 */
	function IsCookie($cookie_name)
 	{
 		global $MySmartBB;
 		
 		return empty($MySmartBB->_COOKIE[$cookie_name]) ? false : true;
 	}
 	
 	/**
 	 * Clean the variable from any dirty :) , we should be thankful for abuamal
 	 *
 	 * By : abuamal
 	 */
	function CleanVariable(&$variable, $type)
	{
		global $MySmartBB;
		
		return $MySmartBB->sys_functions->CleanVariable(&$variable, $type);
	}
	
 	function AddressBar($title)
 	{
 		global $MySmartBB;
 		
 		$MySmartBB->template->display('address_bar_part1');
 		echo $title;
 		$MySmartBB->template->display('address_bar_part2');
 	}
 	
 	/**
 	 * Show footer and stop the script , footer is like water in the life :)
 	 */
 	function stop($no_style = false)
 	{
 		global $MySmartBB;
 		
 		if (!$no_style)
 		{
 			$MySmartBB->template->display('footer');
 		}
 		
 		exit();
 	}
 	
 	/**
 	 * go to $site , abuamal hate this function :D don't ask me why , ask him ;)
 	 */
	function goto($site,$m=2)
 	{
  		echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"$m; URL=$site\">\n";
 	}

	/**
	 * Show $msg in nice template
	 */
 	function msg($msg,$no_style = false)
    {
    	global $MySmartBB;
    	
    	if (defined('IN_ADMIN')
    		or defined('STOP_STYLE')
    		or $no_style)
 		{
    		echo '<font face="Tahoma" size="2"><div dir="rtl" align="center">' . $msg . '</div></font>';
    	}
    	else
    	{
    		$MySmartBB->template->assign('msg',$msg);
    		$MySmartBB->template->display('show_msg');
    	}
 	}
 	
	/**
	 * Show error massege and stop script
	 */
 	function error($msg,$no_header = false,$no_style = false)
    {
    	global $MySmartBB;
    	
    	if (!$no_header)
    	{
    		$this->ShowHeader('خطأ');
    	}
    	
  		$this->msg($msg,$no_style);
  		$this->stop($no_style);
 	}

	/**
	 * Check if $email is true email or not
	 *
	 * This function by : Pal Coder from MySmartBB 1.x
	 */
	function CheckEmail($email)
	{
        return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[_a-z0-9-]+(\.[_a-z0-9-]+)",$email) ? true : false;
	}
	
 	 
 	/**
 	 * Get file extention
 	 *
 	 * @param :
 	 *				filename -> the name of file which we want know it's extension
 	 */
 	function GetFileExtension($filename)
    {
  		$ex = explode('.',$filename);
  		
  		$size = sizeof($ex);
  		
  		if ($size == 2)
  		{
  			return '.' . $ex[1];
  		}
  		elseif ($size > 2)
  		{
  			return 'MULTIEXTENSION';
  		}
  		else
  		{
  			return false;
  		}
 	}
 	
 	/**
 	 * Show the default footer of forum page
 	 */
 	function GetFooter()
 	{
 		// The instructions stored in footer module
 		// so include footer module to execute these inctructions
 		include('modules/footer.module.php');
 		
 		// Get the name of class
        $footer_name = FOOTER_NAME;
        
        // Make a new object
        $footer_name = new $footer_name;
        
        // Execute inctructions
        $footer_name->run();
 	}
 	
 	/**
 	 * Show the default header of forum page
 	 */
 	function ShowHeader($title = null)
 	{
 		global $MySmartBB;
 		
 		// Check if title is empty so use the default name of forum
 		// which stored in info_row['title']
 		$title = (isset($title)) ? $title : $MySmartBB->_CONF['info_row']['title'];
 		
 		// Send a copy from $title to template engine
 		$MySmartBB->template->assign('title',$title);
 		
 		// Show header template
 		$MySmartBB->template->display('header');
 	}
 	
 	/**
 	 * Get the forum's url adress
 	 */
 	function GetForumAdress()
 	{
 		global $MySmartBB;
 		
 		$domain_address 	= 	$MySmartBB->_SERVER['HTTP_HOST'];
 		$filename 			= 	$MySmartBB->_SERVER['REQUEST_URI'];
 		$filename 			= 	explode('/',$filename);
 		
 		$last_part = '';
 		
 		// The programme is under main folder (/var/www)
 		if (sizeof($filename) == 2)
 		{
 			$last_part = '/';
 		}
 		// The programme is under something like this (/public_html/MySmartBB)
 		elseif (sizeof($filename) == 3)
 		{
 			$last_part = '/' . $filename[1];
 		}
 		// The programme is under something like this (/public_html/MySmartBB/MySmartBB-Again)
 		elseif (sizeof($filename) == 4)
 		{
 			$last_part = '/' . $filename[1] . '/' . $filename[2];
 		}
 		
 		$url = 'http://' . $domain_address . $last_part . '/';
 		
 		return $url;
 	}
 	
 	/**
 	 * Get a strong random code :)
 	 */
 	function RandomCode()
    {
  		$code = rand(1,500) . rand(1,1000) . microtime();
  		$code = ceil($code);
  		
  		$code = base64_encode($code);
  		$code = substr($code,0,15);
  		
  		$code = str_replace('=',rand(1,100),$code);
  		
  		return $code;
 	}

	/**
	 * Just send email :)
	 */
 	function mail($to,$subject,$message,$sender)
    {
    	$headers  = "MIME-Version: 1.0\n";
    	$headers .= "Content-type: text/html; charset=windows-1256\n";
    	$headers .= "From: $sender\n";
    	$headers .= "Reply-To: $sender\n";

        $send = @mail($to, $subject, $message, $headers);

        return ($send) ? true : false;
 	}
 	
 	/**
 	 * Check if $adress is true site adress or not
 	 */
 	function IsSite($adress)
 	{
 		return preg_match('~http:\/\/(.*?)~',$adress) ? true : false;
 	}

 	function GetURLExtension($path)
 	{
 		global $MySmartBB;
 		
 		$filename = basename($path);
 		
		return $this->GetFileExtension($filename);
 	}
 	
	function date($input,$format = 'j/n/Y')
	{
		global $MySmartBB;
		
		return $MySmartBB->sys_functions->date($input,$MySmartBB->_CONF['info_row']['time_system'],$format);
	}
	
	function time($time,$format='h:i:s A')
	{
		global $MySmartBB;
		
		return $MySmartBB->sys_functions->time($time,$format);
	}
	
	function GetEditorTools()
	{
		global $MySmartBB;
		
		if (!is_object($MySmartBB->icon))
		{
			trigger_error('ERROR::ICON_OBJECT_DID_NOT_FOUND',E_USER_ERROR);
		}
		
		if (!is_object($MySmartBB->toolbox))
		{
			trigger_error('ERROR::TOOLBOX_OBJECT_DID_NOT_FOUND',E_USER_ERROR);
		}
		
		$SmlArr 					= 	array();
		$SmlArr['order'] 			=	array();
		$SmlArr['order']['field']	=	'id';
		$SmlArr['order']['type']	=	'ASC';
		$SmlArr['proc'] 			= 	array();
		$SmlArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['SmileRows'] = $MySmartBB->icon->GetSmileList($SmlArr);
		
		$IcnArr 					= 	array();
		$IcnArr['order'] 			=	array();
		$IcnArr['order']['field']	=	'id';
		$IcnArr['order']['type']	=	'DESC';
		$IcnArr['proc'] 			= 	array();
		$IcnArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['IconRows'] = $MySmartBB->icon->GetIconList($IcnArr);
		
		$ClrArr 					= 	array();
		$ClrArr['proc'] 			= 	array();
		$ClrArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['ColorRows'] = $MySmartBB->toolbox->GetColorsList($ClrArr);
		
		$FntArr 					= 	array();
		$FntArr['proc'] 			= 	array();
		$FntArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['FontRows'] = $MySmartBB->toolbox->GetFontsList($FntArr);
	}
	
	function ModeratorCheck()
	{
		global $MySmartBB;
		
		$Mod = false;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			if ($MySmartBB->_CONF['group_info']['admincp_allow'] 
				or $MySmartBB->_CONF['group_info']['vice'])
			{
				$Mod = true;
			}
			else
			{
				$ModArr = array();
				$ModArr['username'] 	= 	$MySmartBB->_CONF['member_row']['username'];
				$ModArr['section_id']	=	$MySmartBB->_POST['section'];
				
				$Mod = $MySmartBB->moderator->IsModerator($ModArr);
			}
		}
				
		return $Mod;
	}
	
	function GetForumsList()
	{
		global $MySmartBB;
		
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
							//////////
							
							// Get the first-level sub forums as a _link_ and store it in $forum['sub']
							
							$forum['is_sub'] 	= 	0;
							$forum['sub']		=	'';
							
							if (!empty($forum['forums_cache']))
							{
								$subs = unserialize(base64_decode($forum['forums_cache']));
								
								if (is_array($subs))
								{
									foreach ($subs as $sub)
									{
										if (is_array($sub['groups'][$MySmartBB->_CONF['group_info']['id']]))
										{
											if ($sub['groups'][$MySmartBB->_CONF['group_info']['id']]['view_section'])
											{
												if (!$forum['is_sub'])
												{
													$forum['is_sub'] = 1;
												}
												
												$forum['sub'] .= '<a href="index.php?page=forum&amp;show=1&amp;id=' . $sub['id'] . '">' . $sub['title'] . '</a> ، ';
											}
										}
									}
								}
							}
							
							//////////
							
							// Get the moderators list as a _link_ and store it in $forum['moderators_list']
							
							$forum['is_moderators'] 		= 	0;
							$forum['moderators_list']		=	'';
							
							if (!empty($forum['moderators']))
							{
								$moderators = unserialize($forum['moderators']);
								
								if (is_array($moderators))
								{
									foreach ($moderators as $moderator)
									{
										if (!$forum['is_moderators'])
										{
											$forum['is_moderators'] = 1;
										}
										
										$forum['moderators_list'] .= '<a href="index.php?page=profile&amp;show=1&amp;id=' . $moderator['member_id'] . '">' . $moderator['username'] . '</a> ، ';
									}
								}
							}
							
							//////////
							
							$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_f'] = $forum;
						}
					} // end if is_array
				} // end foreach ($forums)
			} // end !empty($forums_cache)
		} // end foreach ($cats)
	}
}

class MySmartAdminFunctions extends MySmartFunctions
{
 	//
}

?>
