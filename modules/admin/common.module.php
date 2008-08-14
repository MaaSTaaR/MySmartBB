<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

class MySmartCommon
{
	var $CheckMember;
		
	/**
	 * The main function
	 */
	function run()
	{
		global $MySmartBB;
		
		$this->_SetupPage();
		
		$this->_CheckMember();
		
		if (!$MySmartBB->_CONF['member_permission'])
		{
			if (!constant('STOP_STYLE'))
			{
				$this->_ShowLoginForm();
			}
		}
		
		$this->_CommonCode();
	}
	
	function _SetupPage()
	{
		global $MySmartBB;
		
		if (STOP_STYLE != true)
		{
			$MySmartBB->html->lang 					= 	array();
			$MySmartBB->html->lang['direction']		=	'rtl';
			$MySmartBB->html->lang['languagecode']	=	'ar';
			$MySmartBB->html->lang['charset']		=	'utf-8';
			$MySmartBB->html->lang['yes']			=	'نعم';
			$MySmartBB->html->lang['align']			=	'right';
			$MySmartBB->html->lang['no']			=	'لا';
			$MySmartBB->html->lang['send']			=	'موافق';
			$MySmartBB->html->lang['reset']			=	'اعادة الحقول';
		}
	}
		
	function _CheckMember()
	{
		global $MySmartBB;
		
		$username = $MySmartBB->_COOKIE[$MySmartBB->_CONF['admin_username_cookie']];
		$password = $MySmartBB->_COOKIE[$MySmartBB->_CONF['admin_password_cookie']];
		
		$MySmartBB->_CONF['member_permission'] = false;
		
		if (!empty($username) 
			and !empty($password))
		{
			$CheckArr 				= 	array();
			$CheckArr['username'] 	= 	$username;
			$CheckArr['password'] 	= 	$password;
		
			$CheckMember = $MySmartBB->member->CheckAdmin($CheckArr);
			
			if ($CheckMember != false)
			{
				$MySmartBB->_CONF['rows']['member_row'] = 	$CheckMember;
				$MySmartBB->_CONF['member_permission'] 	= 	true;
			}
			else
			{
				$MySmartBB->_CONF['member_permission'] = false;
			}
		}
		else
		{
			$MySmartBB->_CONF['member_permission'] = false;
		}
	}
	
