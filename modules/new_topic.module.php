<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

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
	private $subject_id;
	
	public function run()
	{
		global $MySmartBB;
		
		$MySmartBB->load( 'cache,moderator,section,subject,icon,toolbox,poll,tag,attach' );
		
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
     	$this->subject_id = $MySmartBB->rec->id;
     				
     	if ($Insert)
     	{
     		// ... //
     		
     		if ($MySmartBB->_POST['poll'])
     		{
     			if (isset($MySmartBB->_POST['question'])
     				and isset($MySmartBB->_POST['answers'][0])
     				and isset($MySmartBB->_POST['answers'][1]))
     			{
     				$MySmartBB->poll->insertPoll( $MySmartBB->_POST['question'], $MySmartBB->_POST['answers'], $this->subject_id, true );
     			}
     		}
     		
     		// ... //
     		
     		// Set tags for the subject
     		$tags_size = sizeof($MySmartBB->_POST['tags']);

     		if ($tags_size > 0
     			and strlen($MySmartBB->_POST['tags'][0]) > 0)
     		{
     			$MySmartBB->tag->taggingSubject( $MySmartBB->_POST['tags'], $this->subject_id, $MySmartBB->_POST[ 'title' ] );
     		}
     		
     		// ... //
     		
     		// Upload files
     		if ( $MySmartBB->_POST[ 'attach' ] )
     		{
     			if ( $this->SectionGroup[ 'upload_attach' ] )
     			{
     				$files_number 	= 	sizeof($MySmartBB->_FILES['files']['name']);
     				
     				if ($files_number > 0)
     				{     					
     					if ($files_number > $this->SectionGroup['upload_attach_num']
     						and !$MySmartBB->_CONF['group_info']['admincp_allow'])
     					{
     						$MySmartBB->func->error('المعذره لا يمكنك رفع اكثر من ' . $this->SectionGroup['upload_attach_num'] . 'ملف');
     					}
     					
     					$succ = array();
     					$fail = array();
     					
     					$MySmartBB->attach->addAttach( $MySmartBB->_FILES[ 'files' ], $this->subject_id, true, $succ, $fail  );
     					
     					unset( $MySmartBB->_FILES[ 'files' ] );
     				}
     			}
     		}
     		
     		// ... //
     		
     		if ( !$this->SectionGroup[ 'no_posts' ] )
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
     		
     			if ( $UserTitle != false )
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
     		
     		$UpdateSubjectNumber = $MySmartBB->rec->update();
     		
     		// ... //
     		
     		// Update section's cache
     		$MySmartBB->section->updateSectionsCache( $this->SectionInfo['parent'] );
     		
     		// ... //
     		
			$MySmartBB->func->msg('تم طرح موضوعك "' . $MySmartBB->_POST['title'] . '" بنجاح , يرجى الانتظار حتى يتم نقلك إليه');
			$MySmartBB->func->move('index.php?page=topic&amp;show=1&amp;id=' . $this->subject_id . $MySmartBB->_CONF['template']['password']);
     		
     		// ... //
     	}
	}
}

?>
