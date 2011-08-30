<?php

class MySmartFunctions
{
	// ... //
	
	/**
	 * Check if delicious cookie is here or somebody eat it mmmm :)
	 */
	public function isCookie( $cookie_name )
 	{
 		global $MySmartBB;
 		
 		return empty( $MySmartBB->_COOKIE[ $cookie_name ] ) ? false : true;
 	}
 	
 	// ... //
 	
 	/**
 	 * Clean the variable from any dirty :) , we should be thankful for abuamal
 	 *
 	 * By : abuamal
 	 */
	public function cleanVariable( $var, $type )
	{
		switch ( $type )
		{
			case 'sql':
				return addslashes($var);
				break;
			
			case 'html':
				return htmlspecialchars($var);
				break;
				
			case 'intval':
				return intval($var);
				break;
					
			case 'trim':
				return trim($var);
				break;
					
			case 'unhtml':
				return $this->htmlDecode($var);
				break;
			
			default:
				trigger_error('ERROR::BAD_VALUE_OF_TYPE_VARIABLE',E_USER_ERROR);
				break;
		}
	}
	
	// ... //
	
	/**
	 * Clean the array from dirty, this function based on "cleanVariable( $var, $type )"
	 *
	 * By : abuamal
	 */
	public function cleanArray( &$variable, $type )
	{
		foreach ( $variable as $key => $var )
		{
			/* Multidimensional Array */
			// We should not be in this case as possible, because we want to be light.
			if ( is_array( $var ) )
			{
				$this->cleanArray( $variable[ $key ], $type );
			}
			else
			{
				if ( isset( $variable[ $key ] ) )
				{
					$variable[ $key ] = $this->cleanVariable( $var, $type );
				}
			}
		}
		
		return true;
	}
	
	// ... //
	
 	public function addressBar( $title )
 	{
 		global $MySmartBB;
 		
 		$MySmartBB->template->display('address_bar_part1');
 		echo $title;
 		$MySmartBB->template->display('address_bar_part2');
 	}
 	
 	// ... //
 	
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
 	 * go to $site , abuamal hates this function :D don't ask me why , ask him ;)
 	 */
	public function move( $site, $m = 2 )
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
 	function error($msg,$no_header = true,$no_style = false)
    {
    	global $MySmartBB;
    	
    	if (!$no_header)
    	{
    		$this->ShowHeader('خطأ');
    	}
    	
  		$this->msg($msg,$no_style);
  		$this->stop($no_style);
 	}
 	
 	// ... //
 	
	/**
	 * Check if $email is true email or not
	 *
	 * This function by : Pal Coder from MySmartBB 1.x
	 */
	public function checkEmail( $email )
	{
        return eregi( "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[_a-z0-9-]+(\.[_a-z0-9-]+)", $email ) ? true : false;
	}
	
	// ... //
	 
 	/**
 	 * Get file extention
 	 */
 	public function getFileExtension( $filename )
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
 	
 	// ... //
 	
 	/**
 	 * Show the default footer of forum page
 	 */
 	public function getFooter()
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
 	
 	// ... //
 	
 	/**
 	 * Show the default header of forum page
 	 */
 	public function showHeader( $title = null )
 	{
 		global $MySmartBB;
 		
 		// Check if title is empty so use the default name of forum
 		// which stored in info_row['title']
 		$title = ( isset( $title ) ) ? $title : $MySmartBB->_CONF[ 'info_row' ][ 'title' ];
 		
 		$MySmartBB->template->assign('title',$title);
 		
 		$MySmartBB->template->display('header');
 	}
 	
 	// ... //
 	
 	/**
 	 * Get the forum's url address
 	 */
 	public function getForumAdress()
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
 	
 	// ... //
 	
 	/**
 	 * Get a strong random code :)
 	 */
 	public function randomCode()
    {
  		$code = rand(1,500) . rand(1,1000) . microtime();
  		$code = ceil($code);
  		
  		$code = base64_encode($code);
  		$code = substr($code,0,15);
  		
  		$code = str_replace('=',rand(1,100),$code);
  		
  		return $code;
 	}
 	
 	// ... //

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
 	
 	// ... //
 	
