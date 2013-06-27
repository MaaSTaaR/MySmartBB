<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartTopicsOfMOD' );

class MySmartTopicsOfMOD
{
	private $username;
	private $curr_page;
	
	public function run( $username, $curr_page = 1 )
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'subject' );
		
		$this->username = $username;
		$this->curr_page = (int) $curr_page;
		
		// ... //
		
		$MySmartBB->rec->select = 'id,username';
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $this->username . "'";
		
		$member = $MySmartBB->rec->getInfo();
		
		if ( !$member )
			$MySmartBB->func->error( 'المعذرة، العضو المطلوب غير موجود' );
		
		// ... //
		
		$topics_num = $MySmartBB->subject->getPublicTopicList( "writer='" . $member[ 'username' ] . "'", true );
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'topics_res' ] = '';
		
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->result = 	&$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'topics_res' ];
		
		$MySmartBB->rec->pager 					= 	array();
		$MySmartBB->rec->pager[ 'total' ]		= 	$topics_num;
		$MySmartBB->rec->pager[ 'perpage' ] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager[ 'curr_page' ] 	= 	$this->curr_page;
		$MySmartBB->rec->pager[ 'prefix' ]		=	$MySmartBB->_CONF[ 'init_path' ] . 'topics_of/' . $member[ 'username' ] . '/';
		
		$MySmartBB->subject->getPublicTopicList( "writer='" . $member[ 'username' ] . "'" );
		
		$MySmartBB->rec->setInfoCallback( array( 'MySmartTopicsOfMOD', 'rowsProcessCB' ) );
		
		// ... //
		
		$MySmartBB->template->assign( 'pager', $MySmartBB->pager->show() );
		$MySmartBB->template->assign( 'username', $member[ 'username' ] );
		
		$MySmartBB->func->showHeader( 'مواضيع العضو ' . $member[ 'username' ] );
		
		$MySmartBB->template->display( 'topics_of' );
	}
	
	public function rowsProcessCB( $row )
	{
		global $MySmartBB;
	
		$row[ 'write_date' ] = $MySmartBB->func->date( $row[ 'native_write_time' ] );
	}
}

?>