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
		
		if ( $MySmartBB->_GET[ 'index' ] )
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
		
		// ... //
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'statistics' ] );
		
		$StaticInfo = array();
		
		// ... //
		
		// Get the age of the forum and the installation date
		$StaticInfo[ 'Age' ] 			= 	floor( ( $MySmartBB->_CONF[ 'now' ] - $MySmartBB->_CONF['info_row']['create_date'] ) / 60 / 60 / 24 );
		$StaticInfo[ 'InstallDate' ]	=	$MySmartBB->func->date( $MySmartBB->_CONF['info_row']['create_date'] );
		
		// ... //
		
		// Get the number of members, subjects, replies, active members and sections		
		$StaticInfo[ 'GetMemberNumber' ]	= 	$MySmartBB->_CONF[ 'info_row' ][ 'member_number' ];
		$StaticInfo[ 'GetSubjectNumber' ] 	= 	$MySmartBB->_CONF[ 'info_row' ][ 'subject_number' ];
		$StaticInfo[ 'GetReplyNumber' ]		= 	$MySmartBB->_CONF[ 'info_row' ][ 'reply_number' ];
		$StaticInfo[ 'GetActiveMember' ]	= 	$MySmartBB->member->getActiveMemberNumber();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent<>'0'";
		
		$StaticInfo[ 'GetSectionNumber' ]	= $MySmartBB->rec->getNumber();
		
		// ... //
		
		// Get the writer of oldest subject, the most subject of riplies and the newer subject
		
		$MySmartBB->rec->select = 'writer';
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->order = "id ASC";
		$MySmartBB->rec->limit = '1';

		$GetOldest = $MySmartBB->rec->getInfo();
		
		$StaticInfo['OldestSubjectWriter'] = $GetOldest['writer'];
		
		unset( $GetOldest );
		
		// ... //
		
		$MySmartBB->rec->select = 'writer';
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->order = "id DESC";
		$MySmartBB->rec->limit = '1';
		
		$GetNewer = $MySmartBB->rec->getInfo();
		
		$StaticInfo['NewerSubjectWriter'] = $GetNewer['writer'];
		
		unset( $getNewer );
		
		// ... //
		
		$MySmartBB->rec->select = 'writer';
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->order = "visitor DESC";
		$MySmartBB->rec->limit = '1';
		
		$GetMostVisit = $MySmartBB->rec->getInfo();
		
		$StaticInfo['MostSubjectWriter'] = $GetMostVisit['writer'];
		
		unset( $GetMostVisit );
		
		// ... //
		
		$MySmartBB->template->assign('StaticInfo',$StaticInfo);
		
		// ... //
		
		// Get top ten list of members who have most number of posts
		
		$MySmartBB->_CONF['template']['res']['topten_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->order = "posts DESC";
		$MySmartBB->rec->limit = '10';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['topten_res'];
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		// Get top ten list of subjects which have most number of replies
		
		$MySmartBB->_CONF['template']['res']['topsubject_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->order = "reply_number DESC";
		$MySmartBB->rec->limit = '10';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['topsubject_res'];
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		// Get top ten list of subjects which have most number of visitors

		$MySmartBB->_CONF['template']['res']['topvisit_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->order = "visitor DESC";
		$MySmartBB->rec->limit = '10';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['topvisit_res'];
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'statistics_main' );
		
		// ... //
		
		$MySmartBB->template->display( 'static' );
	}
}

?>
