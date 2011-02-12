<?php

/** PHP5 **/

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


if ( !defined( 'JAVASCRIPT_SMARTCODE' ) )
{
	define( 'JAVASCRIPT_SMARTCODE', true );
}

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartTopicAddMOD');

class MySmartTopicAddMOD
{
	private $SectionInfo;
	private $SectionGroup;
	private $moderator;
	
	public function run()
	{
		global $MySmartBB;
		
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
		
		$MySmartBB->func->getFooter();
	}
	
	private function _commonCode()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if ( empty( $MySmartBB->_GET['id'] ) )
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$this->SectionInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if (!$this->SectionInfo)
		{
			$MySmartBB->func->error('المعذره .. القسم المطلوب غير موجود');
		}
		
		// Kill SQL Injection
		$MySmartBB->func->cleanArray( $this->SectionInfo, 'sql' );
		
		// ... //
		
		/** Get section's group information and make some checks **/
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $this->SectionInfo['id'] . "' AND group_id='" . $MySmartBB->_CONF['group_info']['id'] . "'";
		
		// Finally get the permissions of group
		$this->SectionGroup = $MySmartBB->rec->getInfo();
		
		// The visitor can't show this section , so stop the page
		if (!$this->SectionGroup['view_section'] 
			or !$this->SectionGroup['write_subject'])
		{
			$MySmartBB->func->error('المعذره لا يمكنك الكتابه في هذا القسم');
		}
		
