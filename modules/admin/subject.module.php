<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartSubjectMOD');
	
class MySmartSubjectMOD extends _func
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['close'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_closeSubject();
				}
			}
			elseif ($MySmartBB->_GET['attach'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_attachSubject();
				}
			}
			elseif ($MySmartBB->_GET['mass_del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_massDelMain();
				}
				elseif ($MySmartBB->_GET['confirm'])
				{
					$this->_massDelConfirm();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_massDelStart();
				}
			}
			elseif ($MySmartBB->_GET['mass_move'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_massMoveMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_massMoveStart();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _closeSubject()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->filter = "close='1'";
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->subject->getSubjectList();
		
		$MySmartBB->template->display('subjects_closed');
	}
	
	private function _attachSubject()
	{
		global $MySmartBB;

		$MySmartBB->rec->filter = "attach_subject='1'";
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->subject->getSubjectList();
		
		$MySmartBB->template->display('subjects_attach');		
	}
	
	private function _massDelMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->section->getSectionsList();
		
		$MySmartBB->template->display('subjects_mass_del');
	}
	
	private function _massDelConfirm()
	{
		global $MySmartBB;
		
		$this->check_section_by_id($MySmartBB->_CONF['template']['Inf'],$z);
		
		$MySmartBB->template->display('subjects_mass_del_confirm');
	}
	
	private function _massDelStart()
	{
		global $MySmartBB;
		
		$this->check_section_by_id( $SectionInf, $z );
		
		$del = array();
		
		$del[0] = $MySmartBB->subject->massDeleteSubject( $SectionInf['id'] );
		
		if ($del[0])
		{
			$del[1] = $MySmartBB->reply->massDeleteReply( $SectionInf['id'] );
			
			if ($del[1])
			{
				$MySmartBB->func->msg('تم حذف المواضيع بنجاح !');
				$MySmartBB->func->goto('admin.php?page=subject&amp;mass_del=1&amp;main=1');
			}
		}
	}
	
	private function _massMoveMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->filter = "parent<>'0'";
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->section->getSectionsList();
		
		$MySmartBB->template->display('subjects_mass_move');
	}
		
	private function _massMoveStart()
	{
		global $MySmartBB;
		
		$this->check_section_by_id($FromInf,$ToInf,true);
		
		$move = array();
		
		$move[0] = $MySmartBB->subject->massMoveSubject( $ToInf['id'], $FromInf['id'] );
		
		if ($move[0])
		{
			$move[1] = $MySmartBB->reply->massMoveReply( $ToInf['id'], $FromInf['id'] );
			
			if ($move[1])
			{
				$MySmartBB->func->msg('تم نقل المواضيع بنجاح !');
				$MySmartBB->func->goto('admin.php?page=subject&amp;mass_move=1&amp;main=1');
			}
		}
	}
}

class _func
{
	function check_section_by_id( &$Inf, &$ToInf, $move = false )
	{
		global $MySmartBB;
		
		if (!$move)
		{
			if (empty($MySmartBB->_GET['id']))
			{
				$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
			}
		
			$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
			
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
			
			$Inf = $MySmartBB->section->getSectionInfo();
			
			if ($Inf == false)
			{
				$MySmartBB->func->error('المنتدى المطلوب غير موجود');
			}
		}
		else
		{
			if (empty($MySmartBB->_POST['from'])
				or empty($MySmartBB->_POST['to']))
			{
				$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
			}
		
			$MySmartBB->_POST['from'] = (int) $MySmartBB->_POST['from'];
			$MySmartBB->_POST['to'] = (int) $MySmartBB->_POST['to'];
			
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['from'] . "'";
			
			$Inf = $MySmartBB->section->getSectionInfo();
			
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['to'] . "'";
			
			$ToInf = $MySmartBB->section->getSectionInfo();
			
			if ($Inf == false)
			{
				$MySmartBB->func->error('المنتدى المطلوب غير موجود');
			}
			elseif ($ToInf == false)
			{
				$MySmartBB->func->error('المنتدى المطلوب غير موجود');
			}
		}
	}
}

?>
