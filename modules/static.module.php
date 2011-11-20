<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartStaticMOD');

class MySmartStaticMOD
{
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'static' );
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_showStatic();
		}
		else
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->func->getFooter(); 
	}
	
	private function _showStatic()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'statistics' ] );
		
		$StaticInfo = array();
		
		/**
		 * Get the age of the forum and install date
		 */
		//$StaticInfo['Age'] 			= 	$MySmartBB->misc->getForumAge( $MySmartBB->_CONF['info_row']['create_date'] );
		$StaticInfo['InstallDate']	=	$MySmartBB->func->date( $MySmartBB->_CONF['info_row']['create_date'] );
		
		/**
		 * Get the number of members , subjects , replies , active members and sections
		 */
		$StaticInfo['GetMemberNumber']	= $MySmartBB->_CONF['info_row']['member_number'];
		$StaticInfo['GetSubjectNumber'] = $MySmartBB->_CONF['info_row']['subject_number'];
		$StaticInfo['GetReplyNumber']	= $MySmartBB->_CONF['info_row']['reply_number'];
		// TODO: There is an error here.
		//$StaticInfo['GetActiveMember']	= $MySmartBB->member->getActiveMemberNumber();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent<>'0'";
		
		$StaticInfo['GetSectionNumber']	= $MySmartBB->rec->getNumber();
			
		/**
		 * Get the writer of oldest subject , the most subject of riplies and the newer subject
		 * should be in cache
		 */
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->order = "id ASC";
		$MySmartBB->rec->limit = '1';
		
		$GetOldest = $MySmartBB->rec->getInfo();
		$StaticInfo['OldestSubjectWriter'] = $GetOldest['writer'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->order = "id DESC";
		$MySmartBB->rec->limit = '1';
		
		$GetNewer = $MySmartBB->rec->getInfo();
		$StaticInfo['NewerSubjectWriter'] = $GetNewer['writer'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->order = "visitor DESC";
		$MySmartBB->rec->limit = '1';
		
		$GetMostVisit = $MySmartBB->rec->getInfo();
		$StaticInfo['MostSubjectWriter'] = $GetMostVisit['writer'];
		
		$MySmartBB->template->assign('StaticInfo',$StaticInfo);
		
		/**
		 * Get top ten list of member who have big posts
		 */
		$MySmartBB->_CONF['template']['res']['topten_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->order = "posts DESC";
		$MySmartBB->rec->limit = '10';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['topten_res'];
		
		$MySmartBB->rec->getList();
		
		/**
		 * Get top ten list of subjects which have big replies
		 */
		$MySmartBB->_CONF['template']['res']['topsubject_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->order = "reply_number DESC";
		$MySmartBB->rec->limit = '10';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['topsubject_res'];
		
		$MySmartBB->rec->getList();
		
		/**
		 * Get top ten list of subjects which have big visitors
		 */
		$MySmartBB->_CONF['template']['res']['topvisit_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->order = "visitor DESC";
		$MySmartBB->rec->limit = '10';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['topvisit_res'];
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('static');
	}
}

?>
