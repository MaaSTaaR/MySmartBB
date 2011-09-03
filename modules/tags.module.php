<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartTagsMOD');

class MySmartTagsMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['show'])
		{
			$this->_show();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _show()
	{
		global $MySmartBB;
		
		// Clean the id from any strings
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'tag' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$tag_info = $MySmartBB->rec->getInfo();
		
		if ( !$tag_info )
			$MySmartBB->func->error( 'العلامه المطلوبه غير موجوده' );
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'tag_subject' ];
		$MySmartBB->rec->filter = "tag_id='" . $MySmartBB->_GET['id'] . "'";
		
		$number = $MySmartBB->rec->getNumber();
		
		$MySmartBB->func->showHeader( 'العلامات' );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'tag_subject' ];
		
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$number;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['subject_perpage']; // TODO
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=tags&amp;show=1&amp;id=' . $MySmartBB->_GET['id'];
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->filter = "tag_id='" . $MySmartBB->_GET['id'] . "'";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		$MySmartBB->template->assign( 'tag', $tag_info[ 'tag' ] );
		
		$MySmartBB->template->display('tags_show_subject');
	}
}

?>
