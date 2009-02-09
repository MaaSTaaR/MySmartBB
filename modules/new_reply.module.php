<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['SUBJECT'] 		= 	true;
$CALL_SYSTEM['SECTION'] 		= 	true;
$CALL_SYSTEM['TOOLBOX'] 		= 	true;
$CALL_SYSTEM['ICONS'] 			= 	true;
$CALL_SYSTEM['REPLY'] 			= 	true;
$CALL_SYSTEM['CACHE'] 			= 	true;
$CALL_SYSTEM['USERTITLE'] 		= 	true;
$CALL_SYSTEM['MODERATORS'] 		= 	true;
$CALL_SYSTEM['FILESEXTENSION'] 	= 	true;
$CALL_SYSTEM['ATTACH'] 			= 	true;

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
			
			$UpdateOnline['field']['user_location']		=	'يكتب رداً على : ' . $this->SubjectInfo['title'];
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
		
		$Admin = false;

		if ($MySmartBB->_CONF['member_permission'])
		{
			if ($MySmartBB->_CONF['group_info']['admincp_allow']
				or $MySmartBB->_CONF['group_info']['vice'])
			{
				$Admin = true;
			}
			else
			{
				if (isset($this->SectionInfo))
				{
					$AdminArr = array();
					$AdminArr['username'] = $MySmartBB->_CONF['member_row']['username'];
					$AdminArr['section_id'] = $this->SectionInfo['id'];

					$Admin = $MySmartBB->moderator->IsModerator($AdminArr);
				}
			}
		}
     	
     	// Instead of send a whole version of $this->SectionGroup to template engine
     	// We just send options which we really need, we use this way to save memory
     	$MySmartBB->template->assign('upload_attach',$this->SectionGroup['upload_attach']);
     	
     	$MySmartBB->template->assign('Admin',$Admin);
     	
     	$MySmartBB->template->display('new_reply');
	}
		
	function _Start()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_POST['ajax']))
		{
			$MySmartBB->functions->ShowHeader('تنفيذ عملية اضافة الرد');
		}
		
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
				$MySmartBB->functions->error('عدد حروف عنوان الرد أكبر من (' . $info_row['post_text_max'] . ')');
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

		if ($MySmartBB->_POST['stick'])
		{
			$UpdateArr = array();
			$UpdateArr['where'] = array('id',$this->SubjectInfo['id']);
			
			$update = $MySmartBB->subject->StickSubject($UpdateArr);
		}
		
		if ($MySmartBB->_POST['close'])
		{
			$UpdateArr = array();
			$UpdateArr['reason'] = $MySmartBB->_POST['reason'];
			$UpdateArr['where'] = array('id',$this->SubjectInfo['id']);
			
			$update = $MySmartBB->subject->CloseSubject($UpdateArr);
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
     		
     		if ($this->SectionGroup['no_posts'])
     		{
     			$posts = $MySmartBB->_CONF['member_row']['posts'] + 1;
     		}
     		else
     		{
     			$posts = $MySmartBB->_CONF['member_row']['posts'];
     		}
     		
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
     		
     		// Upload files
     		if ($MySmartBB->_POST['attach'])
     		{
     			if ($this->SectionGroup['upload_attach'])
     			{
	     			$files_error	=	array();
    	 			$files_success	=	array();
    	 			$files_number 	= 	sizeof($MySmartBB->_FILES['files']['name']);
    	 			$stop			=	false;
    	 			
    	 			if ($files_number > 0)
    	 			{
     					if ($files_number > $this->SectionGroup['upload_attach_num']
     						and !$MySmartBB->_CONF['group_info']['admincp_allow'])
     					{
     						$MySmartBB->functions->error('المعذره لا يمكنك رفع اكثر من ' . $this->SectionGroup['upload_attach_num'] . 'ملف');
     					}
     					
    	 				// All of these variables use for loop and arrays
    	 				$x = 0; // For the main loop
    	 				$y = 0; // For error array
    	 				$z = 0; // For success array
    	 				
    	 				while ($files_number > $x)
   		 				{
    	 					if (!empty($MySmartBB->_FILES['files']['name'][$x]))
   	  						{
   		  						//////////
     						
     							// Get the extension of the file
     							$ext = $MySmartBB->functions->GetFileExtension($MySmartBB->_FILES['files']['name'][$x]);
     							
     							// Bad try!
     							if ($ext == 'MULTIEXTENSION'
     								or !$ext)
     							{
     								$files_error[$y] = $MySmartBB->_FILES['files']['name'][$x];
     								
     								$y += 1;
     							}
     							else
     							{
     								// Convert the extension to small case
     								$ext = strtolower($ext);
     							
     								//////////
     							
     								// Check if the extenstion is allowed or not (TODO : cache me please)
     								$ExtArr 			= 	array();
     								$ExtArr['where'] 	= 	array('Ex',$ext);
     							
     								$extension = $MySmartBB->extension->GetExtensionInfo($ExtArr);
     							
     								// The extension is not allowed
     								if (!$extension)
     								{
     									$files_error[$y] = $MySmartBB->_FILES['files']['name'][$x];
     								
     									$y += 1;
     								}
     								else
     								{
     									
     									if (!empty($extension['mime_type']))
     									{
     										if ($MySmartBB->_FILES['files']['type'][$x] != $extension['mime_type'])
     										{
     											$files_error[$y] = $MySmartBB->_FILES['files']['name'][$x];
     											
     											$stop = true;
     											
     											$y += 1;
     										}
     									}
     									
     									//////////
     								
     									// Check the size
     								
     									// Change the size from bytes to KB
     									$size = ceil(($MySmartBB->_FILES['files']['size'][$x] / 1024));
     								
     									// oooh! the file is very large
     									if ($size > $extension['max_size'])
     									{
     										$files_error[$y] = $MySmartBB->_FILES['files']['name'][$x];
     									
     										$stop = true;
     									
     										$y += 1;
     									}
     								
     									//////////
     								
     									if (!$stop)
     									{
     										// Set the name of the file
     								
     										$filename = $MySmartBB->_FILES['files']['name'][$x];
     								
     										// There is a file which has same name, so change the name of the new file
     										if (file_exists($MySmartBB->_CONF['info_row']['download_path'] . '/' . $filename))
     										{
     											$filename = $MySmartBB->_FILES['files']['name'][$x] . '-' . $MySmartBB->functions->RandomCode();
     										}
     									
     										//////////
     									
     										// Copy the file to download dirctory
     										$copy = copy($MySmartBB->_FILES['files']['tmp_name'][$x],$MySmartBB->_CONF['info_row']['download_path'] . '/' . $filename);
     								
     										// Success
     										if ($copy)
     										{
     											// Add the file to the success array 
     											$files_success[$z] = $MySmartBB->_FILES['files']['name'][$x];
     										
     											// Insert attachment to the database
     											$AttachArr 							= 	array();
     											$AttachArr['field'] 				= 	array();
     											$AttachArr['field']['filename'] 	= 	$MySmartBB->_FILES['files']['name'][$x];
     											$AttachArr['field']['filepath'] 	= 	$MySmartBB->_CONF['info_row']['download_path'] . '/' . $filename;
     											$AttachArr['field']['filesize'] 	= 	$MySmartBB->_FILES['files']['size'][$x];
     											$AttachArr['field']['subject_id'] 	= 	$MySmartBB->reply->id;
     											$AttachArr['field']['reply']		=	'1';
     											
     											$InsertAttach = $MySmartBB->attach->InsertAttach($AttachArr);
     											
     											if ($InsertAttach)
     											{
     												$ReplyArr 							= 	array();
     												$ReplyArr['field'] 					= 	array();
     												$ReplyArr['field']['attach_reply'] 	= 	'1';
     												$ReplyArr['where'] 					= 	array('id',$MySmartBB->reply->id);
     												
     												$update = $MySmartBB->reply->UpdateReply($ReplyArr);
     											}
     											
     											$z += 1;
     										}
     								
     										//////////
     									}
     							
     									//////////
     							
     									$x += 1;
     								}
     							}
     						}
     					}
     				}
     			}
     		}
     		
     		//////////
     		
     		if (!isset($MySmartBB->_POST['ajax']))
     		{
     			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $this->SubjectInfo['id'] . $MySmartBB->_CONF['template']['password']);
     		}
     		else
     		{
     			$GetArr 			= 	array();
     			$GetArr['where'] 	= 	array('id',$MySmartBB->reply->id);
     			
     			$MySmartBB->_CONF['template']['Info'] = $MySmartBB->reply->GetReplyInfo($GetArr);
     			
     			$MySmartBB->_CONF['template']['Info']['id'] 				= 	$MySmartBB->_CONF['member_row']['id'];
     			$MySmartBB->_CONF['template']['Info']['username'] 			= 	$MySmartBB->_CONF['member_row']['username'];
     			$MySmartBB->_CONF['template']['Info']['avater_path'] 		= 	$MySmartBB->_CONF['member_row']['avater_path'];
     			$MySmartBB->_CONF['template']['Info']['posts'] 				= 	$MySmartBB->_CONF['member_row']['posts'];
     			$MySmartBB->_CONF['template']['Info']['user_country'] 		= 	$MySmartBB->_CONF['member_row']['user_country'];
     			$MySmartBB->_CONF['template']['Info']['visitor'] 			= 	$MySmartBB->_CONF['member_row']['visitor'];
     			$MySmartBB->_CONF['template']['Info']['away'] 				= 	$MySmartBB->_CONF['member_row']['away'];
     			$MySmartBB->_CONF['template']['Info']['away_msg'] 			= 	$MySmartBB->_CONF['member_row']['away_msg'];
     			$MySmartBB->_CONF['template']['Info']['register_date'] 		= 	$MySmartBB->_CONF['member_row']['register_date'];
     			$MySmartBB->_CONF['template']['Info']['user_title'] 		= 	$MySmartBB->_CONF['member_row']['user_title'];
     			
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
				
				if (empty($MySmartBB->_CONF['member_row']['username_style_cache']))
				{
					$MySmartBB->_CONF['template']['Info']['display_username'] = $MySmartBB->_CONF['member_row']['username'];
				}
				else
				{
					$MySmartBB->_CONF['template']['Info']['display_username'] = $MySmartBB->_CONF['member_row']['username_style_cache'];
			
					$MySmartBB->_CONF['template']['Info']['display_username'] = $MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['Info']['display_username'],'unhtml');
				}
		
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
