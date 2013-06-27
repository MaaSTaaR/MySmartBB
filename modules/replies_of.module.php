<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartRepliesOfMOD' );

class MySmartRepliesOfMOD
{
	private $username;
	private $curr_page;
	
	public function run( $username, $curr_page = 1 )
	{
		global $MySmartBB;
		
		$this->username = $username;
		$this->curr_page = (int) $curr_page;
		
		// ... //
		
		$filter = " AND (topics.delete_topic<>'1'";
		
		if ( is_array( $MySmartBB->_CONF[ 'forbidden_forums' ] ) and sizeof( $MySmartBB->_CONF[ 'forbidden_forums' ] ) > 0 )
			foreach ( $MySmartBB->_CONF[ 'forbidden_forums' ] as $forum_id )
				$filter .= " AND topics.section<>'" . (int) $forum_id . "'";
		
		$filter .= ')';
		
		// ... //
		
		$MySmartBB->rec->select = 'id,username';
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $this->username . "'";
		
		$member = $MySmartBB->rec->getInfo();
		
		if ( !$member )
			$MySmartBB->func->error( 'المعذرة، العضو المطلوب غير موجود' );
		
		// ... //
		
		// TODO : Should be replaced with getPublicRepliesList().
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ] . ' AS topics,' . $MySmartBB->table[ 'reply' ] . ' AS replies';
		$MySmartBB->rec->filter = "replies.writer='" . $member[ 'username' ] . "' AND replies.subject_id=topics.id" . $filter;
		
		$replies_num = $MySmartBB->rec->getNumber();
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'replies_res' ] = '';
		
		$MySmartBB->rec->select = 'topics.title AS topic_title, topics.id AS topic_id, topics.writer AS topic_writer, topics.section AS section, replies.id AS reply_id, replies.write_time AS reply_time, replies.text AS reply_text';
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ] . ' AS topics,' . $MySmartBB->table[ 'reply' ] . ' AS replies';
		$MySmartBB->rec->filter = "replies.writer='" . $member[ 'username' ] . "' AND replies.subject_id=topics.id" . $filter;
		$MySmartBB->rec->order = "replies.id DESC";
		
		$MySmartBB->rec->result = 	&$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'replies_res' ];
		
		$MySmartBB->rec->pager 					= 	array();
		$MySmartBB->rec->pager[ 'total' ]		= 	$replies_num;
		$MySmartBB->rec->pager[ 'perpage' ] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MySmartBB->rec->pager[ 'curr_page' ] 	= 	$this->curr_page;
		$MySmartBB->rec->pager[ 'prefix' ]		=	$MySmartBB->_CONF[ 'init_path' ] . 'replies_of/' . $member[ 'username' ] . '/';
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->rec->setInfoCallback( array( 'MySmartRepliesOfMOD', 'rowsProcessCB' ) );
		
		// ... //
		
		$MySmartBB->template->assign( 'pager', $MySmartBB->pager->show() );
		$MySmartBB->template->assign( 'username', $member[ 'username' ] );
		
		$MySmartBB->func->showHeader( 'ردود العضو ' . $member[ 'username' ] );
		
		$MySmartBB->template->display( 'replies_of' );
	}
	
	public function rowsProcessCB( $row )
	{
		global $MySmartBB;
	
		$row[ 'reply_date' ] = $MySmartBB->func->date( $row[ 'reply_date' ] );
		
		$splitted = $MySmartBB->func->splitText( $row[ 'reply_text' ], 50 );

		if ( $splitted )
			$row[ 'reply_text' ] .= ' ...';
		
		$row[ 'reply_text' ] = nl2br( $row[ 'reply_text' ] );
	}
}

?>