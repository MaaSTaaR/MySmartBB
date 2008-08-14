<?php

/*
 * @package : MySmartTemplate
 * @author : Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @version : 0.25 (Special Version For MySmartBB)
 * @start : 20/4/2006 , 7:00 PM (GMT+3)
 * @last update : 05/07/2008 05:50:33 AM
 * @under : GNU LGPL
*/

class MySmartTemplate
{
	var $templates_dir;
	var $compiler_dir;
	var $templates_ex;
	var $template;
	var $while_num;
	var $while_array	=	array();
	var $foreach_array	=	array();
	var $_vars 			= 	array();
	var $method			=	'file';
	var $x_loop			=	0; // Private
	var $size_loop		=	0; // Private
	
	/**
	 * Set the information
	 */	
	function SetInformation($templates_dir,$compiler_dir,$templates_ex,$method)
	{
		$this->templates_dir 		= 	$templates_dir;
		$this->compiler_dir 		= 	$compiler_dir;
		$this->templates_ex			=	$templates_ex;
		$this->method				=	$method;
	}
	
	function GetTemplateDir()
	{
		return $this->templates_dir;
	}
	
	function GetCompilerDir()
	{
		return $this->compilter_dir;
	}
	
	function GetTemplateExtention()
	{
		return $this->templates_ex;
	}
	
	/**
	 * Display the template after compile it
	 */
	function display($template_name)
	{
		global $MySmartBB;
		
		if ($this->method == 'file')
		{
			if ($MySmartBB->_GET['debug'] != 1)
			{
				$this->_TemplateFromFile($template_name);
			}
		}
		else
		{
			trigger_error('ERROR::BAD_VALUE_OF_METHOD_VARIABLE',E_USER_ERROR);
		}
	}
	
	function content($template_name)
	{
		if ($this->method == 'file')
		{
			return $this->_TemplateFromFile($template_name,true);
		}
	}
	
	/**
	 * If the template isn't compiled , we search it in template directory and if we found it we will compile it
	 */
	function _TemplateFromFile($template_name,$content=false)
	{
		if (filesize($this->templates_dir . $template_name . $this->templates_ex) > 0)
		{
			if (file_exists($this->compiler_dir . $template_name . '-compiler.php'))
			{
				if (filectime($this->compiler_dir . $template_name . '-compiler.php') < filectime($this->templates_dir . $template_name . $this->templates_ex))
				{
					$fp = fopen($this->templates_dir . $template_name . $this->templates_ex,'r');
		
					if (!$fp)
					{
						return 'ERROR::CAN_NOT_OPEN_THE_FILE';
					}
		
					$fr = fread($fp,filesize($this->templates_dir . $template_name . $this->templates_ex));
				
					fclose($fp);
		
					$this->_CompileTemplate($fr,$template_name);
				}
			}
			else
			{
				$fp = fopen($this->templates_dir . $template_name . $this->templates_ex,'r');
		
				if (!$fp)
				{
					trigger_error('ERROR::CAN_NOT_OPEN_THE_FILE',E_USER_ERROR);
				}
		
				$fr = fread($fp,filesize($this->templates_dir . $template_name . $this->templates_ex));
			
				fclose($fp);
		
				$this->_CompileTemplate($fr,$template_name);
			}
		
			if (!$content)
			{
				$this->_GetCompiledFile($template_name,$content);
			}
			else
			{
				return $this->_GetCompiledFile($template_name,$content);
			}
		}
		else
		{
			trigger_error('ERROR::FILE_SIZE_IS_ZERO',E_USER_ERROR);
		}
	}
	
