<?php

//////////

define('IN_MYSMARTBB',true);

//////////

// $_GET['page']		=>	file name
$modules 					= 	array();
$modules['index'] 			= 	'main.module.php';
$modules['options'] 		= 	'options.module.php';
$modules['login'] 			= 	'login.module.php';
$modules['announcement'] 	= 	'announcement.module.php';
$modules['pages'] 			= 	'pages.module.php';
$modules['ads'] 			= 	'ads.module.php';
$modules['member'] 			= 	'member.module.php';
$modules['usertitle'] 		= 	'usertitle.module.php';
$modules['subject'] 		= 	'subject.module.php';
$modules['trash'] 			= 	'trash.module.php';
$modules['extension'] 		= 	'extension.module.php';
$modules['toolbox'] 		= 	'toolbox.module.php';
$modules['style'] 			= 	'style.module.php';
$modules['smile'] 			= 	'smile.module.php';
$modules['icon'] 			= 	'icon.module.php';
$modules['avatar'] 			= 	'avatar.module.php';
$modules['fixup'] 			= 	'fixup.module.php';
$modules['template'] 		= 	'template.module.php';
$modules['sections'] 		= 	'sections.module.php';
$modules['cp_options'] 		= 	'cp_options.module.php';
$modules['ajax'] 			= 	'ajax.module.php';
$modules['moderators']		=	'moderators.module.php';
$modules['groups']			=	'groups.module.php';
$modules['logout']			=	'logout.module.php';
$modules['note'] 			= 	'notes.module.php';
$modules['plugins'] 		= 	'plugins.module.php';
$modules['forums'] 			= 	'forums.module.php';
$modules['forums_add'] 		= 	'forums_add.module.php';
$modules['forums_edit'] 	= 	'forums_edit.module.php';
$modules['forums_del'] 		= 	'forums_del.module.php';
$modules['forums_sort'] 	= 	'forums_sort.module.php';
$modules['forums_groups'] 	= 	'forums_groups.module.php';
$modules['groups_add'] 		= 	'groups_add.module.php';
$modules['groups_edit'] 	= 	'groups_edit.module.php';
$modules['groups_del'] 		= 	'groups_del.module.php';
$modules['sections_add'] 	= 	'sections_add.module.php';
$modules['sections_edit'] 	= 	'sections_edit.module.php';
$modules['sections_del'] 	= 	'sections_del.module.php';
$modules['sections_sort'] 	= 	'sections_sort.module.php';
$modules['sections_groups'] = 	'sections_groups.module.php';
$modules['member_add'] 		= 	'member_add.module.php';
$modules['member_merge'] 	= 	'member_merge.module.php';
$modules['member_edit'] 	= 	'member_edit.module.php';
$modules['member_del'] 		= 	'member_del.module.php';
$modules['member_search'] 	= 	'member_search.module.php';

//////////

$page = empty($_GET['page']) ? 'index' : $_GET['page'];

//////////

$req_file = false;

if (array_key_exists($page,$modules))
{
	$req_file = $modules[$page];
}

//////////

if ($req_file != false)
{
	//////////
	
	if (!file_exists('./modules/admin/' . $req_file))
	{
		die('المعذره .. يبدو ان هناك خطأ في النظام، الملف المطلوب غير موجود');
	}
	
	//////////
	
	require_once('./modules/admin/' . $req_file);
	
	//////////
	
	$class_name = CLASS_NAME;
	
	$class_name = new $class_name;
	
	$class_name->run();
	
	//////////
}
else
{
	die('<div align="center">المعذره .. الصفحه المطلوبه غير موجوده</div>');
}

//////////


?>
