<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartSectionEditMOD');
	
class MySmartSectionEditMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_sections_del' );
		    
			$MySmartBB->load( 'group,subject' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_delMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_delStart();
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}

	private function _delMain()
	{
		global $MySmartBB;
		
		// ... //
		
		$this->checkID($MySmartBB->_CONF['template']['Inf']);
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'sec_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent='0' AND id<>'" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'sec_res' ];
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'forum_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->order = "sort ASC";
		$MySmartBB->rec->filter = "parent<>'0' AND id<>'" . $MySmartBB->_CONF['template']['Inf']['id'] . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'forum_res' ];

		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->template->display('section_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		// ... //
		
		$this->checkID($Inf);
		
		// ... //
				
		if ($MySmartBB->_POST['choose'] == 'move')
		{
			// ... //
			
			if (empty($MySmartBB->_POST['to']))
			{
				$MySmartBB->func->error('يوجد خطأ، لا يمكن إكمال العمليه! لم يتم اختيار القسم');
			}
			
			// ... //
			
			// Move normal sections to another main section
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->fields	= array();
			$MySmartBB->rec->fields['parent'] = $MySmartBB->_POST['to'];
			$MySmartBB->rec->filter = "parent='" . $Inf[ 'id' ] . "'";
			
			$update = $MySmartBB->rec->update();
			
			// ... //
			
			if ($update)
			{
				// ... //
				
				$MySmartBB->func->msg('تم نقل المنتديات بنجاح');
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
				$MySmartBB->rec->filter = "id='" . $Inf['id'] . "'";
				
				$del = $MySmartBB->rec->delete();
				
				// ... //
				
				if ($del)
				{
					// ... //
					
					$MySmartBB->func->msg('تم حذف القسم بنجاح !');
					
					// ... //
					
					$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
					$MySmartBB->rec->filter = "section_id='" . $Inf['id'] . "' AND main_section='1'";
					
					$del = $MySmartBB->rec->delete();
					
					// ... //
					
					if ($del)
					{
						$MySmartBB->func->msg('تم حذف صلاحيات المجموعات بنجاح');						
						$MySmartBB->func->move('admin.php?page=sections&amp;control=1&amp;main=1');
					}
					
					// ... //
				}
			}
		}
		elseif ($MySmartBB->_POST['choose'] == 'del')
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->filter = "parent='" . $Inf['id'] . "'";
			$MySmartBB->rec->order = "sort ASC";
			
			$SecList = $MySmartBB->rec->getList();
		
			$s = array();
			$x = 0;
			
			while ( $row = $MySmartBB->rec->getInfo() )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section_section' ];
				$MySmartBB->rec->filter = "section='" . $row['id'] . "' AND main_section<>'1'";
				
				$del = $MySmartBB->rec->delete();
				
				$s[$x] = ($del) ? 'true' : 'false';
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
				$MySmartBB->rec->filter = "section='" . $row['id'] . "'";
				
				$del = $MySmartBB->rec->delete();
				
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
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->filter = "parent='" . $Inf['id'] . "'";
			
			$del = $MySmartBB->rec->delete();
			
			if ($del)
			{
				$MySmartBB->func->msg('تم حذف المنتديات بنجاح');
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
				$MySmartBB->rec->filter = "id='" . $Inf['id'] . "'";
				
				$del = $MySmartBB->rec->delete();
				
				if ($del)
				{
					$MySmartBB->func->msg('تم حذف القسم بنجاح !');
					
					$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
					$MySmartBB->rec->filter = "section_id='" . $Inf['id'] . "' AND main_section='1'";
					
					$del = $MySmartBB->rec->delete();
					
					if ($del)
					{
						$MySmartBB->func->msg('تم حذف صلاحيات المجموعات بنجاح');
						
						$cache = $MySmartBB->group->updateSectionGroupCache( /* $id? */ );
						
						if ($cache)
						{
							$MySmartBB->func->msg('تمت الخطوه النهائيه بنجاح');
							$MySmartBB->func->move('admin.php?page=sections&amp;control=1&amp;main=1');
						}
					}
				}
			}
		}
		elseif ($MySmartBB->_POST['choose'] == 'move_subjects')
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->filter = "parent='" . $Inf['id'] . "'";
			$MySmartBB->rec->order = "sort ASC";
			
			$SecList = $MySmartBB->rec->getList();
		
			$x = 0;
			$s = array();
		
			while ( $row = $MySmartBB->rec->getInfo() )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
				$MySmartBB->rec->filter = "section_id='" . $row['id'] . "'";
				
				$del = $MySmartBB->rec->delete();
				
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
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
			$MySmartBB->rec->filter = "parent='" . $Inf['id'] . "'";
			
			$del = $MySmartBB->rec->delete();
			
			if ($del)
			{
				$MySmartBB->func->msg('تم حذف المنتديات بنجاح');
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
				$MySmartBB->rec->filter = "id='" . $Inf['id'] . "'";
				
				$del = $MySmartBB->rec->delete();
				
				if ($del)
				{
					$MySmartBB->func->msg('تم حذف القسم بنجاح !');
					
					$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
					$MySmartBB->rec->filter = "section_id='" . $Inf['id'] . "' AND main_section='1'";
					
					$del = $MySmartBB->rec->delete();
						
					if ($del)
					{
						$MySmartBB->func->msg('تم حذف صلاحيات المجموعات بنجاح');
						
						$cache = $MySmartBB->group->updateSectionGroupCache( /* $id? */ );
						
						if ($cache)
						{
							$MySmartBB->func->msg('تمت الخطوه النهائيه بنجاح');
							$MySmartBB->func->move('admin.php?page=sections&amp;control=1&amp;main=1');
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
	
	private function checkID(&$Inf)
	{
		global $MySmartBB;
		
		// ... //
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		// ... //
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$Inf = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ($Inf == false)
		{
			$MySmartBB->func->error('القسم المطلوب غير موجود');
		}
		
		// ... //
	}
}

?>
