<?php

define('NO_INFO',true);

$CALL_SYSTEM = array();
$CALL_SYSTEM['ICONS'] = true;

require_once('database_struct.php');

class Install extends DatabaseStruct
{	
	var $_TempArr 	= 	array();
	var $_Masseges	=	array();
	
	function CheckPermissions(&$msgs)
	{
		$msgs[] = (!is_writable('../../download')) ? 'خطأ : يجب اعطاء المجلد download التصريح 777' : 'تصريح المجلد download صحيح';
		
		$msgs[] = (!is_writable('../../download/avatar')) ? 'خطأ : يجب اعطاء المجلد download/avatar التصريح 777' : 'تصريح المجلد download/avatar صحيح';
		
		$msgs[] = (!is_writable('../../download/contact')) ? 'خطأ : يجب اعطاء المجلد download/contact التصريح 777' : 'تصريح المجلد download/contact صحيح';
		
		$msgs[] = (!is_writable('../../look/styles/forum/main/compiler')) ? 'خطأ : يجب اعطاء المجلد look/styles/forum/main/compiler التصريح 777' : 'تصريح المجلد styles/main/compiler صحيح';
		
		$msgs[] = (!is_writable('../../look/styles/forum/main/templates')) ? 'خطأ : يجب اعطاء المجلد look/styles/forum/main/templates التصريح 777' : 'تصريح المجلد styles/main/compiler صحيح';
	}
	
