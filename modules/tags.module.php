<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartTagsMOD' );

class MySmartTagsMOD
{
	private $id;
	private $curr_page;
	
	public function run( $id, $title = null, $curr_page = 1 )
	{
		global $MySmartBB;
		
		$this->id = (int) $id;
		$this->curr_page = (int) $curr_page;
		
		$MySmartBB->loadLanguage( 'tags' );
		
		$this->_show();		
	}
	
	private function _show()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $this->id ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'tag' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "'";
		
		$tag_info = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$tag_info )
			$MySmartBB->func->error( $MySmartBB->lang[ 'tag_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'tag_subject' ];
		$MySmartBB->rec->filter = "tag_id='" . $this->id . "'";
		
		$number = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'tags' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'tag_subject' ];
		
		$MySmartBB->rec->pager 					= 	array();
		$MySmartBB->rec->pager[ 'total' ]		= 	$number;
		$MySmartBB->rec->pager[ 'perpage' ] 	= 	$MySmartBB->_CONF[ 'info_row' ][ 'subject_perpage' ];
		$MySmartBB->rec->pager[ 'curr_page' ] 	= 	$this->curr_page;
		$MySmartBB->rec->pager[ 'prefix' ] 		= 	$MySmartBB->_CONF[ 'init_path' ] . 'tags/' . $this->id . '/' . $tag_info[ 'tag' ] . '/';
		
		$MySmartBB->rec->filter = "tag_id='" . $this->id . "'";
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->template->assign( 'pager', $MySmartBB->pager->show() );
		$MySmartBB->template->assign( 'tag', $tag_info[ 'tag' ] );
		
		$MySmartBB->template->display( 'tags_show_subject' );
	}
}

?>
