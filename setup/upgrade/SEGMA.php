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

class MySmartSEGMA extends MySmartInstall
{
	// The create_date entry
	function AddCreateDateEntry()
	{

	}
	
}

// Original code By KHALED MAMDOUH (vbzoom.com)
function convertDate( $date, $format = 'j/n/Y' )
{
	$day   = substr( $date, 8, 2);
	$month = substr( $date, 5, 2);
	$year  = substr( $date, 0, 4);
	
	return date( $format, mktime( 0, 0, 0, $month, $day, $year ) );	
}

function convertInfoTable()
{
	global $MySmartBB;
	
	$prefix = $MySmartBB->getPrefix();
	
	$rename = $MySmartBB->db->sql_query( "RENAME TABLE " . $prefix  . "info TO " . $prefix . "oldinfo" );
	
	if ( $rename )
	{
		// TODO :: The code of creating "info" table should be here
		
		/* $create = blah blah ...	*/
		
		if ( $create )
		{
			$query = $MySmartBB->db->sql_query( 'SELECT * FROM ' . $prefix . "oldinfo WHERE id='1'" );
			$old_info = $MySmartBB->db->sql_fetch_array( $query );
			
			$did = false;
			
			$query = $MySmartBB->db->sql_query( 'SHOW FIELDS FROM ' . $prefix . 'oldinfo' );
			
			while ( $r = $MySmartBB->db->sql_fetch_array($query) )
			{
				$value = addslashes( $old_info[ $row['Field'] ] );
				
				$query = $MySmartBB->db->sql_query( "INSERT INTO " . $prefix . "info(id,var_name,value) VALUES('NULL','" . $r[ 'Field' ] . "','" . $value . "')" );
				
				$did = ( $query ) ? true : false;
			}
			
			if ( $did )
			{
				$del = $this->drop_table($prefix . 'oldinfo');
				
				$del = $MySmartBB->db->sql_query( "DROP TABLE " . $prefix . "oldinfo" );
				
				return ( $del ) ? true : false;
			}
			else
			{
				return false;
			}
		}
	}
	
	return false;
}

function storeCreateDate()
{
	global $MySmartBB;

	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
	$MySmartBB->rec->order = 'id ASC';
	$MySmartBB->rec->limit = '1';
	
	$row = $MySmartBB->rec->getInfo();
	
	$d = convertDate( $row[ 'register_date' ] );

	$date = explode( '/', $d, 3 );
	$time = gmmktime( 0, 0, 0, $date[ 1 ], $date[ 2 ], $date[ 0 ] );
	
	$MySmartBB->rec->table = $MySmartBB->table[ 'info' ];
	$MySmartBB->rec->fields = array(	'var_name'	=>	'create_date',
										'value'		=>	$time	);
	
	$insert = $MySmartBB->rec->insert();

	return ( $insert ) ? true : false;
}

$Upgrader = new MySmartUpgrader( $MySmartBB, 'segma' );

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
	
	$MySmartBB->html->open_p();
	
	if ( convertInfoTable() )
	{
		$MySmartBB->html->p_msg( 'تم تحديث جدول المعلومات إلى النمط الجديد' );
	}
	else
	{
		$MySmartBB->html->p_msg( 'لم يتم تحديث جدول المعلومات إلى النمط الجديد' );
	}
	
	if ( storeCreateDate() )
	{
		$MySmartBB->html->p_msg( 'تم اضافه مدخل تاريخ انشاء المنتدى' );
	}
	else
	{
		$MySmartBB->html->p_msg( 'لم يتم اضافه مدخل تاريخ انشاء المنتدى' );
	}
	
	$Upgrader->addFields();
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->info->updateInfo( 'MySBB_version', '2.0 SEGMA' );
	
	$MySmartBB->html->make_link('الخطوه الثانيه -> تعديل تاريخ التسجيل','?step=2');
}
elseif ($MySmartBB->_GET['step'] == 2)
{
	$MySmartBB->html->cells('الخطوه الثانيه : تعديل تاريخ التسجيل','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->open_p();
	
	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
	
	$MySmartBB->rec->getList();
	
	while ( $r = $MySmartBB->rec->getInfo() )
	{
		$d = convertDate( $r[ 'register_date' ] );
		
		$date = explode( '/', $d, 3 );
		$time = gmmktime( 0, 0, 0, $date[ 1 ], $date[ 2 ], $date[ 0 ] );
		
		$MySmartBB->rec->table 		= 	$MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter 	= 	"id='" . $r[ 'id' ] . "'";
		$MySmartBB->rec->fields 	= 	array(	'register_time'	=>	$time	);
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
			$MySmartBB->html->p_msg( 'تم تحديث تاريخ تسجيل ' . $r[ 'username' ] );
		}
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثالثه -> تعديل الكاش','?step=3');
}
elseif ($MySmartBB->_GET['step'] == 3)
{
	$MySmartBB->html->cells('الخطوه الثالثه : تعديل الكاش','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->open_p();
	
	$cache = $MySmartBB->icon->updateSmilesCache();
	
	if ( $cache )
	{
		$MySmartBB->html->p_msg( 'تم تحديث كاش الابتسامات' );
	}
	else
	{
		$MySmartBB->html->p_msg( 'لم يتم تحديث كاش الابتسامات' );
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
