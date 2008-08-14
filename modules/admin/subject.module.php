<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;

include('common.php');
	
define('CLASS_NAME','MySmartSubjectMOD');
	
class MySmartSubjectMOD extends _functions
{
	function run()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('header');
		
		if ($MySmartBB->_GET['close'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_CloseSubject();
			}
		}
		elseif ($MySmartBB->_GET['attach'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_AttachSubject();
			}
		}
		elseif ($MySmartBB->_GET['mass_del'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_MassDelMain();
			}
			elseif ($MySmartBB->_GET['confirm'])
			{
				$this->_MassDelConfirm();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_MassDelStart();
			}
		}
		elseif ($MySmartBB->_GET['mass_move'])
		{
			if ($MySmartBB->_GET['main'])
			{
				$this->_MassMoveMain();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_MassMoveStart();
			}
		}
		
		$MySmartBB->template->display('footer');
	}
	
	function _CloseSubject()
	{
		global $MySmartBB;
		
		$CloseArr 							= 	array();
		$CloseArr['proc'] 					= 	array();
		$CloseArr['proc']['*'] 				= 	array('method'=>'clean','param'=>'html');
		
		$CloseArr['where']					=	array();
		$CloseArr['where'][0]				=	array();
		$CloseArr['where'][0]['name']		=	'close';
		$CloseArr['where'][0]['oper']		=	'=';
		$CloseArr['where'][0]['value']		=	'1';
		
		$CloseArr['order']					=	array();
		$CloseArr['order']['field']			=	'id';
		$CloseArr['order']['type']			=	'DESC';
		
		$MySmartBB->_CONF['template']['while']['CloseList'] = $MySmartBB->subject->GetSubjectList($CloseArr);
		
		$MySmartBB->template->display('subjects_closed');
	}
	
	function _AttachSubject()
	{
		global $MySmartBB;

		$AttachArr 							= 	array();
		$AttachArr['proc'] 					= 	array();
		$AttachArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		$AttachArr['where']					=	array();
		$AttachArr['where'][0]				=	array();
		$AttachArr['where'][0]['name']		=	'attach_subject';
		$AttachArr['where'][0]['oper']		=	'=';
		$AttachArr['where'][0]['value']		=	'1';
		
		$AttachArr['order']					=	array();
		$AttachArr['order']['field']		=	'id';
		$AttachArr['order']['type']			=	'DESC';
		
		$MySmartBB->_CONF['template']['while']['AttachList'] = $MySmartBB->subject->GetSubjectList($AttachArr);
		
		$MySmartBB->template->display('subjects_attach');		
	}
	
	function _MassDelMain()
	{
		global $MySmartBB;
		
		$SecArr 					= 	array();
		$SecArr['get_from']			=	'db';
		$SecArr['type']				=	'forums';
		$SecArr['proc'] 			= 	array();
		$SecArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		$SecArr['order']			=	array();
		$SecArr['order']['field']	=	'id';
		$SecArr['order']['type']	=	'DESC';
		
		$MySmartBB->_CONF['template']['while']['SectionList'] = $MySmartBB->section->GetSectionsList($SecArr);
		
		$MySmartBB->template->display('subjects_mass_del');
	}
	
	function _MassDelConfirm()
	{
		global $MySmartBB;
		
		$this->check_section_by_id($MySmartBB->_CONF['template']['Inf'],$z);
		
		$MySmartBB->template->display('subjects_mass_del_confirm');
	}
	
	function _MassDelStart()
	{
		global $MySmartBB;
		
		$this->check_section_by_id($SectionInf,$z);
		
		$del = array();
		
		$del[0] = $MySmartBB->subject->MassDeleteSubject(array('section_id'	=>	$SectionInf['id']));
		
		if ($del[0])
		{
			$del[1] = $MySmartBB->reply->MassDeleteReply(array('section_id'	=>	$SectionInf['id']));
			
			if ($del[1])
			{
				$MySmartBB->functions->msg('تم حذف المواضيع بنجاح !');
				$MySmartBB->functions->goto('admin.php?page=subject&amp;mass_del=1&amp;main=1');
			}
		}
	}
	
	function _MassMoveMain()
	{
		global $MySmartBB;
		
		$SecArr 						= 	array();
		$SecArr['get_from']				=	'db';
		$SecArr['type']					=	'forums';
		$SecArr['proc'] 				= 	array();
		$SecArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		$SecArr['proc']['title'] 		= 	array('method'=>'list','id'=>'id','store'=>'title');
		
		$SecArr['where']				=	array();
		$SecArr['where'][0]				=	array();
		$SecArr['where'][0]['name']		=	'main_section';
		$SecArr['where'][0]['oper']		=	'<>';
		$SecArr['where'][0]['value']	=	1;
		
		$SecArr['order']				=	array();
		$SecArr['order']['field']		=	'id';
		$SecArr['order']['type']		=	'DESC';
		
		$MySmartBB->_CONF['template']['while']['SectionList'] = $MySmartBB->section->GetSectionsList($SecArr);
		
		$MySmartBB->template->display('subjects_mass_move');
	}
		
	function _MassMoveStart()
	{
		global $MySmartBB;
		
		$this->check_section_by_id($FromInf,$ToInf,true);
		
		$move = array();
		
		$move[0] = $MySmartBB->subject->MassMoveSubject(array('from'	=>	$FromInf['id'],'to'	=>	$ToInf['id']));
		
		if ($move[0])
		{
			$move[1] = $MySmartBB->reply->MassMoveReply(array('from'	=>	$FromInf['id'],'to'	=>	$ToInf['id']));
			
			if ($move[1])
			{
				$MySmartBB->functions->msg('تم نقل المواضيع بنجاح !');
				$MySmartBB->functions->goto('admin.php?page=subject&amp;mass_move=1&amp;main=1');
			}
		}
	}
}

class _functions
{
	function check_section_by_id(&$Inf,&$ToInf,$move=false)
	{
		global $MySmartBB;
		
		if (!$move)
		{
			if (empty($MySmartBB->_GET['id']))
			{
				$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
			}
		
			$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
			$SecArr 			= 	array();
			$SecArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
			$Inf = $MySmartBB->section->GetSectionInfo($SecArr);
			
			if ($Inf == false)
			{
				$MySmartBB->functions->error('المنتدى المطلوب غير موجود');
			}
		
			$MySmartBB->functions->CleanVariable($Inf,'html');
		}
		else
		{
			if (empty($MySmartBB->_POST['from'])
				or empty($MySmartBB->_POST['to']))
			{
				$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
			}
		
			$MySmartBB->_POST['from'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['from'],'intval');
			$MySmartBB->_POST['to'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['to'],'intval');
			
			$SecArr 			= 	array();
			$SecArr['where'] 	= 	array('id',$MySmartBB->_GET['from']);
		
			$Inf = $MySmartBB->section->GetSectionInfo($SecArr);
			
			$ToArr 				= 	array();
			$ToArr['where'] 	= 	array('id',$MySmartBB->_GET['to']);
			
			$ToInf = $MySmartBB->section->GetSectionInfo($ToArr);
			
			if ($Inf == false)
			{
				$MySmartBB->functions->error('المنتدى المطلوب غير موجود');
			}
			elseif ($ToInf == false)
			{
				$MySmartBB->functions->error('المنتدى المطلوب غير موجود');
			}
		
			$MySmartBB->functions->CleanVariable($Inf,'html');
			$MySmartBB->functions->CleanVariable($ToInf,'html');
		}
	}
}

?>