	/**
	 * Can I call it "The Compiler" ? :)
	 */
	function _CompileTemplate($string,$filename)
	{
		// We have loop
		if (preg_match('~\{Des::while}{([^[<].*?)}~',$string)
			or preg_match('~\{Des::while::complete}~',$string))
		{
			$string = $this->_ProccessWhile($string);
		}
		
		if (preg_match('~\{Des::foreach}{([^[<].*?)}~',$string))
		{
			$string = $this->_ProccessForeach($string);
		}
		
		$search_array 	= 	array();
		$replace_array 	= 	array();
		
		//////////
		
		/**
		 * Array
		 */
		 
		// 2D Array (Without print) :
		// 			{$array['0']} -> $array['0']
		$search_array[] 	= 	'~\{{\$([^[<].*?)\[\'([^[<].*?)\'\]\[\'([^[<].*?)\'\]\}}~';
		$replace_array[] 	= 	'$MySmartBB->_CONF[\'template\'][\'\\1\'][\'\\2\'][\'\\3\']';
		
		// 2D Array :
		// 			{$array['0']} -> $array['0']
		$search_array[] 	= 	'~\{\$([^[<].*?)\[\'([^[<].*?)\'\]\[\'([^[<].*?)\'\]\}~';
		$replace_array[] 	= 	'<?php echo $MySmartBB->_CONF[\'template\'][\'\\1\'][\'\\2\'][\'\\3\'] ?>';
				
		// 2D Array (Without print) :
		//			{$array[0]} -> $array[0]
		$search_array[] 	= 	'~\{{\$([^[<].*?)\[([^[<].*?)\]\[([^[<].*?)\]\}}~';
		$replace_array[] 	= 	'$MySmartBB->_CONF[\'template\'][\'\\1\'][\'\\2\'][\'\\3\']';
	
		// 2D Array :
		//			{$array[0]} -> $array[0]
		$search_array[] 	= 	'~\{\$([^[<].*?)\[([^[<].*?)\]\[([^[<].*?)\]\}~';
		$replace_array[] 	= 	'<?php echo $MySmartBB->_CONF[\'template\'][\'\\1\'][\'\\2\'][\'\\3\'] ?>';
				
		// Array (Without print) :
		// 			{$array['0']} -> $array['0']
		$search_array[] 	= 	'~\{{\$([^[<].*?)\[\'([^[<].*?)\'\]\}}~';
		$replace_array[] 	= 	'$MySmartBB->_CONF[\'template\'][\'\\1\'][\'\\2\']';
		
		// Array :
		// 			{$array['0']} -> $array['0']
		$search_array[] 	= 	'~\{\$([^[<].*?)\[\'([^[<].*?)\'\]\}~';
		$replace_array[] 	= 	'<?php echo $MySmartBB->_CONF[\'template\'][\'\\1\'][\'\\2\'] ?>';
		
		// Array (Without print) :
		//			{$array[0]} -> $array[0]
		$search_array[] 	= 	'~\{{\$([^[<].*?)\[([^[<].*?)\]\}}~';
		$replace_array[] 	= 	'$MySmartBB->_CONF[\'template\'][\'\\1\'][\'\\2\']';
			
		// Array :
		//			{$array[0]} -> $array[0]
		$search_array[] 	= 	'~\{\$([^[<].*?)\[([^[<].*?)\]\}~';
		$replace_array[] 	= 	'<?php echo $MySmartBB->_CONF[\'template\'][\'\\1\'][\'\\2\'] ?>';
		
		//////////
		
		/**
		 * Variable
		 */
		 
		// Variable (Without print) :
		//				{$var} -> $var
		$search_array[] 	= 	'~\{{\$([^[<].*?)\}}~';
		$replace_array[] 	= 	'$MySmartBB->_CONF[\'template\'][\'\\1\']';

		// Variable :
		//				{$var} -> $var
		$search_array[] 	= 	'~\{\$([^[<].*?)\}~';
		$replace_array[] 	= 	'<?php echo $MySmartBB->_CONF[\'template\'][\'\\1\'] ?>';

		//////////
		
		/**
		 * If statement
		 */
		 
		// If statement :
		//					{if $i == 1} Hi {/if}
		//					if ($i == 1) { echo 'Hi'; }
		$search_array[] 	= 	'~\{if ([^[<].*?)}~';
		$replace_array[] 	= 	'<?php if (\\1) { ?>';
		
		$search_array[] 	= 	'~\{/if}~';
		$replace_array[] 	= 	'<?php } ?>';
		
		// Elseif statement
		$search_array[] 	= 	'~\{elseif ([^[<].*?)}~';
		$replace_array[] 	= 	'<?php } elseif (\\1) { ?>';
		
		// Else statement
		$search_array[] 	= 	'~\{else}~';
		$replace_array[] 	= 	'<?php } else { ?>';
		
		//////////
		
		/**
		 * Misc
		 */
		 
		// Fetch another template in work template
		// {template}template_name{/template}
		$search_array[] 	= 	'~\{template}([^[<].*?){/template}~';
		$replace_array[] 	= 	'<?php $this->display(\'\\1\'); ?>';
		
		// Include anther file in template
		// {include}style.css{/include}
		$search_array[] 	= 	'~\{include}([^[<].*?){/include}~';
		$replace_array[] 	= 	'<?php include(\\1); ?>';
		
		//////////
		
 		$string = preg_replace($search_array,$replace_array,$string);
 		
 		$create = fopen($this->compiler_dir . $filename . '-compiler.php','w+');
 		
 		if (!$create)
 		{
 			trigger_error('ERROR::CAN_NOT_OPEN_THE_FILE',E_USER_ERROR);
 		}
 		
 		$write  = fwrite($create,$string);
 		
 		if (!$write)
 		{
 			trigger_error('ERROR::CAN_NOT_WRITE_TO_THE_FILE',E_USER_ERROR);
 		}
 		
 		fclose($create);
	}
	
