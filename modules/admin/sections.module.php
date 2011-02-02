<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['GROUP'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartSectionMOD');
	
class MySmartSectionMOD extends _func
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->template->display('header');
			
			if ($MySmartBB->_GET['add'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_addMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_addStart();
				}
			}
			elseif ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_controlMain();
				}
			}
			elseif ($MySmartBB->_GET['edit'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_editMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_editStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_delMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_delStart();
				}
			}
			elseif ($MySmartBB->_GET['change_sort'])
			{
				$this->_changeSort();
			}
			elseif ($MySmartBB->_GET['groups'])
			{
				if ($MySmartBB->_GET['control_group'])
				{
					if ($MySmartBB->_GET['index'])
					{
						$this->_groupControlMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_groupControlStart();
					}
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;
		
		/* ... */
		
		$MySmartBB->rec->order = "id ASC";
		
		$MySmartBB->group->getGroupList();
		
		/* ... */

		$MySmartBB->template->display('sections_add');		
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['name']) 
			or ($MySmartBB->_POST['order_type'] == 'manual' and empty($MySmartBB->_POST['sort'])))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		/* ... */
		
		$sort = 0;
		
		if ($MySmartBB->_POST['order_type'] == 'auto')
		{
			$MySmartBB->rec->filter = "parent='0'";
			$MySmartBB->rec->order = "sort DESC";
			
			$SortSection = $MySmartBB->section->getSectionInfo();
			
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
		
		/* ... */
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 	= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['sort'] 	= 	$sort;
		$MySmartBB->rec->fields['parent'] 	= 	'0';
		
		$MySmartBB->section->get_id	= true;
		
		$insert = $MySmartBB->section->insertSection();
		
		if ($insert)
		{
			$MySmartBB->rec->order = "id ASC";
			
			$groups = $MySmartBB->group->getGroupList();
			
			while ( $row = $MySmartBB->rec->getInfo() )
			{
				$MySmartBB->rec->fields		=	array();
				
				$MySmartBB->rec->fields['section_id'] 			= 	$MySmartBB->section->id;
				$MySmartBB->rec->fields['group_id'] 			= 	$row['id'];
				$MySmartBB->rec->fields['view_section'] 		= 	$MySmartBB->_POST['groups'][$row['id']]['view_section'];
				$MySmartBB->rec->fields['download_attach'] 		= 	$row['download_attach'];
				$MySmartBB->rec->fields['write_subject'] 		= 	$row['write_subject'];
				$MySmartBB->rec->fields['write_reply'] 			= 	$row['write_reply'];
				$MySmartBB->rec->fields['upload_attach'] 		= 	$row['upload_attach'];
				$MySmartBB->rec->fields['edit_own_subject'] 	= 	$row['edit_own_subject'];
				$MySmartBB->rec->fields['edit_own_reply'] 		= 	$row['edit_own_reply'];
				$MySmartBB->rec->fields['del_own_subject'] 		= 	$row['del_own_subject'];
				$MySmartBB->rec->fields['del_own_reply'] 		= 	$row['del_own_reply'];
				$MySmartBB->rec->fields['write_poll'] 			= 	$row['write_poll'];
				$MySmartBB->rec->fields['vote_poll'] 			= 	$row['vote_poll'];
				$MySmartBB->rec->fields['main_section'] 		= 	1;
				$MySmartBB->rec->fields['group_name'] 			= 	$row['title'];
				
				$insert = $MySmartBB->group->insertSectionGroup();
				
				$x += 1;
			}
			
			$cache = $MySmartBB->group->UpdateSectionGroupCache( $MySmartBB->section->id );
			
			if ($cache)
			{
				$MySmartBB->func->msg('تم اضافة القسم بنجاح !');
				$MySmartBB->func->goto('admin.php?page=sections&amp;control=1&amp;main=1');
			}
		}
		else
		{
			$MySmartBB->func->error('هناك مشكله، لم يتمكن من اضافة القسم');
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		/* ... */
		
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent='0'";
		
		$MySmartBB->section->getSectionsList();
		
		/* ... */
		
		$MySmartBB->template->display('sections_main');

		/* ... */
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('section_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		/* ... */
		
		$this->check_by_id($Inf);
		
		/* ... */
		
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['sort']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		/* ... */
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 	= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['sort'] 	= 	$MySmartBB->_POST['sort'];
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$update = $MySmartBB->section->updateSection();
		
		/* ... */
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث القسم بنجاح !');
			$MySmartBB->func->goto('admin.php?page=sections&amp;control=1&amp;main=1');
		}
		
		/* ... */
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		/* ... */
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		/* ... */
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'sec_res' ] = '';
		
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent='0' AND id<>'" . $MySmartBB->_CONF['template']['Inf']['id'] . "";
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'sec_res' ];
		
		$MySmartBB->section->getSectionsList();
		
		/* ... */
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'forum_res' ] = '';
		
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent<>'0' AND id<>'" . $MySmartBB->_CONF['template']['Inf']['id'] . "";
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'forum_res' ];

		$MySmartBB->section->getSectionsList();
		
		/* ... */
		
		$MySmartBB->template->display('section_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		/* ... */
		
		$this->check_by_id($Inf);
		
		/* ... */
				
		if ($MySmartBB->_POST['choose'] == 'move')
		{
			/* ... */
			
			if (empty($MySmartBB->_POST['to']))
			{
				$MySmartBB->func->error('يوجد خطأ، لا يمكن إكمال العمليه! لم يتم اختيار القسم');
			}
			
			/* ... */
			
			// Move normal sections to another main section
			$MySmartBB->rec->fields	= array();
			
			$MySmartBB->rec->fields['parent'] = $MySmartBB->_POST['to'];
			
			$MySmartBB->rec->filter = "parent='" . $Inf[ 'id' ] . "'";
			
			$update = $MySmartBB->section->updateSection();
			
			/* ... */
			
			if ($update)
			{
				/* ... */
				
				$MySmartBB->func->msg('تم نقل المنتديات بنجاح');
				
				$MySmartBB->rec->filter = "id='" . $Inf['id'] . "'";
				
				$del = $MySmartBB->section->deleteSection();
				
				/* ... */
				
				if ($del)
				{
					/* ... */
					
					$MySmartBB->func->msg('تم حذف القسم بنجاح !');
					
					/* ... */
					
					$MySmartBB->rec->filter = "section_id='" . $Inf['id'] . "' AND main_section='1'";
					
					$del = $MySmartBB->group->deleteSectionGroup();
					
					/* ... */
					
					if ($del)
					{
						$MySmartBB->func->msg('تم حذف صلاحيات المجموعات بنجاح');						
						$MySmartBB->func->goto('admin.php?page=sections&amp;control=1&amp;main=1');
					}
					
					/* ... */
				}
			}
		}
		elseif ($MySmartBB->_POST['choose'] == 'del')
		{
			$MySmartBB->rec->filter = "parent='" . $Inf['id'] . "'";
			$MySmartBB->rec->order = "sort ASC";
			
			$SecList = $MySmartBB->section->getSectionsList();
		
			$s = array();
			$x = 0;
			
			while ( $row = $MySmartBB->rec->getInfo() )
			{
				$MySmartBB->rec->filter = "section='" . $row['id'] . "' AND main_section<>'1'";
				
				$del = $MySmartBB->group->deleteSectionGroup();
				
				$s[$x] = ($del) ? 'true' : 'false';
				
				$MySmartBB->filter = "section='" . $row['id'] . "'";
				
				$del = $MySmartBB->subject->deleteSubject();
				
				$s[$x] = ($del) ? 'true' : 'false';
				
				$x += 1;
			}
			
			if (in_array('false',$s))
			{
				$MySmartBB->func->msg('خطأ، لم تتم عملية حذف صلاحيات المجموعات و المواضيع بنجاح !');
			}
			else
			{
				$MySmartBB->func->msg('تم حذف صلاحيات المجموعات للمنتديات');
			}
			
			$MySmartBB->rec->filter = "parent='" . $Inf['id'] . "'";
			
			$del = $MySmartBB->section->deleteSection();
			
			if ($del)
			{
				$MySmartBB->func->msg('تم حذف المنتديات بنجاح');
				
				$MySmartBB->rec->filter = "id='" . $Inf['id'] . "'";
				
				$del = $MySmartBB->section->deleteSection();
				
				if ($del)
				{
					$MySmartBB->func->msg('تم حذف القسم بنجاح !');
					
					$MySmartBB->rec->filter = "section_id='" . $Inf['id'] . "' AND main_section='1'";
					
					$del = $MySmartBB->group->deleteSectionGroup();
					
					if ($del)
					{
						$MySmartBB->func->msg('تم حذف صلاحيات المجموعات بنجاح');
						
						$cache = $MySmartBB->group->updateSectionGroupCache( /* $id? */ );
						
						if ($cache)
						{
							$MySmartBB->func->msg('تمت الخطوه النهائيه بنجاح');
							$MySmartBB->func->goto('admin.php?page=sections&amp;control=1&amp;main=1');
						}
					}
				}
			}
		}
		elseif ($MySmartBB->_POST['choose'] == 'move_subjects')
		{
			$MySmartBB->rec->filter = "parent='" . $Inf['id'] . "'";
			$MySmartBB->rec->order = "sort ASC";
			
			$SecList = $MySmartBB->section->getSectionsList();
		
			$x = 0;
			$s = array();
		
			while ( $row = $MySmartBB->rec->getInfo() )
			{
				$MySmartBB->rec->filter = "section_id='" . $row['id'] . "'";
				
				$del = $MySmartBB->section->deleteSectionGroup();
				
				$s[$x] = ($del) ? 'true' : 'false';
				
				$move = $MySmartBB->subject->massMoveSubject( $MySmartBB->_POST['subject_to'], $row['id'] );
				
				$s[$x] = ($del) ? 'true' : 'false';
				
				$x += 1;
			}
			
			if (in_array('false',$s))
			{
				$MySmartBB->func->msg('خطأ، لم تتم عملية حذف صلاحيات المجموعات بنجاح !');
			}
			else
			{
				$MySmartBB->func->msg('تم حذف صلاحيات المجموعات للمنتديات');
			}
			
			$MySmartBB->rec->filter = "parent='" . $Inf['id'] . "'";
			
			$del = $MySmartBB->section->deleteSection();
			
			if ($del)
			{
				$MySmartBB->func->msg('تم حذف المنتديات بنجاح');
				
				$MySmartBB->rec->filter = "id='" . $Inf['id'] . "'";
				
				$del = $MySmartBB->section->deleteSection();
				
				if ($del)
				{
					$MySmartBB->func->msg('تم حذف القسم بنجاح !');
					
					$MySmartBB->rec->filter = "section_id='" . $Inf['id'] . "' AND main_section='1'";
					
					$del = $MySmartBB->group->deleteSectionGroup();
						
					if ($del)
					{
						$MySmartBB->func->msg('تم حذف صلاحيات المجموعات بنجاح');
						
						$cache = $MySmartBB->group->updateSectionGroupCache( /* $id? */ );
						
						if ($cache)
						{
							$MySmartBB->func->msg('تمت الخطوه النهائيه بنجاح');
							$MySmartBB->func->goto('admin.php?page=sections&amp;control=1&amp;main=1');
						}
					}
				}
			}
		}
		else
		{
			$MySmartBB->func->error('الاختيار غير صحيح!');
		}
	}
	
	private function _changeSort()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->filter = "parent='0'";
		
		$MySmartBB->section->getSectionsList();
		
		$x = 0;
		$s = array();
		
		while ( $row = $MySmartBB->rec->getInfo() )
		{
			$name = 'order-' . $SecList[$x]['id'];
			
			$MySmartBB->rec->fields				=	array();
			$MySmartBB->rec->fields['sort'] 	= 	$MySmartBB->_POST[$name];
			
			$MySmartBB->rec->filter = "id='" . $row[ 'id' ] . "'";
			
			$update = $MySmartBB->section->updateSection();
			
			$s[$SecList[$x]['id']] = ($update) ? 'true' : 'false';

			$x += 1;
		}
		
		if (in_array('false',$s))
		{
			$MySmartBB->func->error('المعذره، لم تنجح العمليه');
		}
		else
		{
			$MySmartBB->func->msg('تم التحديث بنجاح!');
			$MySmartBB->func->goto('admin.php?page=sections&amp;control=1&amp;main=1');
		}
	}
	
	private function _groupControlMain()
	{
		global $MySmartBB;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->rec->filter = "section_id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "' AND main_section='1'";
		
		$MySmartBB->group->getSectionGroupList();
		
		$MySmartBB->template->display('sections_groups_control_main');
	}
	
	private function _groupControlStart()
	{
		global $MySmartBB;
		
		/* ... */
		
		$this->check_by_id($Inf);
		
		/* ... */
		
		$MySmartBB->_GET['group_id'] = (int) $MySmartBB->_GET['group_id'];
		
		/* ... */
		
		$success 	= 	array();
		$fail		=	array();
		$size		=	sizeof($MySmartBB->_POST['groups']);
		
		foreach ($MySmartBB->_POST['groups'] as $id => $val)
		{
			$MySmartBB->rec->fields						=	array();
			$MySmartBB->rec->fields['view_section'] 	= 	$val['view_section'];
			
			$MySmartBB->rec->filter = "group_id='" . $id . "' AND section_id='" . $Inf[ 'id' ] . "'";
			
			$update = $MySmartBB->group->updateSectionGroup();

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
		
		/* ... */
		
		$success_size 	= 	sizeof($success);
		$fail_size		=	sizeof($fail); // Why??
		
		/* ... */
		
		if ($success_size == $size)
		{
			/* ... */
			
			$MySmartBB->func->msg('تم التحديث بنجاح!');
			
			/* ... */
			
			$cache = $MySmartBB->group->updateSectionGroupCache( $Inf['id'] );
			
			/* ... */
			
			if ($cache)
			{
				$MySmartBB->func->msg('تم تحديث المعلومات المخبأه');
				$MySmartBB->func->goto('admin.php?page=sections&amp;groups=1&amp;control_group=1&amp;index=1&amp;id=' . $Inf['id']);
			}
		}
	}
}

class _func
{	
	function check_by_id(&$Inf)
	{
		global $MySmartBB;
		
		/* ... */
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		/* ... */
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		/* ... */
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$Inf = $MySmartBB->section->getSectionInfo();
		
		/* ... */
		
		if ($Inf == false)
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		/* ... */
	}
}

?>
