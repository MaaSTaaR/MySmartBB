<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('FOOTER_NAME','MySmartFooterMOD');

class MySmartFooterMOD
{
	function run()
	{
		global $MySmartBB;
		
		// Get style list			
		$StyleListArr 							= 	array();
		
		// Clean data
		$StyleListArr['proc']					=	array();
		$StyleListArr['proc']['*']				=	array('method'=>'clean','param'=>'html');
		
		// Where setup
		$StyleListArr['where'][0]				=	array();
		$StyleListArr['where'][0]['con']		=	'AND';
		$StyleListArr['where'][0]['name']		=	'style_on';
		$StyleListArr['where'][0]['oper']		=	'=';
		$StyleListArr['where'][0]['value']		=	'1';
		
		// Order setup
		$StyleListArr['order'] 					= 	array();
		$StyleListArr['order']['field'] 		= 	'style_order';
		$StyleListArr['order']['type'] 			= 	'ASC';
		
		$MySmartBB->_CONF['template']['while']['StyleList'] = $MySmartBB->style->GetStyleList($StyleListArr);
		
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
