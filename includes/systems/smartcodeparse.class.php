<?php

/**
 * @package : MySmartCode
 * @copyright : MaaSTaaR <MaaSTaaR@hotmail.com>
 * @version : 1.0 Special verion for MySmartBB
 * @start : 23/2/2006 , 3:46 PM (kuwait : GMT+3)
 * @end   : 23/2/2006 , 6:30 PM (kuwait : GMT+3)
 * @last update : 01/09/2008 04:54:55 AM 
 */
 
class MySmartCodeParse
{
 	/**
 	 * Search some text in $string and change it to other text
 	 *
 	 * @param :
 	 *				$string -> the text
 	 */
 	function replace($string)
 	{
 		global $MySmartBB;
 		
 		$brackets = (strpos($string,'[') !== false) and (strpos($string,']') !== false);
  
 		if ($brackets)
 		{
 			$string = htmlspecialchars($string);
 			
 			$first_search = array();
 			$first_search[] = '~\[code](.*?)\[/code]~ise';
 			$first_search[] = '~\[php](.*?)\[/php]~ise';
 			
 			$first_replace = array();
 			$first_replace[] = '\'[code]\' . base64_encode(\'\\1\') . \'[/code]\'';
 			$first_replace[] = '\'[php]\' . base64_encode(\'\\1\') . \'[/php]\'';
 			
 			if ($MySmartBB->_CONF['info_row']['resize_imagesAllow'])
 			{
 				$first_search[] = '~\[img](.*?)\[/img]~ise';
 				$first_search[] = '~\[IMG](.*?)\[/IMG]~ise';
 				
 				$first_replace[] = '$this->ResizeImage(\'\\1\')';
 				$first_replace[] = '$this->ResizeImage(\'\\1\')';
 			}
 									
 			$string = preg_replace($first_search,$first_replace,$string);
 			 									
 			$search_array = array();
 			$replace_array = array();
 			
 			if (!$MySmartBB->_CONF['info_row']['resize_imagesAllow'])
 			{
 				$search_array[] = '~\[img](.*?)\[/img]~';
 				$replace_array[] = '<img src="\\1" border="0" />';
 			
 				$search_array[] = '~\[IMG](.*?)\[/IMG]~';
 				$replace_array[] = '<img src="\\1" border="0" />';
 			}
 			
 			$search_array[] = '~\[b](.*?)\[/b]~';
 			$replace_array[] = '<b>\\1</b>';
 			
 			$search_array[] = '~\[u](.*?)\[/u]~';
 			$replace_array[] = '<u>\\1</u>';
 			
 			$search_array[] = '~\[font=([^[<].*?)]([^[<].*?)\[/font]~';
 			$replace_array[] = '<div style="font-family:\\1">\\2</div>';
 			
 			$search_array[] = '~\[color=(\#[0-9A-F]{6}|[a-z\-]+)\](.*?)\[/color]~';
 			$replace_array[] = '<div style="color:\\1">\\2</div>';
 			
 			$search_array[] = '~\[quote](.*?)\[/quote]~';
 			$replace_array[] = '<table border="1" cellspacing="0" cellpadding="0" class="t_style_a" width="95%" align="center"><tr><td>' . $MySmartBB->lang_common[ 'quote' ] . '</td></tr><tr><td align="right">\\1</tr></td></table>';
 			
 			$search_array[] = '~\[qu](.*?)\[/qu]~';
 			$replace_array[] = '<table border="1" cellspacing="0" cellpadding="0" class="t_style_a" width="95%" align="center"><tr><td>' . $MySmartBB->lang_common[ 'quote' ] . '</td></tr><tr><td align="right">\\1</tr></td></table>';
 			
 			$search_array[] = '~\[code](.*?)\[/code]~ise';
 			$replace_array[] = '$this->code_tag(\'\\1\',0)';
 			
 			$search_array[] = '~\[php](.*?)\[/php]~ise';
 			$replace_array[] = '$this->code_tag(\'\\1\',1)';
 			
 			$search_array[] = '/\[url\](http:\/\/|ftp:\/\/|https:\/\/)(.*?)\[\/url\]/i';
 			$replace_array[] = "<a href='http://\\2' target='_blank'>\\1\\2</a>";
 			
 			$search_array[] = '/\[url=(http:\/\/|ftp:\/\/|https:\/\/)(.*?)\](.*?)\[\/url\]/i';
 			$replace_array[] = "<a href='http://\\2' target='_blank'>\\3</a>";
 			
 			$search_array[] = '~\[i](.*?)\[/i]~';
 			$replace_array[] = '<i>\\1</i>';
 			
 			$search_array[] = '~\[size=([0-9]+)](.*?)\[/size]~';
 			$replace_array[] = '<div style="font-size:\\1\pt">\\2</div>';
 			
 			$search_array[] = '~\[center](.*?)\[/center]~';
 			$replace_array[] = '<div style="text-align: center">\\1</div>';
 			
  			$search_array[] = '~\[right](.*?)\[/right]~';
 			$replace_array[] = '<div style="text-align: right">\\1</div>';
 			
 			$search_array[] = '~\[left](.*?)\[/left]~';
 			$replace_array[] = '<div style="text-align: left">\\1</div>';
 									
 			$string = preg_replace($search_array,$replace_array,$string);
 			 			
 			$eregi_search = array();
 			$eregi_search[] = '([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})';
 			$eregi_search[] = '([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)';
 									
 			$eregi_replace = array();
 			$eregi_replace[] = '<a href="mailto:\\1">\\1</a>';
 			$eregi_replace[] = '\\1<a href="http://\\2" target="_blank">\\2</a>';
 			
 			// TODO : This function has been DEPRECATED as of PHP 5.3.0.
 			$string = eregi_replace($eregi_search,$eregi_replace,$string); 			
 		}
 		else
 		{
			$search_array = array();
 		 	$search_array[] = ",([^]_a-z0-9-=\"'\/])((https?|ftp|gopher|news|telnet):\/\/)([^ \r\n\(\)\*\^\$!`\"'\|\[\]\{\}<>]*),i";
 		 	$search_array[] = ",^((https?|ftp|gopher|news|telnet):\/\/|www\.)([^ \r\n\(\)\*\^\$!`\"'\|\[\]\{\}<>]*),i";
 		 	$search_array[] = "/^([\\._a-zA-Z0-9-]+(\.[\\._a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3}))/i";

 			$replace_array = array();
 			$replace_array[] = "$1<a href='$2$4' target='_blank'>$2$4</a>";
 			$replace_array[] = "<a href='$1$3' target='_blank'>$1$3</a>";
 			$replace_array[] = "<a href='mailto:$1'>$1<\/a>";
 									
 			$string = preg_replace($search_array,$replace_array ,$string);
 		}
 		
 		$string = nl2br($string);
 		
 		return $string;
 	}
 	
