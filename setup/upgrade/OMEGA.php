<?php

/**********
* Text to utf-8 converter By : Alexander Minkovsky (a_minkovsky@hotmail.com)
* Source : http://phpclasses.waaf.net/browse/package/1974.html
***********/

/**
* 	OMEGA upgrager :
*		1- Change registe_date size in member table
*		2- Change date size in pm table
*		3- Change date size in announcement table
*		4- Drop contactus_extensions table
*		5- Drop contactus_messages table
*		6- Drop contactus_settings table
*		7- Drop membergroup table
*		8- Drop write_date field in reply table
*		9- Drop gmt_time field in reply table
*		10- Drop reply_time field in subject table
*		11- Drop wr_date field in subject table
*		12- Drop gmt_time field in subject table
*		13- Drop lastreply_date field in subject table
*		14- Rename avater to avatar
*		15- Rename emailmsgs to email_msg
*		16- Rename pmfolder to pm_folder
*		17- Rename pmlists to pm_lists
*		18- Change charset from CP1256 to UTF-8
*		19- Fix icons path
*		20- Fix smiles path
*		21- Add MySmartBB_banned table which deleted in 1.5!
*		22- Change smile_path size in smiles table
*		23- Add style_cache field in member table
*		24- Add style_id_cache field in member table
*		25- Add should_update_style_cache field in member table
*		26- Add today_date_cache in info table
*		27- Add today_number_cache in info table
*		28- Add adress_bar_separate in info table
*/

define('NO_TEMPLATE',true);

$CALL_SYSTEM				= 	array();
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['ICONS'] 		= 	true;

include('../common.php');

class MySmartOMEGA extends MySmartInstall
{
	var $_TempArr 	= 	array();
	var $_Masseges	=	array();
	// Text to utf-8 variables
	var $ascMap = array();
	var $utfMap = array();
	var $charset;
	
	//
	function CheckVersion()
	{
		global $MySmartBB;
		
		return ($MySmartBB->_CONF['info_row']['MySBB_version'] == '2.0 SEGMA') ? true : false;
	}
	
