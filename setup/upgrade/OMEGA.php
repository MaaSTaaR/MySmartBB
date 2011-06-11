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

include('../common.php');

require_once( 'MySmartUpgrader.class.php' );

// Text to utf-8 class, By : Alexander Minkovsky (a_minkovsky@hotmail.com)
class textToUTF
{
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
}

$Upgrader = new MySmartUpgrader( $MySmartBB, 'omega' );
$utf = new textToUTF;

$prefix = $MySmartBB->getPrefix();

$MySmartBB->html->page_header('معالج ترقية برنامج منتديات MySmartBB');

$logo = $MySmartBB->html->create_image(array('align'=>'right','alt'=>'MySmartBB','src'=>'../logo.jpg','return'=>true));
$MySmartBB->html->open_table('100%',true);
$MySmartBB->html->cells($logo,'header_logo_side');

/*if ( $MySmartBB->_CONF['info_row']['MySBB_version'] != '2.0 SEGMA' )
{
	$MySmartBB->html->cells('اصدار غير صحيح','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->functions->error('يرجى التحقق من انك قمت بتشغيل تحديثات SEGMA');
}*/

if ($MySmartBB->_GET['step'] == 1)
{
	$MySmartBB->html->cells('عمليات التغيير','main1');
	$MySmartBB->html->close_table();

	$MySmartBB->html->open_p();
	
	$Upgrader->change();
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثانيه -> عمليات الحذف','?step=2');
}
elseif ($MySmartBB->_GET['step'] == 2)
{
	$MySmartBB->html->cells('عمليات الحذف','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->open_p();
	
	$Upgrader->drop();
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثالثه -> عمليات تغيير الاسم','?step=3');
}
elseif ($MySmartBB->_GET['step'] == 3)
{
	$MySmartBB->html->cells('عمليات تغيير الاسم','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->open_p();
	
	$Upgrader->rename();
		
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الرابعه : تغيير ترميز المواضيع','?step=4');
}
elseif ($MySmartBB->_GET['step'] == 4)
{
	$MySmartBB->html->cells('الخطوه الرابعه : تغيير ترميز المواضيع','main1');
	$MySmartBB->html->close_table();
		
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['subject'] . " ORDER BY id ASC");
	
	$MySmartBB->html->open_p();

	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$title 		= 	$utf->strToUtf8($r['title']);
		$text 		= 	$utf->strToUtf8($r['text']);
		$writer 	= 	$utf->strToUtf8($r['writer']);
		$describe 	= 	$utf->strToUtf8($r['subject_describe']);
		$action_by 	= 	$utf->strToUtf8($r['action_by']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['subject'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['reply'] . " ORDER BY id ASC");
	
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$title 		= 	$utf->strToUtf8($r['title']);
		$text 		= 	$utf->strToUtf8($r['text']);
		$writer 	= 	$utf->strToUtf8($r['writer']);
		$action_by 	= 	$utf->strToUtf8($r['action_by']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['reply'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['attach'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$filename = $utf->strToUtf8($r['filename']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['attach'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['email_msg'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$title = $utf->strToUtf8($r['title']);
		$text = $utf->strToUtf8($r['text']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['email_msg'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['group'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$title = $utf->strToUtf8($r['title']);
		$user_title = $utf->strToUtf8($r['user_title']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['group'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['info'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$value = $utf->strToUtf8($r['value']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['info'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['member'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$username 	= 	$utf->strToUtf8($r['username']);
		$email 		= 	$utf->strToUtf8($r['email']);
		$notes 		= 	$utf->strToUtf8($r['user_notes']);
		$sig 		= 	$utf->strToUtf8($r['user_sig']);
		$country 	= 	$utf->strToUtf8($r['user_country']);
		$gender 	= 	$utf->strToUtf8($r['user_gender']);
		$title 		= 	$utf->strToUtf8($r['user_title']);
		$info 		= 	$utf->strToUtf8($r['user_info']);
		$away_msg 	= 	$utf->strToUtf8($r['away_msg']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['member'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['pages'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$title 		= 	$utf->strToUtf8($r['title']);
		$html_code 	= 	$utf->strToUtf8($r['html_code']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['pages'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['pm'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$title 	= 	$utf->strToUtf8($r['title']);
		$from 	= 	$utf->strToUtf8($r['user_from']);
		$to		=	$utf->strToUtf8($r['user_to']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['pm'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['pm_lists'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$list_username 	= 	$utf->strToUtf8($r['list_username']);
		$username 		= 	$utf->strToUtf8($r['username']);

		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['pm_lists'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['poll'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$qus 	= 	$utf->strToUtf8($r['qus']);
		$ans1 	= 	$utf->strToUtf8($r['ans1']);
		$ans2 	= 	$utf->strToUtf8($r['ans2']);
		$ans3 	= 	$utf->strToUtf8($r['ans3']);
		$ans4 	= 	$utf->strToUtf8($r['ans4']);
		$ans5 	= 	$utf->strToUtf8($r['ans5']);
		$ans6 	= 	$utf->strToUtf8($r['ans6']);
		$ans7 	= 	$utf->strToUtf8($r['ans7']);
		$ans8 	= 	$utf->strToUtf8($r['ans8']);
		$res1 	= 	$utf->strToUtf8($r['res1']);
		$res2 	= 	$utf->strToUtf8($r['res2']);
		$res3 	= 	$utf->strToUtf8($r['res3']);
		$res4 	= 	$utf->strToUtf8($r['res4']);
		$res5 	= 	$utf->strToUtf8($r['res5']);
		$res6 	= 	$utf->strToUtf8($r['res6']);
		$res7 	= 	$utf->strToUtf8($r['res7']);
		$res8 	= 	$utf->strToUtf8($r['res8']);

		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['poll'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['section'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$title 			= 	$utf->strToUtf8($r['title']);
		$describe 		= 	$utf->strToUtf8($r['section_describe']);
		$last_writer 	= 	$utf->strToUtf8($r['last_writer']);
		$last_subject 	= 	$utf->strToUtf8($r['last_subject']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['section'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['section_admin'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$username = $utf->strToUtf8($r['username']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['section_admin'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['style'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$title = $utf->strToUtf8($r['style_title']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['style'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['sm_logs'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$username 		= 	$utf->strToUtf8($r['username']);
		$edit_action 	= 	$utf->strToUtf8($r['edit_action']);
		$subject_title 	= 	$utf->strToUtf8($r['subject_title']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['sm_logs'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['toolbox'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$name 		= 	$utf->strToUtf8($r['name']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['toolbox'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['usertitle'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$usertitle 		= 	$utf->strToUtf8($r['usertitle']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['usertitle'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['ads'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$name 		= 	$utf->strToUtf8($r['sitename']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['ads'] . " SET 
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
	
	$utf->loadCharset();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['announcement'] . " ORDER BY id ASC");
		
	$MySmartBB->html->open_p();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$title 		= 	$utf->strToUtf8($r['title']);
		$text 		= 	$utf->strToUtf8($r['text']);
		$writer 	= 	$utf->strToUtf8($r['writer']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['announcement'] . " SET 
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
	
	$insert = $MySmartBB->db->sql_query("INSERT INTO " . $MySmartBB->table['style'] . " SET
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
		$id = $MySmartBB->db->sql_insert_id();
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['info'] . " SET value='" . $id . "' WHERE var_name='def_style'");
		
		if ($update)
		{
			$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['member'] . " SET style='" . $id . "'");
			
			if ( $update )
			{
				$MySmartBB->html->msg('تم تصحيح النمط الافتراضي');
			}
		}
	}
		
	$MySmartBB->html->make_link('الخطوه الرابعه بعد العشرين','?step=24');
}
elseif ($MySmartBB->_GET['step'] == 24)
{
	$MySmartBB->html->cells('الخطوه الرابعه بعد العشرين : تصحيح مسار الايقونات','main1');
	$MySmartBB->html->close_table();
	
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['smiles'] . " WHERE smile_type='1'");
	
	$state = array();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['smiles']  . " SET smile_path='modules/images/icons/" . $r['smile_path'] . "' WHERE id='" . $r['id'] . "'");

		if ($update)
		{
			$MySmartBB->html->msg( '#' . $r[ 'id' ] . ' OK' );
		}
	}
	
	$MySmartBB->html->make_link('الخطوه الخامسه بعد العشرين : تصحيح مسار الابتسامات','?step=25');
}
elseif ($MySmartBB->_GET['step'] == 25)
{
	$MySmartBB->html->cells('الخطوه الخامسه بعد العشرين : تصحيح مسار الابتسامات','main1');
	$MySmartBB->html->close_table();
		
	$query = $MySmartBB->db->sql_query("SELECT * FROM " . $MySmartBB->table['smiles'] . " WHERE smile_type='0'");
	
	$state = array();
	
	while ($r = $MySmartBB->db->sql_fetch_array($query))
	{
		$s = str_replace('image/smiles/','',$r['smile_path']);
		
		$update = $MySmartBB->db->sql_query("UPDATE " . $MySmartBB->table['smiles']  . " SET smile_path='modules/images/smiles/" . $s . "' WHERE id='" . $r['id'] . "'");
	
		if ($update)
		{
			$MySmartBB->html->msg( '#' . $r[ 'id' ] . ' OK' );
		}
	}
	
	$MySmartBB->html->make_link('الخطوه السادسه بعد العشرين : عمليات الانشاء','?step=26');
}
elseif ($MySmartBB->_GET['step'] == 26)
{
	$MySmartBB->html->cells('الخطوه السادسه بعد العشرين : عمليات الانشاء','main1');
	$MySmartBB->html->close_table();
	
	$Upgrader->add();
	
	// TODO
	/*$p[1] 		= 	CreateBannedTable();
	$msgs[1] 	= 	($p[1]) ? 'تم إنشاء جدول الحظر' : 'لم يتم إنشاء جدول الحظر';*/
	
	// TODO :INFO TABLE
	
	/*$p[13]		=	$utf->AddTodayDateCache();
	$msgs[13]	=	($p[13]) ? 'تم إنشاء مدخل كاش تاريخ اليوم' : 'لم يتم إنشاء مدخل كاش تاريخ اليوم';*/
	
	/*$p[14]		=	$utf->AddTodayNumberCache();
	$msgs[14]	=	($p[14]) ? 'تم إنشاء مدخل كاش عدد زوار اليوم' : 'لم يتم إنشاء مدخل كاش عدد زوار اليوم';*/
	
	/*$p[15]		=	$utf->AddAdressBarSeparate();
	$msgs[15]	=	($p[15]) ? 'تم إنشاء مدخل فاصل العنوان' : 'لم يتم إنشاء مدخل فاصل';*/
	
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
	$msgs 		= 	$utf->_Masseges;
	
	$p[1] 		= 	$utf->UpdateForumsCache();
	$msgs[1] 	= 	($p[1]) ? 'تم تحديث كاش المنتديات' : 'لم يتم تحديث كاش المنتديات';
	
	$p[2]		=	$utf->UpdateSubForumsCache();
	$msgs[2]	=	($p[2]) ? 'تم تحديث كاش المنتديات الفرعيه' : 'لم يتم تحديث كاش المنتديات الفرعيه';
	
	$p[3]		=	$utf->UpdateSectionGroupCache();
	$msgs[3]	=	($p[3]) ? 'تم تحديث كاش الصلاحيات' : 'لم يتم تحديث كاش الصلاحيات';
	
	$p[4]		=	$utf->UpdateSmilesNumberCache();
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
	
	$NewVersion = $utf->UpdateVersion();
}

?>
