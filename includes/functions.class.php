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
  		$L  = strlen($filename)-4;
  		$E  = strtolower(substr($filename,$L,4));

        $E  = addslashes($E);

  		return $E;
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
    	global $MySmartBB;
    	
  		$date_ = str_replace('/','',$MySmartBB->_CONF['date']);
  		$s = time() . $date_ . rand(1,10000) . microtime();
  		$s = str_replace(',','',$s);
  		$s = str_replace(' ','',$s);

  		$s2 = time()*85200 . $date_*1000 . rand(1,10000) . microtime();
  		$s2 = str_replace(',','',$s2);
  		$s2 = str_replace(' ','',$s2);

  		$s = md5($s).md5($s2);
  		$s = substr($s,0,26);

  		return $s;
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
 		return preg_match('~\http:\/\/(.*?)~',$adress) ? true : false;
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
}

class MySmartAdminFunctions extends MySmartFunctions
{
 	//
}

?>