	function UpdateVersion()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['info'] . " SET value='2.0 OMEGA' WHERE var_name='MySBB_version'");
		
		return ($update) ? true : false;
	}
	
	// Change operation(s)
	function ChangeRegisterDate()
	{
		global $MySmartBB;
		
		$this->_TempArr['ChangeArr'] = array();
		$this->_TempArr['ChangeArr']['table_name'] 	= 	$MySmartBB->prefix . 'member';
		$this->_TempArr['ChangeArr']['field_name'] 	= 	'register_date';
		$this->_TempArr['ChangeArr']['change']		=	'VARCHAR( 100 ) NOT NULL';
		
		$change = $this->change_field($this->_TempArr['ChangeArr']);
		
		return ($change) ? true : false;
	}
	
	function ChangePrivateMassegeDate()
	{
		global $MySmartBB;
		
		$this->_TempArr['ChangeArr'] = array();
		$this->_TempArr['ChangeArr']['table_name'] 	= 	$MySmartBB->prefix . 'pm';
		$this->_TempArr['ChangeArr']['field_name'] 	= 	'date';
		$this->_TempArr['ChangeArr']['change']		=	'VARCHAR( 100 ) NOT NULL';
		
		$change = $this->change_field($this->_TempArr['ChangeArr']);
		
		return ($change) ? true : false;
	}
	
	function ChangeAnnouncementDate()
	{
		global $MySmartBB;
		
		$this->_TempArr['ChangeArr'] = array();
		$this->_TempArr['ChangeArr']['table_name'] 	= 	$MySmartBB->prefix . 'announcement';
		$this->_TempArr['ChangeArr']['field_name'] 	= 	'date';
		$this->_TempArr['ChangeArr']['change']		=	'VARCHAR( 100 ) NOT NULL';
		
		$change = $this->change_field($this->_TempArr['ChangeArr']);
		
		return ($change) ? true : false;
	}
	
	function ChangeSmilePath()
	{
		global $MySmartBB;
		
		$this->_TempArr['ChangeArr'] = array();
		$this->_TempArr['ChangeArr']['table_name'] 	= 	$MySmartBB->prefix . 'smiles';
		$this->_TempArr['ChangeArr']['field_name'] 	= 	'smile_path';
		$this->_TempArr['ChangeArr']['change']		=	'VARCHAR( 255 ) NOT NULL';
		
		$change = $this->change_field($this->_TempArr['ChangeArr']);
		
		return ($change) ? true : false;
	}
	
	// Drop operation(s)
	function DropContactusTables()
	{
		global $MySmartBB;
		
		$drop = array();
		$drop[0] = $this->drop_table($MySmartBB->prefix . 'contactus_extensions');
		$drop[1] = $this->drop_table($MySmartBB->prefix . 'contactus_messages');
		
		return ($drop[0] and $drop[1]) ? true : false;
	}
	
	function DropWriteDateField()
	{
		global $MySmartBB;
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->prefix . 'reply';
		$this->_TempArr['DropArr']['field_name'] 	= 	'write_date';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
	}
	
	function DropGMTimeFieldReply()
	{
		global $MySmartBB;
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->prefix . 'reply';
		$this->_TempArr['DropArr']['field_name'] 	= 	'gmt_time';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
	}
	
	function DropReplyTimeField()
	{
		global $MySmartBB;
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->prefix . 'subject';
		$this->_TempArr['DropArr']['field_name'] 	= 	'reply_time';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
	}

	function DropWRDateField()
	{
		global $MySmartBB;
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->prefix . 'subject';
		$this->_TempArr['DropArr']['field_name'] 	= 	'wr_date';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
	}
	
	function DropGMTimeFieldSubject()
	{
		global $MySmartBB;
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->prefix . 'subject';
		$this->_TempArr['DropArr']['field_name'] 	= 	'gmt_time';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
	}
	
	function DropLastReplyDateField()
	{
		global $MySmartBB;
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->prefix . 'subject';
		$this->_TempArr['DropArr']['field_name'] 	= 	'lastreply_date';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
	}
	
	// Rename operation(s)
	function RenameAvatarTable()
	{
		global $MySmartBB;
		
		$rename = $this->rename_table($MySmartBB->prefix . 'avater',$MySmartBB->prefix . 'avatar');
		
		return ($rename) ? true : false;
	}
	
	function RenameEmailMassegesTable()
	{
		global $MySmartBB;
		
		$rename = $this->rename_table($MySmartBB->prefix . 'emailmsgs',$MySmartBB->prefix . 'email_msg');
		
		return ($rename) ? true : false;
	}
	
	function RenamePMFolderTable()
	{
		global $MySmartBB;
		
		$rename = $this->rename_table($MySmartBB->prefix . 'pmfolder',$MySmartBB->prefix . 'pm_folder');
		
		return ($rename) ? true : false;
	}
	
	function RenamePMListsTable()
	{
		global $MySmartBB;
		
		$rename = $this->rename_table($MySmartBB->prefix . 'pmlists',$MySmartBB->prefix . 'pm_lists');
		
		return ($rename) ? true : false;
	}
	
	// Repair operation(s)
	function RepairDefaultStyle()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query("INSERT INTO " . $MySmartBB->table['style'] . " SET
												style_title='النمط الافتراضي',
												style_on='1',
												style_order='0',
												style_path='modules/styles/main/css/style.css',
												image_path='modules/styles/main/images',
												template_path='modules/styles/main/templates',
												cache_path='modules/styles/main/compiler'
												");
												
		if ($insert)
		{
			$id = $MySmartBB->DB->sql_insert_id();
			
			$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['info'] . " SET value='" . $id . "' WHERE var_name='def_style'");
			
			if ($update)
			{
				$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['member'] . " SET style='" . $id . "'");
				
				return ($update) ? true : false;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	function FixIconsPath()
	{
		global $MySmartBB;
		
		$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['smiles'] . " WHERE smile_type='1'");
		
		$state = array();
		
		while ($r = $MySmartBB->DB->sql_fetch_array($query))
		{
			$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['smiles']  . " SET smile_path='modules/images/icons/" . $r['smile_path'] . "' WHERE id='" . $r['id'] . "'");
	
			if ($update)
			{
				$state[] = 'true';
			}
			else
			{
				$state[] = 'false';
			}
		}
		
		return $state;
	}
	
	function FixSmilesPath()
	{
		global $MySmartBB;
		
		$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['smiles'] . " WHERE smile_type='0'");
		
		$state = array();
		
		while ($r = $MySmartBB->DB->sql_fetch_array($query))
		{
			$s = str_replace('image/smiles/','',$r['smile_path']);
			
			$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['smiles']  . " SET smile_path='modules/images/smiles/" . $s . "' WHERE id='" . $r['id'] . "'");
	
			if ($update)
			{
				$state[] = 'true';
			}
			else
			{
				$state[] = 'false';
			}
		}
		
		return $state;
	}
	
	// Text to utf-8 functions, By : Alexander Minkovsky (a_minkovsky@hotmail.com)
	function loadCharset()
	{
		$lines = @file_get_contents('./CP1256.MAP');
    	$this->charset = $charset;
    	$lines = preg_replace("/#.*$/m","",$lines); // Delete comments
    	$lines = preg_replace("/\n\n/","",$lines); // Delete double new line
    	$lines = explode("\n",$lines);
    	
    	foreach ($lines as $line)
    	{
    		$parts = explode('0x',$line);
    		
    		if (count($parts) == 3)
    		{
    			$asc = hexdec(substr($parts[1],0,2));
    			$utf = hexdec(substr($parts[2],0,4));
    			
    			$this->ascMap[$charset][$asc]=$utf;
    		}
    	}
    	
    	$this->utfMap = array_flip($this->ascMap[$charset]);
    }
    
	function strToUtf8($str)
	{
		$chars = unpack('C*', $str);
		$cnt = count($chars);
		
		for ($i=1; $i<=$cnt; $i++)
		{
			$this->_charToUtf8($chars[$i]);
		}
		
		return implode("",$chars);
	}
	
	function _charToUtf8(&$char)
	{
		$c = (int)$this->ascMap[$this->charset][$char];
    
    	if ($c < 0x80)
    	{
    		$char = chr($c);
    	}
    	elseif ($c<0x800) // 2 bytes
    	{
    		$char = (chr(0xC0 | $c>>6) . chr(0x80 | $c & 0x3F));
    	}
    	else if($c<0x10000) // 3 bytes
    	{
    		$char = (chr(0xE0 | $c>>12) . chr(0x80 | $c>>6 & 0x3F) . chr(0x80 | $c & 0x3F));
    	}
    	else if($c<0x200000) // 4 bytes
    	{
    		$char = (chr(0xF0 | $c>>18) . chr(0x80 | $c>>12 & 0x3F) . chr(0x80 | $c>>6 & 0x3F) . chr(0x80 | $c & 0x3F));
    	}
    }
    // End of Text to utf-8 functions
    
    ////
    
    function CreateBannedTable()
    {
    	global $MySmartBB;
    	
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['banned'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'text VARCHAR( 100 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'text_type INT( 1 ) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
    }
	
	function AddForumsCache()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 				= array();
		$this->_TempArr['AddArr']['table'] 		= $MySmartBB->table['section'];
		$this->_TempArr['AddArr']['field_name'] = 'forums_cache'; // Changed in THATA 1
		$this->_TempArr['AddArr']['field_des'] 	= 'TEXT';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddSectionsNumber()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='sections_number'");
		
		return ($insert) ? true : false;
	}
	
	function AddSubSectionsNumber()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='subsections_number'");
		
		return ($insert) ? true : false;
	}
	
	function AddSectionGroupNumber()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='sectiongroup_number'");
		
		return ($insert) ? true : false;
	}
	
	function AddSmilesNumber()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='smiles_number'");
		
		return ($insert) ? true : false;
	}
	
	function AddReplyNumber()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 				= array();
		$this->_TempArr['AddArr']['table'] 		= $MySmartBB->table['section'];
		$this->_TempArr['AddArr']['field_name'] = 'subject_num';
		$this->_TempArr['AddArr']['field_des'] 	= 'INT ( 9 )';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddSubjectNumber()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 				= array();
		$this->_TempArr['AddArr']['table'] 		= $MySmartBB->table['section'];
		$this->_TempArr['AddArr']['field_name'] = 'reply_num';
		$this->_TempArr['AddArr']['field_des'] 	= 'INT ( 9 )';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	///
	
	function AddStyleCache()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 				= array();
		$this->_TempArr['AddArr']['table'] 		= $MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] = 'style_cache';
		$this->_TempArr['AddArr']['field_des'] 	= 'TEXT';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddStyleIDCache()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 				= array();
		$this->_TempArr['AddArr']['table'] 		= $MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] = 'style_id_cache';
		$this->_TempArr['AddArr']['field_des'] 	= 'INT( 9 )';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddUpdateStyleCache()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 				= array();
		$this->_TempArr['AddArr']['table'] 		= $MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] = 'should_update_style_cache';
		$this->_TempArr['AddArr']['field_des'] 	= 'INT( 1 )';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddTodayDateCache()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='today_date_cache'");
		
		return ($insert) ? true : false;
	}
	
	function AddTodayNumberCache()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='today_number_cache'");
		
		return ($insert) ? true : false;
	}
	
	function AddAdressBarSeparate()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " VALUES('NULL','adress_bar_separate','&raquo')");
		
		return ($insert) ? true : false;
	}
	
	function UpdateForumsCache()
	{
		global $MySmartBB;
		
		$cache = $MySmartBB->section->UpdateSectionsCache(array('type'=>'normal'));
		
		return ($cache) ? true : false;
	}
	
	function UpdateSubForumsCache()
	{
		global $MySmartBB;
		
		$query = $MySmartBB->DB->sql_query('SELECT * FROM ' . $MySmartBB->table['section']);
		
		$cache = array();
		
		while ($r = $MySmartBB->DB->sql_fetch_array($query))
		{
			$update = $MySmartBB->section->UpdateSectionsCache(array('type'=>'sub','from'=>$r['id']));
			
			$cache[$r['id']] = ($update) ? 'true' : 'false';
		}
				
		return (!in_array('false',$cache)) ? true : false;
	}
	
 	function UpdateSectionGroupCache()
	{
		global $MySmartBB;
		
		$cache = $MySmartBB->group->UpdateSectionGroupCache();
		
		return ($cache) ? true : false;
	}
	
	function UpdateSmilesNumberCache()
	{
		global $MySmartBB;
		
		$num = $MySmartBB->icon->GetSmilesNumber(null);
		
		$number = $MySmartBB->info->UpdateInfo(array('value'=>$num,'var_name'=>'smiles_number'));
	}
}

