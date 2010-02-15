<?php

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['SUBJECT']		=	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.php');

include('../common.php');


function archive_header($title)
{
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	echo '<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ar" lang="ar">';
	echo '<head>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo '<meta name="generator" content="MySmartBB" />';
	include('style.css'); // Quick and Dirty
	echo '<title>' . $title . '</title>';
	echo '</head>';
	
	echo '<body>';
}

if ($common->action == 'index')
{
	archive_header($MySmartBB->_CONF['info_row']['title']);
	
	$forums = array();

	$MySmartBB->functions->GetForumsList($forums);
	
	echo '<ul>';
	
	foreach ($forums as $forum)
	{
		if ($forum['parent'] == 0)
		{
			echo '<li>' . $forum['title'] . '</li>';
		}
		else
		{
			echo '<ul><li><a href="' . $common->url_base . 'forum-' . $forum['id'] . '.html">' . $forum['title'] . '</a></li></ul>';
			
			if (!empty($forum['forums_cache']))
			{
				$cache = unserialize(base64_decode($forum['forums_cache']));
				
				foreach ($cache as $sub)
				{
					echo '<ul><ul><li><a href="' . $common->url_base . 'forum-' . $sub['id'] . '.html">' . $sub['title'] . '</a></li></ul></ul>';
				}
			}
		}
	}
	
	echo '</ul>';
}
elseif ($common->action == 'forum')
{
	//////////
	
	$common->id = $MySmartBB->functions->CleanVariable($common->id,'intval');

	if (empty($common->id))
	{
		$MySmartBB->functions->error('المسار المطلوب غير صحيح');
	}
	
	//////////
	
	$SecArr = array();
	$SecArr['where'] = array();
	$SecArr['where'][0] = array();
	$SecArr['where'][0]['name'] = 'id';
	$SecArr['where'][0]['oper'] = '=';
	$SecArr['where'][0]['value'] = $common->id;
	
	$Section = $MySmartBB->section->GetSectionInfo($SecArr);
	
	if (!$Section)
	{
		$MySmartBB->functions->error('القسم المطلوب غير موجود');
	}
	
	$MySmartBB->functions->CleanVariable($Section,'html');
	$MySmartBB->functions->CleanVariable($Section,'sql');
	
	if (!empty($Section['section_password']))
	{
		$MySmartBB->functions->error('هذا القسم محمي بكلمة مرور');
	}
	
	//////////
	
	$GrpArr = array();
	$GrpArr['where'] = array();
	$GrpArr['where'][0] = array();
	$GrpArr['where'][0]['name'] = 'section_id';
	$GrpArr['where'][0]['oper'] = '=';
	$GrpArr['where'][0]['value'] = $Section['id'];
	
	$GrpArr['where'][1] = array();
	$GrpArr['where'][1]['con'] = 'AND';
	$GrpArr['where'][1]['name'] = 'group_id';
	$GrpArr['where'][1]['oper'] = '=';
	$GrpArr['where'][1]['value'] = $MySmartBB->_CONF['group_info']['id'];
	
	$Group = $MySmartBB->group->GetSectionGroupInfo($GrpArr);
	
	if (!$Group)
	{
		$MySmartBB->functions->error('المجموعه غير موجوده');
	}
	
	if (!$Group['view_section'])
	{
		$MySmartBB->functions->error('غير مسموح لك بعرض هذا القسم');
	}
	
	//////////
	
	// Header
	
	archive_header($Section['title']);
	
	// Address bar
	
	echo '<a href="./">' . $MySmartBB->_CONF['info_row']['title'] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $Section['title'];
	
	//////////
	
	$SubjectArr = array();
	$SubjectArr['where'] = array();
	$SubjectArr['where'][0] = array();
	$SubjectArr['where'][0]['name'] = 'section';
	$SubjectArr['where'][0]['oper'] = '=';
	$SubjectArr['where'][0]['value'] = $Section['id'];
	
	$SubjectArr['where'][1] 			= 	array();
	$SubjectArr['where'][1]['con']		=	'AND';
	$SubjectArr['where'][1]['name'] 	= 	'delete_topic';
	$SubjectArr['where'][1]['oper'] 	= 	'<>';
	$SubjectArr['where'][1]['value'] 	= 	'1';
	
	$SubjectArr['where'][2] 			= 	array();
	$SubjectArr['where'][2]['con']		=	'AND';
	$SubjectArr['where'][2]['name'] 	= 	'review_subject';
	$SubjectArr['where'][2]['oper'] 	= 	'<>';
	$SubjectArr['where'][2]['value'] 	= 	'1';
	
	if ($Section['hide_subject'] 
		and !$MySmartBB->_CONF['group_info']['admincp_allow'])
	{
		$SubjectArr['where'][3] 			= 	array();
		$SubjectArr['where'][3]['con'] 		= 	'AND';
		$SubjectArr['where'][3]['name'] 	= 	'writer';
		$SubjectArr['where'][3]['oper'] 	= 	'=';
		$SubjectArr['where'][3]['value'] 	= 	$MySmartBB->_CONF['member_row']['username'];
	}
	
	$SubjectArr['order'] = array();
	$SubjectArr['order']['field'] = 'id';
	$SubjectArr['order']['type'] = 'ASC';
	
	$SubjectArr['proc'] = array();
	$SubjectArr['proc']['*'] = array('method'=>'clean','param'=>'html');
	
	$Subjects = $MySmartBB->subject->GetSubjectList($SubjectArr);
	
	echo '<ul>';
	
	foreach ($Subjects as $Subject)
	{
		echo '<li><a href="' . $common->url_base . 'topic-' . $Subject['id'] . '.html">' . $Subject['title'] . '</a></li>';
	}
	
	echo '</ul>';
}
elseif ($common->action == 'topic')
{
	//////////
	
	$common->id = $MySmartBB->functions->CleanVariable($common->id,'intval');
	
	if (empty($common->id))
	{
		$MySmartBB->functions->error('المسار المطلوب غير صحيح');
	}
	
	//////////
	
	$SubjectArr = array();
	$SubjectArr['where'] = array();
	$SubjectArr['where'][0] = array();
	$SubjectArr['where'][0]['name'] = 'id';
	$SubjectArr['where'][0]['oper'] = '=';
	$SubjectArr['where'][0]['value'] = $common->id;
	
	$Subject = $MySmartBB->subject->GetSubjectInfo($SubjectArr);
	
	if (!$Subject)
	{
		$MySmartBB->functions->error('الموضوع المطلوب غير موجود');
	}
	
	$MySmartBB->functions->CleanVariable($Subject,'html');
	
	//////////
	
	$SecArr = array();
	$SecArr['where'] = array();
	$SecArr['where'][0] = array();
	$SecArr['where'][0]['name'] = 'id';
	$SecArr['where'][0]['oper'] = '=';
	$SecArr['where'][0]['value'] = $Subject['section'];
	
	$Section = $MySmartBB->section->GetSectionInfo($SecArr);
	
	if (!$Section)
	{
		$MySmartBB->functions->error('القسم غير موجود');
	}
	
	$MySmartBB->functions->CleanVariable($Section,'html');
	
	//////////
	
	$GrpArr = array();
	$GrpArr['where'] = array();
	$GrpArr['where'][0] = array();
	$GrpArr['where'][0]['name'] = 'group_id';
	$GrpArr['where'][0]['oper'] = '=';
	$GrpArr['where'][0]['value'] = $MySmartBB->_CONF['group_info']['id'];
	
	$GrpArr['where'][1] = array();
	$GrpArr['where'][1]['con'] = 'AND';
	$GrpArr['where'][1]['name'] = 'section_id';
	$GrpArr['where'][1]['oper'] = '=';
	$GrpArr['where'][1]['value'] = $Section['id'];
	
	$Group = $MySmartBB->group->GetSectionGroupInfo($GrpArr);
	
	if (!$Group['view_section'])
	{
		$MySmartBB->functions->error('غير مسموح لك بعرض هذا القسم');
	}
	
	//////////
	
	// Header
	
	archive_header($Subject['title']);
	
	// Address bar
	
	echo '<a href="./">' . $MySmartBB->_CONF['info_row']['title'] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' <a href="forum-' . $Section['id'] . '.html>' . $Section['title'] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' ' . $Subject['title'];
	
	//////////
	
	$write_date = $MySmartBB->functions->date($Subject['native_write_time']);
	
	$Subject['text'] = nl2br($Subject['text']);
	
	echo '<h1>' . $Subject['title'] . '</h1>';
	echo '<hr />';
	echo '<p>';
	echo 'الكاتب : ' . $Subject['writer'];
	echo '<br />';
	echo 'بتاريخ : ' . $write_date;
	echo '</p>';
	echo '<p>';
	echo $Subject['text'];
	echo '</p>';
}
else
{
	die('طلب غير صحيح');
}

echo '</body>';
echo '</html>';

?>
