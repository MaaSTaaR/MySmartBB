<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['GROUP'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;

include('common.php');
	
define('CLASS_NAME','MySmartSectionMOD');
	
class MySmartSectionMOD extends _functions
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
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_GroupControlStart();
					}
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	function _AddMain()
	{
		global $MySmartBB;
		
		//////////
		
		$GroupArr 						= 	array();
		$GroupArr['order'] 				= 	array();
		$GroupArr['order']['field'] 	= 	'id';
		$GroupArr['order']['type'] 		= 	'ASC';
		$GroupArr['proc'] 				= 	array();
		$GroupArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['groups'] = $MySmartBB->group->GetGroupList($GroupArr);
		
		//////////

		$MySmartBB->template->display('sections_add');		
	}
	
	function _AddStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']) 
			or ($MySmartBB->_POST['order_type'] == 'manual' and empty($MySmartBB->_POST['sort'])))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		//////////
		
		$sort = 0;
		
		if ($MySmartBB->_POST['order_type'] == 'auto')
		{
			$SortArr = array();
			$SortArr['where'] = array('parent','0');
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
		
		$SecArr['field']['title'] 		= 	$MySmartBB->_POST['name'];
		$SecArr['field']['sort'] 		= 	$sort;
		$SecArr['field']['parent'] 		= 	'0';
		$SecArr['get_id']				=	true;
		
		$insert = $MySmartBB->section->InsertSection($SecArr);
		
		if ($insert)
		{
			$GroupArr 						= 	array();
			$GroupArr['order'] 				= 	array();
			$GroupArr['order']['field'] 	= 	'id';
			$GroupArr['order']['type'] 		= 	'ASC';
			
			$groups = $MySmartBB->group->GetGroupList($GroupArr);
			
			$x = 0;
			$n = sizeof($groups);
			
			while ($x < $n)
			{
				$SecArr 				= 	array();
				$SecArr['field']		=	array();
				
				$SecArr['field']['section_id'] 			= 	$MySmartBB->section->id;
				$SecArr['field']['group_id'] 			= 	$groups[$x]['id'];
				$SecArr['field']['view_section'] 		= 	$MySmartBB->_POST['groups'][$groups[$x]['id']]['view_section'];
				$SecArr['field']['download_attach'] 	= 	$groups[$x]['download_attach'];
				$SecArr['field']['write_subject'] 		= 	$groups[$x]['write_subject'];
				$SecArr['field']['write_reply'] 		= 	$groups[$x]['write_reply'];
				$SecArr['field']['upload_attach'] 		= 	$groups[$x]['upload_attach'];
				$SecArr['field']['edit_own_subject'] 	= 	$groups[$x]['edit_own_subject'];
				$SecArr['field']['edit_own_reply'] 		= 	$groups[$x]['edit_own_reply'];
				$SecArr['field']['del_own_subject'] 	= 	$groups[$x]['del_own_subject'];
				$SecArr['field']['del_own_reply'] 		= 	$groups[$x]['del_own_reply'];
				$SecArr['field']['write_poll'] 			= 	$groups[$x]['write_poll'];
				$SecArr['field']['vote_poll'] 			= 	$groups[$x]['vote_poll'];
				$SecArr['field']['main_section'] 		= 	1;
				$SecArr['field']['group_name'] 			= 	$groups[$x]['title'];
				
				$insert = $MySmartBB->group->InsertSectionGroup($SecArr);
				
				$x += 1;
			}
			
			$CacheArr 			= 	array();
			$CacheArr['id'] 	= 	$MySmartBB->section->id;
			
			$cache = $MySmartBB->group->UpdateSectionGroupCache($CacheArr);
			
			if ($cache)
			{
				$MySmartBB->functions->msg('تم اضافة القسم بنجاح !');
				$MySmartBB->functions->goto('admin.php?page=sections&amp;control=1&amp;main=1');
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
		
		$MySmartBB->_CONF['template']['while']['SecList'] = $MySmartBB->section->GetSectionsList($SecArr);
		
		//////////
		
		$MySmartBB->template->display('sections_main');

		//////////
	}
	
	function _EditMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('section_edit');
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		//////////
		
		$this->check_by_id($Inf);
		
		//////////
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['sort']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		//////////
		
		$SecArr 			= 	array();
		$SecArr['field']	=	array();
		
		$SecArr['field']['title'] 	= 	$MySmartBB->_POST['name'];
		$SecArr['field']['sort'] 	= 	$MySmartBB->_POST['sort'];
		$SecArr['where']			= 	array('id',$Inf['id']);
				
		$update = $MySmartBB->section->UpdateSection($SecArr);
		
		//////////
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث القسم بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=sections&amp;control=1&amp;main=1');
		}
		
		//////////
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		//////////
		
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
		
		$SecArr['where']				=	array();
		$SecArr['where'][0]['con']		= 	'AND';
		$SecArr['where'][0]['name']		= 	'id';
		$SecArr['where'][0]['oper']		= 	'<>';
		$SecArr['where'][0]['value']	= 	$MySmartBB->_CONF['template']['Inf']['id'];
		
		$MySmartBB->_CONF['template']['while']['SecList'] = $MySmartBB->section->GetSectionsList($SecArr);
		
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
		$SecArr['where'][0]['oper']		= 	'<>';
		$SecArr['where'][0]['value']	= 	'0';
		
		$MySmartBB->_CONF['template']['while']['ForumsList'] = $MySmartBB->section->GetSectionsList($SecArr);
		
		//////////
		
		$MySmartBB->template->display('section_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		//////////
		
		$this->check_by_id($Inf);
		
		//////////
				
		if ($MySmartBB->_POST['choose'] == 'move')
		{
			//////////
			
			if (empty($MySmartBB->_POST['to']))
			{
				$MySmartBB->functions->error('يوجد خطأ، لا يمكن إكمال العمليه! لم يتم اختيار القسم');
			}
			
			//////////
			
			// Move normal sections to another main section
			$UpdateArr 				= 	array();
			$UpdateArr['field']		=	array();
			
			$UpdateArr['field']['parent'] 	= 	$MySmartBB->_POST['to'];			
			$UpdateArr['where']				=	array('parent',$Inf['id']);
			
			$update = $MySmartBB->section->UpdateSection($UpdateArr);
			
			//////////
			
			if ($update)
			{
				//////////
				
				$MySmartBB->functions->msg('تم نقل المنتديات بنجاح');
				
				$del = $MySmartBB->section->DeleteSection(array('id'=>$Inf['id']));
				
				//////////
				
				if ($del)
				{
					//////////
					
					$MySmartBB->functions->msg('تم حذف القسم بنجاح !');
					
					//////////
					
					$DelArr 						= 	array();
					$DelArr['where']				=	array();
					$DelArr['where'][0]				=	array();
					$DelArr['where'][0]['name']		=	'section_id';
					$DelArr['where'][0]['oper']		=	'=';
					$DelArr['where'][0]['value']	=	$Inf['id'];
					
					$DelArr['where'][0]				=	array();
					$DelArr['where'][0]['con']		=	'AND';
					$DelArr['where'][0]['name']		=	'main_section';
					$DelArr['where'][0]['oper']		=	'=';
					$DelArr['where'][0]['value']	=	'1';
		
					$del = $MySmartBB->section->DeleteSectionGroup($DelArr);
					
					//////////
					
					if ($del)
					{
						$MySmartBB->functions->msg('تم حذف صلاحيات المجموعات بنجاح');						
						$MySmartBB->functions->goto('admin.php?page=sections&amp;control=1&amp;main=1');
					}
					
					//////////					
				}
			}
		}
		elseif ($MySmartBB->_POST['choose'] == 'del')
		{
			$SecArr 						= 	array();
			$SecArr['get_from']				=	'db';

			$SecArr['where']				=	array();
			$SecArr['where'][0]				=	array();
			$SecArr['where'][0]['name']		=	'parent';
			$SecArr['where'][0]['oper']		=	'=';
			$SecArr['where'][0]['value']	=	$Inf['id'];
			
			$SecArr['order']				=	array();
			$SecArr['order']['field']		=	'sort';
			$SecArr['order']['type']		=	'ASC';
		
			$SecList = $MySmartBB->section->GetSectionsList($SecArr);
		
			$x = 0;
			$y = sizeof($SecList);
			$s = array();
		
			while ($x < $y)
			{
			
				$DelArr 						= 	array();
				$DelArr['where']				=	array();
				$DelArr['where'][0]				=	array();
				$DelArr['where'][0]['name']		=	'section_id';
				$DelArr['where'][0]['oper']		=	'=';
				$DelArr['where'][0]['value']	=	$SecList[$x]['id'];
				
				$DelArr['where'][0]				=	array();
				$DelArr['where'][0]['con']		=	'AND';
				$DelArr['where'][0]['name']		=	'main_section';
				$DelArr['where'][0]['oper']		=	'<>';
				$DelArr['where'][0]['value']	=	'1';
						
				$del = $MySmartBB->section->DeleteSectionGroup($DelArr);
				
				$s[$x] = ($del) ? 'true' : 'false';
				
				$DelSubjectArr 						= 	array();
				$DelSubjectArr['where']				=	array();
				$DelSubjectArr['where'][0]			=	array();
				$DelSubjectArr['where'][0]['name']	=	'section_id';
				$DelSubjectArr['where'][0]['oper']	=	'=';
				$DelSubjectArr['where'][0]['value']	=	$SecList[$x]['id'];
				
				$del = $MySmartBB->section->DeleteSubject($DelSubjectArr);
				
				$s[$x] = ($del) ? 'true' : 'false';
			}
			
			if (in_array('false',$s))
			{
				$MySmartBB->functions->msg('خطأ، لم تتم عملية حذف صلاحيات المجموعات و المواضيع بنجاح !');
			}
			else
			{
				$MySmartBB->functions->msg('تم حذف صلاحيات المجموعات للمنتديات');
			}
			
			$DelSectionArr 						= 	array();
			$DelSectionArr['where']				=	array();
			$DelSectionArr['where'][0]			=	array();
			$DelSectionArr['where'][0]['name']	=	'parent';
			$DelSectionArr['where'][0]['oper']	=	'=';
			$DelSectionArr['where'][0]['value']	=	$Inf['id'];
				
			$del = $MySmartBB->section->DeleteSection($DelSectionArr);
			
			if ($del)
			{
				$MySmartBB->functions->msg('تم حذف المنتديات بنجاح');
				
				$del = $MySmartBB->section->DeleteSection(array('id'=>$Inf['id']));
				
				if ($del)
				{
					$MySmartBB->functions->msg('تم حذف القسم بنجاح !');
					
					$DelSecGroupArr 						= 	array();
					$DelSecGroupArr['where']				=	array();
					$DelSecGroupArr['where'][0]				=	array();
					$DelSecGroupArr['where'][0]['name']		=	'section_id';
					$DelSecGroupArr['where'][0]['oper']		=	'=';
					$DelSecGroupArr['where'][0]['value']	=	$Inf['id'];
				
					$DelSecGroupArr['where'][1]				=	array();
					$DelSecGroupArr['where'][1]['con']		=	'AND';
					$DelSecGroupArr['where'][1]['name']		=	'main_section';
					$DelSecGroupArr['where'][1]['oper']		=	'=';
					$DelSecGroupArr['where'][1]['value']	=	'1';
					
					$del = $MySmartBB->group->DeleteSectionGroup($DelSecGroupArr);
					
					if ($del)
					{
						$MySmartBB->functions->msg('تم حذف صلاحيات المجموعات بنجاح');
						
						$cache = $MySmartBB->group->UpdateSectionGroupCache();
						
						if ($cache)
						{
							$MySmartBB->functions->msg('تمت الخطوه النهائيه بنجاح');
							$MySmartBB->functions->goto('admin.php?page=sections&amp;control=1&amp;main=1');
						}
					}
				}
			}
		}
		elseif ($MySmartBB->_POST['choose'] == 'move_subjects')
		{
			$SecArr 						= 	array();
			$SecArr['get_from']				=	'db';
		
			$SecArr['order']				=	array();
			$SecArr['order']['field']		=	'sort';
			$SecArr['order']['type']		=	'ASC';
			
			$SecArr['where']				=	array();
			$SecArr['where'][0]				=	array();
			$SecArr['where'][0]['name']		=	'parent';
			$SecArr['where'][0]['oper']		=	'=';
			$SecArr['where'][0]['value']	=	$Inf['id'];
		
			$SecList = $MySmartBB->section->GetSectionsList($SecArr);
		
			$x = 0;
			$y = sizeof($SecList);
			$s = array();
		
			while ($x < $y)
			{
				$DelArr 						= 	array();
				
				$DelArr['where']				=	array();
				$DelArr['where'][0]				=	array();
				$DelArr['where'][0]['name']		=	'section_id';
				$DelArr['where'][0]['oper']		=	'=';
				$DelArr['where'][0]['value']	=	$SecList[$x]['id'];
		
				$del = $MySmartBB->section->DeleteSectionGroup($DelArr);
				
				$s[$x] = ($del) ? 'true' : 'false';
				
				$move = $MySmartBB->subject->MassMoveSubject(array('to'=>$MySmartBB->_POST['subject_to'],'from'=>$SecList[$x]['id']));
				
				$s[$x] = ($del) ? 'true' : 'false';
			}
			
			if (in_array('false',$s))
			{
				$MySmartBB->functions->msg('خطأ، لم تتم عملية حذف صلاحيات المجموعات بنجاح !');
			}
			else
			{
				$MySmartBB->functions->msg('تم حذف صلاحيات المجموعات للمنتديات');
			}
			
			$DelArr 						= 	array();
			
			$DelArr['where']				=	array();
			$DelArr['where'][0]				=	array();
			$DelArr['where'][0]['name']		=	'parent';
			$DelArr['where'][0]['oper']		=	'=';
			$DelArr['where'][0]['value']	=	$Inf['id'];
				
			$del = $MySmartBB->section->DeleteSection($DelArr);
			
			if ($del)
			{
				$MySmartBB->functions->msg('تم حذف المنتديات بنجاح');
				
				$DelArr 						= 	array();
			
				$DelArr['where']				=	array();
				$DelArr['where'][0]				=	array();
				$DelArr['where'][0]['name']		=	'id';
				$DelArr['where'][0]['oper']		=	'=';
				$DelArr['where'][0]['value']	=	$Inf['id'];
			
				$del = $MySmartBB->section->DeleteSection($DelArr);
				
				if ($del)
				{
					$MySmartBB->functions->msg('تم حذف القسم بنجاح !');
							
					$DelSecGroupArr 						= 	array();
					$DelSecGroupArr['where']				=	array();
					$DelSecGroupArr['where'][0]				=	array();
					$DelSecGroupArr['where'][0]['name']		=	'section_id';
					$DelSecGroupArr['where'][0]['oper']		=	'=';
					$DelSecGroupArr['where'][0]['value']	=	$Inf['id'];
				
					$DelSecGroupArr['where'][1]				=	array();
					$DelSecGroupArr['where'][1]['con']		=	'AND';
					$DelSecGroupArr['where'][1]['name']		=	'main_section';
					$DelSecGroupArr['where'][1]['oper']		=	'=';
					$DelSecGroupArr['where'][1]['value']	=	'1';
					
					$del = $MySmartBB->group->DeleteSectionGroup($DelSecGroupArr);
						
					if ($del)
					{
						$MySmartBB->functions->msg('تم حذف صلاحيات المجموعات بنجاح');
						
						$cache = $MySmartBB->group->UpdateSectionGroupCache();
						
						if ($cache)
						{
							$MySmartBB->functions->msg('تمت الخطوه النهائيه بنجاح');
							$MySmartBB->functions->goto('admin.php?page=sections&amp;control=1&amp;main=1');
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
		
		$SecArr 						= 	array();
		$SecArr['get_from']				=	'db';
		
		$SecArr['proc'] 				= 	array();
		$SecArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
				
		$SecArr['where']				=	array();
		$SecArr['where'][0]['name']		= 	'parent';
		$SecArr['where'][0]['oper']		= 	'=';
		$SecArr['where'][0]['value']	= 	'0';
		
		$SecList = $MySmartBB->section->GetSectionsList($SecArr);
		
		$x = 0;
		$y = sizeof($SecList);
		$s = array();
		
		while ($x < $y)
		{
			$name = 'order-' . $SecList[$x]['id'];
			
			$UpdateArr 				= 	array();
			$UpdateArr['field']		=	array();
			
			$UpdateArr['field']['sort'] 	= 	$MySmartBB->_POST[$name];
			$UpdateArr['where'] 			= 	array('id',$SecList[$x]['id']);
			
			$update = $MySmartBB->section->UpdateSection($UpdateArr);
			
			$s[$SecList[$x]['id']] = ($update) ? 'true' : 'false';

			$x += 1;
		}
		
		if (in_array('false',$s))
		{
			$MySmartBB->functions->error('المعذره، لم تنجح العمليه');
		}
		else
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح!');
			$MySmartBB->functions->goto('admin.php?page=sections&amp;control=1&amp;main=1');
		}
	}
	
	function _GroupControlMain()
	{
		global $MySmartBB;
		
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
		$SecGroupArr['where'][1]['oper']	=	'=';
		$SecGroupArr['where'][1]['value']	=	'1';
		
		$MySmartBB->_CONF['template']['while']['SecGroupList'] = $MySmartBB->group->GetSectionGroupList($SecGroupArr);
		
		$MySmartBB->template->display('sections_groups_control_main');
	}
	
	function _GroupControlStart()
	{
		global $MySmartBB;
		
		//////////
		
		$this->check_by_id($Inf);
		
		//////////
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_GET['group_id'],'intval');
		
		//////////
		
		$success 	= 	array();
		$fail		=	array();
		$size		=	sizeof($MySmartBB->_POST['groups']);
		
		foreach ($MySmartBB->_POST['groups'] as $id => $val)
		{
			$UpdateArr 				= 	array();
			$UpdateArr['field']		=	array();
			
			$UpdateArr['field']['view_section'] 	= 	$val['view_section'];
			$UpdateArr['where'][0] 					= 	array('name'=>'group_id','oper'=>'=','value'=>$id);
			$UpdateArr['where'][1] 					= 	array('con'=>'AND','name'=>'section_id','oper'=>'=','value'=>$Inf['id']);
		
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
		
		//////////
		
		$success_size 	= 	sizeof($success);
		$fail_size		=	sizeof($fail);
		
		//////////
		
		if ($success_size == $size)
		{
			//////////
			
			$MySmartBB->functions->msg('تم التحديث بنجاح!');
			
			//////////
			
			$UpdateArr 			= 	array();
			$UpdateArr['id'] 	= 	$Inf['id'];
			
			$cache = $MySmartBB->group->UpdateSectionGroupCache($UpdateArr);
			
			//////////
			
			if ($cache)
			{
				$MySmartBB->functions->msg('تم تحديث المعلومات المخبأه');
				$MySmartBB->functions->goto('admin.php?page=sections&amp;groups=1&amp;control_group=1&amp;index=1&amp;id=' . $Inf['id']);
			}
		}
	}
}

class _functions
{	
	function check_by_id(&$Inf)
	{
		global $MySmartBB;
		
		//////////
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		//////////
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		//////////
		
		$CatArr 			= 	array();
		$CatArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$Inf = $MySmartBB->section->GetSectionInfo($CatArr);
		
		//////////
		
		if ($Inf == false)
		{
			$MySmartBB->functions->error('القسم المطلوب غير موجود');
		}
		
		//////////
		
		$MySmartBB->functions->CleanVariable($Inf,'html');
		
		//////////
	}
}

?>
