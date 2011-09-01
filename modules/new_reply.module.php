<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartReplyAddMOD');

class MySmartReplyAddMOD
{
	private $SectionInfo;
	private $SectionGroup;
	private $SubjectInfo;
	private $moderator = false;
	
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'cache,moderator,reply,section,subject' );
		
		$this->_commonCode();
		
		if ($MySmartBB->_GET['index'])
		{
			$this->_index();
		}
		elseif ($MySmartBB->_GET['start'])
		{
			$this->_start();
		}
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		if (!isset($MySmartBB->_POST['ajax']))
		{
			$MySmartBB->func->getFooter();
		}
	}
	
	private function _commonCode()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !', false);
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$this->SubjectInfo = $MySmartBB->rec->getInfo();

		if (!$this->SubjectInfo)
		{
			$MySmartBB->func->error('المعذره .. الموضوع المطلوب غير موجود', false);
		}
		
		$MySmartBB->func->cleanArray( $this->SubjectInfo, 'sql' );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $this->SubjectInfo['section'] . "'";
		
		$this->SectionInfo = $MySmartBB->rec->getInfo();
		
		$MySmartBB->func->cleanArray( $this->SectionInfo, 'sql' );
		
		// ... //
		
		$this->moderator = $MySmartBB->func->moderatorCheck( $this->SectionInfo['id'], $MySmartBB->_CONF['member_row']['username'] );
		
		// ... //

		if ( !$this->moderator )
		{
			if ( $this->SubjectInfo[ 'close' ] )
			{
				$MySmartBB->func->error('المعذره .. هذا الموضوع مغلق', false);
			}
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->SectionInfo['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		$this->SectionGroup = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( !$this->SectionGroup['view_section']
			or !$this->SectionGroup['write_reply'] )
		{
			$MySmartBB->func->error('المعذره لا يمكنك الكتابه في هذا القسم', false);
		}
		
		// ... //
		
		// TODO :: use functions
		if ( !empty($this->SectionInfo['section_password']) 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'] )
		{
			// The visitor don't give me password , so require it
     		if (empty($MySmartBB->_GET['password']))
        	{
      			$MySmartBB->template->display('forum_password');
      			$MySmartBB->func->stop();
     		}
     		// The visitor give me password , so check
     		elseif (!empty($MySmartBB->_GET['password']))
     		{
     			$check = $MySmartBB->section->checkPassword( base64_decode($MySmartBB->_GET['password']), $this->SectionInfo['id'] );
     			
     			// Stop ! it's not the true password															
     			if (!$check)
     			{
     				$MySmartBB->func->error('المعذره .. كلمة المرور غير صحيحه', false);
     			}
     			
     			$MySmartBB->_CONF['template']['password'] = '&amp;password=' . $MySmartBB->_GET['password'];
     		}
     	}
     	
		// ... //
		
		// Where is the member now?
		if ( $MySmartBB->_CONF['member_permission'] )
     	{
     		$MySmartBB->rec->table = $MySmartBB->table[ 'online' ];
			$MySmartBB->rec->fields = array(	'user_location'	=>	'يكتب رداً على : ' . $this->SubjectInfo['title']	);
			$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF['member_row']['username'] . "'";
			
			$update = $MySmartBB->rec->update();
     	}
     	
     	// ... //
     	
     	$MySmartBB->template->assign('section_info',$this->SectionInfo);
     	$MySmartBB->template->assign('subject_info',$this->SubjectInfo);
	}
	
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->template->assign('id',$MySmartBB->_GET['id']);
		
		$MySmartBB->func->showHeader('اضافة رد');
		     	
     	// Instead of send a whole version of $this->SectionGroup to template engine
     	// We just send options which we really need, we use this way to save memory
     	$MySmartBB->template->assign('upload_attach',$this->SectionGroup['upload_attach']);
     	
     	$MySmartBB->template->assign('Admin',$this->moderator);
     	
     	$MySmartBB->template->display('new_reply');
	}
		
	private function _start()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_POST['ajax']))
		{
			$MySmartBB->func->showHeader('تنفيذ عملية اضافة الرد');
		}
		
		$MySmartBB->_POST['title'] = trim( $MySmartBB->_POST[ 'title' ] );
		$MySmartBB->_POST['text'] = trim( $MySmartBB->_POST[ 'text' ] );
		
		if (!isset($MySmartBB->_POST['ajax']))
		{
			$MySmartBB->func->AddressBar('<a href="index.php?page=forum&amp;show=1&amp;id=' . $this->SectionInfo['id'] . $MySmartBB->_CONF['template']['password'] . '">' . $this->SectionInfo['title'] . '</a>' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . '<a href="index.php?page=topic&amp;show=1&amp;id=' . $this->SubjectInfo['id'] . $MySmartBB->_CONF['template']['password'] . '">' . $this->SubjectInfo['title'] . '</a>' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية اضافة الرد');
		}
		
		if (empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			/*$IsFlood = $MySmartBB->subject->IsFlood(array('last_time' => $MySmartBB->_CONF['member_row']['lastpost_time']));
			
			if ($IsFlood)
			{
				$MySmartBB->func->error('المعذره .. لا يمكنك كتابة موضوع جديد إلا بعد ' . $MySmartBB->_CONF['info_row']['floodctrl'] . ' ثانيه');
			}*/
							
			if (isset($MySmartBB->_POST['title']{$MySmartBB->_CONF['info_row']['post_title_max']+1}))
			{
				$MySmartBB->func->error('عدد حروف عنوان الرد أكبر من (' . $info_row['post_text_max'] . ')');
     		}
     		
     		if (isset($MySmartBB->_POST['text']{$MySmartBB->_CONF['info_row']['post_text_max']+1}))
     		{
     			$MySmartBB->func->error('عدد حروف الرد أكبر من (' . $MySmartBB->_CONF['info_row']['post_text_max'] . ')');
     		}

     		if (!isset($MySmartBB->_POST['text']{$MySmartBB->_CONF['info_row']['post_text_min']}))
     		{
     			$MySmartBB->func->error('عدد حروف الرد أصغر من (' . $MySmartBB->_CONF['info_row']['post_text_min'] . ')');
     		}
     	}
     	
     	if ( $this->moderator )
     	{
			if ($MySmartBB->_POST['stick'])
			{
				$update = $MySmartBB->subject->stickSubject( $this->SubjectInfo['id'] );
			}
		
			if ($MySmartBB->_POST['close'])
			{
				$update = $MySmartBB->subject->closeSubject( $MySmartBB->_POST['reason'], $this->SubjectInfo['id'] );
			}
		}
     	
     	// Hello WYSIWYG :)
     	if ($MySmartBB->_CONF['info_row']['wysiwyg_reply'])
     	{
     		$MySmartBB->_POST['text'] = $MySmartBB->func->replaceWYSIWYG( $MySmartBB->_POST['text'] );
     	}
     	
     	$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
     	$MySmartBB->rec->fields = array(	'title'	=>	$MySmartBB->_POST['title'],
     										'text'	=>	$MySmartBB->_POST['text'],
     										'writer'	=>	$MySmartBB->_CONF['member_row']['username'],
     										'subject_id'	=>	$this->SubjectInfo['id'],
     										'write_time'	=>	$MySmartBB->_CONF['now'],
     										'section'	=>	$this->SubjectInfo['section'],
     										'icon'	=>	$MySmartBB->_POST['icon']	);
     	$MySmartBB->rec->get_id = true;
     	
     	$insert = $MySmartBB->rec->insert();
     	
     	if ($insert)
     	{
     		// ... //
     		
     		$posts = ( !$this->SectionGroup[ 'no_posts' ] ) ? $MySmartBB->_CONF['member_row']['posts'] + 1 : $MySmartBB->_CONF['member_row']['posts'];
     		
     		// ... //
     		
     		$usertitle = '';
     		
     		if ($MySmartBB->_CONF['group_info']['usertitle_change'])
     		{
     			$MySmartBB->rec->table = $MySmartBB->table[ 'usertitle' ];
     			$MySmartBB->rec->filter = "posts='" . $posts . "'";
     			
     			$UserTitle = $MySmartBB->rec->getInfo();
     		
     			if ($UserTitle != false)
     			{
     				$usertitle = $UserTitle['usertitle'];
     			}
     		}

     		// ... //
     		
     		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
     		$MySmartBB->rec->fields = array(	'posts'	=>	$posts,
     									'lastpost_time'	=>	$MySmartBB->_CONF['now'],
     									'user_title'	=>	$usertitle	);
     		
     		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
     		
   			$UpdateMember = $MySmartBB->rec->update();
     		
     		// ... //
     		
     		$UpdateWriteTime = $MySmartBB->subject->updateWriteTime( $MySmartBB->_CONF['now'], $this->SubjectInfo['id'] );
     		
			// ... //
			
			$UpdateReplyNumber = $MySmartBB->subject->updateReplyNumber( $this->SubjectInfo['reply_number'], $this->SubjectInfo['id'] );
			
			// ... //

     		$UpdateLast = $MySmartBB->section->updateLastSubject( 	$MySmartBB->_CONF['member_row']['username'], 
     																$this->SubjectInfo['title'], 
     																$this->SubjectInfo['id'], 
     																$MySmartBB->_CONF['date'], 
     																(!$this->SectionInfo['sub_section']) ? $this->SectionInfo['id'] : $this->SectionInfo['from_sub_section'] );
     		
     		// ... //
     		
     		// TODO: only $MySmartBB->_CONF['info_row']['reply_number'] as a parameter?
     		// or $MySmartBB->_CONF['info_row']['reply_number'] + 1 instead??
     		$UpdateSubjectNumber = $MySmartBB->cache->updateReplyNumber( $MySmartBB->_CONF['info_row']['reply_number'] );
     		
     		// ... //
     		
     		$UpdateLastReplier = $MySmartBB->subject->updateLastReplier( $MySmartBB->_CONF['member_row']['username'], $this->SubjectInfo['id'] );
     		
     		// ... //
     		
     		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->fields = array(	'reply_num'	=>	$this->SectionInfo['reply_num'] + 1 );
			$MySmartBB->rec->filter = "id='" . $this->SectionInfo['id'] . "'";
			
			$UpdateSubjectNumber = $MySmartBB->rec->update();
     		
     		// ... //
     		
     		$update_cache = $MySmartBB->section->updateSectionsCache( $this->SectionInfo['parent'] );
     		
     		// ... //
     		
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
     						$MySmartBB->func->error('المعذره لا يمكنك رفع اكثر من ' . $this->SectionGroup['upload_attach_num'] . 'ملف');
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
     							$ext = $MySmartBB->func->getFileExtension($MySmartBB->_FILES['files']['name'][$x]);
     							
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
     								$MySmartBB->rec->filter = "Ex='" . $ext . "'";
     								
     								$extension = $MySmartBB->extension->getExtensionInfo($ExtArr);
     							
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
     											$filename = $MySmartBB->_FILES['files']['name'][$x] . '-' . $MySmartBB->func->RandomCode();
     										}
     									
     										//////////
     									
     										// Copy the file to download dirctory
     										$copy = copy($MySmartBB->_FILES['files']['tmp_name'][$x],$MySmartBB->_CONF['info_row']['download_path'] . '/' . $filename);
     								
     										// Success
     										if ($copy)
     										{
     											// Add the file to the success array 
     											$files_success[$z] = $MySmartBB->_FILES['files']['name'][$x];
     										
     											// Insert the attachment to the database
     											$MySmartBB->rec->fields = array(	'filename'	=>	$MySmartBB->_FILES['files']['name'][$x],
     																				'filepath'	=>	$MySmartBB->_CONF['info_row']['download_path'] . '/' . $filename,
     																				'filesize'	=>	$MySmartBB->_FILES['files']['size'][$x],
     																				'subject_id'	=>	$MySmartBB->reply->id,
     																				'reply'	=>		'1');
     																				
     											$InsertAttach = $MySmartBB->attach->insertAttach();
     											
     											if ($InsertAttach)
     											{
     												$MySmartBB->rec->fields = array(	'attach_reply'	=>	'1'	);
     												
     												$MySmartBB->rec->filter = "id='" . $MySmartBB->rec->id . "'";
     												
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
     			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $this->SubjectInfo['id'] . $MySmartBB->_CONF['template']['password']);
     		}
     		else
     		{
     			$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
     			$MySmartBB->rec->filter = "id='" . $MySmartBB->rec->id . "'";
     			
     			$MySmartBB->_CONF['template']['Info'] = $MySmartBB->rec->getInfo();
     			
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
					$MySmartBB->_CONF['template']['Info']['register_date'] = $MySmartBB->func->date($MySmartBB->_CONF['template']['Info']['register_date']);
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
			
					$MySmartBB->_CONF['template']['Info']['display_username'] = $MySmartBB->func->CleanVariable($MySmartBB->_CONF['template']['Info']['display_username'],'unhtml');
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
				
				$reply_date = $MySmartBB->func->date($MySmartBB->_CONF['template']['Info']['write_time']);
				$reply_time = $MySmartBB->func->time($MySmartBB->_CONF['template']['Info']['write_time']);
		
				$MySmartBB->_CONF['template']['Info']['write_time'] = $reply_date . ' ; ' . $reply_time;
				
     			$MySmartBB->template->display('show_reply');
     		}
     	}
	}
}
	
// Wooooooow , The latest modules of MySmartBB SEGMA 1 :) The THETA stage will come soon ;)
// 11/8/2006 -> 11:21 PM -> MaaSTaaR
	
?>
