<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['TOOLBOX'] 	= 	true;
$CALL_SYSTEM['ICONS'] 		= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;
$CALL_SYSTEM['CACHE'] 		= 	true;
$CALL_SYSTEM['USERTITLE'] 	= 	true;
$CALL_SYSTEM['MODERATORS'] 	= 	true;

define('JAVASCRIPT_SMARTCODE',true);

include('common.php');

define('CLASS_NAME','MySmartReplyAddMOD');

class MySmartReplyAddMOD
{
	var $SectionInfo;
	var $SectionGroup;
	var $SubjectInfo;
	
	function run()
	{
		global $MySmartBB;
		
		$this->_CommonCode();
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_Index();
		}
		elseif ($MySmartBB->_GET['start'])
		{
			$this->_Start();
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		if (!isset($MySmartBB->_POST['ajax']))
		{
			$MySmartBB->functions->GetFooter();
		}
	}
	
	function _CommonCode()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->CleanVariable($_GET['id'],'intval');

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$SubjectArr 			= 	array();
		$SubjectArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$this->SubjectInfo = $MySmartBB->subject->GetSubjectInfo($SubjectArr);
		
		// Kill XSS
		$MySmartBB->functions->CleanVariable($this->SubjectInfo,'html');
		// Kill SQL Injection
		$MySmartBB->functions->CleanVariable($this->SubjectInfo,'sql');
		
		$SecArr 			= 	array();
		$SecArr['where'] 	= 	array('id',$this->SubjectInfo['section']);
		
		$this->SectionInfo = $MySmartBB->section->GetSectionInfo($SecArr);
		
		// Kill XSS
		$MySmartBB->functions->CleanVariable($this->SectionInfo,'html');
		// Kill SQL Injection
		$MySmartBB->functions->CleanVariable($this->SectionInfo,'sql');
					
		if (!$this->SubjectInfo)
		{
			$MySmartBB->functions->error('المعذره .. الموضوع المطلوب غير موجود');
		}
		
