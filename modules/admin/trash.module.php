<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartTrashMOD');

class MySmartTrashMOD extends _func // Yes it's a Smart Trash :D
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
		    $MySmartBB->loadLanguage( 'admin_trash' );
		    
			$MySmartBB->template->display('header');
			
			$MySmartBB->load( 'reply,subject' );
			
			if ($MySmartBB->_GET['subject'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_subjectTrashMain();
				}
				elseif ($MySmartBB->_GET['untrash'])
				{
					$this->_subjectUnTrash();
				}
				elseif ($MySmartBB->_GET['del'])
				{
					if ($MySmartBB->_GET['confirm'])
					{
						$this->_subjectDelMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_subjectDelete();
					}
				}
			}
			elseif ($MySmartBB->_GET['reply'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_replyTrashMain();
				}
				elseif ($MySmartBB->_GET['untrash'])
				{
					$this->_replyUnTrash();
				}
				elseif ($MySmartBB->_GET['del'])
				{
					if ($MySmartBB->_GET['confirm'])
					{
						$this->_replyDelMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_replyDelete();
					}
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _subjectTrashMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "delete_topic='1'";
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('trash_subjects');
	}
	
	private function _subjectUnTrash()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$UnTrash = $MySmartBB->subject->unTrashSubject( $MySmartBB->_GET['id'] );
		
		if ($UnTrash)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'topic_restored' ] );
			$MySmartBB->func->move('admin.php?page=trash&amp;subject=1&amp;main=1');
		}
	}
	
	private function _subjectDelMain()
	{
		global $MySmartBB;
		
		$this->check_subject_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('trash_subject_del');
	}
	
	private function _subjectDelete()
	{
		global $MySmartBB;
		
		$this->check_subject_by_id($Inf);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $Inf['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'topic_deleted' ] );
			$MySmartBB->func->move('admin.php?page=trash&amp;subject=1&amp;main=1');
		}
	}
	
	private function _replyTrashMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->filter = "delete_topic='1'";
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('trash_replies');		
	}
	
	private function _replyUnTrash()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$UnTrash = $MySmartBB->reply->unTrashReply( $MySmartBB->_GET['id'] );
		
		if ($UnTrash)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'reply_restored' ] );
			$MySmartBB->func->move('admin.php?page=trash&amp;reply=1&amp;main=1');
		}
	}
	
	private function _replyDelMain()
	{
		global $MySmartBB;
		
		$this->check_reply_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('trash_reply_del');
	}
	
	private function _replyDelete()
	{
		global $MySmartBB;
		
		$this->check_reply_by_id($ReplyInf);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'reply_deleted' ] );
			$MySmartBB->func->move('admin.php?page=trash&amp;reply=1&amp;main=1');
		}
	}
}

class _func
{
	function check_subject_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		if ($Inf == false)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'topic_doesnt_exist' ] );
		}
	}
	
	function check_reply_by_id(&$ReplyInf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$ReplyInf = $MySmartBB->rec->getInfo();
		
		if ($ReplyInf == false)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'topic_doesnt_exist' ] );
		}
	}
}

?>