	public function date( $input, $type = null, $format = 'j/n/Y' )
	{
		global $MySmartBB;
		
		$input = date( $format, $input );
		
		if ( !isset( $type ) )
		{
			if ( !isset( $MySmartBB->_CONF[ 'info_row' ][ 'timesystem' ] ) )
			{
				$type = 'ty';
			}
			else
			{
				$type = $MySmartBB->_CONF[ 'info_row' ][ 'timesystem' ];
			}
		}
		
		if ($type == 'n')
		{
			return $input;
		}
		else
		{
			$time = time();
		
			$date_list = array();
		
			$date_list['today'] 			= 	$time - (0 * 24 * 60 * 60);
			$date_list['today'] 			= 	date($format,$date_list['today']);
		
			$date_list['yesterday'] 		= 	$time - (1 * 24 * 60 * 60);
			$date_list['yesterday'] 		= 	date($format,$date_list['yesterday']);
		
			$date_list['before_yesterday'] 	= 	$time - (2 * 24 * 60 * 60);
			$date_list['before_yesterday'] 	= 	date($format,$date_list['before_yesterday']);
			
			$date_list['last_week'] 		= 	$time - (7 * 24 * 60 * 60);
			$date_list['last_week'] 		= 	date($format,$date_list['last_week']);
		
			$date_list['last_two_weeks'] 	= 	$time - (14 * 24 * 60 * 60);
			$date_list['last_two_weeks'] 	= 	date($format,$date_list['last_two_weeks']);
		
			$date_list['last_three_weeks'] 	= 	$time - (24 * 24 * 60 * 60);
			$date_list['last_three_weeks'] 	= 	date($format,$date_list['last_three_weeks']);
		
			$date_list['last_month'] 		= 	$time - (30 * 24 * 60 * 60);
			$date_list['last_month'] 		= 	date($format,$date_list['last_month']);
		
			if ($input == $date_list['today'])
			{
				return 'اليوم';
			}
			elseif ($input == $date_list['yesterday'])
			{
				return 'امس';
			}
			elseif ($input == $date_list['before_yesterday'])
			{
				return 'امس الاول';
			}
			elseif ($input == $date_list['last_week'])
			{
				return 'قبل اسبوع';
			}
			elseif ($input == $date_list['last_two_weeks'])
			{
				return 'قبل اسبوعين';
			}
			elseif ($input == $date_list['last_three_weeks'])
			{
				return 'قبل ثلاث اسابيع';
			}
			elseif ($input == $date_list['last_month'])
			{
				return 'قبل شهر';
			}
			else
			{
				return $input;
			}
		}		
	}
	
	// ... //
		
	function time($time,$format='h:i:s A')
	{
		$x = date($format,$time);
		$x = strtolower($x);
		$x = str_replace('pm','مساء',$x);
		$x = str_replace('am','صباحا',$x);
				
		return $x;		
	}
	
	// ... //
	
	public function getEditorTools()
	{
		global $MySmartBB;
		
		if ( !is_object( $MySmartBB->icon ) )
		{
			trigger_error( 'ERROR::ICON_OBJECT_DID_NOT_FOUND', E_USER_ERROR );
		}
		
		if ( !is_object( $MySmartBB->toolbox ) )
		{
			trigger_error( 'ERROR::TOOLBOX_OBJECT_DID_NOT_FOUND', E_USER_ERROR );
		}
		
		// ... //
		
		$MySmartBB->_CONF['template']['res']['smile_res'] = '';
		
		$MySmartBB->rec->order = 'id ASC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['smile_res'];
		
		$MySmartBB->icon->getSmileList();
		
		// ... //
		
		$MySmartBB->_CONF['template']['res']['icon_res'] = '';
		
		$MySmartBB->rec->order = 'id DESC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['icon_res'];
		
		$MySmartBB->icon->getIconList();
		
		// ... //
		
		$MySmartBB->_CONF['template']['res']['color_res'] = '';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['color_res'];
		
		$MySmartBB->toolbox->getColorsList();
		
		// ... //
		
		$MySmartBB->_CONF['template']['res']['font_res'] = '';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['font_res'];
		
		$MySmartBB->toolbox->getFontsList();
		
		// ... //
	}
	
	// ... //
	
	public function moderatorCheck( $section_id, $username = null )
	{
		global $MySmartBB;
		
		$Mod = false;
		$user = null;
		
		if ( $MySmartBB->_CONF['member_permission'] )
		{
			if ( !isset( $username ) )
			{
				if ($MySmartBB->_CONF['group_info']['admincp_allow'] 
					or $MySmartBB->_CONF['group_info']['vice'])
				{
					$Mod = true;
				}
				else
				{
					$user = $MySmartBB->_CONF['member_row']['username'];
				}
			}
			else
			{
				$user = $username;
			}
			
			if ( !$Mod )
				$Mod = $MySmartBB->moderator->isModerator( $user, $section_id );
		}
				
		return $Mod;
	}
	
	// ... //
	