$MySmartBB->install = new MySmartOMEGA;

$MySmartBB->html->page_header('معالج ترقية برنامج منتديات MySmartBB');

$logo = $MySmartBB->html->create_image(array('align'=>'right','alt'=>'MySmartBB','src'=>'../logo.jpg','return'=>true));
$MySmartBB->html->open_table('100%',true);
$MySmartBB->html->cells($logo,'header_logo_side');

if (!$MySmartBB->install->CheckVersion())
{
	$MySmartBB->html->cells('اصدار غير صحيح','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->functions->error('يرجى التحقق من انك قمت بتشغيل تحديثات SEGMA');
}

if ($MySmartBB->_GET['step'] == 1)
{
	$MySmartBB->html->cells('عمليات التغيير','main1');
	$MySmartBB->html->close_table();

	$p 			= 	array();
	$msgs 		= 	$MySmartBB->install->_Masseges;
	
	$p[1] 		= 	$MySmartBB->install->ChangeRegisterDate();
	$msgs[1] 	= 	($p[1]) ? 'تم تغيير حجم حقل تاريخ التسجيل' : 'لم يتم تغيير حجم حقل تاريخ التسجيل';
	
	$p[2]		=	$MySmartBB->install->ChangePrivateMassegeDate();
	$msgs[2]	=	($p[2]) ? 'تم تغيير حجم حقل التاريخ في جدول الرسائل الخاصه' : 'لم يتم تغيير حجم حقل التاريخ في جدول الرسائل الخاصه';
	
	$p[3]		=	$MySmartBB->install->ChangeAnnouncementDate();
	$msgs[3]	=	($p[3]) ? 'تم تغيير حقل التاريخ في جدول الاعلانات الاداريه' : 'لم يتم تغيير حقل التاريخ في جدول الاعلانات الاداريه';
	
	$p[4]		=	$MySmartBB->install->ChangeSmilePath();
	$msgs[4]	=	($p[4]) ? 'تم تغيير حقل المسار في جدول الابتسامات' : 'لم يتم تغيير حقل المسار في جدول الابتسامات';

	$MySmartBB->html->open_p();
	
	foreach ($msgs as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثانيه -> عمليات الحذف','?step=2');
}
elseif ($MySmartBB->_GET['step'] == 2)
{
	$MySmartBB->html->cells('عمليات الحذف','main1');
	$MySmartBB->html->close_table();
	
	$p 			= 	array();
	$msgs 		= 	$MySmartBB->install->_Masseges;
	
	$p[1] 		= 	$MySmartBB->install->DropContactusTables();
	$msgs[1] 	= 	($p[1]) ? 'تم حذف الجداول الثلاثه' : 'لم يتم حذف الجداول الثلاثه';
	
	$p[2]		=	$MySmartBB->install->DropWriteDateField();
	$msgs[2]	=	($p[2]) ? 'تم حذف الحقل write_date' : 'لم يتم تغيير حقل التاريخ في جدول الاعلانات الاداريه';
	
	$p[3] 		= 	$MySmartBB->install->DropGMTimeFieldReply();
	$msgs[3] 	= 	($p[3]) ? 'تم حذف حقل توقيت GMT' : 'لم يتم حذف حقل توقيت GMT';
	
	$p[4]		=	$MySmartBB->install->DropReplyTimeField();
	$msgs[4]	=	($p[4]) ? 'تم حذف حقل reply_time' : 'لم يتم حذف حقل reply_time';
	
	$p[5]		=	$MySmartBB->install->DropWRDateField();
	$msgs[5]	=	($p[5]) ? 'تم حذف حقل wr_date' : 'لم يتم حذف حقل wr_date';
	
	$p[6]		=	$MySmartBB->install->DropGMTimeFieldSubject();
	$msgs[6]	=	($p[6]) ? 'تم حذف حقل توقيت GMT في جدول المواضيع' : 'لم يتم حذف حقل توقيت GMT في جدول المواضيع';
	
	$p[7]		=	$MySmartBB->install->DropLastReplyDateField();
	$msgs[7]	=	($p[7]) ? 'تم حذف حقل آخر رد' : 'لم يتم حذف حقل آخر رد';

	
	$MySmartBB->html->open_p();
	
	foreach ($msgs as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثالثه -> عمليات تغيير الاسم','?step=3');
}
elseif ($MySmartBB->_GET['step'] == 3)
{
	$MySmartBB->html->cells('عمليات تغيير الاسم','main1');
	$MySmartBB->html->close_table();
	
	$p 			= 	array();
	$msgs 		= 	$MySmartBB->install->_Masseges;
	
	$p[0]		=	$MySmartBB->install->RenameAvatarTable();
	$msgs[0]	=	($p[0]) ? 'تم تغيير اسم الجدول #1' : 'لم يتم تغيير اسم الجدول #1';
	
	$p[1]		=	$MySmartBB->install->RenameEmailMassegesTable();
	$msgs[1]	=	($p[1]) ? 'تم تغيير اسم الجدول #2' : 'لم يتم تغيير اسم الجدول #2';
	
	$p[2]		=	$MySmartBB->install->RenamePMFolderTable();
	$msgs[2]	=	($p[2]) ? 'تم تغيير اسم الجدول #3' : 'لم يتم يتغيير اسم الجدول #3';
	
	$p[3]		=	$MySmartBB->install->RenamePMListsTable();
	$msgs[3]	=	($p[3]) ? 'تم تغيير اسم الجدول #4' : 'لم يتم تغيير اسم الجدول #4';
	
	$MySmartBB->html->open_p();
	
	foreach ($msgs as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الرابعه : تغيير ترميز المواضيع','?step=4');
}
elseif ($MySmartBB->_GET['step'] == 4)
{
	$MySmartBB->html->cells('الخطوه الرابعه : تغيير ترميز المواضيع','main1');
	$MySmartBB->html->close_table();
		
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['subject'] . " ORDER BY id ASC");
	
	$MySmartBB->html->open_p();

	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$title 		= 	$MySmartBB->install->strToUtf8($r['title']);
		$text 		= 	$MySmartBB->install->strToUtf8($r['text']);
		$writer 	= 	$MySmartBB->install->strToUtf8($r['writer']);
		$describe 	= 	$MySmartBB->install->strToUtf8($r['subject_describe']);
		$action_by 	= 	$MySmartBB->install->strToUtf8($r['action_by']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['subject'] . " SET 
												title='" . $title . "',
												text='" . $text . "',
												writer='" . $writer . "',
												subject_describe='" . $describe . "',
												action_by='" . $action_by . "' 
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز الموضوع رقم #' . $r['id']);
		}
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الخامسه : تغيير ترميز الردود','?step=5');
}
elseif ($MySmartBB->_GET['step'] == 5)
{
	$MySmartBB->html->cells('الخطوه الخامسه : تغيير ترميز الردود','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['reply'] . " ORDER BY id ASC");
	
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$title 		= 	$MySmartBB->install->strToUtf8($r['title']);
		$text 		= 	$MySmartBB->install->strToUtf8($r['text']);
		$writer 	= 	$MySmartBB->install->strToUtf8($r['writer']);
		$action_by 	= 	$MySmartBB->install->strToUtf8($r['action_by']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['reply'] . " SET 
												title='" . $title . "',
												text='" . $text . "',
												writer='" . $writer . "',
												action_by='" . $action_by . "' 
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز الرد رقم #' . $r['id']);
		}
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه السادسه : تغيير ترميز الملفات المرفقه','?step=6');
}
elseif ($MySmartBB->_GET['step'] == 6)
{
	$MySmartBB->html->cells('الخطوه السادسه : تغيير ترميز الملفات المرفقه','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['attach'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$filename = $MySmartBB->install->strToUtf8($r['filename']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['attach'] . " SET 
												filename='" . $filename . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز المرفق رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه السابعه : تغيير ترميز الرسائل البريديه','?step=7');
}
elseif ($MySmartBB->_GET['step'] == 7)
{
	$MySmartBB->html->cells('الخطوه السابعه : تغيير ترميز الرسائل البريديه','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['email_msg'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$title = $MySmartBB->install->strToUtf8($r['title']);
		$text = $MySmartBB->install->strToUtf8($r['text']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['email_msg'] . " SET 
												title='" . $title . "',
												text='" . $text . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز الرساله رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثامنه : تغيير ترميز المجموعات','?step=8');
}
elseif ($MySmartBB->_GET['step'] == 8)
{
	$MySmartBB->html->cells('الخطوه الثامنه : تغيير ترميز المجموعات','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['group'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$title = $MySmartBB->install->strToUtf8($r['title']);
		$user_title = $MySmartBB->install->strToUtf8($r['user_title']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['group'] . " SET 
												title='" . $title . "',
												user_title='" . $user_title . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز المجموعه رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه التاسعه : تغيير ترميز اعدادات المنتدى','?step=9');
}
elseif ($MySmartBB->_GET['step'] == 9)
{
	$MySmartBB->html->cells('الخطوه التاسعه : تغيير ترميز اعدادات المنتدى','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['info'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$value = $MySmartBB->install->strToUtf8($r['value']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['info'] . " SET 
												value='" . addslashes($value) . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز الإعداد رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه العاشره : تغيير ترميز الاعضاء','?step=10');
}
elseif ($MySmartBB->_GET['step'] == 10)
{
	$MySmartBB->html->cells('الخطوه العاشره : تغيير ترميز الاعضاء','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['member'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$username 	= 	$MySmartBB->install->strToUtf8($r['username']);
		$email 		= 	$MySmartBB->install->strToUtf8($r['email']);
		$notes 		= 	$MySmartBB->install->strToUtf8($r['user_notes']);
		$sig 		= 	$MySmartBB->install->strToUtf8($r['user_sig']);
		$country 	= 	$MySmartBB->install->strToUtf8($r['user_country']);
		$gender 	= 	$MySmartBB->install->strToUtf8($r['user_gender']);
		$title 		= 	$MySmartBB->install->strToUtf8($r['user_title']);
		$info 		= 	$MySmartBB->install->strToUtf8($r['user_info']);
		$away_msg 	= 	$MySmartBB->install->strToUtf8($r['away_msg']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['member'] . " SET 
												username='" . $username . "',
												email='" . $email . "',
												user_notes='" . $notes . "',
												user_sig='" . $sig . "',
												user_country='" . $country . "',
												user_gender='" . $gender . "',
												user_title='" . $title . "',
												user_info='" . $info . "',
												away_msg='" . $away_msg . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز العضو رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الاولى بعد العاشره : تغيير ترميز الصفحات','?step=11');
}
elseif ($MySmartBB->_GET['step'] == 11)
{
	$MySmartBB->html->cells('الخطوه الاولى بعد العاشره : تغيير ترميز الصفحات','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['pages'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$title 		= 	$MySmartBB->install->strToUtf8($r['title']);
		$html_code 	= 	$MySmartBB->install->strToUtf8($r['html_code']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['pages'] . " SET 
												title='" . $title . "',
												html_code='" . $html_code . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز الصفحه رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثانيه بعد العاشره : تغيير ترميز الرسائل الخاصه','?step=12');
}
elseif ($MySmartBB->_GET['step'] == 12)
{
	$MySmartBB->html->cells('الخطوه الثانيه بعد العاشره : تغيير ترميز الرسائل الخاصه','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['pm'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$title 	= 	$MySmartBB->install->strToUtf8($r['title']);
		$from 	= 	$MySmartBB->install->strToUtf8($r['user_from']);
		$to		=	$MySmartBB->install->strToUtf8($r['user_to']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['pm'] . " SET 
												title='" . $title . "',
												user_from='" . $from . "',
												user_to='" . $to . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز الرساله رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثالثه بعد العاشره : تغيير ترميز قوائم الاتصال','?step=13');
}
elseif ($MySmartBB->_GET['step'] == 13)
{
	$MySmartBB->html->cells('الخطوه الثالثه بعد العاشره : تغيير ترميز قوائم الاتصال','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['pm_lists'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$list_username 	= 	$MySmartBB->install->strToUtf8($r['list_username']);
		$username 		= 	$MySmartBB->install->strToUtf8($r['username']);

		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['pm_lists'] . " SET 
												list_username='" . $list_username . "',
												username='" . $username . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز القائمه رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الرابعه بعد العاشره : تغيير ترميز الاستفتاءات','?step=14');
}
elseif ($MySmartBB->_GET['step'] == 14)
{
	$MySmartBB->html->cells('الخطوه الرابعه بعد العاشره : تغيير ترميز الاستفتاءات','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['poll'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$qus 	= 	$MySmartBB->install->strToUtf8($r['qus']);
		$ans1 	= 	$MySmartBB->install->strToUtf8($r['ans1']);
		$ans2 	= 	$MySmartBB->install->strToUtf8($r['ans2']);
		$ans3 	= 	$MySmartBB->install->strToUtf8($r['ans3']);
		$ans4 	= 	$MySmartBB->install->strToUtf8($r['ans4']);
		$ans5 	= 	$MySmartBB->install->strToUtf8($r['ans5']);
		$ans6 	= 	$MySmartBB->install->strToUtf8($r['ans6']);
		$ans7 	= 	$MySmartBB->install->strToUtf8($r['ans7']);
		$ans8 	= 	$MySmartBB->install->strToUtf8($r['ans8']);
		$res1 	= 	$MySmartBB->install->strToUtf8($r['res1']);
		$res2 	= 	$MySmartBB->install->strToUtf8($r['res2']);
		$res3 	= 	$MySmartBB->install->strToUtf8($r['res3']);
		$res4 	= 	$MySmartBB->install->strToUtf8($r['res4']);
		$res5 	= 	$MySmartBB->install->strToUtf8($r['res5']);
		$res6 	= 	$MySmartBB->install->strToUtf8($r['res6']);
		$res7 	= 	$MySmartBB->install->strToUtf8($r['res7']);
		$res8 	= 	$MySmartBB->install->strToUtf8($r['res8']);

		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['poll'] . " SET 
												qus='" . $qus . "',
												ans1='" . $ans1 . "',
												ans2='" . $ans2 . "',
												ans3='" . $ans3 . "',
												ans4='" . $ans4 . "',
												ans5='" . $ans5 . "',
												ans6='" . $ans6 . "',
												ans7='" . $ans7 . "',
												ans8='" . $ans8 . "',
												res1='" . $res1 . "',
												res2='" . $res2 . "',
												res3='" . $res3 . "',
												res4='" . $res4 . "',
												res5='" . $res5 . "',
												res6='" . $res6 . "',
												res7='" . $res7 . "',
												res8='" . $res8 . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز الاستفتاء رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الخامسه بعد العاشره : تغيير ترميز الاقسام','?step=15');
}
elseif ($MySmartBB->_GET['step'] == 15)
{
	$MySmartBB->html->cells('الخطوه الخامسه بعد العاشره : تغيير ترميز الاقسام','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['section'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$title 			= 	$MySmartBB->install->strToUtf8($r['title']);
		$describe 		= 	$MySmartBB->install->strToUtf8($r['section_describe']);
		$last_writer 	= 	$MySmartBB->install->strToUtf8($r['last_writer']);
		$last_subject 	= 	$MySmartBB->install->strToUtf8($r['last_subject']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['section'] . " SET 
												title='" . $title . "',
												section_describe='" . $describe . "',
												last_writer='" . $last_writer . "',
												last_subject='" . $last_subject . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز القسم رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه السادسه بعد العاشره : تغيير ترميز المشرفين','?step=16');
}
elseif ($MySmartBB->_GET['step'] == 16)
{
	$MySmartBB->html->cells('الخطوه السادسه بعد العاشره : تغيير ترميز المشرفين','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['section_admin'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$username = $MySmartBB->install->strToUtf8($r['username']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['section_admin'] . " SET 
												username='" . $username . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز المشرف رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه السابعه بعد العاشره : تغيير ترميز الانماط','?step=17');
}
elseif ($MySmartBB->_GET['step'] == 17)
{
	$MySmartBB->html->cells('الخطوه السابعه بعد العاشره : تغيير ترميز الانماط','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['style'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$title = $MySmartBB->install->strToUtf8($r['style_title']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['style'] . " SET 
												style_title='" . $title . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز النمط رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثامنه بعد العاشره : تغيير ترميز مراقبة المشرفين','?step=18');
}
elseif ($MySmartBB->_GET['step'] == 18)
{
	$MySmartBB->html->cells('الخطوه الثامنه بعد العاشره : تغيير ترميز مراقبة المشرفين','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['sm_logs'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$username 		= 	$MySmartBB->install->strToUtf8($r['username']);
		$edit_action 	= 	$MySmartBB->install->strToUtf8($r['edit_action']);
		$subject_title 	= 	$MySmartBB->install->strToUtf8($r['subject_title']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['sm_logs'] . " SET 
												username='" . $title . "',
												edit_action'" . $edit_action . "',
												subject_title='" . $subject_title . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز المراقبه رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه التاسعه بعد العاشره : تغيير ترميز صندوق الادوات','?step=19');
}
elseif ($MySmartBB->_GET['step'] == 19)
{
	$MySmartBB->html->cells('الخطوه التاسعه بعد العاشره : تغيير ترميز صندوق الادوات','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['toolbox'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$name 		= 	$MySmartBB->install->strToUtf8($r['name']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['toolbox'] . " SET 
												name='" . $name . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز الاداة رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه العشرون : تغيير ترميز مسميات الاعضاء','?step=20');
}
elseif ($MySmartBB->_GET['step'] == 20)
{
	$MySmartBB->html->cells('الخطوه العشرون : تغيير ترميز مسميات الاعضاء','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['usertitle'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$usertitle 		= 	$MySmartBB->install->strToUtf8($r['usertitle']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['usertitle'] . " SET 
												usertitle='" . $usertitle . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز المسمى رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الاولى بعد العشرين : تغيير ترميز الاعلانات التجاريه','?step=21');
}
elseif ($MySmartBB->_GET['step'] == 21)
{
	$MySmartBB->html->cells('الخطوه الاولى بعد العشرين : تغيير ترميز الاعلانات التجاريه','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['ads'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$name 		= 	$MySmartBB->install->strToUtf8($r['sitename']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['ads'] . " SET 
												sitename='" . $name . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز الاعلان رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثانيه بعد العشرين : تغيير ترميز الاعلانات الاداريه','?step=22');
}
elseif ($MySmartBB->_GET['step'] == 22)
{
	$MySmartBB->html->cells('الخطوه الثانيه بعد العشرين : تغيير ترميز الاعلانات الاداريه','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->install->loadCharset();
	
	$query = $MySmartBB->DB->sql_query("SELECT * FROM " . $MySmartBB->table['announcement'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->DB->sql_fetch_array($query))
	{
		$title 		= 	$MySmartBB->install->strToUtf8($r['title']);
		$text 		= 	$MySmartBB->install->strToUtf8($r['text']);
		$writer 	= 	$MySmartBB->install->strToUtf8($r['writer']);
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['announcement'] . " SET 
												title='" . $title . "',
												text='" . $text . "',
												writer='" . $writer . "'
													WHERE id='" . $r['id'] . "'");
													
		if ($update)
		{
			$MySmartBB->html->p_msg('تم تغيير ترميز الاعلان رقم #' . $r['id']);
		}
	}
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثالثه بعد العشرين : تصحيح النمط الافتراضي','?step=23');
}
elseif ($MySmartBB->_GET['step'] == 23)
{
	$MySmartBB->html->cells('الخطوه الثالثه بعد العشرين : تصحيح النمط الافتراضي','main1');
	$MySmartBB->html->close_table();
	
	$repair = $MySmartBB->install->RepairDefaultStyle();
	
	if ($repair)
	{
		$MySmartBB->html->msg('تم تصحيح النمط الافتراضي');
	}
	
	$MySmartBB->html->make_link('الخطوه الرابعه بعد العشرين','?step=24');
}
elseif ($MySmartBB->_GET['step'] == 24)
{
	$MySmartBB->html->cells('الخطوه الرابعه بعد العشرين : تصحيح مسار الايقونات','main1');
	$MySmartBB->html->close_table();
	
	$repair = $MySmartBB->install->FixIconsPath();
	
	if (in_array('false',$repair))
	{
		$MySmartBB->html->msg('لم يتم التصحيح كاملاً');
	}
	else
	{
		$MySmartBB->html->msg('تم تصحيح مسار الايقونات');
	}
	
	$MySmartBB->html->make_link('الخطوه الخامسه بعد العشرين : تصحيح مسار الابتسامات','?step=25');
}
elseif ($MySmartBB->_GET['step'] == 25)
{
	$MySmartBB->html->cells('الخطوه الخامسه بعد العشرين : تصحيح مسار الابتسامات','main1');
	$MySmartBB->html->close_table();
	
	$repair = $MySmartBB->install->FixSmilesPath();
	
	if (in_array('false',$repair))
	{
		$MySmartBB->html->msg('لم يتم التصحيح كاملاً');
	}
	else
	{
		$MySmartBB->html->msg('تم تصحيح مسار الايقونات');
	}
	
	$MySmartBB->html->make_link('الخطوه السادسه بعد العشرين : عمليات الانشاء','?step=26');
}
elseif ($MySmartBB->_GET['step'] == 26)
{
	$MySmartBB->html->cells('الخطوه السادسه بعد العشرين : عمليات الانشاء','main1');
	$MySmartBB->html->close_table();
	
	
	$p 			= 	array();
	$msgs 		= 	$MySmartBB->install->_Masseges;
	
	$p[1] 		= 	$MySmartBB->install->CreateBannedTable();
	$msgs[1] 	= 	($p[1]) ? 'تم إنشاء جدول الحظر' : 'لم يتم إنشاء جدول الحظر';
	
	$p[2]		=	$MySmartBB->install->ChangeAnnouncementDate();
	$msgs[2]	=	($p[2]) ? 'تم تغيير حقل التاريخ في جدول الاعلانات الاداريه' : 'لم يتم تغيير حقل التاريخ في جدول الاعلانات الاداريه';
	
	$p[3]		=	$MySmartBB->install->AddForumsCache();
	$msgs[3]	=	($p[3]) ? 'تم اضافة حقل المعلومات المخبأه' : 'لم يتم اضافة حقل المعلومات المخبأه';
	
	$p[4] 		= 	$MySmartBB->install->AddSectionsNumber();
	$msgs[4] 	= 	($p[4]) ? 'تم إنشاء مدخل عدد الاقسام' : 'لم يتم إنشاء مدخل عدد الاقسام';
	
	$p[5]		=	$MySmartBB->install->AddSubSectionsNumber();
	$msgs[5]	=	($p[5]) ? 'تم إنشاء مدخل عدد المنتديات الفرعيه' : 'لم يتم إنشاء مدخل عدد المنتديات الفرعيه';
	
	$p[6]		=	$MySmartBB->install->AddSectionGroupNumber();
	$msgs[6]	=	($p[6]) ? 'تم إنشاء مدخل عدد مجموعات الاقسام' : 'لم يتم إنشاء مدخل عدد مجموعات الاقسام';
	
	$p[7]		=	$MySmartBB->install->AddSmilesNumber();
	$msgs[7]	=	($p[7]) ? 'تم إنشاء مدخل عدد الابتسامات' : 'لم يتم إنشاء مدخل عدد الابتسامات';
	
	$p[8]		=	$MySmartBB->install->AddReplyNumber();
	$msgs[8]	=	($p[8]) ? 'تم اضافة حقل عدد الردود' : 'لم يتم اضافة حقل عدد الردود';
	
	$p[9]		=	$MySmartBB->install->AddSubjectNumber();
	$msgs[9]	=	($p[9]) ? 'تم اضافة حقل عدد المواضيع' : 'لم يتم اضافة حقل عدد المواضيع';
	
	$p[10]		=	$MySmartBB->install->AddStyleCache();
	$msgs[10]	=	($p[10]) ? 'تم اضافة حقل كاش الانماط' : 'لم يتم اضافة حقل كاش الانماط';
	
	$p[11]		=	$MySmartBB->install->AddStyleIDCache();
	$msgs[11]	=	($p[11]) ? 'تم اضافة حقل كاش معرّف النمط' : 'لم يتم اضافة حقل كاش معرّف النمط';
	
	$p[12]		=	$MySmartBB->install->AddUpdateStyleCache();
	$msgs[12]	=	($p[12]) ? 'تم اضافة حقل تحديث كاش الانماط' : 'لم يتم اضافة حقل تحديث كاش الانماط';
		
	$p[13]		=	$MySmartBB->install->AddTodayDateCache();
	$msgs[13]	=	($p[13]) ? 'تم إنشاء مدخل كاش تاريخ اليوم' : 'لم يتم إنشاء مدخل كاش تاريخ اليوم';
	
	$p[14]		=	$MySmartBB->install->AddTodayNumberCache();
	$msgs[14]	=	($p[14]) ? 'تم إنشاء مدخل كاش عدد زوار اليوم' : 'لم يتم إنشاء مدخل كاش عدد زوار اليوم';
	
	$p[15]		=	$MySmartBB->install->AddAdressBarSeparate();
	$msgs[15]	=	($p[15]) ? 'تم إنشاء مدخل فاصل العنوان' : 'لم يتم إنشاء مدخل فاصل';
	
	$MySmartBB->html->open_p();
	
	foreach ($msgs as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه السابعه بعد العشرين : تحديث الكاش','?step=27');

}
elseif ($MySmartBB->_GET['step'] == 27)
{
	$MySmartBB->html->cells('الخطوه السابعه بعد العشرين : تحديث الكاش','main1');
	$MySmartBB->html->close_table();
	
	
	$p 			= 	array();
	$msgs 		= 	$MySmartBB->install->_Masseges;
	
	$p[1] 		= 	$MySmartBB->install->UpdateForumsCache();
	$msgs[1] 	= 	($p[1]) ? 'تم تحديث كاش المنتديات' : 'لم يتم تحديث كاش المنتديات';
	
	$p[2]		=	$MySmartBB->install->UpdateSubForumsCache();
	$msgs[2]	=	($p[2]) ? 'تم تحديث كاش المنتديات الفرعيه' : 'لم يتم تحديث كاش المنتديات الفرعيه';
	
	$p[3]		=	$MySmartBB->install->UpdateSectionGroupCache();
	$msgs[3]	=	($p[3]) ? 'تم تحديث كاش الصلاحيات' : 'لم يتم تحديث كاش الصلاحيات';
	
	$p[4]		=	$MySmartBB->install->UpdateSmilesNumberCache();
	$msgs[4]	=	($p[4]) ? 'تم تحديث كاش عدد الابتسامات' : 'لم يتم تحديث كاش الابتسامات';
	
	$MySmartBB->html->open_p();
	
	foreach ($msgs as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثامنه بعد العشرين','?step=28');
}
elseif ($MySmartBB->_GET['step'] == 28)
{
	$MySmartBB->html->cells('الخطوه الثامنه بعد العشرين','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->open_p();
	$MySmartBB->html->make_link('اضغط هنا','THETA.php?step=1');
	$MySmartBB->html->p_msg(' لتبدأ تحديثات THETA');
	$MySmartBB->html->close_p();
	
	$NewVersion = $MySmartBB->install->UpdateVersion();
}

?>
