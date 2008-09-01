<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_SMARTCODE',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['SMARTCODE'] 	= 	true;
$CALL_SYSTEM['CACHE'] 		= 	true;
$CALL_SYSTEM['ICONS'] 		= 	true;
$CALL_SYSTEM['TOOLBOX'] 	= 	true;
$CALL_SYSTEM['USERTITLE'] 	= 	true;
$CALL_SYSTEM['POLL'] 		= 	true;
$CALL_SYSTEM['TAG'] 		= 	true;

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
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		//////////
		
		$SecArr 			= 	array();
		$SecArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$this->SectionInfo = $MySmartBB->section->GetSectionInfo($SecArr);
		
		if (!$this->SectionInfo)
		{
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
			//echo $this->SectionInfo['id'];
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
     		
     		$MySmartBB->functions->msg('تم طرح موضوعك "' . $MySmartBB->_POST['title'] . '" بنجاح , يرجى الانتظار حتى يتم نقلك إليه');
     		$MySmartBB->functions->goto('index.php?page=topic&amp;show=1&amp;id=' . $MySmartBB->subject->id . $MySmartBB->_CONF['template']['password']);
     		
     		//////////
     	}
	}
}

?>
