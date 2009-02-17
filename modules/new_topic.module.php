<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['SUBJECT'] 		= 	true;
$CALL_SYSTEM['SECTION'] 		= 	true;
$CALL_SYSTEM['SMARTCODE'] 		= 	true;
$CALL_SYSTEM['CACHE'] 			= 	true;
$CALL_SYSTEM['ICONS'] 			= 	true;
$CALL_SYSTEM['TOOLBOX'] 		= 	true;
$CALL_SYSTEM['USERTITLE'] 		= 	true;
$CALL_SYSTEM['POLL'] 			= 	true;
$CALL_SYSTEM['TAG'] 			= 	true;
$CALL_SYSTEM['FILESEXTENSION'] 	= 	true;
$CALL_SYSTEM['ATTACH'] 			= 	true;
$CALL_SYSTEM['MODERATORS'] 		= 	true;

define('JAVASCRIPT_SMARTCODE',true);

include('common.php');

define('CLASS_NAME','MySmartTopicAddMOD');

class MySmartTopicAddMOD
{
	var $SectionInfo;
	var $SectionGroup;
	
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
		
		$MySmartBB->functions->GetFooter();
	}
		
	function _CommonCode()
	{
		global $MySmartBB;
		
		//////////
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->ShowHeader('خطأ');
			
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		//////////
		
		$SecArr 			= 	array();
		$SecArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$this->SectionInfo = $MySmartBB->section->GetSectionInfo($SecArr);
		
		if (!$this->SectionInfo)
		{
			$MySmartBB->functions->ShowHeader('خطأ');
		
			$MySmartBB->functions->error('المعذره .. القسم المطلوب غير موجود');
		}
		
		// Kill XSS
		$MySmartBB->functions->CleanVariable($this->SectionInfo,'html');
		// Kill SQL Injection
		$MySmartBB->functions->CleanVariable($this->SectionInfo,'sql');
		
		//////////
		
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
		
		//////////
		
		// The visitor can't show this section , so stop the page
		if (!$this->SectionGroup['view_section'] 
			or !$this->SectionGroup['write_subject'])
		{
			$MySmartBB->functions->ShowHeader('خطأ');

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
     			$PassArr['id'] 	= $this->SectionInfo['id'];
     			
     			// The password to check
     			$PassArr['password'] = base64_decode($MySmartBB->_GET['password']);
     			
     			$IsTruePassword = $MySmartBB->section->CheckPassword($PassArr);
     			
     			// Stop ! it's don't true password															
     			if (!$IsTruePassword)
     			{
     				$MySmartBB->functions->ShowHeader('خطأ');

     				$MySmartBB->functions->error('المعذره .. كلمة المرور غير صحيحه');
     			}
     			
     			$MySmartBB->_CONF['template']['password'] = '&amp;password=' . $MySmartBB->_GET['password'];
     		}
     	}
     	
     	//////////
     	
     	$MySmartBB->template->assign('section_info',$this->SectionInfo);
     	
     	//////////
	}
		
	function _Index()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('اضافة موضوع');
		
		$MySmartBB->functions->GetEditorTools();
			     		
     	$MySmartBB->template->assign('id',$MySmartBB->_GET['id']);
     	
     	// Instead of send a whole version of $this->SectionGroup to template engine
     	// We just send options which we really need, we use this way to save memory
     	$MySmartBB->template->assign('upload_attach',$this->SectionGroup['upload_attach']);
     	
		////////
		
		$Admin = $MySmartBB->functions->ModeratorCheck($MySmartBB->_GET['id']);
		
		$MySmartBB->template->assign('Admin',$Admin);
				
		////////
		
     	$MySmartBB->template->display('new_topic');
	}
	
	function _Start()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية اضافة الموضوع');
		
		$MySmartBB->_POST['title'] 	= 	$MySmartBB->functions->CleanVariable($MySmartBB->_POST['title'],'trim');
		$MySmartBB->_POST['text'] 	= 	$MySmartBB->functions->CleanVariable($MySmartBB->_POST['text'],'trim');
		
		$MySmartBB->functions->AddressBar('<a href="index.php?page=forum&amp;show=1&amp;id=' . $this->SectionInfo['id'] . $MySmartBB->_CONF['template']['password'] . '">' . $this->SectionInfo['title'] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate']  . ' تنفيذ عملية كتابة موضوع');
		
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!$MySmartBB->_CONF['rows']['group_info']['admincp_allow'])
		{
			/*$IsFlood = $MySmartBB->subject->IsFlood(array('last_time'=>$MySmartBB->_CONF['member_row']['lastpost_time']));
			
			if ($IsFlood)
			{
				$MySmartBB->functions->error('المعذره .. لا يمكنك كتابة موضوع جديد إلا بعد ' . $MySmartBB->_CONF['info_row']['floodctrl'] . ' ثانيه');
			}*/
		
     		if (isset($MySmartBB->_POST['title']{$MySmartBB->_CONF['info_row']['post_title_max']}))
     		{
       			$MySmartBB->functions->error('عدد حروف عنوان الموضوع أكبر من (' . $MySmartBB->_CONF['info_row']['post_title_max'] . ')');
    		}

        	if  (!isset($MySmartBB->_POST['title']{$MySmartBB->_CONF['info_row']['post_title_min']}))
     		{
      			$MySmartBB->functions->error('عدد حروف عنوان الموضوع أقل من  (' . $MySmartBB->_CONF['info_row']['post_title_min'] . ')');
     		}
       	 	if (isset($MySmartBB->_POST['text']{$MySmartBB->_CONF['info_row']['post_text_max']}))
     		{
      			$MySmartBB->functions->error('عدد حروف الموضوع أكبر من (' . $MySmartBB->_CONF['info_row']['post_text_max'] . ')');
     		}

     		if (!isset($MySmartBB->_POST['text']{$MySmartBB->_CONF['info_row']['post_text_min']}))
     		{
      			$MySmartBB->functions->error('عدد حروف الموضوع أصغر من (' . $MySmartBB->_CONF['info_row']['post_text_min'] . ')');
     		}
     	}
     	
     	$SubjectArr 								= 	array();
     	$SubjectArr['get_id']						=	true;
     	$SubjectArr['field']						=	array();
     	$SubjectArr['field']['title'] 				= 	$MySmartBB->_POST['title'];
     	$SubjectArr['field']['text'] 				= 	$MySmartBB->_POST['text'];
     	$SubjectArr['field']['writer'] 				= 	$MySmartBB->_CONF['rows']['member_row']['username'];
     	$SubjectArr['field']['section'] 			= 	$this->SectionInfo['id'];
     	$SubjectArr['field']['write_time'] 			= 	$MySmartBB->_CONF['now'];
     	$SubjectArr['field']['icon'] 				= 	$MySmartBB->_POST['icon'];
     	$SubjectArr['field']['subject_describe'] 	= 	$MySmartBB->_POST['describe'];
     	$SubjectArr['field']['native_write_time'] 	= 	$MySmartBB->_CONF['now'];
     	$SubjectArr['field']['sec_subject'] 		= 	$this->SectionInfo['sec_section'];
     	$SubjectArr['field']['poll_subject'] 		= 	0;
     	$SubjectArr['field']['attach_subject'] 		= 	0;
     	$SubjectArr['field']['tags_cache']			=	$MySmartBB->_POST['tags'];
     	
		if (($this->SectionInfo['review_subject'] or $MySmartBB->_CONF['member_row']['review_subject'])
			and !$MySmartBB->_CONF['rows']['group_info']['admincp_allow'])
		{
			$SubjectArr['field']['review_subject'] = 1;
		}
		
     	if ($MySmartBB->_POST['stick'])
     	{
     		$SubjectArr['field']['stick'] = 1;
     	}
     	
     	if ($MySmartBB->_POST['close'])
     	{
     		$SubjectArr['field']['close'] = 1;
     	}
     	
     	$Insert = $MySmartBB->subject->InsertSubject($SubjectArr);
     				
     	if ($Insert)
     	{
     		//////////
     		
     		if ($MySmartBB->_POST['poll'])
     		{
     			if (isset($MySmartBB->_POST['question'])
     				and isset($MySmartBB->_POST['answer'][0])
     				and isset($MySmartBB->_POST['answer'][1]))
     			{
     				$answers_number = 4;
     				
     				if ($MySmartBB->_POST['poll_answers_count'] > 0)
     				{
     					$answers_number = $MySmartBB->_POST['poll_answers_count'];
     				}
     				
     				$answers = array();
     				
     				$x = 0;
     				
     				while ($x < $answers_number)
     				{
     					// The text of the answer
     					$answers[$x][0] = $MySmartBB->_POST['answer'][$x];
     					
     					// The result
     					$answers[$x][1] = 0;
     					
     					$x += 1;
     				}
     				
     				$PollArr 				= 	array();
     				$PollArr['question'] 	= 	$MySmartBB->_POST['question'];
     				$PollArr['answers'] 	= 	$answers;
     				$PollArr['subject_id']	=	$MySmartBB->subject->id;
     				
     				$InsertPoll = $MySmartBB->poll->InsertPoll($PollArr);
     			}
     		}
     		
     		//////////
     		
     		// Set tags for the subject
     		$tags_size = sizeof($MySmartBB->_POST['tags']);

     		if ($tags_size > 0
     			and strlen($MySmartBB->_POST['tags'][0]) > 0)
     		{
     			foreach ($MySmartBB->_POST['tags'] as $tag)
     			{
     				$CheckArr 			= 	array();
     				$CheckArr['where'] 	= 	array('tag',$tag);
     				
     				$tag_id = 1;
     				
     				$Tag = $MySmartBB->tag->GetTagInfo($CheckArr);
     				
     				if (!$Tag)
     				{
     					$InsertArr 					=	array();
     					$InsertArr['field']			=	array();
     					$InsertArr['field']['tag']	=	$tag;
     					$InsertArr['get_id']		=	true;
     					
     					$insert = $MySmartBB->tag->InsertTag($InsertArr);
     					
     					$tag_id = $MySmartBB->tag->id;
     					
     					unset($InsertArr);
     				}
     				else
     				{
     					$UpdateArr 			= 	array();
     					$UpdateArr['field']	=	array();
     					
     					$UpdateArr['field']['number'] 	= 	$Tag['num'] + 1;
     					$UpdateArr['where']				=	array('id',$Tag['id']);
     					
     					$update = $MySmartBB->tag->UpdateTag($UpdateArr);
     					
     					$tag_id = $Tag['id'];
     				}
     				
     				$InsertArr 						= 	array();
     				$InsertArr['field']				=	array();
     				
     				$InsertArr['field']['tag_id'] 			= 	$tag_id;
     				$InsertArr['field']['subject_id'] 		=	$MySmartBB->subject->id;
     				$InsertArr['field']['tag'] 				= 	$tag;
     				$InsertArr['field']['subject_title'] 	= 	$MySmartBB->_POST['title'];
     				
     				// Note, this function is from tag system not subject system
     				$insert = $MySmartBB->tag->InsertSubject($InsertArr);
     			}
     		}
     		
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
     											$AttachArr['field']['subject_id'] 	= 	$MySmartBB->subject->id;
     											
     											$InsertAttach = $MySmartBB->attach->InsertAttach($AttachArr);
     											
     											if ($InsertAttach)
     											{
     												$SubjectArr 							= 	array();
     												$SubjectArr['field'] 					= 	array();
     												$SubjectArr['field']['attach_subject'] 	= 	'1';
     												$SubjectArr['where'] 					= 	array('id',$MySmartBB->subject->id);
     												
     												$update = $MySmartBB->subject->UpdateSubject($SubjectArr);
     											}
     										
     											$z += 1;
     										} // End of if ($copy)
     									
     										//////////
     									
     									} // End of if (!$stop)
     								
     									//////////
     								} // End of else
     							}
     							
     							$x += 1;	
     						}
     					}
     				}
     			}
     		}
     		
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
   			
   			//////////
     		
     		$LastArr = array();
     		
     		$LastArr['writer'] 		= 	$MySmartBB->_CONF['member_row']['username'];
     		$LastArr['title'] 		= 	$MySmartBB->_POST['title'];
     		$LastArr['subject_id'] 	= 	$MySmartBB->subject->id;
     		$LastArr['date'] 		= 	$MySmartBB->_CONF['date'];
     		$LastArr['where'] 		= 	(!$this->SectionInfo['sub_section']) ? array('id',$this->SectionInfo['id']) : array('id',$this->SectionInfo['from_sub_section']);
     		
     		// Update Last subject's information
     		$UpdateLast = $MySmartBB->section->UpdateLastSubject($LastArr);
     		
     		// Free memory
     		unset($LastArr);
     		
     		//////////
     		
     		// The overall number of subjects
     		$UpdateSubjectNumber = $MySmartBB->cache->UpdateSubjectNumber(array('subject_num'	=>	$MySmartBB->_CONF['info_row']['subject_number']));
     		
     		//////////
     		
     		// The number of section's subjects number
     		$UpdateArr 					= 	array();
     		$UpdateArr['field']			=	array();
     		
     		$UpdateArr['field']['subject_num'] 	= 	$this->SectionInfo['subject_num'] + 1;
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
     		
     		if ((!$this->SectionInfo['review_subject'] and !$MySmartBB->_CONF['member_row']['review_subject'])
     			or $MySmartBB->_CONF['rows']['group_info']['admincp_allow'])
			{
     			$MySmartBB->functions->msg('تم طرح موضوعك "' . $MySmartBB->_POST['title'] . '" بنجاح , يرجى الانتظار حتى يتم نقلك إليه');
     			$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->subject->id . $MySmartBB->_CONF['template']['password']);
     		}
     		else
     		{
     			$MySmartBB->functions->msg('نشكرك لمشاركتك! مشاركتك لن تضاف حتى تتم الموافقة عليها من قبل الإدارة. سيتم الآن إعادتك الى المنتدى.');
     			$MySmartBB->functions->goto('index.php?page=forum&amp;show=1&amp;id=' . $this->SectionInfo['id'] . $MySmartBB->_CONF['template']['password']);
     		}
     		
     		//////////
     	}
	}
}

?>
