<?php

/**
* 	SEGMA upgrager :
*		1- Upgrade to new method of info table
*		2- Add forum's create day to info table
*		3- Drop "notinindex_id" field from online table
*		4- Add logged field to member table
*		5- Add register_time field to member table
*		6- Convert register dates format from old method to new one (which based on unixstamp)
*/

include('../common.php');

require_once( 'MySmartUpgrader.class.php' );

function sql_query( $sql )
{
	echo $sql;
}

class MySmartSEGMA extends MySmartInstall
{
	var $_TempArr 	= 	array();
	var $_Masseges	=	array();
	
	// Convert old info table to new info table :)
	/*function ConvertInfoTable()
	{
		global $MySmartBB;
		
		$prefix = $MySmartBB->getPrefix();
		
		$this->_TempArr['RenameArr'] = array();
		$this->_TempArr['RenameArr']['old_name'] = $prefix . 'info';
		$this->_TempArr['RenameArr']['new_name'] = $prefix . 'oldinfo';
		
		$rename = $this->rename_field($this->_TempArr['RenameArr']);
	
		if ($rename)
		{
			$this->_TempArr['CreateArr']				= 	array();
			$this->_TempArr['CreateArr']['table_name'] 	= 	$prefix . 'info';
			$this->_TempArr['CreateArr']['fields'] 		= 	array();
			$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
			$this->_TempArr['CreateArr']['fields'][] 	= 	'var_name VARCHAR( 255 ) NOT NULL';
			$this->_TempArr['CreateArr']['fields'][] 	= 	'value text NOT NULL';
			
			$create = $this->create_table($this->_TempArr['CreateArr']);
			
			if ($create)
			{
				$getoldinfo = sql_query('SELECT * FROM ' . $prefix . "oldinfo WHERE id='1'");
				$old_info   = $MySmartBB->DB->sql_fetch_array($getoldinfo);
				        
		        $did = false;
		        
				$field_query = sql_query('SHOW FIELDS FROM ' . $prefix . 'oldinfo');
				while ($row = $MySmartBB->DB->sql_fetch_array($field_query))
				{
					$value = addslashes($old_info[$row['Field']]);		    
		    
		    		$query = sql_query("INSERT INTO " . $prefix . "info(id,var_name,value) VALUES('NULL','" . $row['Field'] . "','" . $value . "')");
		    		
		    		if ($query)
		    		{		    			
		    			$did = true;
		    		}
				}

				if ($did)
				{			
					$del = $this->drop_table($prefix . 'oldinfo');
			
					if ($del)
					{
						return true;
					}
				}
			}
		}
	}
	
	// The create_date entry
	function AddCreateDateEntry()
	{
		global $MySmartBB;
		
		$query = sql_query('SELECT register_date FROM ' . $MySmartBB->table['member'] . ' ORDER BY id ASC LIMIT 1');
		$row = $MySmartBB->DB->sql_fetch_array($query);
		
		$date = $this->_DateFormatDo($row['register_date']);
		
		$new_date = explode('/', $date, 3);
		$time = gmmktime(0,  0, 0, $new_date[1], $new_date[2], $new_date[0]);
		
		$insert = sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='create_date',value='" . $time . "'");
		
		return ($insert) ? true : false;
	}*/
	
	// Drop notinindex_id
	function DropNotInIndex()
	{
		global $MySmartBB;
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] = $MySmartBB->table['online'];
		$this->_TempArr['DropArr']['field_name'] = 'notinindex_id';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		return ($drop) ? true : false;
	}
	
	// Add logged field
	function AddLogged()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 				= array();
		$this->_TempArr['AddArr']['table'] 		= $MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] = 'logged';
		$this->_TempArr['AddArr']['field_des'] 	= 'VARCHAR( 30 ) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddRegisterTime()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 				= array();
		$this->_TempArr['AddArr']['table'] 		= $MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] = 'register_time';
		$this->_TempArr['AddArr']['field_des'] 	= 'VARCHAR( 50 ) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	//function NewRegisterDateFormat(/* I Love & :D */&$msgs)
	/*{
		global $MySmartBB;
				
		$query = sql_query('SELECT * FROM ' . $MySmartBB->table['member']);
		
		while ($row = $MySmartBB->DB->sql_fetch_array($query))
		{
			$r_date = $this->_DateFormatDo($row['register_date']);
			
			$date = explode('/', $r_date, 3);
			$time = gmmktime(0,  0, 0, $date[1], $date[2], $date[0]);
			
			$update = sql_query("UPDATE " . $MySmartBB->table['member'] . " SET register_time='" . $time . "'");
			
			if ($update)
			{
				$msgs[] = 'تم تحديث تاريخ تسجيل ' . htmlspecialchars($row['username']);
			}
		}
	}*/
	
	// By KHALED MAMDOUH .. vbzoom.com
 	/*function _DateFormatDo($GetDateFormat,$DateFormat="j/n/Y")
    {
  		$Day   = SubStr($GetDateFormat,8,2);
  		$Month = SubStr($GetDateFormat,5,2);
  		$Year  = SubStr($GetDateFormat,0,4);

  		$ResultDate = @date ($DateFormat, mktime (0,0,0,$Month,$Day,$Year));

  		return $ResultDate;
 	}*/
 	
 	/*function FixCaches(&$msgs)
 	{
 		global $MySmartBB;
 		
 		//  Smiles Cache
		$update = $this->_UpdateSmileArray();
		$msgs[] = ($update) ? 'تم تحديث كاش الابتسامات' : 'لم يتم تحديث كاش الابتسامات';
 	}
 		
	function _UpdateSmileArray()
	{
		global $MySmartBB;
		
		$cache = $MySmartBB->icon->UpdateSmilesCache(null);
		
		return ($cache) ? true : false;
	}
	
	function UpdateVersion()
	{
		global $MySmartBB;
		
		$update = sql_query("UPDATE " . $MySmartBB->table['info'] . " SET value='2.0 SEGMA' WHERE var_name='MySBB_version'");
		
		return ($update) ? true : false;
	}*/
}

