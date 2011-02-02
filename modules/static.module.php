<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['MISC'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartStaticMOD');

class MySmartStaticMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_showStatic();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter(); 
	}
	
	private function _showStatic()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('الاحصائيات');
		
		$StaticInfo = array();
		
		/**
		 * Get the age of the forum and install date
		 */
		$StaticInfo['Age'] 			= 	$MySmartBB->misc->getForumAge( $MySmartBB->_CONF['info_row']['create_date'] );
		$StaticInfo['InstallDate']	=	$MySmartBB->func->date( $MySmartBB->_CONF['info_row']['create_date'] );
		
		/**
		 * Get the number of members , subjects , replies , active members and sections
		 */
		$StaticInfo['GetMemberNumber']	= $MySmartBB->_CONF['info_row']['member_number'];
		$StaticInfo['GetSubjectNumber'] = $MySmartBB->_CONF['info_row']['subject_number'];
		$StaticInfo['GetReplyNumber']	= $MySmartBB->_CONF['info_row']['reply_number'];
		$StaticInfo['GetActiveMember']	= $MySmartBB->member->getActiveMemberNumber();
		
		$MySmartBB->rec->filter = "parent<>'0'";
		
		$StaticInfo['GetSectionNumber']	= $MySmartBB->section->getSectionNumber();
			
		/**
		 * Get the writer of oldest subject , the most subject of riplies and the newer subject
		 * should be in cache
		 */
		 
		$MySmartBB->rec->order = "id ASC";
		$MySmartBB->rec->limit = '1';
		
		$GetOldest = $MySmartBB->subject->getSubjectInfo();
		$StaticInfo['OldestSubjectWriter'] = $GetOldest['writer'];
		
		$MySmartBB->rec->order = "id DESC";
		$MySmartBB->rec->limit = '1';
		
		$GetNewer = $MySmartBB->subject->getSubjectInfo();
		$StaticInfo['NewerSubjectWriter'] = $GetNewer['writer'];

		$MySmartBB->rec->order = "visitor DESC";
		$MySmartBB->rec->limit = '1';
		
		$GetMostVisit = $MySmartBB->subject->getSubjectInfo();
		$StaticInfo['MostSubjectWriter'] = $GetMostVisit['writer'];
		
		$MySmartBB->template->assign('StaticInfo',$StaticInfo);
		
		/**
		 * Get top ten list of member who have big posts
		 */
		$MySmartBB->_CONF['template']['res']['topten_res'] = '';
		
		$MySmartBB->rec->order = "posts DESC";
		$MySmartBB->rec->limit = '10';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['topten_res'];
		
		$MySmartBB->member->getMemberList();
		
		/**
		 * Get top ten list of subjects which have big replies
		 */
		$MySmartBB->_CONF['template']['res']['topsubject_res'] = '';
		
		$MySmartBB->rec->order = "reply_number DESC";
		$MySmartBB->rec->limit = '10';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['topsubject_res'];
		
		$MySmartBB->subject->getSubjectList();
		
		/**
		 * Get top ten list of subjects which have big visitors
		 */
		$MySmartBB->_CONF['template']['res']['topvisit_res'] = '';
		
		$MySmartBB->rec->order = "visitor DESC";
		$MySmartBB->rec->limit = '10';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['topvisit_res'];
		
		$MySmartBB->subject->getSubjectList();
		
		$MySmartBB->template->display('static');
	}
}

?>