	function _CommonCode()
	{
		global $MySmartBB;
		
		//////////
				
		// The list of commands
		$MySmartBB->_CONF['CMD'] 				= 	array();
		$MySmartBB->_CONF['CMD']['help']		=	'مساعده'; // Help command, It's something like "man" in Unix-based systems
		$MySmartBB->_CONF['CMD']['اضافة-منتدى'] 	= 	'./modules/admin/includes/cmd/add_forum.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-منتدى'] 	= 	'./modules/admin/includes/cmd/add_forum.cmd.php';
		$MySmartBB->_CONF['CMD']['تحديث-منتدى'] 	= 	'./modules/admin/includes/cmd/update_forum.cmd.php';
		$MySmartBB->_CONF['CMD']['حذف-منتدى'] 	= 	'./modules/admin/includes/cmd/delete_forum.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-قسم'] 	= 	'./modules/admin/includes/cmd/add_section.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-قسم'] 	= 	'./modules/admin/includes/cmd/add_section.cmd.php';
		$MySmartBB->_CONF['CMD']['تحديث-قسم'] 	= 	'./modules/admin/includes/cmd/update_section.cmd.php';
		$MySmartBB->_CONF['CMD']['حذف-قسم'] 		= 	'./modules/admin/includes/cmd/delete_section.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-اعلان'] 	= 	'./modules/admin/includes/cmd/add_ads.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-اعلان'] 	= 	'./modules/admin/includes/cmd/add_ads.cmd.php';
		$MySmartBB->_CONF['CMD']['تحديث-اعلان'] 	= 	'./modules/admin/includes/cmd/update_ads.cmd.php';
		$MySmartBB->_CONF['CMD']['حذف-اعلان'] 	= 	'./modules/admin/includes/cmd/delete_ads.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-عضو'] 	= 	'./modules/admin/includes/cmd/add_member.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-عضو'] 	= 	'./modules/admin/includes/cmd/add_member.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-مسمى'] 	= 	'./modules/admin/includes/cmd/add_usertitle.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-مسمى'] 	= 	'./modules/admin/includes/cmd/add_usertitle.cmd.php';
		$MySmartBB->_CONF['CMD']['تحديث-مسمى'] 	= 	'./modules/admin/includes/cmd/update_usertitle.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-امتداد'] 	= 	'./modules/admin/includes/cmd/add_extension.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-امتداد'] 	= 	'./modules/admin/includes/cmd/add_extension.cmd.php';
		$MySmartBB->_CONF['CMD']['تحديث-امتداد'] 	= 	'./modules/admin/includes/cmd/update_extension.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-خط'] 	= 	'./modules/admin/includes/cmd/add_font.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-خط'] 	= 	'./modules/admin/includes/cmd/add_font.cmd.php';
		$MySmartBB->_CONF['CMD']['تحديث-خط'] 	= 	'./modules/admin/includes/cmd/update_font.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-لون'] 	= 	'./modules/admin/includes/cmd/add_color.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-لون'] 	= 	'./modules/admin/includes/cmd/add_color.cmd.php';
		$MySmartBB->_CONF['CMD']['تحديث-لون'] 	= 	'./modules/admin/includes/cmd/update_color.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-نمط'] 	= 	'./modules/admin/includes/cmd/add_style.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-نمط'] 	= 	'./modules/admin/includes/cmd/add_style.cmd.php';
		$MySmartBB->_CONF['CMD']['حذف-نمط'] 		= 	'./modules/admin/includes/cmd/delete_style.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-ابتسامه'] 	= 	'./modules/admin/includes/cmd/add_smile.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-ابتسامه'] 	= 	'./modules/admin/includes/cmd/add_smile.cmd.php';
		$MySmartBB->_CONF['CMD']['حذف-ابتسامه'] 	= 	'./modules/admin/includes/cmd/delete_smile.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-ايقونه'] 	= 	'./modules/admin/includes/cmd/add_icon.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-ايقونه'] 	= 	'./modules/admin/includes/cmd/add_icon.cmd.php';
		$MySmartBB->_CONF['CMD']['حذف-ايقونه'] 	= 	'./modules/admin/includes/cmd/delete_icon.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافة-صوره'] 	= 	'./modules/admin/includes/cmd/add_avatar.cmd.php';
		$MySmartBB->_CONF['CMD']['اضافه-صوره'] 	= 	'./modules/admin/includes/cmd/add_avatar.cmd.php';
		$MySmartBB->_CONF['CMD']['حذف-صوره'] 	= 	'./modules/admin/includes/cmd/delete_avatar.cmd.php';
		
		//////////
		
		// Set information for template engine
		$MySmartBB->template->SetInformation('look/styles/admin/main/templates/','look/styles/admin/main/compiler/','.tpl','file');
		
		//////////
		
		// We will use this in options page
		$MySmartBB->template->assign('_CONF',$MySmartBB->_CONF);
		
		//////////
	}
	
	function _ShowLoginForm()
	{
		global $MySmartBB;
		
		$MySmartBB->html->space();
	
		$MySmartBB->html->open_form('admin.php?page=login&amp;login=1');
		$MySmartBB->html->open_table('40%','t_style_a',1);
		
		$MySmartBB->html->cells('تسجيل الدخول','main1 rows_space');
		$MySmartBB->html->row('اسم المستخدم',$MySmartBB->html->input('username'));
		$MySmartBB->html->row('كلمة المرور',$MySmartBB->html->password('password'));
		
		$MySmartBB->html->close_table();
		$MySmartBB->html->close_form();
	}
}
	
?>
