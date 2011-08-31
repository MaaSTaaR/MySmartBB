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
