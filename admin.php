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
$modules['forums'] 			= 	'forums.module.php';
$modules['cp_options'] 		= 	'cp_options.module.php';
$modules['ajax'] 			= 	'ajax.module.php';
$modules['moderators']		=	'moderators.module.php';
$modules['groups']			=	'groups.module.php';

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
		die('������� .. ���� �� ���� ��� �� ������ ����� ������� ��� �����');
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
	die('<div align="center">������� .. ������ �������� ��� ������</div>');
}

//////////


?>
