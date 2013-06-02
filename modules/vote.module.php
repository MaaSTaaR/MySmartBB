<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include('common.module.php');

define('CLASS_NAME','MySmartVoteMOD');

class MySmartVoteMOD
{
	private $id;
	
	public function run()
	{
		global $MySmartBB;
		
		$this->id = (int) $id;
		
		$MySmartBB->loadLanguage( 'vote' );
		
		$MySmartBB->load( 'poll' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'vote' ] );
		
		$this->_start();
		
		$MySmartBB->func->getFooter();
	}
	
	private function _start()
	{
		global $MySmartBB;
		
		if ( empty( $this->id ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
			
		if ( empty( $MySmartBB->_POST[ 'answer' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang[ 'please_choose_answer' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'poll' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "'";
		
		$Poll = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$Poll )
			$MySmartBB->func->error( $MySmartBB->lang[ 'vote_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->rec->select = 'section';
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $Poll[ 'subject_id' ] . "'";
		
		$subject = $MySmartBB->rec->getInfo();
		
		if ( !$subject )
			$MySmartBB->func->error( $MySmartBB->lang[ 'topic_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $subject[ 'section' ] . "' AND group_id='" . $MySmartBB->_CONF[ 'group_info' ][ 'id' ] . "'";
		
		$permissions = $MySmartBB->rec->getInfo();
		
		if ( !$permissions[ 'vote_poll' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission_to_vote' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'vote' ];
		$MySmartBB->rec->filter = "poll_id='" . $this->id . "' AND member_id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] .  "'";
		
		$Vote = $MySmartBB->rec->getNumber();
		
		if ( $Vote > 0 )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_vote_multi' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'vote' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "'";
		$MySmartBB->rec->fields = array(	'poll_id'	=>	$this->id,
											'member_id'	=>	$MySmartBB->_CONF[ 'member_row' ][ 'id' ],
											'username'	=>	$MySmartBB->_CONF[ 'member_row' ][ 'username' ]	);
		
		$insert = $MySmartBB->rec->insert();
		
		// ... //
		
		if ( $insert )
		{
			$update = $MySmartBB->poll->updateResults( $Poll, $MySmartBB->_POST[ 'answer' ] );
		
			if ( $update )
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'vote_succeed' ] );
				$MySmartBB->func->move( 'index.php?page=topic&amp;show=1&amp;id=' . $Poll['subject_id'] );
			}
		}
	}
}

?>