		if (!empty($this->SectionInfo['section_password']) 
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
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
     			$IsTruePassword = $MySmartBB->section->checkPassword( $MySmartBB->_GET['password'], $this->SectionInfo['id'] );
     			
     			// Stop ! it's don't true password															
     			if (!$IsTruePassword)
     			{
     				$MySmartBB->func->error('المعذره .. كلمة المرور غير صحيحه');
     			}
     			
     			$MySmartBB->_CONF['template']['password'] = '&amp;password=' . $MySmartBB->_GET['password'];
     		}
     	}
     	
     	// ... //
     	
     	$this->moderator = $MySmartBB->func->moderatorCheck( $MySmartBB->_GET['id'] );
     	
     	// ... //
     	
     	$MySmartBB->template->assign('section_info',$this->SectionInfo);
     	
     	// ... //
	}
		
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('اضافة موضوع');
		
		$MySmartBB->func->getEditorTools();
			     		
     	$MySmartBB->template->assign('id',$MySmartBB->_GET['id']);
     	
     	// Instead of send a whole version of $this->SectionGroup to template engine
     	// We just send options which we really need, we use this way to save memory
     	$MySmartBB->template->assign('upload_attach',$this->SectionGroup['upload_attach']);
     	
		// ... //
		
		$MySmartBB->template->assign('Admin',$this->moderator);
				
		// ... //
		
     	$MySmartBB->template->display('new_topic');
	}
	
	private function _start()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تنفيذ عملية اضافة الموضوع');
		
		$MySmartBB->_POST['title'] 	= 	trim( $MySmartBB->_POST['title'] );
		$MySmartBB->_POST['text'] 	= 	trim( $MySmartBB->_POST['text'] );
		
		$MySmartBB->func->addressBar('<a href="index.php?page=forum&amp;show=1&amp;id=' . $this->SectionInfo['id'] . $MySmartBB->_CONF['template']['password'] . '">' . $this->SectionInfo['title'] . '</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate']  . ' تنفيذ عملية كتابة موضوع');
		
		if (empty($MySmartBB->_POST['title']) 
			or empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			/*$IsFlood = $MySmartBB->subject->IsFlood(array('last_time'=>$MySmartBB->_CONF['member_row']['lastpost_time']));
			
			if ($IsFlood)
			{
				$MySmartBB->func->error('المعذره .. لا يمكنك كتابة موضوع جديد إلا بعد ' . $MySmartBB->_CONF['info_row']['floodctrl'] . ' ثانيه');
			}*/
		
     		if (isset($MySmartBB->_POST['title']{$MySmartBB->_CONF['info_row']['post_title_max']}))
     		{
       			$MySmartBB->func->error('عدد حروف عنوان الموضوع أكبر من (' . $MySmartBB->_CONF['info_row']['post_title_max'] . ')');
    		}

        	if  (!isset($MySmartBB->_POST['title']{$MySmartBB->_CONF['info_row']['post_title_min']}))
     		{
      			$MySmartBB->func->error('عدد حروف عنوان الموضوع أقل من  (' . $MySmartBB->_CONF['info_row']['post_title_min'] . ')');
     		}

       	 	if (isset($MySmartBB->_POST['text']{$MySmartBB->_CONF['info_row']['post_text_max']}))
     		{
      			$MySmartBB->func->error('عدد حروف الموضوع أكبر من (' . $MySmartBB->_CONF['info_row']['post_text_max'] . ')');
     		}

     		if (!isset($MySmartBB->_POST['text']{$MySmartBB->_CONF['info_row']['post_text_min']}))
     		{
      			$MySmartBB->func->error('عدد حروف الموضوع أصغر من (' . $MySmartBB->_CONF['info_row']['post_text_min'] . ')');
     		}
     	}
     	
     	// Hello WYSIWYG :)
     	if ($MySmartBB->_CONF['info_row']['wysiwyg_topic'])
     	{
     		$MySmartBB->_POST['text'] = $MySmartBB->func->replaceWYSIWYG($MySmartBB->_POST['text']);
     	}
     	
     	$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
    	$MySmartBB->rec->get_id = true;

     	$MySmartBB->rec->fields = array(	'title'	=>	$MySmartBB->_POST['title'],
     										'text'	=>	$MySmartBB->_POST['text'],
     										'writer'	=>	$MySmartBB->_CONF['member_row']['username'],
     										'section'	=>	$this->SectionInfo['id'],
     										'write_time'	=>	$MySmartBB->_CONF['now'],
     										'icon'	=>	$MySmartBB->_POST['icon'],
     										'subject_describe'	=>	$MySmartBB->_POST['describe'],
     										'native_write_time'	=>	$MySmartBB->_CONF['now'],
     										'sec_subject'	=>	$this->SectionInfo['sec_section'],
     										'poll_subject'	=>	0,
     										'attach_subject'	=>	0,
     										'tags_cache'	=>	$MySmartBB->_POST['tags']	);
     										
		if (($this->SectionInfo['review_subject'] or $MySmartBB->_CONF['member_row']['review_subject'])
			and !$MySmartBB->_CONF['group_info']['admincp_allow'])
		{
			$MySmartBB->rec->fields['review_subject'] = 1;
		}
		
		if ( $this->moderator )
		{
     		if ($MySmartBB->_POST['stick'])
     		{
     			$MySmartBB->rec->fields['stick'] = 1;
     		}
     	
     		if ($MySmartBB->_POST['close'])
     		{
     			$MySmartBB->rec->fields['close'] = 1;
     		}
     	}
     	
     	$Insert = $MySmartBB->rec->insert();
     				
     	if ($Insert)
     	{
     		// ... //
     		
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
     				
     				$MySmartBB->rec->table = $MySmartBB->table[ 'poll' ];
     				$MySmartBB->rec->fields = array(	'qus'	=>	$MySmartBB->_POST['question'],
     													'answers'	=>	$answers,
     													'subject_id'	=>	$MySmartBB->subject->id);
     				
     				$MySmartBB->rec->insert();
     			}
     		}
     		
     		// ... //
     		
     		// Set tags for the subject
     		$tags_size = sizeof($MySmartBB->_POST['tags']);

     		if ($tags_size > 0
     			and strlen($MySmartBB->_POST['tags'][0]) > 0)
     		{
     			foreach ($MySmartBB->_POST['tags'] as $tag)
     			{
     				$tag_id = 1;
     				
     				$MySmartBB->rec->table = $MySmartBB->table[ 'tags' ];
     				$MySmartBB->rec->filter = "tag='" . $tag . "'";
     				
     				$Tag = $MySmartBB->rec->getInfo();
     				
     				if (!$Tag)
     				{
     					$MySmartBB->rec->table = $MySmartBB->table[ 'tags' ];
     					$MySmartBB->rec->fields = array(	'tag'	=>	$tag	);
     					$MySmartBB->rec->get_id = true;
     					
     					$insert = $MySmartBB->rec->insert();
     					
     					$tag_id = $MySmartBB->rec->id;
     				}
     				else
     				{
     					$MySmartBB->rec->table = $MySmartBB->table[ 'tags' ];
     					$MySmartBB->rec->fields = array(	'number'	=>	$Tag['num'] + 1);
     					$MySmartBB->rec->filter = "id='" . $Tag['id'] . "'";
     					
     					$update = $MySmartBB->rec->update();
     					
     					$tag_id = $Tag['id'];
     				}
     				
     				$MySmartBB->rec->table = $MySmartBB->table[ 'tags' ];
     				$MySmartBB->rec->fields = array(	'tag_id'	=>	$tag_id,
     													'subject_id'	=>	$MySmartBB->subject->id,
     													'tag'	=>	$tag,
     													'subject_title'	=>	$MySmartBB->_POST['title']);
     													
     				// Note, this function is from tag system not subject system
     				$insert = $MySmartBB->rec->insert();
     			}
     		}
     		
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
     								
     								$extension = $MySmartBB->extension->getExtensionInfo();
     							
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
     											$filename = $MySmartBB->_FILES['files']['name'][$x] . '-' . $MySmartBB->func->randomCode();
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
     																				'subject_id'	=>	$MySmartBB->subject->id);
     											
     											$InsertAttach = $MySmartBB->attach->insertAttach();
     											
     											if ($InsertAttach)
     											{
     												$MySmartBB->rec->fields = array(	'attach_subject'	=>	'1'	);
     												$MySmartBB->rec->filter = "id='" . $MySmartBB->subject->id . "'";
     												
     												$update = $MySmartBB->subject->updateSubject();
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
     		
     		// ... //
     		
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
     											'user_title'	=>	(isset($usertitle)) ? $usertitle : null);
     											
   			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
   			
   			$MySmartBB->rec->update();
   			
   			// ... //
     		
     		// Update Last subject's information
     		$MySmartBB->section->updateLastSubject( $MySmartBB->_CONF['member_row']['username'], 
     												$MySmartBB->_POST['title'], 
     												$MySmartBB->rec->id, 
     												$MySmartBB->_CONF['date'], 
     												(!$this->SectionInfo['sub_section']) ? $this->SectionInfo['id'] : $this->SectionInfo['from_sub_section'] );
     		     		
     		// ... //
     		
     		// The overall number of subjects
     		$MySmartBB->cache->updateSubjectNumber( $MySmartBB->_CONF['info_row']['subject_number'] );
     		
     		// ... //
     		
     		// The number of section's subjects number
     		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
     		$MySmartBB->rec->fields = array(	'subject_num'	=>	$this->SectionInfo['subject_num'] + 1	);
     		$MySmartBB->rec->filter = "id='" . $this->SectionInfo['id'] . "'";
     		
     		$UpdateSubjectNumber = $MySmartBB->section->update();
     		
     		// ... //
     		
     		// Update section's cache
     		$MySmartBB->section->updateSectionsCache( $this->SectionInfo['parent'] );
     		
     		// ... //
     		
     		if ((!$this->SectionInfo['review_subject'] and !$MySmartBB->_CONF['member_row']['review_subject'])
     			or $MySmartBB->_CONF['group_info']['admincp_allow'])
			{
     			$MySmartBB->func->msg('تم طرح موضوعك "' . $MySmartBB->_POST['title'] . '" بنجاح , يرجى الانتظار حتى يتم نقلك إليه');
     			$MySmartBB->func->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->subject->id . $MySmartBB->_CONF['template']['password']);
     		}
     		else
     		{
     			$MySmartBB->func->msg('نشكرك لمشاركتك! مشاركتك لن تضاف حتى تتم الموافقة عليها من قبل الإدارة. سيتم الآن إعادتك الى المنتدى.');
     			$MySmartBB->func->goto('index.php?page=forum&amp;show=1&amp;id=' . $this->SectionInfo['id'] . $MySmartBB->_CONF['template']['password']);
     		}
     		
     		// ... //
     	}
	}
}

?>