	function CreateTables(&$msgs)
	{
		global $MySmartBB;
		
		$p = array();
		
		$success 	= 	'تم انشاء الجدول ';
		$fail 		= 	'لم يتم انشاء الجدول ';
		
		$p[1] = $this->_CreateEmailMasseges();
		$msgs[1] = ($p[1]) ? $success . $MySmartBB->table['email_msg'] : $fail . $MySmartBB->table['email_msg'];
		
		$p[2] = $this->_CreateExtension();
		$msgs[2] = ($p[2]) ? $success . $MySmartBB->table['extension'] : $fail . $MySmartBB->table['extension'];
		
		$p[3] = $this->_CreateGroup();
		$msgs[3] = ($p[3]) ? $success . $MySmartBB->table['group'] : $fail . $MySmartBB->table['group'];
		
		$p[4] = $this->_CreateInfo();
		$msgs[4] = ($p[4]) ? $success . $MySmartBB->table['info'] : $fail . $MySmartBB->table['info'];
		
		$p[5] = $this->_CreateMember();
		$msgs[5] = ($p[5]) ? $success . $MySmartBB->table['member'] : $fail . $MySmartBB->table['member'];
		
		$p[6] = $this->_CreateOnline();
		$msgs[6] = ($p[6]) ? $success . $MySmartBB->table['online'] : $fail . $MySmartBB->table['online'];
		
		$p[7] = $this->_CreatePages();
		$msgs[7] = ($p[7]) ? $success . $MySmartBB->table['pages'] : $fail . $MySmartBB->table['pages'];
		
		$p[8] = $this->_CreatePrivateMassege();
		$msgs[8] = ($p[8]) ? $success . $MySmartBB->table['pm'] : $fail . $MySmartBB->table['pm'];
		
		$p[9] = $this->_CreatePrivateMassegeFolder();
		$msgs[9] = ($p[9]) ? $success . $MySmartBB->table['pm_folder'] : $fail . $MySmartBB->table['pm_folder'];
		
		$p[10] = $this->_CreatePrivateMassegeLists();
		$msgs[10] = ($p[10]) ? $success . $MySmartBB->table['pm_lists'] : $fail . $MySmartBB->table['pm_lists'];

		$p[11] = $this->_CreatePoll();
		$msgs[11] = ($p[11]) ? $success . $MySmartBB->table['poll'] : $fail . $MySmartBB->table['poll'];
		
		$p[12] = $this->_CreateReply();
		$msgs[12] = ($p[12]) ? $success . $MySmartBB->table['reply'] : $fail . $MySmartBB->table['reply'];
		
		$p[13] = $this->_CreateRequests();
		$msgs[13] = ($p[13]) ? $success . $MySmartBB->table['requests'] : $fail . $MySmartBB->table['requests'];
		
		$p[14] = $this->_CreateSection();
		$msgs[14] = ($p[14]) ? $success . $MySmartBB->table['section'] : $fail . $MySmartBB->table['section'];
		
		$p[15] = $this->_CreateSectionAdmin();
		$msgs[15] = ($p[15]) ? $success . $MySmartBB->table['moderators'] : $fail . $MySmartBB->table['moderators'];
		
		$p[16] = $this->_CreateSectionGroup();
		$msgs[16] = ($p[16]) ? $success . $MySmartBB->table['section_group'] : $fail . $MySmartBB->table['section_group'];
		
		$p[17] = $this->_CreateSmiles();
		$msgs[17] = ($p[17]) ? $success . $MySmartBB->table['smiles'] : $fail . $MySmartBB->table['smiles'];
		
		$p[18] = $this->_CreateStyle();
		$msgs[18] = ($p[18]) ? $success . $MySmartBB->table['style'] : $fail . $MySmartBB->table['style'];
		
		$p[19] = $this->_CreateSubject();
		$msgs[19] = ($p[19]) ? $success . $MySmartBB->table['subject'] : $fail . $MySmartBB->table['subject'];
		
		$p[20] = $this->_CreateSuperMemberLogs();
		$msgs[20] = ($p[20]) ? $success . $MySmartBB->table['sm_logs'] : $fail . $MySmartBB->table['sm_logs'];

		$p[21] = $this->_CreateToday();
		$msgs[21] = ($p[21]) ? $success . $MySmartBB->table['today'] : $fail . $MySmartBB->table['today'];
		
		$p[22] = $this->_CreateToolBox();
		$msgs[22] = ($p[22]) ? $success . $MySmartBB->table['toolbox'] : $fail . $MySmartBB->table['toolbox'];
		
		$p[23] = $this->_CreateUserTitle();
		$msgs[23] = ($p[23]) ? $success . $MySmartBB->table['usertitle'] : $fail . $MySmartBB->table['usertitle'];
		
		$p[24] = $this->_CreateVote();
		$msgs[24] = ($p[24]) ? $success . $MySmartBB->table['vote'] : $fail . $MySmartBB->table['vote'];
		
		$p[25] = $this->_CreateAds();
		$msgs[25] = ($p[25]) ? $success . $MySmartBB->table['ads'] : $fail . $MySmartBB->table['ads'];
		
		$p[26] = $this->_CreateAnnouncement();
		$msgs[26] = ($p[26]) ? $success . $MySmartBB->table['announcement'] : $fail . $MySmartBB->table['announcement'];
		
		$p[27] = $this->_CreateAttach();
		$msgs[27] = ($p[27]) ? $success . $MySmartBB->table['attach'] : $fail . $MySmartBB->table['attach'];
		
		$p[28] = $this->_CreateAvatar();
		$msgs[28] = ($p[28]) ? $success . $MySmartBB->table['avatar'] : $fail . $MySmartBB->table['avatar'];
		
		$p[29] = $this->_CreateBanned();
		$msgs[29] = ($p[29]) ? $success . $MySmartBB->table['banned'] : $fail . $MySmartBB->table['banned'];
		
		$p[30] = $this->_CreateTags();
		$msgs[30] = ($p[30]) ? $success . $MySmartBB->table['tag'] : $fail . $MySmartBB->table['tag'];
	
		$p[31] = $this->_CreateTagsSubject();
		$msgs[31] = ($p[31]) ? $success . $MySmartBB->table['tag_subject'] : $fail . $MySmartBB->table['tag_subject'];
	}
	
	function InsertInformation(&$msgs)
	{
		$p = array();
		
		$success = 'تم ادخال ';
		$fail = 'لم يتم ادخال ';
		
		$p[0] = $this->_InsertEmailMasseges();
		$msgs[0] = (in_array('true',$p[0])) ? $success . 'الرسائل' : $fail . 'الرسائل';
		
		$p[1] = $this->_InsertExtension();
		$msgs[1] = (in_array('true',$p[1])) ? $success . 'الامتدادات' : $fail . 'الامتدادات';
		
		$p[2] = $this->_InsertGroup();
		$msgs[2] = (in_array('true',$p[2])) ? $success . 'المجموعات' : $fail . 'المجموعات';
		
		$p[3] = $this->_InsertInfo();
		$msgs[3] = (in_array('true',$p[3])) ? $success . 'المعلومات' : $fail . 'المعلومات';
		
		$p[4] = $this->_InsertSmiles();
		$msgs[4] = (in_array('true',$p[4])) ? $success . 'الابتسامات' : $fail . 'الابتسامات';
		
		$p[5] = $this->_InsertStyle();
		$msgs[5] = ($p[5]) ? $success . 'النمط الافتراضي' : $fail . 'النمط الافتراضي';
		
		$p[6] = $this->_InsertToolBox();
		$msgs[6] = ($p[6]) ? $success . 'الادوات' : $fail . 'الادوات';
		
		$p[7] = $this->_InsertUserTitle();
		$msgs[7] = ($p[7]) ? $success . 'مسميات الاعضاء' : $fail . 'مسميات الاعضاء';
	}
}

