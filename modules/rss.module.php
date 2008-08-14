<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['SECTION'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 		= 	true;

include('common.php');

define('CLASS_NAME','MySmartRSSMOD');

class MySmartRSSMOD
{
	function run()
	{
		global $MySmartBB;
		
		echo '<?xml version="1.0"?>';
		echo '<rss version="2.0">';
		echo '<channel>';
		echo '<title>' . $MySmartBB->_CONF['info_row']['title'] . '</title>';
		echo '<link>' . $MySmartBB->functions->GetForumAdress() . '</link>';
		echo '<description>خلاصات آخر المواضيع النشطه في ' . $MySmartBB->_CONF['info_row']['title'] . '</description>';
		
		if ($MySmartBB->_GET['subject'])
		{
			$this->_SubjectRSS();
		}
		elseif ($MySmartBB->_GET['section'])
		{
			$this->_SectionRSS();
		}
		
		echo '</channel>';
		echo '</rss>';
	}
	
	function _SubjectRSS()
	{
		global $MySmartBB;
		
		$SubjectArr = array();
		
		$SubjectArr['where'] 				= 	array();
				
		$SubjectArr['where'][0] 			= 	array();
		$SubjectArr['where'][0]['name'] 	= 	'delete_topic';
		$SubjectArr['where'][0]['oper'] 	= 	'<>';
		$SubjectArr['where'][0]['value'] 	= 	'1';
		
		$SubjectArr['where'][1] 			= 	array();
		$SubjectArr['where'][1]['con']		=	'AND';
		$SubjectArr['where'][1]['name'] 	= 	'sec_subject';
		$SubjectArr['where'][1]['oper'] 	= 	'<>';
		$SubjectArr['where'][1]['value'] 	= 	'1';
				
		$SubjectArr['order'] 			= 	array();
		$SubjectArr['order']['field'] 	= 	'write_time';
		$SubjectArr['order']['type'] 	= 	'DESC';
		
		$SubjectArr['limit'] 			= 	'10';
		
		$SubjectArr['proc'] 			= 	array();
		// Ok Mr.XSS go to hell !
		$SubjectArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html'); 
		
		$SubjectList = $MySmartBB->subject->GetSubjectList($SubjectArr);
		
		$size 	= 	sizeof($SubjectList);
		$x		=	0;
		
		while ($x < $size)
		{
			echo '<item>';
			echo '<title>' . $SubjectList[$x]['title'] . '</title>';
			echo '<link>' . $MySmartBB->functions->GetForumAdress() . 'index.php?page=topic&amp;show=1&amp;id=' . $SubjectList[$x]['id'] . '</link>';
			echo '<description>' . $SubjectList[$x]['text'] . '</description>';
			echo '</item>';
			
			$x += 1;
		}
	}
	
	function _SectionRSS()
	{
		global $MySmartBB;
		
		// Clean id from any strings
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		// No _GET['id'] , so ? show a small error :)
		if (empty($MySmartBB->_GET['id']))
		{
			echo '<item>';
			echo '<title>المسار المتبع غير صحيح</title>';
			echo '</item>';
		}
		else
		{
			// Get section information and set it in $this->Section
			$SecArr 			= 	array();
			$SecArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
			
			$Section = $MySmartBB->section->GetSectionInfo($SecArr);
				
			// Clear section information from any denger
			$MySmartBB->functions->CleanVariable($Section,'html');
			
			// Temporary array to save the parameter of GetSectionGroupList() in nice way
			$SecGroupArr 						= 	array();
			$SecGroupArr['where'] 				= 	array();
		
			$SecGroupArr['where'][0]			=	array(	'name' 	=> 'section_id',
															'oper'	=>	'=',
															'value'	=>	$Section['id']);
		
			$SecGroupArr['where'][1]			=	array();
			$SecGroupArr['where'][1]['con']		=	'AND';
			$SecGroupArr['where'][1]['name']	=	'group_id';
			$SecGroupArr['where'][1]['oper']	=	'=';
			$SecGroupArr['where'][1]['value']	=	$MySmartBB->_CONF['group_info']['id'];
		
			
			// Ok :) , the permssion for this visitor/member in this section
			$SectionGroup = $MySmartBB->group->GetSectionGroupInfo($SecGroupArr);
					
			// This section isn't exists
			if (!$Section)
			{
				$MySmartBB->functions->error('القسم المطلوب غير موجود');
			}	
		
			// This member can't view this section
			if ($SectionGroup['view_section'] != 1)
			{
				echo '<item>';
				echo '<title>غير مسموح لك الاطلاع على محتويات هذا المنتدى</title>';
				echo '</item>';
				
				return 0;
			}
			
			// This is main section , so we can't get subjects list from it 
			if ($Section['main_section'])
			{
				echo '<item>';
				echo '<title>هذا المنتدى قسم رئيسي</title>';
				echo '</item>';
				
				return 0;
			}
			
			if (!empty($Section['section_password']))
			{
				echo '<item>';
				echo '<title>هذا المنتدى محمي بكلمة مرور</title>';
				echo '</item>';
				
				return 0;
			}
			
			$SubjectArr = array();
				
			$SubjectArr['where'] 				= 	array();
			
			$SubjectArr['where'][0] 			= 	array();
			$SubjectArr['where'][0]['name'] 	= 	'section';
			$SubjectArr['where'][0]['oper'] 	= 	'=';
			$SubjectArr['where'][0]['value'] 	= 	$MySmartBB->_GET['id'];
			
			$SubjectArr['where'][1] 			= 	array();
			$SubjectArr['where'][1]['con'] 		= 	'AND';
			$SubjectArr['where'][1]['name'] 	= 	'delete_topic';
			$SubjectArr['where'][1]['oper'] 	= 	'<>';
			$SubjectArr['where'][1]['value'] 	= 	'1';
				
			$SubjectArr['order'] 			= 	array();
			$SubjectArr['order']['field'] 	= 	'write_time';
			$SubjectArr['order']['type'] 	= 	'DESC';
			
			$SubjectArr['limit'] 			= 	'10';
		
			$SubjectArr['proc'] 			= 	array();
			// Ok Mr.XSS go to hell !
			$SubjectArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html'); 
		
			$SubjectList = $MySmartBB->subject->GetSubjectList($SubjectArr);
		
			$size 	= 	sizeof($SubjectList);
			$x		=	0;
		
			while ($x < $size)
			{
				echo '<item>';
				echo '<title>' . $SubjectList[$x]['title'] . '</title>';
				echo '<link>' . $MySmartBB->functions->GetForumAdress() . 'index.php?page=topic&amp;show=1&amp;id=' . $SubjectList[$x]['id'] . '</link>';
				echo '<description>' . $SubjectList[$x]['text'] . '</description>';
				echo '</item>';
			
				$x += 1;
			}
		}
	}
}

?>
