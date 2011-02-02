<?php

/** PHP5 **/

$CALL_SYSTEM 			= 	array();
$CALL_SYSTEM['SUBJECT'] = 	true;
$CALL_SYSTEM['SECTION'] = 	true;
$CALL_SYSTEM['ATTACH'] 	= 	true;
$CALL_SYSTEM['PM'] 		= 	true;

(!defined('IN_MYSMARTBB')) ? die() : '';

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartDownloadMOD');

class MySmartDownloadMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['subject'])
		{
			$this->_downloadSubject();
		}
		elseif ($MySmartBB->_GET['attach'])
		{
			$this->_downloadAttach();
		}
		elseif ($MySmartBB->_GET['pm'])
		{
			$this->_downloadPM();
		}
	}
	
	private function _downloadSubject()
	{
		global $MySmartBB;
		
		// ... //
		
		// Clean id from any string, that will protect us
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		// If the id is empty, so stop the page
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره المسار المتبع غير صحيح');
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject']
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$SubjectInfo = $MySmartBB->rec->getInfo();
		
		if ($SubjectInfo['delete_topic'] 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			$MySmartBB->func->error('الموضوع المطلوب منقول إلى سلّة المحذوفات');
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $SubjectInfo['section'] . "'";
		
		$SectionInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $SectionInfo['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		$SectionGroup = $MySmartBB->rec->getInfo();
		
		if (!$SectionGroup['view_section'])
		{
			$MySmartBB->func->error('المعذره لا يمكنك عرض هذا الموضوع');
		}
		
		// ... //
		
		$filename = str_replace(' ','_',$SubjectInfo['title']);
		$filename .= '.txt';
		
		header('Content-Disposition: attachment;filename=' . $filename);
		header('Content-type: text/plain');
		
		echo 'موضوع بعنوان : ' . $SubjectInfo['title'] . '
الكاتب : ' . $SubjectInfo['writer'] . '

' . $SubjectInfo['text'];
	}
	
	private function _downloadAttach()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره المسار المتبع غير صحيح');
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$AttachInfo = $MySmartBB->rec->getInfo();
		
		// ... //
				
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $AttachInfo['subject_id'] . "'";
		
		$SubjectInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		// The subject isn't available
		if ($SubjectInfo['delete_topic'] 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			$MySmartBB->func->error('الموضوع المطلوب منقول إلى سلّة المحذوفات');
		}
		
		// ... //
		
		// We can't stop the admin :)
		if (!$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
			$MySmartBB->rec->filter = "section_id='" . $SubjectInfo['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
			
			$SectionGroup = $MySmartBB->rec->getInfo();
		
			// ... //
		
			// The user can't show this subject
			if (!$SectionGroup['view_section'])
			{
				$MySmartBB->func->error('المعذره لا يمكنك عرض هذا الموضوع');
			}
		
			// The user can't download this attachment
			if (!$SectionGroup['download_attach'])
			{
				$MySmartBB->func->error('المعذره لا يمكنك تحميل هذا المرفق');
			}
			
			// These checks are special for members	
			if ($MySmartBB->_CONF['member_permission'])
			{
				// No enough posts
				if ($MySmartBB->_CONF['group_info']['download_attach_number'] > $MySmartBB->_CONF['member_row']['posts'])
				{
					$MySmartBB->func->error('يجب ان تكون عدد مشاركاتك ' . $MySmartBB->_CONF['group_info']['download_attach_number']);
				}
			}
		}

		// ... //
		
		// Send headers
		
		// File name
		header('Content-Disposition: attachment;filename=' . $AttachInfo['filename']);
		
		// File size (bytes)
		header('Content-Length: ' . $AttachInfo['filesize']);
		
		// MIME (TODO : dynamic)
		header('Content-type: application/download');
		
		// ... //
		
		// Count a new download
		$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
		$MySmartBB->rec->fields = array(	'visitor'	=>	$AttachInfo['visitor'] + 1);
		$MySmartBB->rec->filter = "id='" . $AttachInfo['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		//////////
		
		// File content
		file('./' . $AttachInfo['filepath']);
		
		//////////
	}
	
	private function _downloadPM()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))		
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "' AND user_to='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		
		$MsgInfo = $MySmartBB->rec->getInfo();
																		
		if (!$MsgInfo)
		{
			$MySmartBB->func->error('الرساله المطلوبه غير موجوده');
		}
		
		$MsgInfo['title'] = $MySmartBB->func->cleanVariable($MsgInfo['title'],'html');
		
		$filename = str_replace(' ','_',$MsgInfo['title']);
		$filename .= '.txt';
		
		//////////
		
		// Send headers
		
		// File name
		header('Content-Disposition: attachment;filename=' . $filename);
		
		// MIME
		header('Content-type: text/plain');
		
		//////////
		
		echo 'عنوان الرساله : ' . $MsgInfo['title'] . '
المرسل : ' . $MsgInfo['user_from'] . '

';
		echo $MsgInfo['text'];
	}
}

?>
