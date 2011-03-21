<?php

define('NO_INFO',true); // TODO: huh?

require_once('database_struct.php');

$installer = new MySmartInstaller( $MySmartBB );

$MySmartBB->html->page_header('معالج تثبيت برنامج منتديات MySmartBB');

$logo = $MySmartBB->html->create_image(array('align'=>'right','alt'=>'MySmartBB','src'=>'../logo.jpg','return'=>true));
$MySmartBB->html->open_table('100%',true);
$MySmartBB->html->cells($logo,'header_logo_side');

// ... //

if (empty($MySmartBB->_GET['step']))
{
	$MySmartBB->html->cells('اولاً : رسالة الترحيب','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->msg('مرحباً بك، انت الآن مُقدم على تركيب الجيل الثاني من برنامج منتديات MySmartBB، من خلال هذا المعالج سوف يتم زرع الجداول المطلوبه و القيام بالاجراءات اللازمه حتى يعمل البرنامج،يرجى التحقق من انك قمت بالخطوات اللازمه ما قبل التثبيت،اذا كنت تحتاج للمساعده نرجوا منك مراجعة الموقع الرسمي.');

	$MySmartBB->html->make_link('إبدأ عملية التثبيت','?step=1');
}

if ($MySmartBB->_GET['step'] == 1)
{
	$MySmartBB->html->cells('الخطوه الاولى : التحقق من تصاريح المجلدات','main1');
	$MySmartBB->html->close_table();
	
	// ... //
	
	$directories = array(	'../../download', 
							'../../download/avatar', 
							'../../download/contact', // TODO : delete me please!
							'../../modules/styles/main/compiler', 
							'../../modules/styles/main/templates' );
	
	foreach ( $directories as $directory )
	{
		if ( !is_writable( $directory ) )
		{
			$MySmartBB->html->msg( 'تصريح المجلد ' . $directory . ' غير صحيح' );
		}
		else
		{
			$MySmartBB->html->msg( 'تصريح الملجد ' . $directory . ' صحيح' );
		}
	}
	
	// ... //
	
	$MySmartBB->html->make_link('الخطوه التاليه -> انشاء الجداول','?step=2');
}
elseif ($MySmartBB->_GET['step'] == 2)
{
	$MySmartBB->html->cells('الخطوه الثانيه : إنشاء الجداول','main1');
	$MySmartBB->html->close_table();
	
	$installer->createTables();
	
	$MySmartBB->html->make_link('الخطوه التاليه -> إدخال المعلومات','?step=3');
}
elseif ($MySmartBB->_GET['step'] == 3)
{
	$MySmartBB->html->cells('الخطوه الثالثه : إدخال المعلومات','main1');
	$MySmartBB->html->close_table();
	
	$installer->insertInformation();
	
	$MySmartBB->html->make_link('الخطوه التاليه -> إدخال معلومات المنتدى','?step=4');
}
elseif ($MySmartBB->_GET['step'] == 4)
{
	$MySmartBB->html->cells('الخطوه الرابعه : ادخال معلومات المنتدى','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->open_form('index.php?step=5');
	
	$MySmartBB->html->open_table('60%',true,1);
	$MySmartBB->html->open_table_head('معلومات المدير','main1');
	$MySmartBB->html->row('اسم المستخدم',$MySmartBB->html->input('username'));
	$MySmartBB->html->row('كلمة المرور',$MySmartBB->html->password('password'));
	$MySmartBB->html->row('البريد الالكتروني',$MySmartBB->html->input('email'));
	$MySmartBB->html->row('الجنس',$MySmartBB->html->select('gender',array('m'=>'ذكر','f'=>'انثى')));
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->open_table('60%',true,1);
	$MySmartBB->html->open_table_head('معلومات المنتدى','main1');
	$MySmartBB->html->row('اسم المنتدى',$MySmartBB->html->input('title'));
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->close_form();
}
elseif ($MySmartBB->_GET['step'] == 5)
{
	$MySmartBB->html->cells('الخطوه الاخيره','main1');
	$MySmartBB->html->close_table();
	
	if (empty($MySmartBB->_POST['username']) 
		or empty($MySmartBB->_POST['password']) 
		or empty($MySmartBB->_POST['email']) 
		or empty($MySmartBB->_POST['gender']) 
		or empty($MySmartBB->_POST['title']))
	{
		$MySmartBB->func->error('يرجى تعبئة كافة المعلومات!');
	}
	
	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
	
	$MySmartBB->rec->fields			=	array();
	
	$MySmartBB->rec->fields['username']				= 	$MySmartBB->_POST['username'];
	$MySmartBB->rec->fields['password']				= 	md5($MySmartBB->_POST['password']);
	$MySmartBB->rec->fields['email']				= 	$MySmartBB->_POST['email'];
	$MySmartBB->rec->fields['usergroup']			= 	1;
	$MySmartBB->rec->fields['user_gender']			= 	$MySmartBB->_POST['gender'];
	$MySmartBB->rec->fields['register_date']		= 	$MySmartBB->_CONF['now'];
	$MySmartBB->rec->fields['user_title']			= 	'المشرف العام';
	$MySmartBB->rec->fields['style']				=	1;
	$MySmartBB->rec->fields['username_style_cache']	=	'<strong><em><span style="color: #800000;">' . $MySmartBB->_POST['username'] . '</span></em></strong>';
	
	$insert = $MySmartBB->rec->insert();
	
	if ($insert)
	{
		$MySmartBB->html->msg('تم إنشاء حساب المدير بنجاح');
	}
	else
	{
		$MySmartBB->html->msg('لم يتم إنشاء حساب المدير');
	}
	
	$update = $MySmartBB->info->updateInfo( 'create_date', $MySmartBB->_CONF['now'] );
	
	if ($update)
	{
		$MySmartBB->html->msg('تم تسجيل تاريخ إنشاء المنتدى');
	}
	else
	{
		$MySmartBB->html->msg('لم يتم تسجيل تاريخ إنشاء المنتدى');
	}
	
	$update = $MySmartBB->info->updateInfo( 'title', $MySmartBB->_POST['title'] );
	
	if ($update)
	{
		$MySmartBB->html->msg('تم وضع عنوان المنتدى');
	}
	else
	{
		$MySmartBB->html->msg('لم يتم وضع عنوان المنتدى');
	}
	
	$cache = $MySmartBB->icon->updateSmilesCache();
	
	if ($cache)
	{
		$MySmartBB->html->msg('تم وضع المعلومات المخبأه للابتسامات');
	}
	else
	{
		$MySmartBB->html->msg('لم يتم وضع المعلومات المخبأه للابتسامات');
	}
	
	$MySmartBB->html->msg('تهانينا! تم تثبيت المنتدى بنجاح. يرجى التأكد من حذفك لهذا المجلد','center');
	$MySmartBB->html->msg('للذهاب إلى الصفحه الرئيسيه للمنتدى : ') . $MySmartBB->html->make_link('هنا','../../index.php');
	$MySmartBB->html->msg('للذهاب إلى لوحة التحكم : ') . $MySmartBB->html->make_link('هنا','../../admin.php');
}

?>