	public function getForumsList( $check_group = true )
	{
		global $MySmartBB;
		
		$forums_list = array();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = 'parent=0';
		$MySmartBB->rec->order = 'sort ASC';
		
		// Get main sections
		$MySmartBB->rec->getList();
		
		// Loop to read the information of main sections
		while ( $cat = $MySmartBB->rec->getInfo() )
		{
			// ... //
			
			// Get the groups information to know view this section or not
			
			if ( $check_group )
			{
				$groups = unserialize( base64_decode( $cat[ 'sectiongroup_cache' ] ) );
			
				if ( is_array( $groups[ $MySmartBB->_CONF[ 'group_info' ][ 'id' ] ] ) )
				{
					if ( $groups[ $MySmartBB->_CONF[ 'group_info' ][ 'id' ] ][ 'view_section' ] )
					{
						$forums_list[ $cat['id'] . '_m' ] = $cat;
					}
				}
			
				unset($groups);
			}
			else
			{
				$forums_list[ $cat['id'] . '_m' ] = $cat;
			}
			
			// ... //
			
			if ( !empty( $cat[ 'forums_cache' ] ) )
			{
				$forums = unserialize( base64_decode( $cat[ 'forums_cache' ] ) );
				
				foreach ($forums as $forum)
				{
					$show_forum = false;
					
					if ( $check_group )
					{
						// Check if the visitor have the permission to see this forum or not
						if ( is_array( $forum[ 'groups' ][ $MySmartBB->_CONF[ 'group_info' ][ 'id' ] ] ) )
						{
							if ( $forum[ 'groups' ][ $MySmartBB->_CONF[ 'group_info' ][ 'id' ] ][ 'view_section' ] )
							{
								$show_forum = true;
							}
						}
					}
					else
					{
						$show_forum = true;
					}
					
					// ... //
					
					if ( $show_forum )
					{
						// Get the first-level sub forums as a _link_ and store it in $forum['sub']	
						$forum[ 'is_sub' ] 	= 	0;
						$forum[ 'sub' ]		=	null;
						
						if ( !empty( $forum[ 'forums_cache' ] ) )
						{
							$subs = unserialize( base64_decode( $forum[ 'forums_cache' ] ) );
							
							if ( is_array( $subs ) )
							{
								foreach ( $subs as $sub )
								{
									if ( is_array( $sub[ 'groups' ][ $MySmartBB->_CONF[ 'group_info' ][ 'id' ] ] ) )
									{
										if ( $sub[ 'groups' ][ $MySmartBB->_CONF[ 'group_info' ][ 'id' ] ][ 'view_section' ] )
										{
											if ( !$forum[ 'is_sub' ] )
											{
												$forum[ 'is_sub' ] = 1;
											}
											
											$forum['sub'] .= '<a href="index.php?page=forum&amp;show=1&amp;id=' . $sub[ 'id' ] . '">' . $sub[ 'title' ] . '</a> ، ';
										}
									}
								}
							}
						}
							
						// ... //
						
						// Get the moderators list as a _link_ and store it in $forum['moderators_list']
						
						$forum['is_moderators'] 		= 	0;
						$forum['moderators_list']		=	null;
						
						if ( !empty( $forum[ 'moderators' ] ) )
						{
							$moderators = unserialize( $forum[ 'moderators' ] );
							
							if ( is_array( $moderators ) )
							{
								foreach ( $moderators as $moderator )
								{
									if ( !$forum[ 'is_moderators' ] )
									{
										$forum[ 'is_moderators' ] = 1;
									}
									
									$forum[ 'moderators_list' ] .= '<a href="index.php?page=profile&amp;show=1&amp;id=' . $moderator['member_id'] . '">' . $moderator['username'] . '</a> ، ';
								}
							}
						}
							
						// ... //
							
						$forums_list[ $forum[ 'id' ] . '_f' ] = $forum;
					} // end if $show_forum
				} // end foreach ($forums)
			} // end !empty($forums_cache)
		}
		
		return $forums_list;
	}
	
	// ... //
	