	/**
	 * We have {Des::while} loop , that's mean probably we will fetch information from database
	 */
	function _ProccessWhile($string)
	{
		$search_array 		= 	array();
		$replace_array 		= 	array();
		
		$search_array[] 	=	'~\{Des::while}{([^[<].*?)}~';
		$replace_array[] 	=	'<?php $this->x_loop = 0; $this->size_loop = sizeof($MySmartBB->_CONF[\'template\'][\'while\'][\'\\1\']); while ($this->x_loop < $this->size_loop) { ?>';
		
		$search_array[] 	=	'~\{\{\$([^[<].*?)\[([^[<].*?)\]\}\}~';
		$replace_array[] 	=	'$MySmartBB->_CONF[\'template\'][\'while\'][\'\\1\'][$this->x_loop][\\2]';
		
		$search_array[] 	=	'~\{\$([^[<].*?)\[([^[<].*?)\]\}~';
		$replace_array[] 	=	'<?php echo $MySmartBB->_CONF[\'template\'][\'while\'][\'\\1\'][$this->x_loop][\\2]; ?>';
		
		$string 			= 	preg_replace($search_array,$replace_array,$string);
		
		$string 			= 	str_replace('{/Des::while}','<?php $this->x_loop = $this->x_loop + 1; } ?>',$string);
		$string 			= 	str_replace('{Des::while::complete}','',$string);
		$string 			= 	str_replace('{/Des::while::complete}','',$string);
		
		return $string;	
	}
	
	function _ProccessForeach($string)
	{
		$search_array 		= 	array();
		$replace_array 		= 	array();
		
		$search_array[] 	=	'~\{Des::foreach}{([^[<].*?)}{([^[<].*?)}~';
		$replace_array[] 	=	'<?php foreach ($MySmartBB->_CONF[\'template\'][\'foreach\'][\'\\1\'] as $\\2) { ?>';
		
		// Variable (Without print) :
		//				{$var} -> $var
		$search_array[] 	= 	'~\{{\$([^[<].*?)\}}~';
		$replace_array[] 	= 	'$\\1';

		// Variable :
		//				{$var} -> $var
		$search_array[] 	= 	'~\{\$([^[<].*?)\}~';
		$replace_array[] 	= 	'<?php echo $\\1 ?>';
		
		$search_array[] 	=	'~\{\$([^[<].*?)\[([^[<].*?)\]\}~';
		$replace_array[] 	=	'<?php echo $\\1[\\2]; ?>';
		
		$search_array[] 	=	'~\{{\$([^[<].*?)\[([^[<].*?)\]}}~';
		$replace_array[] 	=	'$\\1[\\2]';
		
		$search_array[] 	=	'~\{counter}~';
		$replace_array[] 	=	'<?php echo $this->x_loop ?>';
		
		$search_array[] 	=	'~\{{counter}}~';
		$replace_array[] 	=	'$this->x_loop';
		
		$string 			= 	preg_replace($search_array,$replace_array,$string);
		
		$string 			= 	str_replace('{/Des::foreach}','<?php $this->x_loop += 1; } ?>',$string);
		
		return $string;	
	}
	
	/**
	 * If the template is already compiled , so include it
	 */
	function _GetCompiledFile($template_name,$content=false)
	{
		global $MySmartBB;
		
		// Yeah it's here , include it .
		if (file_exists($this->compiler_dir . $template_name . '-compiler.php'))
		{
			if (!$content)
			{
				include($this->compiler_dir . $template_name . '-compiler.php');	
			
				// Don't forget return true :)
				return true;
			}
			else
			{
				$fp = fopen($this->compiler_dir . $template_name . '-compiler.php','r');
		
				if (!$fp)
				{
					trigger_error('ERROR::CAN_NOT_OPEN_THE_FILE',E_USER_ERROR);
				}
		
				$fr = fread($fp,filesize($this->templates_dir . $template_name . $this->templates_ex));
				
				if (!$fr)
				{
					trigger_error('ERROR::CAN_NOT_READ_FROM_THE_FILE',E_USER_ERROR);
				}
				
				fclose($fp);
				
				return $fr;
			}
		}
		// it's not here , so return false
		else
		{
			return false;
		}
	}
	
	// Define variable to use it in template
	function assign($varname,$value)
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template'][$varname] = $value;
	}
		
	// Stop script
	function _error($msg)
	{
		die($msg);
	}
}


?>
