<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartTagsMOD' );

class MySmartTagsMOD
{
	private $id;
	
	public function run( $id )
	{
		global $MySmartBB;
		
		$this->id = (int) $id;
		
		$MySmartBB->loadLanguage( 'tags' );
		
		$this->_show();
		
		$MySmartBB->func->getFooter();
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
		
		$MySmartBB->_GET[ 'count' ] = ( !isset( $MySmartBB->_GET[ 'count' ] ) ) ? 0 : $MySmartBB->_GET[ 'count' ];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'tag_subject' ];
		$MySmartBB->rec->filter = "tag_id='" . $this->id . "'";
		
		$number = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'tags' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'tag_subject' ];
		
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$number;
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['subject_perpage']; // TODO
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=tags&amp;show=1&amp;id=' . $this->id;
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->filter = "tag_id='" . $this->id . "'";
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->template->assign( 'pager', $MySmartBB->pager->show() );
		$MySmartBB->template->assign( 'tag', $tag_info[ 'tag' ] );
		
		$MySmartBB->template->display( 'tags_show_subject' );
	}
}

?>
