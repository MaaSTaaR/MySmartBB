<?php

class MySmartFunctions
{
	private $header_showed = false;
	
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
		    case 'sql,html':
		    case 'html,sql':
		        return htmlspecialchars( addslashes( stripslashes( $var ) ) );
		        break;
		        
			case 'sql':
				return addslashes( stripslashes( $var ) );
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
 	function error( $msg, $no_header = true, $no_style = false )
    {
    	global $MySmartBB;
    	
    	if ( !$no_header or !$this->header_showed )
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
	    // TODO : This function has been DEPRECATED as of PHP 5.3.0.
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
 		
 		$this->header_showed = true;
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
 	
 	public function getDirPath()
 	{
 		global $MySmartBB;
 		
  		$parts = explode( '/', $MySmartBB->_SERVER[ 'SCRIPT_NAME' ] );
  		
  		$path = '';
  		
  		foreach ( $parts as $part )
  		{
  			if ( !stristr( $part, '.php' ) )
  				$path .= $part;
  			else
  				break;
  		}
  		
  		return $path . '/';
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
	 * Just send an email :)
	 */
 	public function mail( $to, $subject, $message, $sender )
    {
    	$headers  = "MIME-Version: 1.0\n";
    	$headers .= "Content-type: text/html; charset=utf-8\n";
    	$headers .= "From: $sender\n";
    	$headers .= "Reply-To: $sender\n";

        $send = mail( $to, $subject, $message, $headers );

        return $send;
 	}
 	
 	/**
 	 * Check if $adress is true site adress or not
 	 */
 	public function isSite($adress)
 	{
 		return preg_match('~http:\/\/(.*?)~',$adress) ? true : false;
 	}

 	public function getURLExtension($path)
 	{
 		global $MySmartBB;
 		
 		$filename = basename($path);
 		
		return $MySmartBB->attach->getFileExtension($filename);
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
		
			$date_list['today'] 			= 	$time;
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
				return $MySmartBB->lang_common[ 'today' ];
			}
			elseif ($input == $date_list['yesterday'])
			{
				return $MySmartBB->lang_common[ 'yesterday' ];
			}
			elseif ($input == $date_list['before_yesterday'])
			{
				return $MySmartBB->lang_common[ 'two_days_ago' ];
			}
			elseif ($input == $date_list['last_week'])
			{
				return $MySmartBB->lang_common[ 'last_week' ];
			}
			elseif ($input == $date_list['last_two_weeks'])
			{
				return $MySmartBB->lang_common[ 'two_weeks_ago' ];
			}
			elseif ($input == $date_list['last_three_weeks'])
			{
				return $MySmartBB->lang_common[ 'three_weeks_ago' ];
			}
			elseif ($input == $date_list['last_month'])
			{
				return $MySmartBB->lang_common[ 'last_month' ];
			}
			else
			{
				return $input;
			}
		}		
	}
	
	// ... //
		
	public function time( $time, $format='h:i:s A' )
	{
	    global $MySmartBB;
	    
		$x = date( $format, $time );
		$x = strtolower( $x );
		$x = str_replace( 'pm', $MySmartBB->lang_common[ 'pm' ], $x );
		$x = str_replace( 'am', $MySmartBB->lang_common[ 'am' ], $x );
				
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
	
	public function htmlDecode( $text )
	{
	    $text = stripslashes( $text );
	    
		$text = str_replace('&amp;','&',$text);
		$text = str_replace('&lt;','<',$text);
		$text = str_replace('&quot;','"',$text);
		$text = str_replace('&gt;','>',$text);
		$text = str_replace("\'","'",$text);
		
		$forbidden = array( '<script', '</script>', 'document.cookie', 'document.location', 'javascript' );
		
		$text = str_ireplace( $forbidden, '', $text );
		
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
	
	// For performance purpose, we didn't put this function in the includes/functions/ads.class.php
	// Because we need to call this function in common.module.php, 
	// therefore it _should_ be here so there is no need to load ads.class.php in all pages for one function only.
	public function getRandomAds()
	{
	    global $MySmartBB;
	    
	    $info = $MySmartBB->_CONF[ 'info_row' ][ 'ads_cache' ];
	    
	    if ( !empty( $info ) )
	    {
	        $cache = unserialize( base64_decode( $info ) );
	        
	        if ( is_array( $cache ) )
	        {
	            $random = rand( 0, $MySmartBB->_CONF[ 'info_row' ][ 'ads_num' ] - 1 );
	            
	            return $cache[ $random ];
	        }
	        else
	        {
	            return null;
	        }
	    }
	    else
	    {
	        return null;
	    }
	}
}

?>
