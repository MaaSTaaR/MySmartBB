<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartForumsMOD');
	
class MySmartForumsMOD extends _functions
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
					if ($MySmartBB->_GET['start'])
					{
						$this->_groupControlStart();
					}
				}
			}
			elseif ($MySmartBB->_GET['forum'])
			{
				if ($MySmartBB->_GET['index'])
				{
					$this->_forumMain();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;

		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->order = "id ASC";
		
		$MySmartBB->func->setResource( 'group_res' );
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->func->getForumsList( false );
		
		// ... //
		
		$MySmartBB->template->display( 'forum_add' );
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		// ... //
		
 		if (empty($MySmartBB->_POST['name'])
 			or ($MySmartBB->_POST['order_type'] == 'manual' and empty($MySmartBB->_POST['sort'])))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		// ... //
		
		$sort = 0;
		
		if ($MySmartBB->_POST['order_type'] == 'auto')
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->filter = "parent='" . (int) $MySmartBB->_POST['parent'] . "'";
			$MySmartBB->rec->order = "sort DESC";
			
			$SortSection = $MySmartBB->rec->getInfo();
			
			if (!$SortSection)
			{
				$sort = 1;
			}
			else
			{
				$sort = $SortSection['sort'] + 1;
			}
		}
		else
		{
			$sort = $MySmartBB->_POST['sort'];
		}
		
		// ... //
		
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		
		$MySmartBB->rec->fields = array();
		
		$MySmartBB->rec->fields['title'] 					= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['sort'] 					= 	$sort;
		$MySmartBB->rec->fields['section_describe']			=	$MySmartBB->_POST['describe'];
		$MySmartBB->rec->fields['parent']					=	$MySmartBB->_POST['parent'];
		$MySmartBB->rec->fields['show_sig']					=	1;
		$MySmartBB->rec->fields['usesmartcode_allow']		=	1;
		$MySmartBB->rec->fields['subject_order']			=	1;
		$MySmartBB->rec->fields['sectionpicture_type']		=	2;
		
		$MySmartBB->rec->get_id = true;
		
		$insert = $MySmartBB->rec->insert();
		
		// ... //
		
		if ($insert)
		{
			// ... //
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
			$MySmartBB->rec->order = "id ASC";
			
			$MySmartBB->rec->getList();
			
			while ( $row = $MySmartBB->rec->getInfo() )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
				
				$MySmartBB->rec->fields	=	array();
				
				$MySmartBB->rec->fields['section_id'] 			= 	$MySmartBB->rec->id;
				$MySmartBB->rec->fields['group_id'] 			= 	$row['id'];
				$MySmartBB->rec->fields['view_section'] 		= 	$MySmartBB->_POST['groups'][$row['id']]['view_section'];
				$MySmartBB->rec->fields['download_attach'] 		= 	$row['download_attach'];
				$MySmartBB->rec->fields['write_subject'] 		= 	$MySmartBB->_POST['groups'][$row['id']]['write_subject'];
				$MySmartBB->rec->fields['write_reply'] 			= 	$MySmartBB->_POST['groups'][$row['id']]['write_reply'];
				$MySmartBB->rec->fields['upload_attach'] 		= 	$row['upload_attach'];
				$MySmartBB->rec->fields['edit_own_subject']		= 	$row['edit_own_subject'];
				$MySmartBB->rec->fields['edit_own_reply'] 		= 	$row['edit_own_reply'];
				$MySmartBB->rec->fields['del_own_subject'] 		= 	$row['del_own_subject'];
				$MySmartBB->rec->fields['del_own_reply'] 		= 	$row['del_own_reply'];
				$MySmartBB->rec->fields['write_poll'] 			= 	$row['write_poll'];
				$MySmartBB->rec->fields['no_posts'] 			= 	$row['no_posts'];
				$MySmartBB->rec->fields['vote_poll'] 			= 	$row['vote_poll'];
				$MySmartBB->rec->fields['main_section'] 		= 	0;
				$MySmartBB->rec->fields['group_name'] 			= 	$row['title'];
				
				$MySmartBB->rec->insert();
			}
			
			// ... //
			
			$cache = $MySmartBB->section->updateSectionsCache( $MySmartBB->_POST['parent'] );
				
			if ($cache)
			{
				$MySmartBB->func->msg('تم اضافة المنتدى بنجاح !');
				$MySmartBB->func->move('admin.php?page=forums&amp;edit=1&amp;main=1&amp;id=' . $MySmartBB->rec->id);
			}
			else
			{
				$MySmartBB->func->error('هناك مشكله، لا يمكنه تحديث المعلومات المخبأه');
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
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'forums_list' ] = $MySmartBB->func->getForumsList( false );
		
		// ... //
		
		$MySmartBB->template->display('forums_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id( $MySmartBB->_CONF['template']['Inf'] );
		
		// ... //
		
		/*$SecArr 						= 	array();
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
		
		// ... //*/
		
		$MySmartBB->template->display('forum_edit');
	}
	
	public function _editStart()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		// ... //
		
 		if (empty($MySmartBB->_POST['name']) 
 			or empty($MySmartBB->_POST['sort']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		// ... //
		
		// Check if the user change the parent or not
		$new_parent_flag 	= 	false;
		$old_parent			=	0;
		
		if ($MySmartBB->_CONF['template']['Inf']['parent'] != $MySmartBB->_POST['parent'])
		{
			$new_parent_flag	= 	true;
			$old_parent			=	$MySmartBB->_CONF['template']['Inf']['id'];
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['title'] 					= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['sort'] 					= 	$MySmartBB->_POST['sort'];
		$MySmartBB->rec->fields['section_describe']			=	$MySmartBB->_POST['describe'];
		$MySmartBB->rec->fields['section_password']			=	$MySmartBB->_POST['section_password'];
		$MySmartBB->rec->fields['show_sig']					=	$MySmartBB->_POST['show_sig'];
		$MySmartBB->rec->fields['usesmartcode_allow']		=	$MySmartBB->_POST['usesmartcode_allow'];
		$MySmartBB->rec->fields['section_picture']			=	$MySmartBB->_POST['section_picture'];
		$MySmartBB->rec->fields['sectionpicture_type']		=	$MySmartBB->_POST['sectionpicture_type'];
		$MySmartBB->rec->fields['use_section_picture']		=	$MySmartBB->_POST['use_section_picture'];
		$MySmartBB->rec->fields['linksection']				=	$MySmartBB->_POST['linksection'];
		$MySmartBB->rec->fields['linksite']					=	$MySmartBB->_POST['linksite'];
		$MySmartBB->rec->fields['subject_order']			=	$MySmartBB->_POST['subject_order'];
		$MySmartBB->rec->fields['hide_subject']				=	$MySmartBB->_POST['hide_subject'];
		$MySmartBB->rec->fields['sec_section']				=	$MySmartBB->_POST['sec_section'];
		$MySmartBB->rec->fields['header'] 					= 	$MySmartBB->_POST['head'];
		$MySmartBB->rec->fields['footer'] 					= 	$MySmartBB->_POST['foot'];
		$MySmartBB->rec->fields['sig_iteration']			=	$MySmartBB->_POST['sig_iteration'];
		$MySmartBB->rec->fields['parent']					=	$MySmartBB->_POST['parent'];
		$MySmartBB->rec->fields['review_subject']			=	$MySmartBB->_POST['review_subject'];

		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		
		$MySmartBB->rec->update();
		
		if ($update)
		{
			$cache = $MySmartBB->section->updateSectionsCache( $MySmartBB->_POST['parent'] );
			
			// There is a new main section
			if ($new_parent_flag)
			{
				$cache = $MySmartBB->section->updateSectionsCache( $old_parent );
			}
			
			if ($cache)
			{
				$MySmartBB->func->msg('تم تحديث القسم بنجاح !');
				$MySmartBB->func->move('admin.php?page=forums&amp;edit=1&amp;main=1&amp;id=' . $MySmartBB->_CONF['template']['Inf']['id']);
			}
			else
			{
				$MySmartBB->func->error('هناك مشكله، لم يتم التحديث');
			}
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id( $MySmartBB->_CONF['template']['Inf'] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent<>'0' AND id<>'" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('forum_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		if ($MySmartBB->_POST['choose'] == 'move')
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
			
			$del = $MySmartBB->rec->delete();
			
			if ($del)
			{
				$MySmartBB->func->msg('تم حذف المنتدى بنجاح !');
				
				$move = $MySmartBB->subject->massMoveSubject( (int) $MySmartBB->_POST['to'], $MySmartBB->_CONF['template']['Inf']['id'] );
				
				if ($move)
				{
					$MySmartBB->func->msg('تم نقل المواضيع بنجاح');
					
					// ... //
					
					$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
					$MySmartBB->rec->filter = "section_id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
					
					$FromSubjectNumber = $MySmartBB->rec->getNumber();
					
					// ... //
					
					$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
					$MySmartBB->rec->filter = "section_id='" . (int) $MySmartBB->_POST['to'] . "'";
					
					$ToSubjectNumber = $MySmartBB->rec->getNumber();
					
					// ... //
					
					$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
     				$MySmartBB->rec->fields = array(	'subject_num'	=>	$FromSubjectNumber + $ToSubjectNumber	);
     				$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST['to'] . "'";
     				
		     		$update = $MySmartBB->rec->update();
     				
     				if ($update)
     				{
						$cache = $MySmartBB->section->updateSectionsCache( $MySmartBB->_CONF['template']['Inf']['parent'] );
						
						if ($cache)
						{
							$MySmartBB->func->msg('تم تحديث المعلومات بنجاح !');
							
							$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
							$MySmartBB->rec->filter = "section_id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
							
							$del = $MySmartBB->rec->delete();
							
							if ($del)
							{
								$MySmartBB->func->msg('تم حذف صلاحيات المجموعات بنجاح');
								$MySmartBB->func->move('admin.php?page=forums&amp;control=1&amp;main=1');
							}
						}
					}
				}
			}
		}
		elseif ($MySmartBB->_POST['choose'] == 'del')
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
			
			$del = $MySmartBB->rec->delete();
				
			if ($del)
			{
				$MySmartBB->func->msg('تم حذف المنتدى بنجاح !');
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
				$MySmartBB->rec->filter = "section='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
				
				$del = $MySmartBB->rec->delete();
				
				if ($del)
				{
					$MySmartBB->func->msg('تم حذف المواضيع بنجاح');
					
					$cache = $MySmartBB->section->updateSectionsCache( $MySmartBB->_CONF['template']['Inf']['parent'] );
					
					if ($cache)
					{
						$MySmartBB->func->msg('تم تحديث المعلومات بنجاح !');
						
						$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
						$MySmartBB->rec->filter = "section_id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
						
						$del = $MySmartBB->rec->delete();
						
						if ($del)
						{
							$MySmartBB->func->msg('تم حذف صلاحيات المجموعات بنجاح');
							$MySmartBB->func->move('admin.php?page=forums&amp;control=1&amp;main=1');
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
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "parent<>'0'";
		$MySmartBB->rec->order = "sort ASC";
		
		$MySmartBB->rec->getList();
		
		while ( $row = $MySmartBB->rec->getInfo() )
		{
			$name = 'order-' . $row['id'];
			
			if ($row['order'] != $MySmartBB->_POST[$name])
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
				$MySmartBB->rec->fields = array(	'sort'	=>	$MySmartBB->_POST[ $name ]	);
				$MySmartBB->rec->filter = "id='" . $row[ 'id' ] . "'";
				
				$update = $MySmartBB->rec->update();
				
				if ($update)
				{
					$cache = $MySmartBB->section->updateSectionsCache( $row[ 'parent' ] );
				}
				
				$s[ $row[ 'id' ] ] = ($update) ? 'true' : 'false';
			}

			$x += 1;
		}
		
		if ( in_array( 'false', $s ) )
		{
			$MySmartBB->func->error('المعذره، لم تنجح العمليه');
		}
		else
		{
			$MySmartBB->func->msg('تم التحديث بنجاح!');
			$MySmartBB->func->move('admin.php?page=forums&amp;control=1&amp;main=1');
		}
	}
	
	private function _groupControlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "' AND main_section<>'1'";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('forums_groups_control_main');
	}
		
	private function _groupControlStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);

		$MySmartBB->_GET['group_id'] = (int) $MySmartBB->_GET['group_id'];
		
		$success 	= 	array();
		$fail		=	array();
		$size		=	sizeof($MySmartBB->_POST['groups']);
		
		foreach ($MySmartBB->_POST['groups'] as $id => $val)
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
			
			$MySmartBB->rec->fields		=	array();
			
			$MySmartBB->rec->fields['view_section'] 		= 	$val['view_section'];
			$MySmartBB->rec->fields['download_attach'] 		= 	$val['download_attach'];
			$MySmartBB->rec->fields['write_subject'] 		= 	$val['write_subject'];
			$MySmartBB->rec->fields['write_reply'] 			= 	$val['write_reply'];
			$MySmartBB->rec->fields['upload_attach'] 		= 	$val['upload_attach'];
			$MySmartBB->rec->fields['edit_own_subject'] 	= 	$val['edit_own_subject'];
			$MySmartBB->rec->fields['edit_own_reply'] 		= 	$val['edit_own_reply'];
			$MySmartBB->rec->fields['del_own_subject'] 		= 	$val['del_own_subject'];
			$MySmartBB->rec->fields['del_own_reply'] 		= 	$val['del_own_reply'];
			$MySmartBB->rec->fields['write_poll'] 			= 	$val['write_poll'];
			$MySmartBB->rec->fields['no_posts'] 			= 	$val['no_posts'];
			$MySmartBB->rec->fields['vote_poll'] 			= 	$val['vote_poll'];
			
			$MySmartBB->rec->filter = "group_id='" . $id . "' AND section_id='" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
			
			$update = $MySmartBB->rec->update();
			
			if ($update)
			{
				$success[] = $id;
			}
			else
			{
				$fail[] = $id;
			}
		}
		
		$success_size 	= 	sizeof($success);
		$fail_size		=	sizeof($fail); // Why?
		
		if ($success_size == $size)
		{
			$MySmartBB->func->msg('تم التحديث بنجاح!');
			
			$cache = $MySmartBB->group->updateSectionGroupCache( $MySmartBB->_CONF['template']['Inf']['id'] );
			
			if ($cache)
			{
				$MySmartBB->func->msg('تم تحديث المعلومات المخبأه');
				
				$cache = $MySmartBB->section->updateSectionsCache( $MySmartBB->_CONF['template']['Inf']['parent'] );
				
				if ($cache)
				{
					$MySmartBB->func->msg('تمّت الخطوه النهائيه');
					$MySmartBB->func->move('admin.php?page=forums&amp;groups=1&amp;control_group=1&amp;index=1&amp;id=' . $MySmartBB->_CONF['template']['Inf']['id']);
				}
			}
		}
	}
	
	function _ForumMain()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		// ... //
		
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
		
		// ... //
		
		$MySmartBB->template->display('forums_forum_main');
	}
}

class _functions
{
	public function check_by_id( &$Inf )
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		if ($Inf == false)
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}		
	}
}

?>
