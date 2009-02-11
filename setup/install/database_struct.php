<?php

include('../common.php');

class DatabaseStruct extends MySmartInstall
{
	var $_TempArr 	= 	array();
	var $_Masseges	=	array();
	
	function _CreateAds()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['ads'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'sitename VARCHAR( 200 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'site VARCHAR( 200 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'picture VARCHAR( 200 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'width int( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'height int( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'clicks int( 9 ) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreateAnnouncement()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['announcement'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'title VARCHAR( 200 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'text text NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'writer VARCHAR( 200 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'date VARCHAR( 100 ) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreateAttach()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['attach'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'filename VARCHAR( 100 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'filepath VARCHAR( 100 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'filesize VARCHAR( 10 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_id int( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'visitor int( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'reply int( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'pm_id int( 9 ) NOT NULL';
		
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreateAvatar()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['avatar'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'avatar_path VARCHAR( 100 ) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreateBanned()
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
	
	function _CreateEmailMasseges()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['email_msg'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'title VARCHAR( 200 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'text text NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _InsertEmailMasseges()
	{
		global $MySmartBB;
		
		$MassegesArray = array();
		
		$MassegesArray[0] 			= 	array();
		$MassegesArray[0]['id'] 		= 	1;
		$MassegesArray[0]['title'] 	= 	'طلب تغيير كلمة المرور';
		$MassegesArray[0]['text'] 	= 	'السلام عليكم و رحمة الله و بركاته [MySBB]username[/MySBB]<br /><br />لقد قمت بطلب تغيير كلمة مرورك الخاصه في المنتدى , لاكمال الخطوات و تغييرها يرجى الضغط على هذه الوصله : <a href="[MySBB]change_url[/MySBB]">[MySBB]change_url[/MySBB]</a><br /><br />اذا لم تطلب تغيير كلمة المرور يرجى الضغط على الوصله التاليه لكي يتم إلغاء الطلب : <a href="[MySBB]cancel_url[/MySBB]">[MySBB]cancel_url[/MySBB]</a><br /><br />مع تحيات ادارة [MySBB]board_title[/MySBB]';
		
		$MassegesArray[1] 			= 	array();
		$MassegesArray[1]['id'] 		= 	2;
		$MassegesArray[1]['title'] 	= 	'طلب تغيير بريدك الالكتروني';
		$MassegesArray[1]['text'] 	= 	'السلام عليكم و رحمة الله و بركاته [MySBB]username[/MySBB]<br /><br />لقد قمت بطلب تغيير بريدك الالكتروني في المنتدى , لاكمال الخطوات و تغييره يرجى الضغط على هذه الوصله : <a href="[MySBB]change_url[/MySBB]">[MySBB]change_url[/MySBB]</a><br /><br />اذا لم تطلب تغيير البريد الالكتروني يرجى الضغط على الوصله التاليه لكي يتم إلغاء الطلب : <a href="[MySBB]cancel_url[/MySBB]">[MySBB]cancel_url[/MySBB]</a><br /><br />مع تحيات ادارة [MySBB]board_title[/MySBB]';
		
		$MassegesArray[2] 			= 	array();
		$MassegesArray[2]['id'] 		= 	3;
		$MassegesArray[2]['title'] 	= 	'تبليغ عن موضوع مخالف';
		$MassegesArray[2]['text'] 	= 	'<p>السلام عليكم و رحمة الله و بركاته عزيزي المدير , لقد قام احد الاعضاء\\الزوار بالتبليغ عن الموضوع التالي : <a href="[MySBB]subject_url[/MySBB]">[MySBB]subject_url[/MySBB]</a></p>';
		
		$MassegesArray[3] 			= 	array();
		$MassegesArray[3]['id'] 		= 	4;
		$MassegesArray[3]['title'] 	= 	'تفعيل العضويه';
		$MassegesArray[3]['text'] 	= 	'السلام عليكم و رحمة الله و بركاته يا [MySBB]username[/MySBB] <br /><br />نشكرك على التسجيل في [MySBB]board_title[/MySBB] , يرجى تفعيل العضويه لكي تتمكن من المشاركه في المنتدى و تنتقل إلى مجموعة الاعضاء<br /><br />لتفعيل عضويتك يرجى الضغط على الرابط التالي : <a href="[MySBB]url[/MySBB]">[MySBB]url[/MySBB]</a><br /><br />مع تحيات الاداره';
		
		$MassegesArray[4] 			= 	array();
		$MassegesArray[4]['id'] 		= 	5;
		$MassegesArray[4]['title'] 	= 	'شروط التسجيل';
		$MassegesArray[4]['text'] 	= 	'يمكنك التسجيل في المنتدى ولكن قبل ذلك عليك قراءة هذه القوانين حتى لا تتعرض للتوقيف أو المخالفة: <br />
    1- الالتزام بآداب الحديث والحوار وعدم التعرض للدين الإسلامي بالإساءة. <br />
    2- عدم التعرض لأي شخص بالإهانة أو أو التجريح أو المساس بولاة الأمر. <br />
    3- عدم الإعلان عن منتديات ومواقع أخرى بفتح مواضيع جديدة أو في التوقيع أو الرسائل الخاصة. <br />
    4- عدم تكرار طرح نفس الموضوع في أكثر من قسم.<br />
    5- عدم طرح أي شكوى ضد أي مشرف أو عضو علناً ، ولتقديم شكوى يجب مراسلة إدارة المنتدى.<br />
    6- يمنع منعاً باتاً التدخل في شؤون إدارة المنتدى ، ولإدارة المنتدى كامل الصلاحية في حذف أو تعديل أو نقل أو إغلاق أي موضوع أو إيقاف عضوية أي مشترك دون ذكر الأسباب. <br />
    7- عدم طرح أي مواضيع مضمونها معصية الله تعالى وفيما يغضبه سبحانه من المحرمات.<br />
    8- عدم طرح مواضيع الـHACK والاختراق وطرق اختراق البروكسي.<br />
    9- عدم استخدام إسم غير لائق لعضويتك عند التسجيل أو التسجيل بحروف مبهمة أو أرقام أو بريد الكتروني.<br />
    10- عدم وضع البريد الإلكتروني او رقم الهاتف في المواضيع والردود أو التوقيع.<br />
    بعد قراءتك الشروط والتسجيل فأي مخالفة تصدر منك سيتم الاتخاذ الاجراء اللازم بحقك أو إيقاف عضويتك';
		
		$x = 0;
		$i = array();
		
		while ($x <= sizeof($MassegesArray))
		{
			$insert = $MySmartBB->DB->sql_query("INSERT INTO " . $MySmartBB->table['email_msg'] . " SET 
													id='" . $MassegesArray[$x]['id'] . "',
													title='" . $MassegesArray[$x]['title'] . "',
													text='" . $MassegesArray[$x]['text'] . "'");
														
			$i[$x] = ($insert) ? 'true' : 'false';
				
			$x += 1;
		}
		
		return $i;
	}
	
	function _CreateExtension()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['extension'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'Ex VARCHAR( 5 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'max_size VARCHAR( 20 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'mime_type VARCHAR( 255 ) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _InsertExtension()
	{
		global $MySmartBB;
		
		$ExtensionsArray = array();
		
		$ExtensionsArray[0] 					= 	array();
		$ExtensionsArray[0]['extension'] 		= 	'.zip';
		$ExtensionsArray[0]['max_size'] 		= 	'500';
		$ExtensionsArray[0]['mime_type'] 		= 	'application/zip';
		
		$ExtensionsArray[1] 					= 	array();
		$ExtensionsArray[1]['extension'] 		= 	'.txt';
		$ExtensionsArray[1]['max_size'] 		= 	'500';
		$ExtensionsArray[1]['mime_type'] 		= 	'text/plain';
		
		$ExtensionsArray[2] 					= 	array();
		$ExtensionsArray[2]['extension'] 		= 	'.jpg';
		$ExtensionsArray[2]['max_size'] 		= 	'500';
		$ExtensionsArray[2]['mime_type'] 		= 	'image/jpeg';
		
		$ExtensionsArray[3] 					= 	array();
		$ExtensionsArray[3]['extension'] 		= 	'.gif';
		$ExtensionsArray[3]['max_size'] 		= 	'500';
		$ExtensionsArray[3]['mime_type'] 		= 	'image/gif';
				
		$x = 0;
		$i = array();
		
		while ($x < sizeof($ExtensionsArray))
		{
			$insert = $MySmartBB->DB->sql_query("INSERT INTO " . $MySmartBB->table['extension'] . " SET 
														id='NULL',
														Ex='" . $ExtensionsArray[$x]['extension'] . "',
														max_size='" . $ExtensionsArray[$x]['max_size'] . "'");
														
			$i[$x] = ($insert) ? 'true' : 'false';
					
			$x += 1;
		}
		
		return $i;
	}
	
	function _CreateGroup()
	{
		// Hmmmmmmmm , It's long table :/ , anyway i should do it
		global $MySmartBB;
				
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['group'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'title VARCHAR( 100 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username_style VARCHAR( 100 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_title VARCHAR( 100 ) NOT NULL';
		
		$this->_TempArr['CreateArr']['fields'][] 	= 	'forum_team INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'banned INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'view_section INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'download_attach INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'download_attach_number SMALLINT( 4 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'write_subject INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'write_reply INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'upload_attach INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'upload_attach_num INT( 5 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'edit_own_subject INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'edit_own_reply INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'del_own_subject INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'del_own_reply INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'write_poll INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'vote_poll INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'use_pm INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'send_pm INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'resive_pm INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'max_pm INT( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'min_send_pm INT( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'sig_allow INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'sig_len INT( 5 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'group_mod INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'del_subject INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'del_reply INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'edit_subject INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'edit_reply INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'stick_subject INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'unstick_subject INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'move_subject INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'close_subject INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'usercp_allow INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_allow INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'search_allow INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'memberlist_allow INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'vice INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'show_hidden INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'view_usernamestyle INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'usertitle_change INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'onlinepage_allow INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'allow_see_offstyles INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_section INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_option INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_member INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_membergroup INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_membertitle INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_admin INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_adminstep INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_subject INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_database INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_fixup INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_ads INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_template INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_adminads INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_attach INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_page INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_block INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_style INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_toolbox INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_smile INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_icon INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_avater INT( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'group_order INT( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'admincp_contactus INT( 1 ) NOT NULL';
		
		// Ouf :\ my hand
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _InsertGroup()
	{
		global $MySmartBB;
		
		// Do you know? I hate this table :(
		
		$GroupsArray = array();
		
		// Group ID : 1
		$GroupsArray[0] 								= array();
		$GroupsArray[0]['id'] 						= 1;
		$GroupsArray[0]['title'] 					= 'مدير المنتدى';
		$GroupsArray[0]['username_style'] 			= '<strong><em><span style="color: #800000;">[username]</span></em></strong>';
		$GroupsArray[0]['user_title'] 				= 'المشرف العام';
		$GroupsArray[0]['forum_team'] 				= 1;
		$GroupsArray[0]['banned'] 					= 0;
		$GroupsArray[0]['view_section'] 				= 1;
		$GroupsArray[0]['download_attach']			= 1;
		$GroupsArray[0]['download_attach_number'] 	= 0;
		$GroupsArray[0]['write_subject'] 			= 1;
		$GroupsArray[0]['write_reply'] 				= 1;
		$GroupsArray[0]['upload_attach'] 			= 1;
		$GroupsArray[0]['upload_attach_num'] 		= 5;
		$GroupsArray[0]['edit_own_subject'] 			= 1;
		$GroupsArray[0]['edit_own_reply'] 			= 1;
		$GroupsArray[0]['del_own_subject'] 			= 1;
		$GroupsArray[0]['del_own_reply'] 			= 1;
		$GroupsArray[0]['write_poll'] 				= 1;
		$GroupsArray[0]['vote_poll'] 				= 1;
		$GroupsArray[0]['use_pm'] 					= 1;
		$GroupsArray[0]['send_pm'] 					= 1;
		$GroupsArray[0]['resive_pm'] 				= 1;
		$GroupsArray[0]['max_pm'] 					= 0;
		$GroupsArray[0]['min_send_pm'] 				= 0;
		$GroupsArray[0]['sig_allow'] 				= 1;
		$GroupsArray[0]['sig_len']					= 100;
		$GroupsArray[0]['group_mod'] 				= 0;
		$GroupsArray[0]['del_subject'] 				= 0;
		$GroupsArray[0]['del_reply'] 				= 0;
		$GroupsArray[0]['edit_subject'] 				= 0;
		$GroupsArray[0]['edit_reply'] 				= 0;
		$GroupsArray[0]['stick_subject'] 			= 0;
		$GroupsArray[0]['unstick_subject'] 			= 0;
		$GroupsArray[0]['close_subject'] 			= 0;
		$GroupsArray[0]['usercp_allow'] 				= 1;
		$GroupsArray[0]['admincp_allow'] 			= 1;
		$GroupsArray[0]['search_allow'] 				= 1;
		$GroupsArray[0]['memberlist_allow'] 			= 1;
		$GroupsArray[0]['vice'] 						= 0;
		$GroupsArray[0]['show_hidden'] 				= 1;
		$GroupsArray[0]['view_usernamestyle'] 		= 1;
		$GroupsArray[0]['usertitle_change'] 			= 0;
		$GroupsArray[0]['onlinepage_allow'] 			= 1;
		$GroupsArray[0]['allow_see_offstyles'] 		= 0;
		$GroupsArray[0]['admincp_section'] 			= 1;
		$GroupsArray[0]['admincp_option'] 			= 1;
		$GroupsArray[0]['admincp_member'] 			= 1;
		$GroupsArray[0]['admincp_membergroup'] 		= 1;
		$GroupsArray[0]['admincp_membertitle'] 		= 1;
		$GroupsArray[0]['admincp_admin'] 			= 1;
		$GroupsArray[0]['admincp_adminstep'] 		= 1;
		$GroupsArray[0]['admincp_subject'] 			= 1;
		$GroupsArray[0]['admincp_database'] 			= 1;
		$GroupsArray[0]['admincp_fixup'] 			= 1;
		$GroupsArray[0]['admincp_ads'] 				= 1;
		$GroupsArray[0]['admincp_template'] 			= 1;
		$GroupsArray[0]['admincp_adminads'] 			= 1;
		$GroupsArray[0]['admincp_attach'] 			= 1;
		$GroupsArray[0]['admincp_page'] 				= 1;
		$GroupsArray[0]['admincp_block'] 			= 1;		
		$GroupsArray[0]['admincp_style'] 			= 1;
		$GroupsArray[0]['admincp_toolbox'] 			= 1;
		$GroupsArray[0]['admincp_smile'] 			= 1;
		$GroupsArray[0]['admincp_icon'] 				= 1;
		$GroupsArray[0]['admincp_avater'] 			= 1;
		$GroupsArray[0]['group_order'] 				= 1;
		$GroupsArray[0]['admincp_contactus'] 		= 1;
		
		// Group ID : 2
		$GroupsArray[1] 								= array();
		$GroupsArray[1]['id'] 						= 2;
		$GroupsArray[1]['title'] 					= 'نائب المدير';
		$GroupsArray[1]['username_style'] 			= '<strong><span style="color: #FF0000;">[username]</span></strong>';
		$GroupsArray[1]['user_title'] 				= 'النائب العام';
		$GroupsArray[1]['forum_team'] 				= 1;
		$GroupsArray[1]['banned'] 					= 0;
		$GroupsArray[1]['view_section'] 				= 1;
		$GroupsArray[1]['download_attach']			= 1;
		$GroupsArray[1]['download_attach_number'] 	= 0;
		$GroupsArray[1]['write_subject'] 			= 1;
		$GroupsArray[1]['write_reply'] 				= 1;
		$GroupsArray[1]['upload_attach'] 			= 1;
		$GroupsArray[1]['upload_attach_num'] 		= 5;
		$GroupsArray[1]['edit_own_subject'] 			= 1;
		$GroupsArray[1]['edit_own_reply'] 			= 1;
		$GroupsArray[1]['del_own_subject'] 			= 1;
		$GroupsArray[1]['del_own_reply'] 			= 1;
		$GroupsArray[1]['write_poll'] 				= 1;
		$GroupsArray[1]['vote_poll'] 				= 1;
		$GroupsArray[1]['use_pm'] 					= 1;
		$GroupsArray[1]['send_pm'] 					= 1;
		$GroupsArray[1]['resive_pm'] 				= 1;
		$GroupsArray[1]['max_pm'] 					= 0;
		$GroupsArray[1]['min_send_pm'] 				= 0;
		$GroupsArray[1]['sig_allow'] 				= 1;
		$GroupsArray[1]['sig_len']					= 0;
		$GroupsArray[1]['group_mod'] 				= 0;
		$GroupsArray[1]['del_subject'] 				= 0;
		$GroupsArray[1]['del_reply'] 				= 0;
		$GroupsArray[1]['edit_subject'] 				= 0;
		$GroupsArray[1]['edit_reply'] 				= 0;
		$GroupsArray[1]['stick_subject'] 			= 0;
		$GroupsArray[1]['unstick_subject'] 			= 0;
		$GroupsArray[1]['close_subject'] 			= 0;
		$GroupsArray[1]['usercp_allow'] 				= 1;
		$GroupsArray[1]['admincp_allow'] 			= 0;
		$GroupsArray[1]['search_allow'] 				= 1;
		$GroupsArray[1]['memberlist_allow'] 			= 1;
		$GroupsArray[1]['vice'] 						= 1;
		$GroupsArray[1]['show_hidden'] 				= 0;
		$GroupsArray[1]['view_usernamestyle'] 		= 1;
		$GroupsArray[1]['usertitle_change'] 			= 0;
		$GroupsArray[1]['onlinepage_allow'] 			= 1;
		$GroupsArray[1]['allow_see_offstyles'] 		= 0;
		$GroupsArray[1]['admincp_section'] 			= 0;
		$GroupsArray[1]['admincp_option'] 			= 0;
		$GroupsArray[1]['admincp_member'] 			= 0;
		$GroupsArray[1]['admincp_membergroup'] 		= 0;
		$GroupsArray[1]['admincp_membertitle'] 		= 0;
		$GroupsArray[1]['admincp_admin'] 			= 0;
		$GroupsArray[1]['admincp_adminstep'] 		= 0;
		$GroupsArray[1]['admincp_subject'] 			= 0;
		$GroupsArray[1]['admincp_database'] 			= 0;
		$GroupsArray[1]['admincp_fixup'] 			= 0;
		$GroupsArray[1]['admincp_ads'] 				= 0;
		$GroupsArray[1]['admincp_template'] 			= 0;
		$GroupsArray[1]['admincp_adminads'] 			= 0;
		$GroupsArray[1]['admincp_attach'] 			= 0;
		$GroupsArray[1]['admincp_page'] 				= 0;
		$GroupsArray[1]['admincp_block'] 			= 0;		
		$GroupsArray[1]['admincp_style'] 			= 0;
		$GroupsArray[1]['admincp_toolbox'] 			= 0;
		$GroupsArray[1]['admincp_smile'] 			= 0;
		$GroupsArray[1]['admincp_icon'] 				= 0;
		$GroupsArray[1]['admincp_avater'] 			= 0;
		$GroupsArray[1]['group_order'] 				= 3;
		$GroupsArray[1]['admincp_contactus'] 		= 0;
		
		// Group ID : 3
		$GroupsArray[2] 								= array();
		$GroupsArray[2]['id'] 						= 3;
		$GroupsArray[2]['title'] 					= 'مشرف';
		$GroupsArray[2]['username_style'] 			= '<strong><span style="color: #0000FF;">[username]</span></strong>';
		$GroupsArray[2]['user_title'] 				= 'مشرف';
		$GroupsArray[2]['forum_team'] 				= 1;
		$GroupsArray[2]['banned'] 					= 0;
		$GroupsArray[2]['view_section'] 				= 1;
		$GroupsArray[2]['download_attach']			= 1;
		$GroupsArray[2]['download_attach_number'] 	= 0;
		$GroupsArray[2]['write_subject'] 			= 1;
		$GroupsArray[2]['write_reply'] 				= 1;
		$GroupsArray[2]['upload_attach'] 			= 1;
		$GroupsArray[2]['upload_attach_num'] 		= 5;
		$GroupsArray[2]['edit_own_subject'] 			= 1;
		$GroupsArray[2]['edit_own_reply'] 			= 1;
		$GroupsArray[2]['del_own_subject'] 			= 1;
		$GroupsArray[2]['del_own_reply'] 			= 1;
		$GroupsArray[2]['write_poll'] 				= 1;
		$GroupsArray[2]['vote_poll'] 				= 1;
		$GroupsArray[2]['use_pm'] 					= 1;
		$GroupsArray[2]['send_pm'] 					= 1;
		$GroupsArray[2]['resive_pm'] 				= 1;
		$GroupsArray[2]['max_pm'] 					= 50;
		$GroupsArray[2]['min_send_pm'] 				= 0;
		$GroupsArray[2]['sig_allow'] 				= 1;
		$GroupsArray[2]['sig_len']					= 1000;
		$GroupsArray[2]['group_mod'] 				= 1;
		$GroupsArray[2]['del_subject'] 				= 1;
		$GroupsArray[2]['del_reply'] 				= 1;
		$GroupsArray[2]['edit_subject'] 				= 1;
		$GroupsArray[2]['edit_reply'] 				= 1;
		$GroupsArray[2]['stick_subject'] 			= 1;
		$GroupsArray[2]['unstick_subject'] 			= 1;
		$GroupsArray[2]['close_subject'] 			= 1;
		$GroupsArray[2]['usercp_allow'] 				= 0;
		$GroupsArray[2]['admincp_allow'] 			= 0;
		$GroupsArray[2]['search_allow'] 				= 1;
		$GroupsArray[2]['memberlist_allow'] 			= 1;
		$GroupsArray[2]['vice'] 						= 0;
		$GroupsArray[2]['show_hidden'] 				= 0;
		$GroupsArray[2]['view_usernamestyle'] 		= 1;
		$GroupsArray[2]['usertitle_change'] 			= 0;
		$GroupsArray[2]['onlinepage_allow'] 			= 1;
		$GroupsArray[2]['allow_see_offstyles'] 		= 0;
		$GroupsArray[2]['admincp_section'] 			= 0;
		$GroupsArray[2]['admincp_option'] 			= 0;
		$GroupsArray[2]['admincp_member'] 			= 0;
		$GroupsArray[2]['admincp_membergroup'] 		= 0;
		$GroupsArray[2]['admincp_membertitle'] 		= 0;
		$GroupsArray[2]['admincp_admin'] 			= 0;
		$GroupsArray[2]['admincp_adminstep'] 		= 0;
		$GroupsArray[2]['admincp_subject'] 			= 0;
		$GroupsArray[2]['admincp_database'] 			= 0;
		$GroupsArray[2]['admincp_fixup'] 			= 0;
		$GroupsArray[2]['admincp_ads'] 				= 0;
		$GroupsArray[2]['admincp_template'] 			= 0;
		$GroupsArray[2]['admincp_adminads'] 			= 0;
		$GroupsArray[2]['admincp_attach'] 			= 0;
		$GroupsArray[2]['admincp_page'] 				= 0;
		$GroupsArray[2]['admincp_block'] 			= 0;		
		$GroupsArray[2]['admincp_style'] 			= 0;
		$GroupsArray[2]['admincp_toolbox'] 			= 0;
		$GroupsArray[2]['admincp_smile'] 			= 0;
		$GroupsArray[2]['admincp_icon'] 				= 0;
		$GroupsArray[2]['admincp_avater'] 			= 0;
		$GroupsArray[2]['group_order'] 				= 4;
		$GroupsArray[2]['admincp_contactus'] 		= 0;
		
		// Group ID : 4
		$GroupsArray[3] 								= array();
		$GroupsArray[3]['id'] 						= 4;
		$GroupsArray[3]['title'] 					= 'عضو';
		$GroupsArray[3]['username_style'] 			= '<span style="color: #000000;">[username]</span>';
		$GroupsArray[3]['user_title'] 				= 'عضو';
		$GroupsArray[3]['forum_team'] 				= 0;
		$GroupsArray[3]['banned'] 					= 0;
		$GroupsArray[3]['view_section'] 				= 1;
		$GroupsArray[3]['download_attach']			= 1;
		$GroupsArray[3]['download_attach_number'] 	= 0;
		$GroupsArray[3]['write_subject'] 			= 1;
		$GroupsArray[3]['write_reply'] 				= 1;
		$GroupsArray[3]['upload_attach'] 			= 1;
		$GroupsArray[3]['upload_attach_num'] 		= 5;
		$GroupsArray[3]['edit_own_subject'] 			= 1;
		$GroupsArray[3]['edit_own_reply'] 			= 1;
		$GroupsArray[3]['del_own_subject'] 			= 1;
		$GroupsArray[3]['del_own_reply'] 			= 1;
		$GroupsArray[3]['write_poll'] 				= 1;
		$GroupsArray[3]['vote_poll'] 				= 1;
		$GroupsArray[3]['use_pm'] 					= 1;
		$GroupsArray[3]['send_pm'] 					= 1;
		$GroupsArray[3]['resive_pm'] 				= 1;
		$GroupsArray[3]['max_pm'] 					= 50;
		$GroupsArray[3]['min_send_pm'] 				= 0;
		$GroupsArray[3]['sig_allow'] 				= 1;
		$GroupsArray[3]['sig_len']					= 1000;
		$GroupsArray[3]['group_mod'] 				= 0;
		$GroupsArray[3]['del_subject'] 				= 0;
		$GroupsArray[3]['del_reply'] 				= 0;
		$GroupsArray[3]['edit_subject'] 				= 0;
		$GroupsArray[3]['edit_reply'] 				= 0;
		$GroupsArray[3]['stick_subject'] 			= 0;
		$GroupsArray[3]['unstick_subject'] 			= 0;
		$GroupsArray[3]['close_subject'] 			= 0;
		$GroupsArray[3]['usercp_allow'] 				= 0;
		$GroupsArray[3]['admincp_allow'] 			= 0;
		$GroupsArray[3]['search_allow'] 				= 1;
		$GroupsArray[3]['memberlist_allow'] 			= 1;
		$GroupsArray[3]['vice'] 						= 0;
		$GroupsArray[3]['show_hidden'] 				= 0;
		$GroupsArray[3]['view_usernamestyle'] 		= 1;
		$GroupsArray[3]['usertitle_change'] 			= 1;
		$GroupsArray[3]['onlinepage_allow'] 			= 1;
		$GroupsArray[3]['allow_see_offstyles'] 		= 0;
		$GroupsArray[3]['admincp_section'] 			= 0;
		$GroupsArray[3]['admincp_option'] 			= 0;
		$GroupsArray[3]['admincp_member'] 			= 0;
		$GroupsArray[3]['admincp_membergroup'] 		= 0;
		$GroupsArray[3]['admincp_membertitle'] 		= 0;
		$GroupsArray[3]['admincp_admin'] 			= 0;
		$GroupsArray[3]['admincp_adminstep'] 		= 0;
		$GroupsArray[3]['admincp_subject'] 			= 0;
		$GroupsArray[3]['admincp_database'] 			= 0;
		$GroupsArray[3]['admincp_fixup'] 			= 0;
		$GroupsArray[3]['admincp_ads'] 				= 0;
		$GroupsArray[3]['admincp_template'] 			= 0;
		$GroupsArray[3]['admincp_adminads'] 			= 0;
		$GroupsArray[3]['admincp_attach'] 			= 0;
		$GroupsArray[3]['admincp_page'] 				= 0;
		$GroupsArray[3]['admincp_block'] 			= 0;		
		$GroupsArray[3]['admincp_style'] 			= 0;
		$GroupsArray[3]['admincp_toolbox'] 			= 0;
		$GroupsArray[3]['admincp_smile'] 			= 0;
		$GroupsArray[3]['admincp_icon'] 				= 0;
		$GroupsArray[3]['admincp_avater'] 			= 0;
		$GroupsArray[3]['group_order'] 				= 5;
		$GroupsArray[3]['admincp_contactus'] 		= 0;
		
		// Group ID : 5
		$GroupsArray[4] 								= array();
		$GroupsArray[4]['id'] 						= 5;
		$GroupsArray[4]['title'] 					= 'على قائمة الإنتظار';
		$GroupsArray[4]['username_style'] 			= '<span style="color: #008080;">[username]</span>';
		$GroupsArray[4]['user_title'] 				= 'عضويه غير مفعلّه';
		$GroupsArray[4]['forum_team'] 				= 0;
		$GroupsArray[4]['banned'] 					= 0;
		$GroupsArray[4]['view_section'] 				= 1;
		$GroupsArray[4]['download_attach']			= 0;
		$GroupsArray[4]['download_attach_number'] 	= 0;
		$GroupsArray[4]['write_subject'] 			= 0;
		$GroupsArray[4]['write_reply'] 				= 0;
		$GroupsArray[4]['upload_attach'] 			= 0;
		$GroupsArray[4]['upload_attach_num'] 		= 5;
		$GroupsArray[4]['edit_own_subject'] 			= 0;
		$GroupsArray[4]['edit_own_reply'] 			= 0;
		$GroupsArray[4]['del_own_subject'] 			= 0;
		$GroupsArray[4]['del_own_reply'] 			= 0;
		$GroupsArray[4]['write_poll'] 				= 0;
		$GroupsArray[4]['vote_poll'] 				= 0;
		$GroupsArray[4]['use_pm'] 					= 0;
		$GroupsArray[4]['send_pm'] 					= 0;
		$GroupsArray[4]['resive_pm'] 				= 0;
		$GroupsArray[4]['max_pm'] 					= 0;
		$GroupsArray[4]['min_send_pm'] 				= 0;
		$GroupsArray[4]['sig_allow'] 				= 0;
		$GroupsArray[4]['sig_len']					= 0;
		$GroupsArray[4]['group_mod'] 				= 0;
		$GroupsArray[4]['del_subject'] 				= 0;
		$GroupsArray[4]['del_reply'] 				= 0;
		$GroupsArray[4]['edit_subject'] 				= 0;
		$GroupsArray[4]['edit_reply'] 				= 0;
		$GroupsArray[4]['stick_subject'] 			= 0;
		$GroupsArray[4]['unstick_subject'] 			= 0;
		$GroupsArray[4]['close_subject'] 			= 0;
		$GroupsArray[4]['usercp_allow'] 				= 0;
		$GroupsArray[4]['admincp_allow'] 			= 0;
		$GroupsArray[4]['search_allow'] 				= 1;
		$GroupsArray[4]['memberlist_allow'] 			= 1;
		$GroupsArray[4]['vice'] 						= 0;
		$GroupsArray[4]['show_hidden'] 				= 0;
		$GroupsArray[4]['view_usernamestyle'] 		= 0;
		$GroupsArray[4]['usertitle_change'] 			= 0;
		$GroupsArray[4]['onlinepage_allow'] 			= 0;
		$GroupsArray[4]['allow_see_offstyles'] 		= 0;
		$GroupsArray[4]['admincp_section'] 			= 0;
		$GroupsArray[4]['admincp_option'] 			= 0;
		$GroupsArray[4]['admincp_member'] 			= 0;
		$GroupsArray[4]['admincp_membergroup'] 		= 0;
		$GroupsArray[4]['admincp_membertitle'] 		= 0;
		$GroupsArray[4]['admincp_admin'] 			= 0;
		$GroupsArray[4]['admincp_adminstep'] 		= 0;
		$GroupsArray[4]['admincp_subject'] 			= 0;
		$GroupsArray[4]['admincp_database'] 			= 0;
		$GroupsArray[4]['admincp_fixup'] 			= 0;
		$GroupsArray[4]['admincp_ads'] 				= 0;
		$GroupsArray[4]['admincp_template'] 			= 0;
		$GroupsArray[4]['admincp_adminads'] 			= 0;
		$GroupsArray[4]['admincp_attach'] 			= 0;
		$GroupsArray[4]['admincp_page'] 				= 0;
		$GroupsArray[4]['admincp_block'] 			= 0;		
		$GroupsArray[4]['admincp_style'] 			= 0;
		$GroupsArray[4]['admincp_toolbox'] 			= 0;
		$GroupsArray[4]['admincp_smile'] 			= 0;
		$GroupsArray[4]['admincp_icon'] 				= 0;
		$GroupsArray[4]['admincp_avater'] 			= 0;
		$GroupsArray[4]['group_order'] 				= 6;
		$GroupsArray[4]['admincp_contactus'] 		= 0;
		
		// Group ID : 6
		$GroupsArray[5] 								= array();
		$GroupsArray[5]['id'] 						= 6;
		$GroupsArray[5]['title'] 					= 'موقوف';
		$GroupsArray[5]['username_style'] 			= '<span style="color: #FF0000;">[username]</span>';
		$GroupsArray[5]['user_title'] 				= 'موقوف';
		$GroupsArray[5]['forum_team'] 				= 0;
		$GroupsArray[5]['banned'] 					= 1;
		$GroupsArray[5]['view_section'] 				= 0;
		$GroupsArray[5]['download_attach']			= 0;
		$GroupsArray[5]['download_attach_number'] 	= 0;
		$GroupsArray[5]['write_subject'] 			= 0;
		$GroupsArray[5]['write_reply'] 				= 0;
		$GroupsArray[5]['upload_attach'] 			= 0;
		$GroupsArray[5]['upload_attach_num'] 		= 5;
		$GroupsArray[5]['edit_own_subject'] 			= 0;
		$GroupsArray[5]['edit_own_reply'] 			= 0;
		$GroupsArray[5]['del_own_subject'] 			= 0;
		$GroupsArray[5]['del_own_reply'] 			= 0;
		$GroupsArray[5]['write_poll'] 				= 0;
		$GroupsArray[5]['vote_poll'] 				= 0;
		$GroupsArray[5]['use_pm'] 					= 0;
		$GroupsArray[5]['send_pm'] 					= 0;
		$GroupsArray[5]['resive_pm'] 				= 0;
		$GroupsArray[5]['max_pm'] 					= 0;
		$GroupsArray[5]['min_send_pm'] 				= 0;
		$GroupsArray[5]['sig_allow'] 				= 0;
		$GroupsArray[5]['sig_len']					= 0;
		$GroupsArray[5]['group_mod'] 				= 0;
		$GroupsArray[5]['del_subject'] 				= 0;
		$GroupsArray[5]['del_reply'] 				= 0;
		$GroupsArray[5]['edit_subject'] 				= 0;
		$GroupsArray[5]['edit_reply'] 				= 0;
		$GroupsArray[5]['stick_subject'] 			= 0;
		$GroupsArray[5]['unstick_subject'] 			= 0;
		$GroupsArray[5]['close_subject'] 			= 0;
		$GroupsArray[5]['usercp_allow'] 				= 0;
		$GroupsArray[5]['admincp_allow'] 			= 0;
		$GroupsArray[5]['search_allow'] 				= 0;
		$GroupsArray[5]['memberlist_allow'] 			= 0;
		$GroupsArray[5]['vice'] 						= 0;
		$GroupsArray[5]['show_hidden'] 				= 0;
		$GroupsArray[5]['view_usernamestyle'] 		= 1;
		$GroupsArray[5]['usertitle_change'] 			= 0;
		$GroupsArray[5]['onlinepage_allow'] 			= 0;
		$GroupsArray[5]['allow_see_offstyles'] 		= 0;
		$GroupsArray[5]['admincp_section'] 			= 0;
		$GroupsArray[5]['admincp_option'] 			= 0;
		$GroupsArray[5]['admincp_member'] 			= 0;
		$GroupsArray[5]['admincp_membergroup'] 		= 0;
		$GroupsArray[5]['admincp_membertitle'] 		= 0;
		$GroupsArray[5]['admincp_admin'] 			= 0;
		$GroupsArray[5]['admincp_adminstep'] 		= 0;
		$GroupsArray[5]['admincp_subject'] 			= 0;
		$GroupsArray[5]['admincp_database'] 			= 0;
		$GroupsArray[5]['admincp_fixup'] 			= 0;
		$GroupsArray[5]['admincp_ads'] 				= 0;
		$GroupsArray[5]['admincp_template'] 			= 0;
		$GroupsArray[5]['admincp_adminads'] 			= 0;
		$GroupsArray[5]['admincp_attach'] 			= 0;
		$GroupsArray[5]['admincp_page'] 				= 0;
		$GroupsArray[5]['admincp_block'] 			= 0;		
		$GroupsArray[5]['admincp_style'] 			= 0;
		$GroupsArray[5]['admincp_toolbox'] 			= 0;
		$GroupsArray[5]['admincp_smile'] 			= 0;
		$GroupsArray[5]['admincp_icon'] 				= 0;
		$GroupsArray[5]['admincp_avater'] 			= 0;
		$GroupsArray[5]['group_order'] 				= 7;
		$GroupsArray[5]['admincp_contactus'] 		= 0;
		
		// Group ID : 7
		$GroupsArray[6] 								= array();
		$GroupsArray[6]['id'] 						= 7;
		$GroupsArray[6]['title'] 					= 'الزوار';
		$GroupsArray[6]['username_style'] 			= '[username]';
		$GroupsArray[6]['user_title'] 				= 'زائر';
		$GroupsArray[6]['forum_team'] 				= 0;
		$GroupsArray[6]['banned'] 					= 0;
		$GroupsArray[6]['view_section'] 				= 1;
		$GroupsArray[6]['download_attach']			= 0;
		$GroupsArray[6]['download_attach_number'] 	= 0;
		$GroupsArray[6]['write_subject'] 			= 0;
		$GroupsArray[6]['write_reply'] 				= 0;
		$GroupsArray[6]['upload_attach'] 			= 0;
		$GroupsArray[6]['upload_attach_num'] 		= 5;
		$GroupsArray[6]['edit_own_subject'] 			= 0;
		$GroupsArray[6]['edit_own_reply'] 			= 0;
		$GroupsArray[6]['del_own_subject'] 			= 0;
		$GroupsArray[6]['del_own_reply'] 			= 0;
		$GroupsArray[6]['write_poll'] 				= 0;
		$GroupsArray[6]['vote_poll'] 				= 0;
		$GroupsArray[6]['use_pm'] 					= 0;
		$GroupsArray[6]['send_pm'] 					= 0;
		$GroupsArray[6]['resive_pm'] 				= 0;
		$GroupsArray[6]['max_pm'] 					= 0;
		$GroupsArray[6]['min_send_pm'] 				= 0;
		$GroupsArray[6]['sig_allow'] 				= 0;
		$GroupsArray[6]['sig_len']					= 0;
		$GroupsArray[6]['group_mod'] 				= 0;
		$GroupsArray[6]['del_subject'] 				= 0;
		$GroupsArray[6]['del_reply'] 				= 0;
		$GroupsArray[6]['edit_subject'] 				= 0;
		$GroupsArray[6]['edit_reply'] 				= 0;
		$GroupsArray[6]['stick_subject'] 			= 0;
		$GroupsArray[6]['unstick_subject'] 			= 0;
		$GroupsArray[6]['close_subject'] 			= 0;
		$GroupsArray[6]['usercp_allow'] 				= 0;
		$GroupsArray[6]['admincp_allow'] 			= 0;
		$GroupsArray[6]['search_allow'] 				= 1;
		$GroupsArray[6]['memberlist_allow'] 			= 1;
		$GroupsArray[6]['vice'] 						= 0;
		$GroupsArray[6]['show_hidden'] 				= 0;
		$GroupsArray[6]['view_usernamestyle'] 		= 0;
		$GroupsArray[6]['usertitle_change'] 			= 0;
		$GroupsArray[6]['onlinepage_allow'] 			= 0;
		$GroupsArray[6]['allow_see_offstyles'] 		= 0;
		$GroupsArray[6]['admincp_section'] 			= 0;
		$GroupsArray[6]['admincp_option'] 			= 0;
		$GroupsArray[6]['admincp_member'] 			= 0;
		$GroupsArray[6]['admincp_membergroup'] 		= 0;
		$GroupsArray[6]['admincp_membertitle'] 		= 0;
		$GroupsArray[6]['admincp_admin'] 			= 0;
		$GroupsArray[6]['admincp_adminstep'] 		= 0;
		$GroupsArray[6]['admincp_subject'] 			= 0;
		$GroupsArray[6]['admincp_database'] 			= 0;
		$GroupsArray[6]['admincp_fixup'] 			= 0;
		$GroupsArray[6]['admincp_ads'] 				= 0;
		$GroupsArray[6]['admincp_template'] 			= 0;
		$GroupsArray[6]['admincp_adminads'] 			= 0;
		$GroupsArray[6]['admincp_attach'] 			= 0;
		$GroupsArray[6]['admincp_page'] 				= 0;
		$GroupsArray[6]['admincp_block'] 			= 0;		
		$GroupsArray[6]['admincp_style'] 			= 0;
		$GroupsArray[6]['admincp_toolbox'] 			= 0;
		$GroupsArray[6]['admincp_smile'] 			= 0;
		$GroupsArray[6]['admincp_icon'] 				= 0;
		$GroupsArray[6]['admincp_avater'] 			= 0;
		$GroupsArray[6]['group_order'] 				= 8;
		$GroupsArray[6]['admincp_contactus'] 		= 0;
		
		// Group ID : 8
		$GroupsArray[7] 								= array();
		$GroupsArray[7]['id'] 						= 8;
		$GroupsArray[7]['title'] 					= 'المراقب العام';
		$GroupsArray[7]['username_style'] 			= '<strong><span style="color: #800000;">[username]</span></strong>';
		$GroupsArray[7]['user_title'] 				= 'مساعد المدير';
		$GroupsArray[7]['forum_team'] 				= 1;
		$GroupsArray[7]['banned'] 					= 0;
		$GroupsArray[7]['view_section'] 				= 1;
		$GroupsArray[7]['download_attach']			= 1;
		$GroupsArray[7]['download_attach_number'] 	= 0;
		$GroupsArray[7]['write_subject'] 			= 1;
		$GroupsArray[7]['write_reply'] 				= 1;
		$GroupsArray[7]['upload_attach'] 			= 1;
		$GroupsArray[7]['upload_attach_num'] 		= 5;
		$GroupsArray[7]['edit_own_subject'] 			= 1;
		$GroupsArray[7]['edit_own_reply'] 			= 1;
		$GroupsArray[7]['del_own_subject'] 			= 1;
		$GroupsArray[7]['del_own_reply'] 			= 1;
		$GroupsArray[7]['write_poll'] 				= 1;
		$GroupsArray[7]['vote_poll'] 				= 1;
		$GroupsArray[7]['use_pm'] 					= 1;
		$GroupsArray[7]['send_pm'] 					= 1;
		$GroupsArray[7]['resive_pm'] 				= 1;
		$GroupsArray[7]['max_pm'] 					= 0;
		$GroupsArray[7]['min_send_pm'] 				= 0;
		$GroupsArray[7]['sig_allow'] 				= 1;
		$GroupsArray[7]['sig_len']					= 0;
		$GroupsArray[7]['group_mod'] 				= 0;
		$GroupsArray[7]['del_subject'] 				= 0;
		$GroupsArray[7]['del_reply'] 				= 0;
		$GroupsArray[7]['edit_subject'] 				= 0;
		$GroupsArray[7]['edit_reply'] 				= 0;
		$GroupsArray[7]['stick_subject'] 			= 0;
		$GroupsArray[7]['unstick_subject'] 			= 0;
		$GroupsArray[7]['close_subject'] 			= 0;
		$GroupsArray[7]['usercp_allow'] 				= 0;
		$GroupsArray[7]['admincp_allow'] 			= 1;
		$GroupsArray[7]['search_allow'] 				= 1;
		$GroupsArray[7]['memberlist_allow'] 			= 1;
		$GroupsArray[7]['vice'] 						= 0;
		$GroupsArray[7]['show_hidden'] 				= 1;
		$GroupsArray[7]['view_usernamestyle'] 		= 1;
		$GroupsArray[7]['usertitle_change'] 			= 0;
		$GroupsArray[7]['onlinepage_allow'] 			= 1;
		$GroupsArray[7]['allow_see_offstyles'] 		= 0;
		$GroupsArray[7]['admincp_section'] 			= 1;
		$GroupsArray[7]['admincp_option'] 			= 1;
		$GroupsArray[7]['admincp_member'] 			= 1;
		$GroupsArray[7]['admincp_membergroup'] 		= 0;
		$GroupsArray[7]['admincp_membertitle'] 		= 1;
		$GroupsArray[7]['admincp_admin'] 			= 0;
		$GroupsArray[7]['admincp_adminstep'] 		= 1;
		$GroupsArray[7]['admincp_subject'] 			= 1;
		$GroupsArray[7]['admincp_database'] 			= 0;
		$GroupsArray[7]['admincp_fixup'] 			= 1;
		$GroupsArray[7]['admincp_ads'] 				= 1;
		$GroupsArray[7]['admincp_template'] 			= 0;
		$GroupsArray[7]['admincp_adminads'] 			= 1;
		$GroupsArray[7]['admincp_attach'] 			= 0;
		$GroupsArray[7]['admincp_page'] 				= 1;
		$GroupsArray[7]['admincp_block'] 			= 1;		
		$GroupsArray[7]['admincp_style'] 			= 0;
		$GroupsArray[7]['admincp_toolbox'] 			= 1;
		$GroupsArray[7]['admincp_smile'] 			= 1;
		$GroupsArray[7]['admincp_icon'] 				= 1;
		$GroupsArray[7]['admincp_avater'] 			= 1;
		$GroupsArray[7]['group_order'] 				= 2;
		$GroupsArray[7]['admincp_contactus'] 		= 0;
		
		// I Can't Belive :| I Do It!
		
		$GroupArray = $MySmartBB->functions->CleanVariable($GroupArray,'sql');
		
		$x = 0;
		$i = array();
		
		while ($x < sizeof($GroupsArray))
		{
			$insert = $MySmartBB->DB->sql_query("INSERT INTO " . $MySmartBB->table['group'] . " SET 
											id='" . $GroupsArray[$x]['id'] . "',
											title='" . $GroupsArray[$x]['title'] . "',
											username_style='" . $GroupsArray[$x]['username_style'] . "',
											user_title='" . $GroupsArray[$x]['user_title'] . "',
											forum_team='" . $GroupsArray[$x]['forum_team'] . "',
											banned='" . $GroupsArray[$x]['banned'] . "',
											view_section='" . $GroupsArray[$x]['view_section'] . "',
											download_attach='" . $GroupsArray[$x]['download_attach'] . "',
											download_attach_number='" . $GroupsArray[$x]['download_attach_number'] . "',
											write_subject='" . $GroupsArray[$x]['write_subject'] . "',
											write_reply='" . $GroupsArray[$x]['write_reply'] . "',
											upload_attach='" . $GroupsArray[$x]['upload_attach'] . "',
											upload_attach_num='" . $GroupsArray[$x]['upload_attach_num'] . "',
											edit_own_subject='" . $GroupsArray[$x]['edit_own_subject'] . "',
											edit_own_reply='" . $GroupsArray[$x]['edit_own_reply'] . "',
											del_own_subject='" . $GroupsArray[$x]['del_own_subject'] . "',
											del_own_reply='" . $GroupsArray[$x]['del_own_reply'] . "',
											write_poll='" . $GroupsArray[$x]['write_poll'] . "',
											vote_poll='" . $GroupsArray[$x]['vote_poll'] . "',
											use_pm='" . $GroupsArray[$x]['use_pm'] . "',
											send_pm='" . $GroupsArray[$x]['send_pm'] . "',
											resive_pm='" . $GroupsArray[$x]['resive_pm'] . "',
											max_pm='" . $GroupsArray[$x]['max_pm'] . "',
											min_send_pm='" . $GroupsArray[$x]['min_send_pm'] . "',
											sig_allow='" . $GroupsArray[$x]['sig_allow'] . "',
											sig_len='" . $GroupsArray[$x]['sig_len'] . "',
											group_mod='" . $GroupsArray[$x]['group_mod'] . "',
											del_subject='" . $GroupsArray[$x]['del_subject'] . "',
											del_reply='" . $GroupsArray[$x]['del_reply'] . "',
											edit_subject='" . $GroupsArray[$x]['edit_subject'] . "',
											edit_reply='" . $GroupsArray[$x]['edit_reply'] . "',
											stick_subject='" . $GroupsArray[$x]['stick_subject'] . "',
											unstick_subject='" . $GroupsArray[$x]['unstick_subject'] . "',
											close_subject='" . $GroupsArray[$x]['close_subject'] . "',
											usercp_allow='" . $GroupsArray[$x]['usercp_allow'] . "',
											admincp_allow='" . $GroupsArray[$x]['admincp_allow'] . "',
											search_allow='" . $GroupsArray[$x]['search_allow'] . "',
											memberlist_allow='" . $GroupsArray[$x]['memberlist_allow'] . "',
											vice='" . $GroupsArray[$x]['vice'] . "',
											show_hidden='" . $GroupsArray[$x]['show_hidden'] . "',
											view_usernamestyle='" . $GroupsArray[$x]['view_usernamestyle'] . "',
											usertitle_change='" . $GroupsArray[$x]['usertitle_change'] . "',
											onlinepage_allow='" . $GroupsArray[$x]['onlinepage_allow'] . "',
											allow_see_offstyles='" . $GroupsArray[$x]['allow_see_offstyles'] . "',
											admincp_section='" . $GroupsArray[$x]['admincp_section'] . "',
											admincp_option='" . $GroupsArray[$x]['admincp_option'] . "',
											admincp_member='" . $GroupsArray[$x]['admincp_member'] . "',
											admincp_membergroup='" . $GroupsArray[$x]['admincp_membergroup'] . "',
											admincp_membertitle='" . $GroupsArray[$x]['admincp_membertitle'] . "',
											admincp_admin='" . $GroupsArray[$x]['admincp_admin'] . "',
											admincp_adminstep='" . $GroupsArray[$x]['admincp_adminstep'] . "',
											admincp_subject='" . $GroupsArray[$x]['admincp_subject'] . "',
											admincp_database='" . $GroupsArray[$x]['admincp_database'] . "',
											admincp_fixup='" . $GroupsArray[$x]['admincp_fixup'] . "',
											admincp_ads='" . $GroupsArray[$x]['admincp_ads'] . "',
											admincp_template='" . $GroupsArray[$x]['admincp_template'] . "',
											admincp_adminads='" . $GroupsArray[$x]['admincp_adminads'] . "',
											admincp_attach='" . $GroupsArray[$x]['admincp_attach'] . "',
											admincp_page='" . $GroupsArray[$x]['admincp_page'] . "',
											admincp_style='" . $GroupsArray[$x]['admincp_style'] . "',
											admincp_toolbox='" . $GroupsArray[$x]['admincp_toolbox'] . "',
											admincp_smile='" . $GroupsArray[$x]['admincp_smile'] . "',
											admincp_icon='" . $GroupsArray[$x]['admincp_icon'] . "',
											admincp_avater='" . $GroupsArray[$x]['admincp_avater'] . "',
											group_order='" . $GroupsArray[$x]['group_order'] . "',
											admincp_contactus='" . $GroupsArray[$x]['admincp_contactus'] . "'");
														
			$i[$x] = ($insert) ? 'true' : 'false';
					
			$x += 1;
			
			// Again , I hate this table . i want to sleep and i think this table will be my nightmare today
		}
		
		return $i;
	}
	
	function _CreateInfo()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['info'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'var_name VARCHAR( 255 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'value text NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _InsertInfo()
	{
		global $MySmartBB;
		
		$InfoArray 								= array();
		$InfoArray['title'] 					= '';
		$InfoArray['show_onlineguest'] 			= 0;
		$InfoArray['perpage'] 					= 15;
		$InfoArray['subject_perpage'] 			= 15;
		$InfoArray['show_subject_all'] 			= 0;
		$InfoArray['send_email'] 				= '';
		$InfoArray['avatar_perpage'] 			= 5;
		$InfoArray['admin_email'] 				= '';
		$InfoArray['MySBB_version'] 			= '2.0 THETA 1';
		$InfoArray['Sat'] 						= 1;
		$InfoArray['Sun'] 						= 1;
		$InfoArray['Mon'] 						= 1;
		$InfoArray['Tue'] 						= 1;
		$InfoArray['Wed'] 						= 1;
		$InfoArray['Thu'] 						= 1;
		$InfoArray['Fri'] 						= 1;
		$InfoArray['fastreply_allow'] 			= 1;
		$InfoArray['download_path'] 			= 'download';
		$InfoArray['def_group'] 				= 5;
		$InfoArray['adef_group'] 				= 4;
		$InfoArray['def_style'] 				= 1;
		$InfoArray['board_close'] 				= 0;
		$InfoArray['board_msg'] 				= '';
		$InfoArray['use_list'] 					= 0;
		$InfoArray['supermember_logs'] 			= 0;
		$InfoArray['page_max'] 					= 5;
		$InfoArray['reg_o'] 					= 1;
		$InfoArray['time_out'] 					= 1440;
		$InfoArray['samesubject_show'] 			= 1;
		$InfoArray['reg_less_num'] 				= 3;
		$InfoArray['reg_max_num'] 				= 25;
		$InfoArray['reg_pass_min_num'] 			= 5;
		$InfoArray['reg_pass_max_num'] 			= 25;
		$InfoArray['post_text_min'] 			= 5;
		$InfoArray['post_text_max'] 			= 10000;
		$InfoArray['post_title_min'] 			= 4;
		$InfoArray['post_title_max'] 			= 40;
		$InfoArray['upload_avatar'] 			= 1;
		$InfoArray['max_avatar_width'] 			= 150;
		$InfoArray['max_avatar_height'] 		= 150;
		$InfoArray['reg_close'] 				= 0;
		$InfoArray['msg_title_temp'] 			= '';
		$InfoArray['msg_content_temp'] 			= '';
		$InfoArray['confirm_on_change_mail'] 	= 0;
		$InfoArray['confirm_on_change_pass'] 	= 0;
		$InfoArray['allow_avatar'] 				= 1;
		$InfoArray['allow_apsent'] 				= 1;
		$InfoArray['ads_num'] 					= 0;
		$InfoArray['smiles_cache'] 				= '';
		$InfoArray['forums_cache'] 				= '';
		$InfoArray['subforums_cache'] 			= '';
		$InfoArray['sectiongroup_cache'] 		= '';
		$InfoArray['subject_number'] 			= 0;
		$InfoArray['reply_number'] 				= 0;
		$InfoArray['member_number'] 			= 0;
		$InfoArray['last_member'] 				= '';
		$InfoArray['last_member_id'] 			= 0;
		$InfoArray['floodctrl'] 				= 0;
		$InfoArray['meta'] 						= '<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />\r\n<meta http-equiv="Content-Language" content="ar" />\r\n<meta name="keywords" content=" منتدى , منتديات, MySBB, MySmartBB, mymartbb, my smart bulletin board " />\r\n<meta name="description" content="هذا المنتدى يستخدم برنامج MySmartBB لمعرفة المزيد عنه اذهب إلى www.mysmartbb.com" />';
		$InfoArray['toolbox_show'] 				= 1;
		$InfoArray['smiles_show'] 				= 1;
		$InfoArray['icons_show'] 				= 1;
		$InfoArray['title_quote'] 				= 1;
		$InfoArray['close_stick_activate'] 		= 1;
		$InfoArray['timestamp'] 				= '0000';
		$InfoArray['timesystem'] 				= 'ty';
		$InfoArray['online_now_section'] 		= 1;
		$InfoArray['online_now_subject'] 		= 1;
		$InfoArray['resize_imagesAllow'] 		= 0;
		$InfoArray['default_imagesW'] 			= 0;
		$InfoArray['default_imagesH'] 			= 0;
		$InfoArray['create_date'] 				= '';
		$InfoArray['icon_path'] 				= 'look/images/icons/';
		// Since OMEGA 5
		$InfoArray['sectiongroup_number']		= 0;
		$InfoArray['subsections_number']		= 0;
		$InfoArray['sections_number']			= 0;
		$InfoArray['smiles_number']				= 0;
		// Since OMEGA 6
		$InfoArray['today_date_cache']			= 0;
		$InfoArray['today_number_cache']		= 0;
		$InfoArray['adress_bar_separate']		= '&raquo;';
		// Since THETA 1
		$InfoArray['ajax_search']				= 0; 
		$InfoArray['ajax_register']				= 0;
		$InfoArray['ajax_freply']				= 0;
		$InfoArray['admin_ajax_main_rename']	= 0;
		// Since THETA 2 (ALPHA 3)
		$InfoArray['ajax_moderator_options']	= 0;
		$InfoArray['reg_Sat'] 					= 1;
		$InfoArray['reg_Sun'] 					= 1;
		$InfoArray['reg_Mon'] 					= 1;
		$InfoArray['reg_Tue'] 					= 1;
		$InfoArray['reg_Wed'] 					= 1;
		$InfoArray['reg_Thu'] 					= 1;
		$InfoArray['reg_Fri'] 					= 1;
		$InfoArray['admin_notes']				= '';
		$InfoArray['pm_feature']				= 1;
		
		$x = 0;
		$i = array();
		
		foreach ($InfoArray as $k => $v)
		{
			$insert = $MySmartBB->DB->sql_query("INSERT INTO " . $MySmartBB->table['info'] . " SET var_name='" . $k . "',value='" . $v . "'");
			
			$i[$x] = ($insert) ? 'true' : 'false';
			
			$x += 1;
		}
		
		return $i;
	}
	
	function _CreateMember()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['member'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username VARCHAR( 200 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'password VARCHAR( 200 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'email VARCHAR( 200 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'usergroup INT( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_notes mediumtext NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_sig mediumtext NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_country varchar(100) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_gender char(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_website varchar(100) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'lastvisit varchar(10) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_time varchar(6) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'register_date varchar(100) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'posts int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_title varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'visitor int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_info varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'avater_path varchar(100) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'away int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'away_msg tinytext NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'new_password varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'new_email varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'active_number varchar(90) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'style int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'hide_online int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'send_allow int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'unread_pm int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'lastpost_time varchar(15) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'keepmeon int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'logged varchar(30) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'register_time varchar(50) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'style_cache TEXT NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'style_id_cache INT( 9 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'should_update_style_cache INT( 1 ) NOT NULL';
		// Since THETA 1
		$this->_TempArr['CreateArr']['fields'][] 	= 	'autoreply int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'autoreply_title varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'autoreply_msg text NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'pm_senders int( 1 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'pm_senders_msg varchar( 255 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'member_ip varchar( 20 ) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_sig mediumtext NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'reply_sig mediumtext NOT NULL';
		// Since ALPHA 3 (THETA 3)
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username_style_cache varchar( 255 ) NOT NULL';
		
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreateOnline()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['online'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'path varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'logged varchar(30) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_ip varchar(30) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'hide_browse int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username_style varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_location varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_show int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_id int(9) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreatePages()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['pages'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'title varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'html_code text NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreatePrivateMassege()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['pm'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'title varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'text text NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_from varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_to varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_read char(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'alarm char(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'date varchar(100) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'icon varchar(50) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'folder varchar(90) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreatePrivateMassegeFolder()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['pm_folder'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'folder_name varchar(50) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username varchar(200) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreatePrivateMassegeLists()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['pm_lists'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'list_username varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username varchar(200) NOT NULL';
			
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreatePoll()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['poll'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'qus varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'answers text NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_id int(9) NOT NULL';
					
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _CreateReply()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['reply'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'title varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'text text NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'writer varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'stick int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'close int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'delete_topic int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'section int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'write_time varchar(15) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'icon varchar(50) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'action_by varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'attach_reply int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'actiondate datetime NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'keepmeon int(1) NOT NULL';
					
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _CreateRequests()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['requests'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'random_url varchar(26) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'request_type int(1) NOT NULL';
		
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _CreateSection()
	{
		global $MySmartBB;

		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['section'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'title varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'section_describe varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'parent int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'sort int(5) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'section_password varchar(50) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'show_sig int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'usesmartcode_allow int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'section_picture varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'sectionpicture_type int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'use_section_picture int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'linksection int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'linkvisitor int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'linksite varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_order int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'hide_subject int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'last_writer varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'last_subject varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'last_subjectid int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'last_date varchar(11) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'sec_section int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'sig_iteration int(1) NOT NULL';
		// Since OMEGA 5
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_num int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'reply_num int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'forums_cache text NOT NULL';
		// Since THETA 1
		$this->_TempArr['CreateArr']['fields'][] 	= 	'moderators text NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'sectiongroup_cache text NOT NULL';
		// Since ALPHA 1
		$this->_TempArr['CreateArr']['fields'][] 	= 	'footer text NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'header text NOT NULL';
		// Since ALPHA 3
		//$this->_TempArr['CreateArr']['fields'][] 	= 	'no_posts int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'review_subject int(1) NOT NULL';
		
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _CreateSectionAdmin()
	{
		global $MySmartBB;

		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['moderators'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'section_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'member_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username varchar(255) NOT NULL';
					
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _CreateSectionGroup()
	{
		global $MySmartBB;

		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['section_group'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'section_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'group_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'view_section int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'download_attach int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'write_subject int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'write_reply int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'upload_attach int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'edit_own_subject int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'edit_own_reply int(1)  NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'del_own_subject int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'del_own_reply int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'write_poll int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'vote_poll int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'main_section int(1) NOT NULL';
		// Since THETA 1
		$this->_TempArr['CreateArr']['fields'][] 	= 	"no_posts int(1) NOT NULL DEFAULT '1'";
		$this->_TempArr['CreateArr']['fields'][] 	= 	'group_name varchar(255) NOT NULL';
					
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _CreateSmiles()
	{
		global $MySmartBB;

		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['smiles'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'smile_short varchar(15) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'smile_path varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'smile_type int(1) NOT NULL';
					
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _InsertSmiles()
	{
		global $MySmartBB;
		
		$SmilesArray = array();
		
		$SmilesArray[0] 					= 	array();
		$SmilesArray[0]['smile_short'] 		= 	':)';
		$SmilesArray[0]['smile_path'] 		= 	'look/images/smiles/smile.gif';
		$SmilesArray[0]['smile_type'] 		= 	'0';
		
		$SmilesArray[1] 					= 	array();
		$SmilesArray[1]['smile_short'] 		= 	';)';
		$SmilesArray[1]['smile_path'] 		= 	'look/images/smiles/wink_3.gif';
		$SmilesArray[1]['smile_type'] 		= 	'0';
		
		$SmilesArray[2] 					= 	array();
		$SmilesArray[2]['smile_short'] 		= 	':roll:';
		$SmilesArray[2]['smile_path'] 		= 	'look/images/smiles/rolleyes.gif';
		$SmilesArray[2]['smile_type'] 		= 	'0';
		
		$SmilesArray[3] 					= 	array();
		$SmilesArray[3]['smile_short'] 		= 	':D';
		$SmilesArray[3]['smile_path'] 		= 	'look/images/smiles/biggrin2.gif';
		$SmilesArray[3]['smile_type'] 		= 	'0';
		
		$SmilesArray[4] 					= 	array();
		$SmilesArray[4]['smile_short'] 		= 	':cool:';
		$SmilesArray[4]['smile_path'] 		= 	'look/images/smiles/cool.gif';
		$SmilesArray[4]['smile_type'] 		= 	'0';
		
		$SmilesArray[5] 					= 	array();
		$SmilesArray[5]['smile_short'] 		= 	':lol:';
		$SmilesArray[5]['smile_path'] 		= 	'look/images/smiles/laugh.gif';
		$SmilesArray[5]['smile_type'] 		= 	'0';
		
		$SmilesArray[6] 					= 	array();
		$SmilesArray[6]['smile_short'] 		= 	':(';
		$SmilesArray[6]['smile_path'] 		= 	'look/images/smiles/sad.gif';
		$SmilesArray[6]['smile_type'] 		= 	'0';
		
		$SmilesArray[7] 					= 	array();
		$SmilesArray[7]['smile_short'] 		= 	':mad:';
		$SmilesArray[7]['smile_path'] 		= 	'look/images/smiles/mad_1.gif';
		$SmilesArray[7]['smile_type'] 		= 	'0';
		
		$SmilesArray[8] 					= 	array();
		$SmilesArray[8]['smile_short'] 		= 	':#';
		$SmilesArray[8]['smile_path'] 		= 	'look/images/smiles/blushing.gif';
		$SmilesArray[8]['smile_type'] 		= 	'0';
		
		$SmilesArray[9] 					= 	array();
		$SmilesArray[9]['smile_short'] 		= 	':@@:';
		$SmilesArray[9]['smile_path'] 		= 	'look/images/smiles/blink.gif';
		$SmilesArray[9]['smile_type'] 		= 	'0';
		
		$SmilesArray[10] 					= 	array();
		$SmilesArray[10]['smile_short'] 	= 	':yes:';
		$SmilesArray[10]['smile_path'] 		= 	'look/images/smiles/yes.gif';
		$SmilesArray[10]['smile_type'] 		= 	'0';
		
		$SmilesArray[11] 					= 	array();
		$SmilesArray[11]['smile_short'] 	= 	':no:';
		$SmilesArray[11]['smile_path'] 		= 	'look/images/smiles/no_1.gif';
		$SmilesArray[11]['smile_type'] 		= 	'0';
		
		$SmilesArray[12] 					= 	array();
		$SmilesArray[12]['smile_short'] 	= 	':hmm:';
		$SmilesArray[12]['smile_path'] 		= 	'look/images/smiles/g.gif';
		$SmilesArray[12]['smile_type'] 		= 	'0';
		
		$SmilesArray[13] 					= 	array();
		$SmilesArray[13]['smile_short'] 	= 	'';
		$SmilesArray[13]['smile_path'] 		= 	'look/images/icons/bomb.gif';
		$SmilesArray[13]['smile_type'] 		= 	'1';
		
		$SmilesArray[14] 					= 	array();
		$SmilesArray[14]['smile_short'] 	= 	'';
		$SmilesArray[14]['smile_path'] 		= 	'look/images/icons/boxed.gif';
		$SmilesArray[14]['smile_type'] 		= 	'1';
		
		$SmilesArray[15] 					= 	array();
		$SmilesArray[15]['smile_short'] 	= 	'';
		$SmilesArray[15]['smile_path'] 		= 	'look/images/icons/bye2.gif';
		$SmilesArray[15]['smile_type'] 		= 	'1';
		
		$SmilesArray[16] 					= 	array();
		$SmilesArray[16]['smile_short'] 	= 	'';
		$SmilesArray[16]['smile_path'] 		= 	'look/images/icons/clap_1.gif';
		$SmilesArray[16]['smile_type'] 		= 	'1';
		
		$SmilesArray[17] 					= 	array();
		$SmilesArray[17]['smile_short'] 	= 	'';
		$SmilesArray[17]['smile_path'] 		= 	'look/images/icons/coffee.gif';
		$SmilesArray[17]['smile_type'] 		= 	'1';
		
		$SmilesArray[18] 					= 	array();
		$SmilesArray[18]['smile_short'] 	= 	'';
		$SmilesArray[18]['smile_path'] 		= 	'look/images/icons/cry.gif';
		$SmilesArray[18]['smile_type'] 		= 	'1';
		
		$SmilesArray[19] 					= 	array();
		$SmilesArray[19]['smile_short'] 	= 	'';
		$SmilesArray[19]['smile_path'] 		= 	'look/images/icons/cupidarrow.gif';
		$SmilesArray[19]['smile_type'] 		= 	'1';
		
		$SmilesArray[20] 					= 	array();
		$SmilesArray[20]['smile_short'] 	= 	'';
		$SmilesArray[20]['smile_path'] 		= 	'look/images/icons/devil_2.gif';
		$SmilesArray[20]['smile_type'] 		= 	'1';
		
		$SmilesArray[21] 					= 	array();
		$SmilesArray[21]['smile_short'] 	= 	'';
		$SmilesArray[21]['smile_path'] 		= 	'look/images/icons/g.gif';
		$SmilesArray[21]['smile_type'] 		= 	'1';
		
		$SmilesArray[22] 					= 	array();
		$SmilesArray[22]['smile_short'] 	= 	'';
		$SmilesArray[22]['smile_path'] 		= 	'look/images/icons/icecream.gif';
		$SmilesArray[22]['smile_type'] 		= 	'1';
		
		$SmilesArray[23] 					= 	array();
		$SmilesArray[23]['smile_short'] 	= 	'';
		$SmilesArray[23]['smile_path'] 		= 	'look/images/icons/king.gif';
		$SmilesArray[23]['smile_type'] 		= 	'1';
		
		$SmilesArray[24] 					= 	array();
		$SmilesArray[24]['smile_short'] 	= 	'';
		$SmilesArray[24]['smile_path'] 		= 	'look/images/icons/lock.gif';
		$SmilesArray[24]['smile_type'] 		= 	'1';
		
		$SmilesArray[25] 					= 	array();
		$SmilesArray[25]['smile_short'] 	= 	'';
		$SmilesArray[25]['smile_path'] 		= 	'look/images/icons/marsa117.gif';
		$SmilesArray[25]['smile_type'] 		= 	'1';
		
		$SmilesArray[26] 					= 	array();
		$SmilesArray[26]['smile_short'] 	= 	'';
		$SmilesArray[26]['smile_path'] 		= 	'look/images/icons/mf_bookread.gif';
		$SmilesArray[26]['smile_type'] 		= 	'1';
		
		$SmilesArray[27] 					= 	array();
		$SmilesArray[27]['smile_short'] 	= 	'';
		$SmilesArray[27]['smile_path'] 		= 	'look/images/icons/smoke.gif';
		$SmilesArray[27]['smile_type'] 		= 	'1';
		
		$SmilesArray[28] 					= 	array();
		$SmilesArray[28]['smile_short'] 	= 	'';
		$SmilesArray[28]['smile_path'] 		= 	'look/images/icons/thumbup.gif';
		$SmilesArray[28]['smile_type'] 		= 	'1';
		
		$SmilesArray[29] 					= 	array();
		$SmilesArray[29]['smile_short'] 	= 	'';
		$SmilesArray[29]['smile_path'] 		= 	'look/images/icons/tooth.gif';
		$SmilesArray[29]['smile_type'] 		= 	'1';
		
		$SmilesArray[30] 					= 	array();
		$SmilesArray[30]['smile_short'] 	= 	'';
		$SmilesArray[30]['smile_path'] 		= 	'look/images/icons/vertag.gif';
		$SmilesArray[30]['smile_type'] 		= 	'1';
		
		$SmilesArray[31] 					= 	array();
		$SmilesArray[31]['smile_short'] 	= 	'';
		$SmilesArray[31]['smile_path'] 		= 	'look/images/icons/wub.gif';
		$SmilesArray[31]['smile_type'] 		= 	'1';
		
		$SmilesArray[32] 					= 	array();
		$SmilesArray[32]['smile_short'] 	= 	'';
		$SmilesArray[32]['smile_path'] 		= 	'look/images/icons/winner_first_h4h.gif';
		$SmilesArray[32]['smile_type'] 		= 	'1';
		
		$SmilesArray[33] 					= 	array();
		$SmilesArray[33]['smile_short'] 	= 	'';
		$SmilesArray[33]['smile_path'] 		= 	'look/images/icons/winner_second_h4h.gif';
		$SmilesArray[33]['smile_type'] 		= 	'1';
		
		$SmilesArray[34] 					= 	array();
		$SmilesArray[34]['smile_short'] 	= 	'';
		$SmilesArray[34]['smile_path'] 		= 	'look/images/icons/winner_third_h4h.gif';
		$SmilesArray[34]['smile_type'] 		= 	'1';
		
		$x = 0;
		$i = array();
		
		while ($x < sizeof($SmilesArray))
		{
			$insert = $MySmartBB->DB->sql_query("INSERT INTO " . $MySmartBB->table['smiles'] . " SET 
														smile_short='" . $SmilesArray[$x]['smile_short'] . "',
														smile_path='" . $SmilesArray[$x]['smile_path'] . "',
														smile_type='" . $SmilesArray[$x]['smile_type'] . "'");
														
			$i[$x] = ($insert) ? 'true' : 'false';
					
			$x += 1;
		}
		
		return $i;
		
	}
	
	function _CreateStyle()
	{
		global $MySmartBB;

		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['style'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'style_title varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'style_on int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'style_order int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'style_path varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'image_path varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'template_path varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'cache_path varchar(200) NOT NULL';
					
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _InsertStyle()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query("INSERT INTO " . $MySmartBB->table['style'] . " SET
												style_title='النمط الافتراضي',
												style_on='1',
												style_order='0',
												style_path='look/styles/forum/main/css/style.css',
												image_path='look/styles/forum/main/images',
												template_path='look/styles/forum/main/templates',
												cache_path='look/styles/forum/main/compiler'
												");
												
		return ($insert) ? true : false;
	}
	
	function _CreateSubject()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['subject'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'title varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'text text NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'writer varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'section int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'write_date varchar(10) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'stick int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'close int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'delete_topic int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'reply_number int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'visitor int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'write_time varchar(25) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'native_write_time int(15) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'icon varchar(50) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_describe varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'action_by varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'sec_subject int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'lastreply_cache text NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'last_replier varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'poll_subject int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'attach_subject int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'actiondate datetime NOT NULL';
		// Since THETA 1
		$this->_TempArr['CreateArr']['fields'][] 	= 	'tags_cache text NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'close_reason varchar(255) NOT NULL';
		// Since ALPHA 2 (THETA 2)
		$this->_TempArr['CreateArr']['fields'][] 	= 	'delete_reason varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'review_subject int(1) NOT NULL';
		
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _CreateSuperMemberLogs()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['sm_logs'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'edit_action varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_title varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'edit_date varchar(10) NOT NULL';
					
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _CreateToday()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['today'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'user_date varchar(10) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'hide_browse int(1) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username_style varchar(255) NOT NULL';
					
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _CreateToolBox()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['toolbox'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'name varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'tool_type int(1) NOT NULL';
					
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _InsertToolBox()
	{
		global $MySmartBB;
		
		$ToolboxArray = array();
		
		// Fonts
		$ToolboxArray['Tahoma'] 			= 1;
		$ToolboxArray['Times_new_roman'] 	= 1;
		$ToolboxArray['Courier_new'] 		= 1;
		$ToolboxArray['Arial'] 				= 1;
		
		// Colors - i think convert it to hex is better!
		$ToolboxArray['skyblue'] 			= 2;
		$ToolboxArray['royalblue'] 			= 2;
		$ToolboxArray['blue'] 				= 2;
		$ToolboxArray['darkblue'] 			= 2;
		$ToolboxArray['orange'] 			= 2;
		$ToolboxArray['orangered'] 			= 2;
		$ToolboxArray['crimson'] 			= 2;
		$ToolboxArray['red'] 				= 2;
		$ToolboxArray['firebrick'] 			= 2;
		$ToolboxArray['darkred'] 			= 2;
		$ToolboxArray['green'] 				= 2;
		$ToolboxArray['limegreen'] 			= 2;
		$ToolboxArray['seagreen'] 			= 2;
		$ToolboxArray['deeppink'] 			= 2;
		$ToolboxArray['tomato'] 			= 2;
		$ToolboxArray['coral'] 				= 2;
		$ToolboxArray['purple'] 			= 2;
		$ToolboxArray['indigo'] 			= 2;
		$ToolboxArray['burlywood'] 			= 2;
		$ToolboxArray['sandybrown'] 		= 2;
		$ToolboxArray['sienna'] 			= 2;
		$ToolboxArray['chocolate'] 			= 2;
		$ToolboxArray['teal'] 				= 2;
		$ToolboxArray['silver'] 			= 2;
		
		$x = 0;
		$i = array();
		
		foreach ($ToolboxArray as $k	=>	$v)
		{
			$k = str_replace('_',' ',$k);
			
			$insert = $MySmartBB->DB->sql_query("INSERT INTO " . $MySmartBB->table['toolbox'] . " SET 
													name='" . $k . "',
													tool_type='" . $v ."'");
													
			$i[$x] = ($insert) ? 'true' : 'false';
			
			$x += 1;
		}
		
		return $i;
	}
	
	function _CreateUserTitle()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['usertitle'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'usertitle varchar(200) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'posts int(9) NOT NULL';
					
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	function _InsertUserTitle()
	{
		global $MySmartBB;
		
		$insert = $MySmartBB->DB->sql_query("INSERT INTO " . $MySmartBB->table['usertitle'] . " SET
												usertitle='عضو',
												posts='0'");
												
		return ($insert) ? true : false;
	}
	
	function _CreateVote()
	{
		global $MySmartBB;
		
		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['vote'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'poll_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'member_id int(9) NOT NULL';
		// Since THETA 1
		$this->_TempArr['CreateArr']['fields'][] 	= 	'username varchar(255) NOT NULL';
		
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;
	}
	
	/** Since THETA 1 **/
	function _CreateTags()
	{
		global $MySmartBB;

		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['tag'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'tag varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'number int(9) NOT NULL';
							
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	function _CreateTagsSubject()
	{
		global $MySmartBB;

		$this->_TempArr['CreateArr']				= 	array();
		$this->_TempArr['CreateArr']['table_name'] 	= 	$MySmartBB->table['tag_subject'];
		$this->_TempArr['CreateArr']['fields'] 		= 	array();
		$this->_TempArr['CreateArr']['fields'][] 	= 	'id INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'tag_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_id int(9) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'tag varchar(255) NOT NULL';
		$this->_TempArr['CreateArr']['fields'][] 	= 	'subject_title varchar(255) NOT NULL';
							
		$create = $this->create_table($this->_TempArr['CreateArr']);
		
		return ($create) ? true : false;		
	}
	
	// That's it !
}

?>