$MySmartBB->install = new Install;

$MySmartBB->html->page_header('معالج تثبيت برنامج منتديات MySmartBB');

$logo = $MySmartBB->html->create_image(array('align'=>'right','alt'=>'MySmartBB','src'=>'../logo.jpg','return'=>true));
$MySmartBB->html->open_table('100%',true);
$MySmartBB->html->cells($logo,'header_logo_side');

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
	
	$p = $MySmartBB->install->CheckPermissions($MySmartBB->install->_Masseges);
	
	foreach ($MySmartBB->install->_Masseges as $msg)
	{
		$MySmartBB->html->msg($msg);
	}
	
	$MySmartBB->html->make_link('الخطوه التاليه -> انشاء الجداول','?step=2');
}
elseif ($MySmartBB->_GET['step'] == 2)
{
	$MySmartBB->html->cells('الخطوه الثانيه : إنشاء الجداول','main1');
	$MySmartBB->html->close_table();
	
	$p = $MySmartBB->install->CreateTables($MySmartBB->install->_Masseges);
	
	foreach ($MySmartBB->install->_Masseges as $msg)
	{
		$MySmartBB->html->msg($msg);
	}
	
	$MySmartBB->html->make_link('الخطوه التاليه -> إدخال المعلومات','?step=3');
}
elseif ($MySmartBB->_GET['step'] == 3)
{
	$MySmartBB->html->cells('الخطوه الثالثه : إدخال المعلومات','main1');
	$MySmartBB->html->close_table();
	
	$p = $MySmartBB->install->InsertInformation($MySmartBB->install->_Masseges);
	
	foreach ($MySmartBB->install->_Masseges as $msg)
	{
		$MySmartBB->html->msg($msg);
	}
	
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
		$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات!');
	}
	
	$InsertArr 					= 	array();
	$InsertArr['field']			=	array();
	
	$InsertArr['field']['username']			= 	$MySmartBB->_POST['username'];
	$InsertArr['field']['password']			= 	md5($MySmartBB->_POST['password']);
	$InsertArr['field']['email']			= 	$MySmartBB->_POST['email'];
	$InsertArr['field']['usergroup']		= 	1;
	$InsertArr['field']['user_gender']		= 	$MySmartBB->_POST['gender'];
	$InsertArr['field']['register_date']	= 	$MySmartBB->_CONF['now'];
	$InsertArr['field']['user_title']		= 	'المشرف العام';
	$InsertArr['field']['style']			=	1;
	
	$insert = $MySmartBB->member->InsertMember($InsertArr);
	
	if ($insert)
	{
		$MySmartBB->html->msg('تم إنشاء حساب المدير بنجاح');
	}
	else
	{
		$MySmartBB->html->msg('لم يتم إنشاء حساب المدير');
	}
	
	$update = $MySmartBB->DB->sql_query('UPDATE ' . $MySmartBB->table['info'] . " SET value='" . $MySmartBB->_CONF['now'] . "' WHERE var_name='create_date'");
	
	if ($update)
	{
		$MySmartBB->html->msg('تم تسجيل تاريخ إنشاء المنتدى');
	}
	else
	{
		$MySmartBB->html->msg('لم يتم تسجيل تاريخ إنشاء المنتدى');
	}
	
	$update = $MySmartBB->DB->sql_query('UPDATE ' . $MySmartBB->table['info'] . " SET value='" . $MySmartBB->_POST['title'] . "' WHERE var_name='title'");
	
	if ($update)
	{
		$MySmartBB->html->msg('تم وضع عنوان المنتدى');
	}
	else
	{
		$MySmartBB->html->msg('لم يتم وضع عنوان المنتدى');
	}
	
	$cache = $MySmartBB->icon->UpdateSmilesCache(null);
	
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