 	/**
 	 * The SmartCode should be programmer paradise like Linux ;)
 	 *
 	 * @author : Jason Warner <jason@mercuryboard.com>
 	 *
 	 * @edited by : MaaSTaaR <MaaSTaaR@gmail.com>
 	 *
 	 * @param :
 	 * 	 			code 	-> the code
 	 *				is_php	->	if the code wrote in php this variable should value true to highlight the code
 	 */
 	 function code_tag($code,$is_php)
 	 {
 	    global $MySmartBB;
 	    
 	 	$input = stripslashes(base64_decode($code));
 	 	
		if (substr($input, 0, 1) != "\r") 
		{
			$input = "\r\n" . $input;
		}

		if (substr($input, -1) != "\n") 
		{
			$input .= "\r\n";
		}
 	 	
		if ($is_php) 
		{
			
			if (!strstr('<?',$input)) 
			{
				$input  = '<' . "?php $input ?" . '>';
				$tagged = true;
			}
			
			ob_start();

			highlight_string($input);
			$input = ob_get_contents();

			ob_end_clean();
		} 
		else 
		{
			$input = str_replace('\'', '&#039;', $input);
			$input = nl2br($input);
		}


		if (isset($tagged)) 
		{
			$input = str_replace(array('&lt;?php', '?&gt;'), '', $input);
			$input = str_replace(array('<?php', '?>'), '', $input);
		}
		
		$lines = explode('<br />', $input);
		$count = count($lines) - 1;

		$col1 = '';
		$col2 = '';
		
		$start = 1;
		
		for ($i = 1; $i < $count; $i++)
		{
			$col1 .= $start . '<br />';
			$col2 .= rtrim($lines[$i]);
			$start += 1;
		}

		$return = "<table align='center' border='1' width='90%' cellpadding='0' cellspacing='0' class='t_style_a' dir='ltr'>";
		$return .= "<tr><td width='89%' colspan='2' dir='rtl'><b>" . $MySmartBB->lang_common[ 'code' ] . "</b></td></tr>";
		$return .= "<tr><td width='1%'><br />$col1</td>";
		$return .= "<td>" . $this->strip_smiles($col2) . "</td></tr></table>";

		return $return;		
 	 }
 	 
 	public function replace_smiles( &$text )
	{
		global $MySmartBB;
		
		$smiles = $MySmartBB->icon->getCachedSmiles();
		
		foreach ($smiles as $smile)
		{
			$text = str_replace($smile['smile_short'],'<img src="' . $smile['smile_path'] . '" border="0" alt="' . $smile['smile_short'] . '" />',$text);
		}
	}
	
	function strip_smiles(&$text)
	{   		
   		global $MySmartBB;

		$smiles = $MySmartBB->icon->GetCachedSmiles();
		
		foreach ($smiles as $smile)
		{
			$MySmartBB->functions->CleanVariable($smile,'html');
			
			$text = str_replace('<img src="' . $smile['smile_path'] . '" border="0" alt="' . $smile['smile_short'] . '" />',$smile['smile_short'],$text);
			
			// For WYSIWYG
			$text = str_replace('&lt;img src=&quot;' . $smile['smile_path'] . '&quot;&gt;',$smile['smile_short'],$text);
		}
    }
    
    function ResizeImage($path)
    {
    	global $MySmartBB;
    	
    	return '<a target="_blank" href="' . $path . '"><img src="' . $path . '" border="0" alt="' . $path . '" width="' . $MySmartBB->_CONF['info_row']['default_imagesW'] . '" height="' . $MySmartBB->_CONF['info_row']['default_imagesH'] . '" /></a>';
    }
}

?>
