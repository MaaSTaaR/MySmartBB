<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['GROUP'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;

include('common.php');

define('CLASS_NAME','MySmartForumsMOD');
	
class MySmartForumsMOD extends _functions
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['add'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_AddMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_AddStart();
				}
			}
			elseif ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_ControlMain();
				}
			}
			elseif ($MySmartBB->_GET['edit'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_EditMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_EditStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_DelMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_DelStart();
				}
			}
			elseif ($MySmartBB->_GET['change_sort'])
			{
				$this->_ChangeSort();
			}
			elseif ($MySmartBB->_GET['groups'])
			{
				if ($MySmartBB->_GET['control_group'])
				{
					if ($MySmartBB->_GET['index'])
					{
						$this->_GroupControlMain();
					}
					if ($MySmartBB->_GET['start'])
					{
						$this->_GroupControlStart();
					}
				}
			}
			elseif ($MySmartBB->_GET['forum'])
			{
				if ($MySmartBB->_GET['index'])
				{
					$this->_ForumMain();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	function _AddMain()
	{
		global $MySmartBB;

		//////////
		
		$SecArr 						= 	array();
		$SecArr['get_from']				=	'db';
		
		$SecArr['proc'] 				= 	array();
		$SecArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		$SecArr['order']				=	array();
		$SecArr['order']['field']		=	'sort';
		$SecArr['order']['type']		=	'ASC';
		
		$SecArr['where']				=	array();
		$SecArr['where'][0]['name']		= 	'parent';
		$SecArr['where'][0]['oper']		= 	'=';
		$SecArr['where'][0]['value']	= 	'0';
		
		// Get main sections
		$cats = $MySmartBB->section->GetSectionsList($SecArr);
		
		// We will use forums_list to store list of forums which will view in main page
		$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
		
		// Loop to read the information of main sections
		foreach ($cats as $cat)
		{
			$MySmartBB->_CONF['template']['foreach']['forums_list'][$cat['id'] . '_m'] = $cat;
			
			if (!empty($cat['forums_cache']))
			{
				$forums = unserialize(base64_decode($cat['forums_cache']));
				
				foreach ($forums as $forum)
				{
					$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_f'] = $forum;
				}
			}
		}
		
		//////////
		
		$GroupArr 						= 	array();
		$GroupArr['order'] 				= 	array();
		$GroupArr['order']['field'] 	= 	'id';
		$GroupArr['order']['type'] 		= 	'ASC';
		
		$MySmartBB->_CONF['template']['while']['groups'] = $MySmartBB->group->GetGroupList($GroupArr);
		
		//////////
		
		$MySmartBB->template->display('forum_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		//////////
		
 		if (empty($MySmartBB->_POST['name'])
 			or ($MySmartBB->_POST['order_type'] == 'manual' and empty($MySmartBB->_POST['sort'])))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		elseif ($MySmartBB->_POST['use_section_picture'] == 1 
			and empty($MySmartBB->_POST['section_picture']))
		{
			$MySmartBB->functions->error('لا بد من وضع وصلة الصوره');
		}
		elseif ($MySmartBB->_POST['linksection'] == 1 
			and empty($MySmartBB->_POST['linksite']))
		{
			$MySmartBB->functions->error('لا بد من كتابة الوصله المطلوبه');
		}
		
		//////////
		
		$sort = 0;
		
		if ($MySmartBB->_POST['order_type'] == 'auto')
		{
			$SortArr = array();
			$SortArr['where'] = array('parent',$MySmartBB->_POST['parent']);
			$SortArr['order'] = array();
			$SortArr['order']['field'] = 'sort';
			$SortArr['order']['type'] = 'DESC';
			
			$SortSection = $MySmartBB->section->GetSectionInfo($SortArr);
			
			// No section
			if (!$SortSection)
			{
				$sort = 1;
			}
			// There is a section
			else
			{
				$sort = $SortSection['sort'] + 1;
			}
		}
		else
		{
			$sort = $MySmartBB->_POST['sort'];
		}
		
		//////////
		
		
		$SecArr 			= 	array();
		$SecArr['field']	=	array();
		
		$SecArr['field']['title'] 					= 	$MySmartBB->_POST['name'];
		$SecArr['field']['sort'] 					= 	$sort;
		$SecArr['field']['section_describe']		=	$MySmartBB->_POST['describe'];
		$SecArr['field']['section_password']		=	$MySmartBB->_POST['section_password'];
		$SecArr['field']['show_sig']				=	$MySmartBB->_POST['show_sig'];
		$SecArr['field']['usesmartcode_allow']		=	$MySmartBB->_POST['usesmartcode_allow'];
		$SecArr['field']['section_picture']			=	$MySmartBB->_POST['section_picture'];
		$SecArr['field']['sectionpicture_type']		=	$MySmartBB->_POST['sectionpicture_type'];
		$SecArr['field']['use_section_picture']		=	$MySmartBB->_POST['use_section_picture'];
		$SecArr['field']['linksection']				=	$MySmartBB->_POST['linksection'];
		$SecArr['field']['linksite']				=	$MySmartBB->_POST['linksite'];
		$SecArr['field']['subject_order']			=	$MySmartBB->_POST['subject_order'];
		$SecArr['field']['hide_subject']			=	$MySmartBB->_POST['hide_subject'];
		$SecArr['field']['sec_section']				=	$MySmartBB->_POST['sec_section'];
		$SecArr['field']['sig_iteration']			=	$MySmartBB->_POST['sig_iteration'];
		$SecArr['field']['parent']					=	$MySmartBB->_POST['parent'];
		$SecArr['field']['header'] 					= 	$MySmartBB->_POST['head'];
		$SecArr['field']['footer'] 					= 	$MySmartBB->_POST['foot'];
		$SecArr['get_id']							=	true;
		
		$insert = $MySmartBB->section->InsertSection($SecArr);
		
		//////////
		
		if ($insert)
		{
			//////////
			
			$GroupArr 						= 	array();
			$GroupArr['order'] 				= 	array();
			$GroupArr['order']['field'] 	= 	'id';
			$GroupArr['order']['type'] 		= 	'ASC';
			
			$groups = $MySmartBB->group->GetGroupList($GroupArr);
			
			//////////
			
			$x = 0;
			$n = sizeof($groups);
			
			while ($x < $n)
			{
				$SecArr 			= 	array();
				$SecArr['field']	=	array();
				
				$SecArr['field']['section_id'] 			= 	$MySmartBB->section->id;
				$SecArr['field']['group_id'] 			= 	$groups[$x]['id'];
				$SecArr['field']['view_section'] 		= 	$MySmartBB->_POST['groups'][$groups[$x]['id']]['view_section'];
				$SecArr['field']['download_attach'] 	= 	$groups[$x]['download_attach'];
				$SecArr['field']['write_subject'] 		= 	$MySmartBB->_POST['groups'][$groups[$x]['id']]['write_subject'];
				$SecArr['field']['write_reply'] 		= 	$MySmartBB->_POST['groups'][$groups[$x]['id']]['write_reply'];
				$SecArr['field']['upload_attach'] 		= 	$groups[$x]['upload_attach'];
				$SecArr['field']['edit_own_subject']	= 	$groups[$x]['edit_own_subject'];
				$SecArr['field']['edit_own_reply'] 		= 	$groups[$x]['edit_own_reply'];
				$SecArr['field']['del_own_subject'] 	= 	$groups[$x]['del_own_subject'];
				$SecArr['field']['del_own_reply'] 		= 	$groups[$x]['del_own_reply'];
				$SecArr['field']['write_poll'] 			= 	$groups[$x]['write_poll'];
				$SecArr['field']['vote_poll'] 			= 	$groups[$x]['vote_poll'];
				$SecArr['field']['main_section'] 		= 	0;
				$SecArr['field']['group_name'] 			= 	$groups[$x]['title'];
				
				$insert = $MySmartBB->group->InsertSectionGroup($SecArr);
				
				$x += 1;
			}
			
			//////////
			
			$cache = $MySmartBB->section->UpdateSectionsCache(array('parent'=>$MySmartBB->_POST['parent']));
			
			//////////
				
			if ($cache)
			{
				$MySmartBB->functions->msg('تم اضافة المنتدى بنجاح !');
				$MySmartBB->functions->goto('admin.php?page=forums&amp;control=1&amp;main=1');
			}
			else
			{
				$MySmartBB->functions->error('هناك مشكله، لا يمكنه تحديث المعلومات المخبأه');
			}
		}
		else
		{
			$MySmartBB->functions->error('هناك مشكله، لم يتمكن من اضافة القسم');
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;
		
		//////////
		
		$SecArr 						= 	array();
		$SecArr['get_from']				=	'db';
		
		$SecArr['proc'] 				= 	array();
		$SecArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		$SecArr['order']				=	array();
		$SecArr['order']['field']		=	'sort';
		$SecArr['order']['type']		=	'ASC';
		
		$SecArr['where']				=	array();
		$SecArr['where'][0]['name']		= 	'parent';
		$SecArr['where'][0]['oper']		= 	'=';
		$SecArr['where'][0]['value']	= 	'0';
		
		// Get main sections
		$cats = $MySmartBB->section->GetSectionsList($SecArr);
		
		// We will use forums_list to store list of forums which will view in main page
		$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
		
		// Loop to read the information of main sections
		foreach ($cats as $cat)
		{
			$MySmartBB->_CONF['template']['foreach']['forums_list'][$cat['id'] . '_m'] = $cat;
			
			if (!empty($cat['forums_cache']))
			{
				$forums = unserialize(base64_decode($cat['forums_cache']));
				
				foreach ($forums as $forum)
				{
					$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_f'] = $forum;
				}
			}
		}
		
		//////////
		
		$MySmartBB->template->display('forums_main');
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		//////////
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		//////////
		
		$SecArr 						= 	array();
		$SecArr['get_from']				=	'db';
		
		$SecArr['proc'] 				= 	array();
		$SecArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		$SecArr['order']				=	array();
		$SecArr['order']['field']		=	'sort';
		$SecArr['order']['type']		=	'ASC';
		
		$SecArr['where']				=	array();
		$SecArr['where'][0]['name']		= 	'parent';
		$SecArr['where'][0]['oper']		= 	'=';
		$SecArr['where'][0]['value']	= 	'0';
		
		// Get main sections
		$cats = $MySmartBB->section->GetSectionsList($SecArr);
		
		// We will use forums_list to store list of forums which will view in main page
		$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
		
		// Loop to read the information of main sections
		foreach ($cats as $cat)
		{
			$MySmartBB->_CONF['template']['foreach']['forums_list'][$cat['id'] . '_m'] = $cat;
			
			if (!empty($cat['forums_cache']))
			{
				$forums = unserialize(base64_decode($cat['forums_cache']));
				
				foreach ($forums as $forum)
				{
					if ($forum['id'] != $MySmartBB->_CONF['template']['Inf']['id'])
					{
						$MySmartBB->_CONF['template']['foreach']['forums_list'][$forum['id'] . '_f'] = $forum;
					}
				}
			}
		}
		
		//////////
		
		$MySmartBB->template->display('forum_edit');
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		//////////
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		//////////
		
 		if (empty($MySmartBB->_POST['name']) 
 			or empty($MySmartBB->_POST['sort']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		//////////
		
		// Check if the user change the parent or not
		$new_parent 	= 	false;
		$old_parent		=	0;
		
		if ($MySmartBB->_CONF['template']['Inf']['parent'] != $MySmartBB->_POST['parent'])
		{
			$new_parent		= 	true;
			$old_parent		=	$MySmartBB->_CONF['template']['Inf']['id'];
		}
		
		//////////
		
		$SecArr 			= 	array();
		$SecArr['field']	=	array();
		
		$SecArr['field']['title'] 					= 	$MySmartBB->_POST['name'];
		$SecArr['field']['sort'] 					= 	$MySmartBB->_POST['sort'];
		$SecArr['field']['section_describe']		=	$MySmartBB->_POST['describe'];
		$SecArr['field']['section_password']		=	$MySmartBB->_POST['section_password'];
		$SecArr['field']['show_sig']				=	$MySmartBB->_POST['show_sig'];
		$SecArr['field']['usesmartcode_allow']		=	$MySmartBB->_POST['usesmartcode_allow'];
		$SecArr['field']['section_picture']			=	$MySmartBB->_POST['section_picture'];
		$SecArr['field']['sectionpicture_type']		=	$MySmartBB->_POST['sectionpicture_type'];
		$SecArr['field']['use_section_picture']		=	$MySmartBB->_POST['use_section_picture'];
		$SecArr['field']['linksection']				=	$MySmartBB->_POST['linksection'];
		$SecArr['field']['linksite']				=	$MySmartBB->_POST['linksite'];
		$SecArr['field']['subject_order']			=	$MySmartBB->_POST['subject_order'];
		$SecArr['field']['hide_subject']			=	$MySmartBB->_POST['hide_subject'];
		$SecArr['field']['sec_section']				=	$MySmartBB->_POST['sec_section'];
		$SecArr['field']['header'] 					= 	$MySmartBB->_POST['head'];
		$SecArr['field']['footer'] 					= 	$MySmartBB->_POST['foot'];
		$SecArr['field']['sig_iteration']			=	$MySmartBB->_POST['sig_iteration'];
		$SecArr['field']['parent']					=	$MySmartBB->_POST['parent'];
		$SecArr['where']							= 	array('id',$MySmartBB->_CONF['template']['Inf']['id']);
		
		$update = $MySmartBB->section->UpdateSection($SecArr);
		
		if ($update)
		{
			$cache = $MySmartBB->section->UpdateSectionsCache(array('parent'=>$MySmartBB->_POST['parent']));
			
			// There is a new main section
			if ($new_parent)
			{
				$cache = $MySmartBB->section->UpdateSectionsCache(array('parent'=>$old_parent));
			}
			
			if ($cache)
			{
				$MySmartBB->functions->msg('تم تحديث القسم بنجاح !');
				$MySmartBB->functions->goto('admin.php?page=forums&amp;control=1&amp;main=1');
			}
			else
			{
				$MySmartBB->functions->error('هناك مشكله، لم يتم التحديث');
			}
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$SecArr 					= 	array();
		$SecArr['get_from']			=	'db';
		$SecArr['proc'] 			= 	array();
		$SecArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		$SecArr['order']			=	array();
		$SecArr['order']['field']	=	'sort';
		$SecArr['order']['type']	=	'ASC';
		
		$SecArr['where']			=	array();
		$SecArr['where'][0]			=	array('name'=>'parent','oper'=>'<>','value'=>'0');
		$SecArr['where'][1]			=	array('con'=>'AND','name'=>'id','oper'=>'<>','value'=>$MySmartBB->_CONF['template']['Inf']['id']);
		
		$MySmartBB->_CONF['template']['while']['SecList'] = $MySmartBB->section->GetSectionsList($SecArr);
		
		$MySmartBB->template->display('forum_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		if ($MySmartBB->_POST['choose'] == 'move')
		{
			$DelArr 			= 	array();
			$DelArr['where'] 	= 	array('id',$MySmartBB->_CONF['template']['Inf']['id']);
			
			$del = $MySmartBB->section->DeleteSection($DelArr);
			
			if ($del)
			{
				$MySmartBB->functions->msg('تم حذف المنتدى بنجاح !');
				
				$move = $MySmartBB->subject->MassMoveSubject(array('to'=>$MySmartBB->_POST['to'],'from'=>$MySmartBB->_CONF['template']['Inf']['id']));
				
				if ($move)
				{
					$MySmartBB->functions->msg('تم نقل المواضيع بنجاح');
					
					//////////
					
					$NumberArr 				= 	array();
					$NumberArr['get_from']	=	'db';
					$NumberArr['where'] 	= 	array('section_id',$MySmartBB->_CONF['template']['Inf']['id']);
					
					$FromSubjectNumber = $MySmartBB->subject->GetSubjectNumber($NumberArr);
					
					unset($NumberArr);
					
					//////////
					
					$NumberArr 				= 	array();
					$NumberArr['get_from']	=	'db';
					$NumberArr['where'] 	= 	array('section_id',$MySmartBB->_POST['to']);
					
					$ToSubjectNumber = $MySmartBB->subject->GetSubjectNumber($NumberArr);
					
					//////////
					
		     		$UpdateArr 					= 	array();
     				$UpdateArr['field']			=	array();
     		
     				$UpdateArr['field']['subject_num'] 	= 	$FromSubjectNumber + $ToSubjectNumber;
     				$UpdateArr['where']					= 	array('id',$MySmartBB->_POST['to']);
     		
		     		$update = $MySmartBB->section->UpdateSection($UpdateArr);
     				
     				if ($update)
     				{
						$cache = $MySmartBB->section->UpdateSectionsCache(array('parent'=>$MySmartBB->_CONF['template']['Inf']['parent']));
					
						if ($cache)
						{
							$MySmartBB->functions->msg('تم تحديث المعلومات بنجاح !');
							
							$DelArr 						= 	array();
							$DelArr['where']				=	array();
							$DelArr['where'][0]				=	array();
							$DelArr['where'][0]['name']		=	'section_id';
							$DelArr['where'][0]['oper']		=	'=';
							$DelArr['where'][0]['value']	=	$MySmartBB->_CONF['template']['Inf']['id'];
			
							$del = $MySmartBB->group->DeleteSectionGroup($DelArr);
							
							if ($del)
							{
								$MySmartBB->functions->msg('تم حذف صلاحيات المجموعات بنجاح');
								$MySmartBB->functions->goto('admin.php?page=forums&amp;control=1&amp;main=1');
							}
						}
					}
				}
			}
		}
		elseif ($MySmartBB->_POST['choose'] == 'del')
		{
			$DelArr 			= 	array();
			$DelArr['where'] 	= 	array('id',$MySmartBB->_CONF['template']['Inf']['id']);
			
			$del = $MySmartBB->section->DeleteSection($DelArr);
				
			if ($del)
			{
				$MySmartBB->functions->msg('تم حذف المنتدى بنجاح !');
				
				$DelArr 						= 	array();
				$DelArr['where']				=	array();
				$DelArr['where'][0]				=	array();
				$DelArr['where'][0]['name']		=	'section';
				$DelArr['where'][0]['oper']		=	'=';
				$DelArr['where'][0]['value']	=	$MySmartBB->_CONF['template']['Inf']['id'];
								
				$del = $MySmartBB->subject->DeleteSubject($DelArr);
				
				if ($del)
				{
					$MySmartBB->functions->msg('تم حذف المواضيع بنجاح');
					
					$cache = $MySmartBB->section->UpdateSectionsCache(array('parent'=>$MySmartBB->_CONF['template']['Inf']['parent']));
					
					if ($cache)
					{
						$MySmartBB->functions->msg('تم تحديث المعلومات بنجاح !');
						
						$DelArr 						= 	array();
						$DelArr['where']				=	array();
						$DelArr['where'][0]				=	array();
						$DelArr['where'][0]['name']		=	'section_id';
						$DelArr['where'][0]['oper']		=	'=';
						$DelArr['where'][0]['value']	=	$MySmartBB->_CONF['template']['Inf']['id'];
				
						$del = $MySmartBB->group->DeleteSectionGroup($DelArr);
						
						if ($del)
						{
							$MySmartBB->functions->msg('تم حذف صلاحيات المجموعات بنجاح');
							$MySmartBB->functions->goto('admin.php?page=forums&amp;control=1&amp;main=1');
						}
					}
				}
			}
		}
		else
		{
			$MySmartBB->functions->error('الاختيار غير صحيح!');
		}
	}
	
	function _ChangeSort()
	{
		global $MySmartBB;
		
 		$SecArr 					= 	array();
		$SecArr['get_from']			=	'db';
		$SecArr['proc'] 			= 	array();
		$SecArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		$SecArr['order']			=	array();
		$SecArr['order']['field']	=	'sort';
		$SecArr['order']['type']	=	'ASC';
		
		$SecArr['where']				=	array();
		$SecArr['where'][0]				=	array();
		$SecArr['where'][0]['name']		=	'parent';
		$SecArr['where'][0]['oper']		=	'<>';
		$SecArr['where'][0]['value']	=	'0';
		
		$SecList = $MySmartBB->section->GetSectionsList($SecArr);
		
		$x = 0;
		$y = sizeof($SecList);
		$s = array();
		
		while ($x < $y)
		{
			$name = 'order-' . $SecList[$x]['id'];
			
			if ($SecList[$x]['order'] != $MySmartBB->_POST[$name])
			{
				$UpdateArr 						= 	array();
				
				$UpdateArr['field']		 		= 	array();
				$UpdateArr['field']['sort'] 	= 	$MySmartBB->_POST[$name];
				
				$UpdateArr['where'] 			=	array('id',$SecList[$x]['id']);
				
				$update = $MySmartBB->section->UpdateSection($UpdateArr);
				
				if ($update)
				{
					$cache = $MySmartBB->section->UpdateSectionsCache(array('parent'=>$SecList[$x]['parent']));
				}
				
				$s[$SecList[$x]['id']] = ($update) ? 'true' : 'false';
			}

			$x += 1;
		}
		
		if (in_array('false',$s))
		{
			$MySmartBB->functions->error('المعذره، لم تنجح العمليه');
		}
		else
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح!');
			$MySmartBB->functions->goto('admin.php?page=forums&amp;control=1&amp;main=1');
		}
	}
	
	function _GroupControlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$SecGroupArr 						= 	array();
		$SecGroupArr['where'] 				= 	array();
		
		$SecGroupArr['where'][0]			=	array();
		$SecGroupArr['where'][0]['name'] 	= 	'section_id';
		$SecGroupArr['where'][0]['oper']	=	'=';
		$SecGroupArr['where'][0]['value'] 	= 	$MySmartBB->_CONF['template']['Inf']['id'];
		
		$SecGroupArr['where'][1]			=	array();
		$SecGroupArr['where'][1]['con']		=	'AND';
		$SecGroupArr['where'][1]['name']	=	'main_section';
		$SecGroupArr['where'][1]['oper']	=	'<>';
		$SecGroupArr['where'][1]['value']	=	'1';
		
		$MySmartBB->_CONF['template']['while']['SecGroupList'] = $MySmartBB->group->GetSectionGroupList($SecGroupArr);
		
		$MySmartBB->template->display('forums_groups_control_main');
	}
		
	function _GroupControlStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);

		$MySmartBB->functions->CleanVariable($MySmartBB->_GET['group_id'],'intval');
		
		$success 	= 	array();
		$fail		=	array();
		$size		=	sizeof($MySmartBB->_POST['groups']);
		
		foreach ($MySmartBB->_POST['groups'] as $id => $val)
		{
			$UpdateArr 				= 	array();
			$UpdateArr['field']		=	array();
			
			$UpdateArr['field']['view_section'] 		= 	$val['view_section'];
			$UpdateArr['field']['download_attach'] 		= 	$val['download_attach'];
			$UpdateArr['field']['write_subject'] 		= 	$val['write_subject'];
			$UpdateArr['field']['write_reply'] 			= 	$val['write_reply'];
			$UpdateArr['field']['upload_attach'] 		= 	$val['upload_attach'];
			$UpdateArr['field']['edit_own_subject'] 	= 	$val['edit_own_subject'];
			$UpdateArr['field']['edit_own_reply'] 		= 	$val['edit_own_reply'];
			$UpdateArr['field']['del_own_subject'] 		= 	$val['del_own_subject'];
			$UpdateArr['field']['del_own_reply'] 		= 	$val['del_own_reply'];
			$UpdateArr['field']['write_poll'] 			= 	$val['write_poll'];
			$UpdateArr['field']['vote_poll'] 			= 	$val['vote_poll'];
			$UpdateArr['where'][0] 						= 	array('name'=>'group_id','oper'=>'=','value'=>$id);
			$UpdateArr['where'][1] 						= 	array('con'=>'AND','name'=>'section_id','oper'=>'=','value'=>$MySmartBB->_CONF['template']['Inf']['id']);
			
			$update = $MySmartBB->group->UpdateSectionGroup($UpdateArr);
			
			unset($UpdateArr);
			
			if ($update)
			{
				$success[] = $id;
			}
			else
			{
				$fail[] = $id;
			}
			
			unset($update);
		}
		
		$success_size 	= 	sizeof($success);
		$fail_size		=	sizeof($fail);
		
		if ($success_size == $size)
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح!');
			
			$UpdateArr 			= 	array();
			$UpdateArr['id'] 	= 	$MySmartBB->_CONF['template']['Inf']['id'];
			
			$cache = $MySmartBB->group->UpdateSectionGroupCache($UpdateArr);
			
			if ($cache)
			{
				$MySmartBB->functions->msg('تم تحديث المعلومات المخبأه');
				
				$UpdateArr 				= 	array();
				$UpdateArr['parent'] 	= 	$MySmartBB->_CONF['template']['Inf']['parent'];
			
				$cache = $MySmartBB->section->UpdateSectionsCache($UpdateArr);
				
				if ($cache)
				{
					$MySmartBB->functions->msg('تمّت الخطوه النهائيه');
					$MySmartBB->functions->goto('admin.php?page=forums&amp;groups=1&amp;control_group=1&amp;index=1&amp;id=' . $MySmartBB->_CONF['template']['Inf']['id']);
				}
			}
		}
	}
	
	function _ForumMain()
	{
		global $MySmartBB;
		
		//////////
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		//////////
		
		if (!empty($MySmartBB->_CONF['template']['Inf']['forums_cache']))
		{
			$MySmartBB->_CONF['template']['foreach']['forums_list'] = unserialize(base64_decode($MySmartBB->_CONF['template']['Inf']['forums_cache']));
		
			$size = sizeof($MySmartBB->_CONF['template']['foreach']['forums_list']);
		
			// No information!
			if ($size <= 0)
			{
				$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
			}
		}
		else
		{
			$MySmartBB->_CONF['template']['foreach']['forums_list'] = array();
		}
		
		//////////
		
		$MySmartBB->template->display('forums_forum_main');
	}
}

class _functions
{
	function check_by_id(&$Inf)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$SecArr 			= 	array();
		$SecArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$Inf = $MySmartBB->section->GetSectionInfo($SecArr);
		
		if ($Inf == false)
		{
			$MySmartBB->functions->error('القسم المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($Inf,'html');
	}
}

?>
