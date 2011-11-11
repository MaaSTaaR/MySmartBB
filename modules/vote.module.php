<?php

// TODO :: groups, visitor

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartVoteMOD');

class MySmartVoteMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'vote' );
		
		$MySmartBB->load( 'poll' );
		
		// Show header with page title
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'vote' ] );
		
		if ($MySmartBB->_GET['start'])
		{
			$this->_start();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _start()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'poll' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$Poll = $MySmartBB->rec->getInfo();
		
		if (!$Poll)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'vote_doesnt_exist' ] );
		}
		
		if (!isset($MySmartBB->_POST['answer']))
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'please_choose_answer' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'vote' ];
		$MySmartBB->rec->filter = "poll_id='" . $MySmartBB->_GET['id'] . "' AND member_id='" . $MySmartBB->_CONF['member_row']['id'] .  "'";
		
		$Vote = $MySmartBB->rec->getInfo();
		
		if ($Vote != false)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_vote_multi' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'vote' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		$MySmartBB->rec->fields = array(	'poll_id'	=>	$MySmartBB->_GET['id'],
											'member_id'	=>	$MySmartBB->_CONF['member_row']['id'],
											'username'	=>	$MySmartBB->_CONF['member_row']['username']	);
		
		$insert = $MySmartBB->rec->insert();
		
		if ( $insert )
		{
			$update = $MySmartBB->poll->updateResults( $Poll, $MySmartBB->_POST[ 'answer' ] );
		
			if ($update)
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'vote_succeed' ] );
				$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $Poll['subject_id']);
			}
		}
	}
}

?>