		$Mod = false;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			if ($MySmartBB->_CONF['group_info']['admincp_allow'] 
				or $MySmartBB->_CONF['group_info']['vice'])
			{
				$Mod = true;
			}
			else
			{
				if (isset($this->SectionInfo))
				{
					$ModArr 				= 	array();
					$ModArr['username'] 	= 	$MySmartBB->_CONF['member_row']['username'];
					$ModArr['section_id']	=	$this->SectionInfo['id'];
				
					$Mod = $MySmartBB->moderator->IsModerator($ModArr);
				}
			}
		}
		
		if (!$Mod)
		{
			if ($this->SubjectInfo['close'])
			{
				$MySmartBB->functions->error('المعذره .. هذا الموضوع مغلق');
			}
		}
				
		/** Get section's group information and make some checks **/
		$SecGroupArr 						= 	array();
		$SecGroupArr['where'] 				= 	array();
		
		$SecGroupArr['where'][0]			=	array();
		$SecGroupArr['where'][0]['name'] 	= 	'section_id';
		$SecGroupArr['where'][0]['oper']	=	'=';
		$SecGroupArr['where'][0]['value'] 	= 	$this->SectionInfo['id'];
		
		$SecGroupArr['where'][1]			=	array();
		$SecGroupArr['where'][1]['con']		=	'AND';
		$SecGroupArr['where'][1]['name']	=	'group_id';
		$SecGroupArr['where'][1]['oper']	=	'=';
		$SecGroupArr['where'][1]['value']	=	$MySmartBB->_CONF['group_info']['id'];
		
		// Finally get the permissions of group
		$this->SectionGroup = $MySmartBB->group->GetSectionGroupInfo($SecGroupArr);
		
		// The visitor can't show this section , so stop the page
		if (!$this->SectionGroup['view_section']
			or !$this->SectionGroup['write_reply'])
		{
			$MySmartBB->functions->error('المعذره لا يمكنك الكتابه في هذا القسم');
		}
		
		if (!empty($this->SectionInfo['section_password']) 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			// The visitor don't give me password , so require it
     		if (empty($MySmartBB->_GET['password']))
        	{
      			$MySmartBB->template->display('forum_password');
      			$MySmartBB->functions->stop();
     		}
     		// The visitor give me password , so check
     		elseif (!empty($MySmartBB->_GET['password']))
     		{
     			$PassArr = array();
     			
     			// Section id
     			$PassArr['id'] = $this->SectionInfo['id'];
     			
     			// The password to check
     			$PassArr['password'] = base64_decode($MySmartBB->_GET['password']);
     			
     			$IsTruePassword = $MySmartBB->section->CheckPassword($PassArr);
     			
     			// Stop ! it's don't true password															
     			if (!$IsTruePassword)
     			{
     				$MySmartBB->functions->error('المعذره .. كلمة المرور غير صحيحه');
     			}
     			
     			$MySmartBB->_CONF['template']['password'] = '&amp;password=' . $MySmartBB->_GET['password'];
     		}
     	}
     	
		//////////
		
		// Where is the member now?
		if ($MySmartBB->_CONF['member_permission'])
     	{
     		$UpdateOnline 			= 	array();
			$UpdateOnline['field']	=	array();
			
			$UpdateOnline['field']['user_location']		=	'يكتب رد على : ' . $this->SubjectInfo['title'];
			$UpdateOnline['where']						=	array('username',$MySmartBB->_CONF['member_row']['username']);
			
			$update = $MySmartBB->online->UpdateOnline($UpdateOnline);
     	}
     	
     	//////////
     	
     	$MySmartBB->template->assign('section_info',$this->SectionInfo);
     	$MySmartBB->template->assign('subject_info',$this->SubjectInfo);
	}
	
	function _Index()
	{			
		global $MySmartBB;
		
		$MySmartBB->functions->GetEditorTools();
			     		
     	$MySmartBB->template->assign('id',$MySmartBB->_GET['id']);
     	
     	$MySmartBB->functions->ShowHeader('اضافة رد');
     			
     	$MySmartBB->template->display('new_reply');
	}
		
	function _Start()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية اضافة الرد');
		
		$MySmartBB->_POST['title'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['title'],'trim');
		$MySmartBB->_POST['text'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['text'],'trim');
		
		if (!isset($MySmartBB->_POST['ajax']))
		{
			$MySmartBB->functions->AddressBar('<a href="index.php?page=forum&amp;show=1&amp;id=' . $this->SectionInfo['id'] . $MySmartBB->_CONF['template']['password'] . '">' . $this->SectionInfo['title'] . '</a>' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . '<a href="index.php?page=topic&amp;show=1&amp;id=' . $this->SubjectInfo['id'] . $MySmartBB->_CONF['template']['password'] . '">' . $this->SubjectInfo['title'] . '</a>' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية اضافة الرد');
		}
		
		if (empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			/*$IsFlood = $MySmartBB->subject->IsFlood(array('last_time' => $MySmartBB->_CONF['member_row']['lastpost_time']));
			
			if ($IsFlood)
			{
				$MySmartBB->functions->error('المعذره .. لا يمكنك كتابة موضوع جديد إلا بعد ' . $MySmartBB->_CONF['info_row']['floodctrl'] . ' ثانيه');
			}*/
							
			if (isset($MySmartBB->_POST['title']{$MySmartBB->_CONF['info_row']['post_title_max']+1}))
			{
				$MySmartBB->functions->error('عدد حروف عنوان الموضوع أكبر من (' . $info_row['post_text_max'] . ')');
     		}
     		
     		if (isset($MySmartBB->_POST['text']{$MySmartBB->_CONF['info_row']['post_text_max']+1}))
     		{
     			$MySmartBB->functions->error('عدد حروف الرد أكبر من (' . $MySmartBB->_CONF['info_row']['post_text_max'] . ')');
     		}

     		if (!isset($MySmartBB->_POST['text']{$MySmartBB->_CONF['info_row']['post_text_min']}))
     		{
     			$MySmartBB->functions->error('عدد حروف الرد أصغر من (' . $MySmartBB->_CONF['info_row']['post_text_min'] . ')');
     		}
     	}
     	
     	$ReplyArr 			= 	array();
     	$ReplyArr['field'] 	= 	array();
     	
     	$ReplyArr['field']['title'] 		= 	$MySmartBB->_POST['title'];
     	$ReplyArr['field']['text'] 			= 	$MySmartBB->_POST['text'];
     	$ReplyArr['field']['writer'] 		= 	$MySmartBB->_CONF['member_row']['username'];
     	$ReplyArr['field']['subject_id'] 	= 	$this->SubjectInfo['id'];
     	$ReplyArr['field']['write_time'] 	= 	$MySmartBB->_CONF['now'];
     	$ReplyArr['field']['section'] 		= 	$this->SubjectInfo['section'];
     	$ReplyArr['field']['icon'] 			= 	$MySmartBB->_POST['icon'];
     	$ReplyArr['get_id']					=	true;
     	
     	$Insert = $MySmartBB->reply->InsertReply($ReplyArr);
     	
     	if ($Insert)
     	{
     		//////////
     		
     		$posts = $MySmartBB->_CONF['member_row']['posts'] + 1;
     		
     		if ($MySmartBB->_CONF['group_info']['usertitle_change'])
     		{
     			$UsertitleArr 			= 	array();
     			$UsertitleArr['where'] 	= 	array('posts',$posts);
     		
     			$UserTitle = $MySmartBB->usertitle->GetUsertitleInfo($UsertitleArr);
     		
     			if ($UserTitle != false)
     			{
     				$usertitle = $UserTitle['usertitle'];
     			}
     		}

     		//////////
     		
	   		$MemberArr 				= 	array();
	   		$MemberArr['field'] 	= 	array();
     		
     		$MemberArr['field']['posts']			=	$posts;
     		$MemberArr['field']['lastpost_time'] 	=	$MySmartBB->_CONF['now'];
     		$MemberArr['field']['user_title']		=	(isset($usertitle)) ? $usertitle : null;
     		$MemberArr['where']						=	array('id',$MySmartBB->_CONF['member_row']['id']);
     			
   			$UpdateMember = $MySmartBB->member->UpdateMember($MemberArr);
     			
     		$TimeArr = array();
     		
     		$TimeArr['write_time'] 	= 	$MySmartBB->_CONF['now'];
     		$TimeArr['where']		=	array('id',$this->SubjectInfo['id']);
     		
     		$UpdateWriteTime = $MySmartBB->subject->UpdateWriteTime($TimeArr);
     		
     		$RepArr 					= 	array();
     		$RepArr['reply_number']		=	$this->SubjectInfo['reply_number'];
     		$RepArr['where'] 			= 	array('id',$this->SubjectInfo['id']);
     		
     		$UpdateReplyNumber = $MySmartBB->subject->UpdateReplyNumber($RepArr);
     		     		
     		$LastArr = array();
     		
     		$LastArr['writer'] 		= 	$MySmartBB->_CONF['member_row']['username'];
     		$LastArr['title'] 		= 	$this->SubjectInfo['title'];
     		$LastArr['subject_id'] 	= 	$this->SubjectInfo['id'];
     		$LastArr['date'] 		= 	$MySmartBB->_CONF['date'];
     		$LastArr['where'] 		= 	(!$this->SectionInfo['sub_section']) ? array('id',$this->SectionInfo['id']) : array('id',$this->SectionInfo['from_sub_section']);
     		
     		$UpdateLast = $MySmartBB->section->UpdateLastSubject($LastArr);
     		
     		// Free memory
     		unset($LastArr);
     		
     		$UpdateSubjectNumber = $MySmartBB->cache->UpdateReplyNumber(array('reply_num'	=>	$MySmartBB->_CONF['info_row']['reply_number']));
     		
     		$LastArr = array();
     		
     		$LastArr['replier'] 	= 	$MySmartBB->_CONF['member_row']['username'];
     		$LastArr['where']		=	array('id',$this->SubjectInfo['id']);
     		
     		$UpdateLastReplier = $MySmartBB->subject->UpdateLastReplier($LastArr);
     		
     		// Free memory
     		unset($LastArr);
     		
     		$UpdateArr 					= 	array();
     		$UpdateArr['field']			=	array();
     		
     		$UpdateArr['field']['reply_num'] 	= 	$this->SectionInfo['reply_num'] + 1;
     		$UpdateArr['where']					= 	array('id',$this->SectionInfo['id']);
     		
     		$UpdateSubjectNumber = $MySmartBB->section->UpdateSection($UpdateArr);
     		
     		// Free memory
     		unset($UpdateArr);
     		
     		//////////
     		
     		// Update section's cache
     		$UpdateArr 				= 	array();
     		$UpdateArr['parent'] 	= 	$this->SectionInfo['parent'];
     		
     		$update_cache = $MySmartBB->section->UpdateSectionsCache($UpdateArr);
     		
     		unset($UpdateArr);
     		
     		//////////
     		
     		if (!isset($MySmartBB->_POST['ajax']))
     		{
     			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $this->SubjectInfo['id'] . $MySmartBB->_CONF['template']['password']);
     		}
     		else
     		{
     			$GetArr = array();
     			$GetArr['where'] = array('id',$MySmartBB->reply->id);
     			
     			$MySmartBB->_CONF['template']['Info'] = $MySmartBB->reply->GetReplyInfo($GetArr);
     			
     			$MySmartBB->_CONF['template']['Info']['id'] 			= 	$MySmartBB->_CONF['member_row']['id'];
     			$MySmartBB->_CONF['template']['Info']['username'] 		= 	$MySmartBB->_CONF['member_row']['username'];
     			$MySmartBB->_CONF['template']['Info']['avater_path'] 	= 	$MySmartBB->_CONF['member_row']['avater_path'];
     			$MySmartBB->_CONF['template']['Info']['posts'] 			= 	$MySmartBB->_CONF['member_row']['posts'];
     			$MySmartBB->_CONF['template']['Info']['user_country'] 	= 	$MySmartBB->_CONF['member_row']['user_country'];
     			$MySmartBB->_CONF['template']['Info']['visitor'] 		= 	$MySmartBB->_CONF['member_row']['visitor'];
     			$MySmartBB->_CONF['template']['Info']['away'] 			= 	$MySmartBB->_CONF['member_row']['away'];
     			$MySmartBB->_CONF['template']['Info']['away_msg'] 		= 	$MySmartBB->_CONF['member_row']['away_msg'];
     			$MySmartBB->_CONF['template']['Info']['register_date'] 	= 	$MySmartBB->_CONF['member_row']['register_date'];
     			$MySmartBB->_CONF['template']['Info']['user_title'] 	= 	$MySmartBB->_CONF['member_row']['user_title'];
     			
     			// Make register date in nice format to show it
				if (is_numeric($MySmartBB->_CONF['template']['Info']['register_date']))
				{
					$MySmartBB->_CONF['template']['Info']['register_date'] = $MySmartBB->functions->date($MySmartBB->_CONF['template']['Info']['register_date']);
				}
		
				// Make member gender as a readable text
				$MySmartBB->_CONF['template']['Info']['user_gender'] 	= 	str_replace('m','ذكر',$MySmartBB->_CONF['member_row']['user_gender']);
				$MySmartBB->_CONF['template']['Info']['user_gender'] 	= 	str_replace('f','انثى',$MySmartBB->_CONF['template']['Info']['user_gender']);
				
				$CheckOnline = ($MySmartBB->_CONF['member_row']['logged'] < $MySmartBB->_CONF['timeout']) ? false : true;
											
				($CheckOnline) ? $MySmartBB->template->assign('status',"<font class='online'>متصل</font>") : $MySmartBB->template->assign('status',"<font class='offline'>غير متصل</font>");
		
				$MySmartBB->_CONF['template']['Info']['text'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['template']['Info']['text']);
				
				// Convert the smiles to image
				$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['Info']['text']);
			
				// Member signture is not empty , show make it nice with SmartCode
				if (!empty($MySmartBB->_CONF['member_row']['user_sig']))
				{
					$MySmartBB->_CONF['template']['Info']['user_sig'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['member_row']['user_sig']);
					
					$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['Info']['user_sig']);
				}
				
				$reply_date = $MySmartBB->functions->date($MySmartBB->_CONF['template']['Info']['write_time']);
				$reply_time = $MySmartBB->functions->time($MySmartBB->_CONF['template']['Info']['write_time']);
		
				$MySmartBB->_CONF['template']['Info']['write_time'] = $reply_date . ' ; ' . $reply_time;
				
     			$MySmartBB->template->display('show_reply');
     		}
     	}
	}
}
	
	// Wooooooow , The latest modules of MySmartBB SEGMA 1 :) The THETA stage will come soon ;)
	// 11/8/2006 -> 11:21 PM -> MaaSTaaR
	
?>
