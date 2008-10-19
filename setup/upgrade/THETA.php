<?php

/**
* THETA upgrader
*/

define('NO_TEMPLATE',true);

$CALL_SYSTEM				= 	array();
$CALL_SYSTEM['SECTION'] 	= 	true;

include('../common.php');

class MySmartTHETA extends MySmartInstall
{
	var $_TempArr 	= 	array();
	var $_Masseges	=	array();

	function CheckVersion()
	{
		global $MySmartBB;
		
		return ($MySmartBB->_CONF['info_row']['MySBB_version'] == '2.0 OMEGA') ? true : false;
	}
	
	function UpdateVersion()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['info'] . " SET value='2.0.0' WHERE var_name='MySBB_version'");
		
		return ($update) ? true : false;
	}
	
	// Add operation(s)
	function AddAjaxSearch()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='ajax_search',value='0'");
		
		return ($insert) ? true : false;
	}
	
	function AddAjaxRegister()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='ajax_register',value='0'");
		
		return ($insert) ? true : false;
	}
	
	function AddAjaxReply()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='ajax_freply',value='0'");
		
		return ($insert) ? true : false;
	}
	
	function AddAjaxMainRename()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query('INSERT INTO ' . $MySmartBB->table['info'] . " SET var_name='admin_ajax_main_rename',value='0'");
		
		return ($insert) ? true : false;
	}
	
	function AddModerators()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['section'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'moderators';
		$this->_TempArr['AddArr']['field_des'] 		= 	'TEXT NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddAnswers()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['poll'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'answers';
		$this->_TempArr['AddArr']['field_des'] 		= 	'TEXT NOT NULL AFTER qus';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddUsername()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['vote'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'username';
		$this->_TempArr['AddArr']['field_des'] 		= 	'VARCHAR(255) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddAutoreply()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'autoreply';
		$this->_TempArr['AddArr']['field_des'] 		= 	'INT(9) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddAutoreplyTitle()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'autoreply_title';
		$this->_TempArr['AddArr']['field_des'] 		= 	'VARCHAR(255) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddAutoreplyMsg()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'autoreply_msg';
		$this->_TempArr['AddArr']['field_des'] 		= 	'TEXT NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddPMSenders()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'pm_senders';
		$this->_TempArr['AddArr']['field_des'] 		= 	'INT(1) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddPMSendersMsg()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'pm_senders_msg';
		$this->_TempArr['AddArr']['field_des'] 		= 	'VARCHAR(255) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddTagsCache()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['subject'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'tags_cache';
		$this->_TempArr['AddArr']['field_des'] 		= 	'TEXT NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddCloseReason()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['subject'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'close_reason';
		$this->_TempArr['AddArr']['field_des'] 		= 	'VARCHAR(255) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddMemberIP()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['member'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'member_ip';
		$this->_TempArr['AddArr']['field_des'] 		= 	'VARCHAR(20) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddGroupName()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['section_group'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'group_name';
		$this->_TempArr['AddArr']['field_des'] 		= 	'VARCHAR(255) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	function AddMIMEType()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['extension'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'mime_type';
		$this->_TempArr['AddArr']['field_des'] 		= 	'VARCHAR(255) NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	// Rename operation(s)
	function RenameModeratorTable()
	{
		global $MySmartBB;
		
		$rename = $this->rename_table($MySmartBB->prefix . 'sectionadmin',$MySmartBB->prefix . 'moderators');
		
		return ($rename) ? true : false;
	}
	
	// Drop operation(s)
	/****/
		
	// Create operation(s)
    function CreateTagsTable()
    {
    	global $MySmartBB;
    	
		$this->_TempArr['CreateArr']			= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['tag'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'tag VARCHAR( 100 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'number INT( 9 ) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
    }
    
	function CreateTagsSubjectTable()
	{
		global $MySmartBB;
    	
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['tag_subject'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'tag_id INT( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_id INT( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'tag VARCHAR( 255 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_title VARCHAR( 255 ) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
    }
    
    /** New sections system **/
    // Step 1 : Add parent field
    function AddParent()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr'] 			= 	array();
		$this->_TempArr['AddArr']['table'] 		= 	$MySmartBB->table['section'];
		$this->_TempArr['AddArr']['field_name'] 	= 	'parent';
		$this->_TempArr['AddArr']['field_des'] 		= 	'VARCHAR(9) NOT NULL AFTER section_describe';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	// Step 2 : Change the value of "parent" to 0 for sections which have "main_section" equal 1
	function ChangeMainSections()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['section'] . " SET parent='0' WHERE main_section='1'");
		
		return ($update) ? true : false;
	}
	
	// Step 3 : Change the value of "parent" to x for sections which have "main_section" not equal 1 
	// and "from_main_section" equal x
	function ChangeSections()
	{
		global $MySmartBB;
		
		$update = $MySmartBB->DB->sql_query("UPDATE " . $MySmartBB->table['section'] . " AS s SET parent=s.from_main_section WHERE main_section<>'1'");
		
		return ($update) ? true : false;
	}
	
	// Step 4 : Drop unwanted fields
	function DropUnwantedFields()
	{
		$this->_TempArr['DropArr'] 			= 	array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['section'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'main_section';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] 			= 	array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['section'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'from_main_section';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] 			= 	array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['section'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'sub_section';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] 			= 	array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['section'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'from_sub_section';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		// Sorry for this!
		return true;
	}
	
	// Finally : Add section group cache
	function AddSectionGroupCache()
	{
		global $MySmartBB;
		
		$this->_TempArr['AddArr']					=	array();
		$this->_TempArr['AddArr']['table']			=	$MySmartBB->table['section'];
		$this->_TempArr['AddArr']['field_name']		=	'sectiongroup_cache';
		$this->_TempArr['AddArr']['field_des']		=	'TEXT NOT NULL';
		
		$add = $this->add_field($this->_TempArr['AddArr']);
		
		unset($this->_TempArr['AddArr']);
		
		return ($add) ? true : false;
	}
	
	/** New Poll System **/
	function ConvertPollInformation()
	{
		global $MySmartBB;
		
		// TODO :: page support
		$query = $MySmartBB->DB->sql_query('SELECT * FROM ' . $MySmartBB->table['poll']);
		
		while ($r = $MySmartBB->DB->sql_fetch_array($query))
		{
			// We must know the answers number to start work
			$answers_number = 4;
			
			if (!empty($r['ans8']))
			{
				$answers_number = 8;
			}
			elseif (!empty($r['ans7'])
					and empty($r['ans8']))
			{
				$answers_number = 7;
			}
			elseif (!empty($r['ans6'])
					and empty($r['ans7']))
			{
				$answers_number = 6;
			}
			elseif (!empty($r['ans5'])
					and empty($r['ans6']))
			{
				$answers_number = 5;
			}
			
			$answers = array();
     		
     		$x = 0;
     		
     		while ($x < $answers_number)
     		{
     			// The text of the answer
     			$answers[$x][0] = $r['ans{$x+1}'];
     			
     			// The result
     			$answers[$x][1] = $r['res{$x+1}'];
     			
     			$x += 1;
     		}
     				
     		$PollArr 				= 	array();
     		$PollArr['answers'] 	= 	$answers;
     		$PollArr['where']		=	$array('id',$r['id']);
     		
     		$UpdatePoll = $MySmartBB->poll->UpdatePoll($PollArr);
		}
		
		return true;
	}
	
	function DropAnswerFields()
	{
		global $MySmartBB;
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'ans1';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'ans2';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'ans3';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'ans4';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'ans5';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'ans6';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'ans7';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'ans8';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'res1';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'res2';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'res3';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'res4';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'res5';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'res6';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'res7';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		$this->_TempArr['DropArr'] = array();
		$this->_TempArr['DropArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['DropArr']['field_name'] 	= 	'res8';
		
		$drop = $this->drop_field($this->_TempArr['DropArr']);
		
		unset($this->_TempArr['DropArr']);
		
		// Sorry! :/
		return true;
	}
}

$MySmartBB->install = new MySmartTHETA;

$MySmartBB->html->page_header('معالج ترقية برنامج منتديات MySmartBB');

$logo = $MySmartBB->html->create_image(array('align'=>'right','alt'=>'MySmartBB','src'=>'../logo.jpg','return'=>true));
$MySmartBB->html->open_table('100%',true);
$MySmartBB->html->cells($logo,'header_logo_side');

if (!$MySmartBB->install->CheckVersion())
{
	$MySmartBB->html->cells('اصدار غير صحيح','main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->functions->error('يرجى التحقق من انك قمت بتشغيل تحديثات OMEGA');
}

if ($MySmartBB->_GET['step'] == 1)
{
	$MySmartBB->html->cells('عمليات الاضافه','main1');
	$MySmartBB->html->close_table();

	$p 			= 	array();
	$msgs 		= 	$MySmartBB->install->_Masseges;
	
	$p[1] 		= 	$MySmartBB->install->AddAjaxSearch();
	$msgs[1] 	= 	($p[1]) ? 'تم اضافة حقل البحث بإستخدام اجاكس' : 'لم يتم اضافة حقل البحث بإستخدام اجاكس';
	
	$p[2] 		= 	$MySmartBB->install->AddAjaxRegister();
	$msgs[2] 	= 	($p[2]) ? 'تم اضافة حقل التسجيل بإستخدام اجاكس' : 'لم يتم اضافة حقل التسجيل بإستخدام اجاكس';
	
	$p[3] 		= 	$MySmartBB->install->AddAjaxReply();
	$msgs[3] 	= 	($p[3]) ? 'تم اضافة حقل الرد بإستخدام اجاكس' : 'لم يتم اضافة حقل الرد بإستخدام اجاكس';
	
	$p[3] 		= 	$MySmartBB->install->AddAjaxMainRename();
	$msgs[3] 	= 	($p[3]) ? 'تم اضافة حقل  تغيير الاسم بإستخدام اجاكس' : 'لم يتم اضافة حقل تغيير الاسم بإستخدام اجاكس';
	
	$p[4] 		= 	$MySmartBB->install->AddModerators();
	$msgs[4] 	= 	($p[4]) ? 'تم اضافة حقل المشرفين' : 'لم يتم اضافة حقل المشرفين';
	
	$p[4] 		= 	$MySmartBB->install->AddAnswers();
	$msgs[4] 	= 	($p[4]) ? 'تم اضافة حقل الاجوبه' : 'لم يتم اضافة حقل الاجوبه';
	
	$p[5] 		= 	$MySmartBB->install->AddUsername();
	$msgs[5] 	= 	($p[5]) ? 'تم اضافة حقل اسم المستخدم' : 'لم يتم اضافة حقل اسم المستخدم';
	
	$p[6] 		= 	$MySmartBB->install->AddAutoreply();
	$msgs[6] 	= 	($p[6]) ? 'تم اضافة حقل الرد التلقائي' : 'لم يتم اضافة حقل الرد التلقائي';
	
	$p[7] 		= 	$MySmartBB->install->AddAutoreplyTitle();
	$msgs[7] 	= 	($p[7]) ? 'تم اضافة حقل عنوان الرد التلقائي' : 'لم يتم اضافة حقل عنوان الرد التلقائي';
	
	$p[8] 		= 	$MySmartBB->install->AddAutoreplyMsg();
	$msgs[8] 	= 	($p[8]) ? 'تم اضافة حقل محتوى الرد التلقائي' : 'لم يتم اضافة حقل محتوى الرد التلقائي';
	
	$p[9] 		= 	$MySmartBB->install->AddPMSenders();
	$msgs[9] 	= 	($p[9]) ? 'تم اضافة حقل رساله للمرسلين' : 'لم يتم اضافة حقل رساله للمرسلين';

	$p[10] 		= 	$MySmartBB->install->AddPMSendersMsg();
	$msgs[10] 	= 	($p[10]) ? 'تم اضافة حقل محتوى الرساله للمرسلين' : 'لم يتم اضافة حقل محتوى الرساله للمرسلين';
	
	$p[11] 		= 	$MySmartBB->install->AddTagsCache();
	$msgs[11] 	= 	($p[11]) ? 'تم اضافة حقل المعلومات المخبأه للعلامات' : 'لم يتم اضافة حقل المعلومات المخبأه للعلامات';
	
	$p[12] 		= 	$MySmartBB->install->AddCloseReason();
	$msgs[12] 	= 	($p[12]) ? 'تم اضافة حقل سبب الاغلاق' : 'لم يتم اضافة حقل سبب الاغلاق';
	
	$p[13] 		= 	$MySmartBB->install->AddMemberIP();
	$msgs[13] 	= 	($p[13]) ? 'تم اضافة حقل عنوان الآيبي' : 'لم يتم اضافة حقل عنوان الآيبي';
	
	$p[14] 		= 	$MySmartBB->install->AddGroupName();
	$msgs[14] 	= 	($p[14]) ? 'تم اضافة حقل اسم المجموعه' : 'لم يتم اضافة حقل اسم المجموعه';
	
	$p[15] 		= 	$MySmartBB->install->AddMIMEType();
	$msgs[15] 	= 	($p[15]) ? 'تم اضافة حقل نوع MIME' : 'لم يتم اضافة حقل  نوع MIME';
	
	$MySmartBB->html->open_p();
	
	foreach ($msgs as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثانيه -> عمليات تغيير الاسم','?step=2');
}
elseif ($MySmartBB->_GET['step'] == 2)
{
	$MySmartBB->html->cells('عمليات تغيير الاسم','main1');
	$MySmartBB->html->close_table();

	$p 			= 	array();
	$msgs 		= 	$MySmartBB->install->_Masseges;
	
	$p[1] 		= 	$MySmartBB->install->RenameModeratorTable();
	$msgs[1] 	= 	($p[1]) ? 'تم تغيير اسم جدول المشرفين' : 'لم يتم تغيير اسم جدول المشرفين';
	
	$MySmartBB->html->open_p();
	
	foreach ($msgs as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الثالثه -> تغيير نظام التصويت','?step=3');
}
elseif ($MySmartBB->_GET['step'] == 3)
{
	$MySmartBB->html->cells('تغيير نظام التصويت','main1');
	$MySmartBB->html->close_table();
	
	$convert = $MySmartBB->install->ConvertPollInformation();
	
	if ($convert)
	{
		$MySmartBB->html->open_p();
		$MySmartBB->html->p_msg('تم نقل المعلومات إلى النظام الجديد');
		$MySmartBB->html->close_p();
		
		$p = $MySmartBB->install->DropAnswerFields();
		
		if ($p)
		{
			$MySmartBB->html->open_p();
			$MySmartBB->html->p_msg('تم ازالة الحقول غير المرغوب بها');
			$MySmartBB->html->close_p();
		}
	}
		
	$MySmartBB->html->make_link('الخطوه الرابعه -> عمليات الإنشاء','?step=4');
}
elseif ($MySmartBB->_GET['step'] == 4)
{
	$MySmartBB->html->cells('عمليات الانشاء','main1');
	$MySmartBB->html->close_table();

	$p 			= 	array();
	$msgs 		= 	$MySmartBB->install->_Masseges;
	
	$p[1] 		= 	$MySmartBB->install->CreateTagsTable();
	$msgs[1] 	= 	($p[1]) ? 'تم إنشاء جدول العلامات' : 'لم يتم إنشاء جدول العلامات';
	
	$p[2] 		= 	$MySmartBB->install->CreateTagsSubjectTable();
	$msgs[2] 	= 	($p[2]) ? 'تم إنشاء جدول علامات المواضيع' : 'لم يتم إنشاء جدول علامات المواضيع';
	
	$MySmartBB->html->open_p();
	
	foreach ($msgs as $msg)
	{
		$MySmartBB->html->p_msg($msg);
	}
	
	$MySmartBB->html->close_p();
	
	$MySmartBB->html->make_link('الخطوه الخامسه -> تغيير نظام المنتديات','?step=5');
}
elseif ($MySmartBB->_GET['step'] == 5)
{
	$MySmartBB->html->cells('تغيير نظام المنتديات','main1');
	$MySmartBB->html->close_table();
	
	$add = $MySmartBB->install->AddParent();
	
	if ($add)
	{
		$MySmartBB->html->open_p();
		$MySmartBB->html->p_msg('تم اضافة الحقل');
		$MySmartBB->html->close_p();
		
		$main = $MySmartBB->install->ChangeMainSections();
		
		if ($main)
		{
			$MySmartBB->html->open_p();
			$MySmartBB->html->p_msg('تم تحويل الاقسام الرئيسيه إلى النظام الجديد');
			$MySmartBB->html->close_p();
			
			$normal = $MySmartBB->install->ChangeSections();
			
			if ($normal)
			{
				$MySmartBB->html->open_p();
				$MySmartBB->html->p_msg('تم تحويل المنتديات إلى النظام الجديد');
				$MySmartBB->html->close_p();
				
				$drop = $MySmartBB->install->DropUnwantedFields();
				
				if ($drop)
				{
					$MySmartBB->html->open_p();
					$MySmartBB->html->p_msg('تم حذف الحقول غير المرغوب بها');
					$MySmartBB->html->close_p();
				}
			}
		}
	}
		
	$MySmartBB->html->make_link('الخطوه السادسه','?step=6');
}
elseif ($MySmartBB->_GET['step'] == 6)
{
	$MySmartBB->html->cells('الخطوه السادسه','main1');
	$MySmartBB->html->close_table();
	
	$Update = $MySmartBB->section->UpdateAllSectionsCache();
	
	$NewVersion = $MySmartBB->install->UpdateVersion();
}

?>