$Upgrader = new MySmartUpgrader( $MySmartBB, 'segma' );

$Upgrader->addFields();



$MySmartBB->install = new MySmartSEGMA;

$MySmartBB->html->page_header('معالج ترقية برنامج منتديات MySmartBB');

$logo = $MySmartBB->html->create_image(array('align'=>'right','alt'=>'MySmartBB','src'=>'../logo.jpg','return'=>true));
$MySmartBB->html->open_table('100%',true);
$MySmartBB->html->cells($logo,'header_logo_side');

if ($MySmartBB->_GET['welcome'] or !isset($MySmartBB->_GET['step']))
{
	$MySmartBB->html->cells('مرحباً بك','main1');
	$MySmartBB->html->close_table();

	$MySmartBB->html->msg('مرحباً بك في معالج ترقية الجيل الاول من برنامج MySmartBB إلى الجيل الثاني');
	$MySmartBB->html->msg('يرجى التحقق من انك قمت بأخذ نسخه احتياطيه من قاعدة البيانات قبل البدأ بعملية الترقيه، بالاضافه إلى التحقق من انك تستخدم آخر نسخه من الجيل الاول من ابناء 1.5.x حتى تتمكن من الترقيه بدون مشاكل.');
	$MySmartBB->html->msg('ملاحظه : عملية الترقيه طويله قليلاً و مُقسمه إلى عدّة خطوات و مراحل.');
	
	$MySmartBB->html->make_link('الخطوه الاولى -> تعديلات على جداول قواعد البيانات','?step=1');
}
elseif ($MySmartBB->_GET['step'] == 1)
{
	$MySmartBB->html->cells('الخطوه الاولى : تعديلات على جداول قواعد البيانات','main1');
	$MySmartBB->html->close_table();
	
	$p 			= 	array();
	$msgs 		= 	$MySmartBB->install->_Masseges;
	
	/*$p[1] 		= 	$MySmartBB->install->ConvertInfoTable();
	$msgs[1] 	= 	($p[1]) ? 'تم تحديث جدول المعلومات إلى النمط الجديد' : 'لم يتم تحديث جدول المعلومات إلى النمط الجديد';*/
	
	/*$p[2]		=	$MySmartBB->install->AddCreateDateEntry();
	$msgs[2]	=	($p[2]) ? 'تم اضافه مدخل تاريخ انشاء المنتدى' : 'لم يتم اضافة مدخل تاريخ انشاء المنتدى';*/
	
	$p[3]		=	$MySmartBB->install->DropNotInIndex();
	$msgs[3]	=	($p[3]) ? 'تم حذف الحقل' : 'لم يتم حذف الحقل';
	
	$p[4]		=	$MySmartBB->install->AddLogged();
	$msgs[4]	=	($p[4]) ? 'تم اضافة الحقل logged' : 'لم يتم اضافة الحقل logged';
	
	$p[5]		=	$MySmartBB->install->AddRegisterTime();
	$msgs[5]	=	($p[5]) ? 'تم اضافة الحقل register_time' : 'لم يتم اضافة الحقل register_time';
	
	$MySmartBB->html->open_p();
	
	foreach ($msgs as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$NewVersion = $MySmartBB->install->UpdateVersion();
	
	$MySmartBB->html->make_link('الخطوه الثانيه -> تعديل تاريخ التسجيل','?step=2');
}
elseif ($MySmartBB->_GET['step'] == 2)
{
	$MySmartBB->html->cells('الخطوه الثانيه : تعديل تاريخ التسجيل','main1');
	$MySmartBB->html->close_table();
	
	$p		=	array();
	
	$p[]	=	$MySmartBB->install->NewRegisterDateFormat($MySmartBB->install->_Masseges);
	
	$MySmartBB->html->open_p();
	
	foreach ($MySmartBB->install->_Masseges as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثالثه -> تعديل الكاش','?step=3');
}
elseif ($MySmartBB->_GET['step'] == 3)
{
	$MySmartBB->html->cells('الخطوه الثالثه : تعديل الكاش','main1');
	$MySmartBB->html->close_table();
	
	$p		=	array();
	
	$p[]	=	$MySmartBB->install->FixCaches($MySmartBB->install->_Masseges);
	
	$MySmartBB->html->open_p();
	
	foreach ($MySmartBB->install->_Masseges as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الرابعه','?step=4');
}
elseif ($MySmartBB->_GET['step'] == 4)
{
	$MySmartBB->html->cells('الخطوه الرابعه','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->open_p();
	$MySmartBB->html->make_link('اضغط هنا','OMEGA.php?step=1');
	$MySmartBB->html->p_msg(' لتبدأ تحديثات OMEGA');
	$MySmartBB->html->close_p();
}

?>