	public function replaceWYSIWYG( $text )
	{
		global $MySmartBB;
		
		// &lt; = <
		// &quot; = "
		// &gt; = >
		
		//////////
		
		// Smiles
 		$MySmartBB->smartparse->strip_smiles($text);
 		
 		//////////
 		
 		$search_array 	= 	array();
 		$replace_array 	= 	array();
 		
 		//////////
 		
 		// Bold
 		$search_array[] = '~&lt;span style=&quot;font-weight: bold;&quot;&gt;(.*?)&lt;/span&gt;~';
 		$replace_array[] = '[b]\\1[/b]';
 		
 		// Bold & Underline
 		$search_array[] = '~&lt;span style=&quot;(font-weight: bold;|text-decoration: underline;) (text-decoration: underline;|font-weight: bold;)&quot;&gt;(.*?)&lt;/span&gt;~';
 		$replace_array[] = '[b][u]\\3[/u][/b]';
 		
 		// Bold & Italic
 		$search_array[] = '~&lt;span style=&quot;(font-weight: bold;|font-style: italic;) (font-style: italic;|font-weight: bold;)&quot;&gt;(.*?)&lt;/span&gt;~';
 		$replace_array[] = '[b][i]\\3[/i][/b]';
 		
		// Bold & Italic & Underline
 		$search_array[] = '~&lt;span style=&quot;(font-weight: bold;|text-decoration: underline;|font-style: italic;) (text-decoration: underline;|font-weight: bold;|font-style: italic;) (text-decoration: underline;|font-weight: bold;|font-style: italic;)&quot;&gt;(.*?)&lt;/span&gt;~';
 		$replace_array[] = '[b][u][i]\\4[/i][/u][/b]';
 		
 		//////////
 		
 		// Italic
 		$search_array[] = '~&lt;span style=&quot;font-style: italic;&quot;&gt;(.*?)&lt;/span&gt;~';
 		$replace_array[] = '[i]\\1[/i]';
 		
 		// Italic & Underline
 		$search_array[] = '~&lt;span style=&quot;(font-style: italic;|text-decoration: underline;) (font-style: italic;|text-decoration: underline;)&quot;&gt;(.*?)&lt;/span&gt;~';
 		$replace_array[] = '[i][u]\\3[/u][/i]';
 		
 		//////////
 		
 		// Underline
 		$search_array[] = '~&lt;span style=&quot;text-decoration: underline;&quot;&gt;(.*?)&lt;/span&gt;~';
 		$replace_array[] = '[u]\\1[/u]';
 		
 		//////////
 		
 		// Links
 		$search_array[] = '~&lt;a href=&quot;(.*?)&quot;&gt;(.*?)&lt;/a&gt;~';
 		$replace_array[] = '[url=\\1]\\2[/url]';
 		
 		//////////
 		
 		// Images
 		$search_array[] = '~&lt;img src=&quot;(.*?)&quot; alt=&quot;(.*?)&quot; border=&quot;0&quot;&gt;~';
 		$replace_array[] = '[img]\\1[/img]';
 		
 		
 		$search_array[] = '~&lt;img src=&quot;(.*?)&quot;&gt;~';
 		$replace_array[] = '[img]\\1[/img]';
 		
 		//////////
 		
 		// Center
 		$search_array[] = '~&lt;div style=&quot;text-align: center;&quot;&gt;(.*?)&lt;/div&gt;~';
 		$replace_array[] = '[center]\\1[/center]';
 		
 		// Right
 		$search_array[] = '~&lt;div style=&quot;text-align: right;&quot;&gt;(.*?)&lt;/div&gt;~';
 		$replace_array[] = '[right]\\1[/right]';
 		
 		// Left
 		$search_array[] = '~&lt;div style=&quot;text-align: left;&quot;&gt;(.*?)&lt;/div&gt;~';
 		$replace_array[] = '[left]\\1[/left]';
 		
 		//////////
 		
 		// New line
 		$search_array[] = '~&lt;br&gt;~';
 		$replace_array[] = '\n';
 		
 		$search_array[] = '~<br />~';
 		$replace_array[] = '\n';
 		
 		//////////
 		
		$string = preg_replace($search_array,$replace_array,$text);
		
		$string = nl2br($string);
		
		return $string;
	}
	
	public function htmlDecode( $text )
	{
		$text = str_replace('&amp;','&',$text);
		$text = str_replace('&lt;','<',$text);
		$text = str_replace('&quot;','"',$text);
		$text = str_replace('&gt;','>',$text);
		$text = str_replace("\'","'",$text);
		
		$text = str_replace('<script','',$text);
		$text = str_replace('</script>','',$text);
		$text = str_replace('document.cookie','',$text);
		$text = str_replace('document.location','',$text);
		$text = str_replace('javascript','',$text);
		
		return $text;
	}
			
	/**
	 * Sets the variable which stores the returned "resource" for template.
	 *
	 * Use this function only with MySmartRecords->getList();
	 */
	public function &setResource( $name = null )
	{
		global $MySmartBB;
		
		if ( isset( $name ) )
		{
			$MySmartBB->_CONF[ 'template' ][ 'res' ][ $name ] = '';
		
			$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ $name ];
		}
		else
		{
			$resource = '';

			$MySmartBB->rec->result = &$resource;
		
			return $resource;
		}
	}
}

?>
