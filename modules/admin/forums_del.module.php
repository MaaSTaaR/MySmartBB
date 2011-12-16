<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'IN_ADMIN', true );

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartForumsDeleteMOD' );
	
class MySmartForumsDeleteMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_forums_del' );
		    
			$MySmartBB->load( 'section,subject' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_delMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_delStart();
			}
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->checkID( $MySmartBB->_CONF['template']['Inf'] );
		
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
		
		$this->checkID( $MySmartBB->_CONF['template']['Inf'] );
		
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
	
	private function checkID( &$Inf )
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
