<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('FOOTER_NAME','MySmartFooterMOD');

class MySmartFooterMOD
{
	function run()
	{
		global $MySmartBB;
		
		/* ... */
		
		$MySmartBB->rec->filter = "style_on='1'";
		$MySmartBB->rec->order = 'style_order ASC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'style_res' ];
		
		$MySmartBB->style->getStyleList();
		
		/* ... */
		
		$MySmartBB->template->assign('memory_usage',memory_get_usage()/1024);
		$MySmartBB->template->assign('query_num',$MySmartBB->_CONF['temp']['query_numbers']);
		
		$MySmartBB->template->display('footer');
		
		if (!empty($MySmartBB->_GET['debug']))
		{
			$x = 1;
			
			foreach ($MySmartBB->_CONF['temp']['queries'] as $k => $v)
			{
				echo $x . ': ' . $v . '<hr />';
			
				$x++;
			}
		}
		
		// Kill everything , Hey MySmartBB you should be lovely with server because it's Powered by Linux ;)
		unset($MySmartBB->_CONF);
 		unset($MySmartBB->template->_vars);
 		unset($MySmartBB->_GET);
 		unset($MySmartBB->_POST);
 		unset($MySmartBB->_SERVER);
 		unset($MySmartBB->_COOKIE);
 		unset($MySmartBB->_FILES);
	}
}

?>
