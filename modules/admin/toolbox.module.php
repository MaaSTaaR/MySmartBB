<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define('CLASS_NAME','MySmartToolboxMOD');
	
class MySmartToolboxMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
		    $MySmartBB->loadLanguage( 'admin_toolbox' );
		    
			$MySmartBB->template->display('header');
			
			$MySmartBB->load( 'toolbox' );
			
			if ($MySmartBB->_GET['fonts'])
			{
				if ($MySmartBB->_GET['add'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_addFontsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_addFontsStart();
					}
				}
				elseif ($MySmartBB->_GET['control'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_controlFontsMain();
					}
				}
				elseif ($MySmartBB->_GET['edit'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_editFontsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_editFontsStart();
					}
				}
				elseif ($MySmartBB->_GET['del'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_delFontsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_delFontsStart();
					}
				}
			}
			
			if ($MySmartBB->_GET['colors'])
			{
				if ($MySmartBB->_GET['add'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_addColorsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_addColorsStart();
					}
				}
				elseif ($MySmartBB->_GET['control'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_controlColorsMain();
					}
				}
				elseif ($MySmartBB->_GET['edit'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_editColorsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_editColorsStart();
					}
				}
				elseif ($MySmartBB->_GET['del'])
				{
					if ($MySmartBB->_GET['main'])
					{
						$this->_delColorsMain();
					}
					elseif ($MySmartBB->_GET['start'])
					{
						$this->_delColorsStart();
					}
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	/**
	 * Fonts functions
	 */
	private function _addFontsMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('font_add');
	}
	
	private function _addFontsStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'name' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$MySmartBB->rec->fields	=	array( 'name' => $MySmartBB->_POST['name'] );
		
		$insert = $MySmartBB->toolbox->insertFont();
			
		if ($insert)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'font_added' ] );
			$MySmartBB->func->move('admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlFontsMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->toolbox->getFontsList();
		
		$MySmartBB->template->display('fonts_main');
	}
	
	private function _editFontsMain()
	{
		global $MySmartBB;
		
		$this->check_font_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('font_edit');
	}
	
	private function _editFontsStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'name' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$Inf = null;
		
		$this->check_font_by_id($Inf);
		
		// ... //
		
		$MySmartBB->rec->fields	=	array( 'name' => $MySmartBB->_POST['name'] );
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$update = $MySmartBB->toolbox->updateFont();
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'font_updated' ] );
			$MySmartBB->func->move('admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1');
		}
	}
	
	private function _delFontsMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = null;
		
		$this->check_font_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('font_del');
	}
	
	private function _DelFontsStart()
	{
		global $MySmartBB;
		
		$Inf = null;
		
		$this->check_font_by_id($Inf);
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$del = $MySmartBB->toolbox->deleteFont();
		
		if ($del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'font_deleted' ] );
			$MySmartBB->func->move('admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1');
		}
	}
	
	/**
	 * Colors func
	 */
	private function _addColorsMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('color_add');
	}
	
	private function _addColorsStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'name' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$MySmartBB->rec->fields	= array( 'name' => $MySmartBB->_POST[ 'name' ] );
		
		$insert = $MySmartBB->toolbox->insertColor();
		
		if ($insert)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'color_added' ] );
			$MySmartBB->func->move('admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1');
		}
	}
	
	private function _controlColorsMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->toolbox->getColorsList();
		
		$MySmartBB->template->display('colors_main');
	}
	
	private function _editColorsMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = null;
		
		$this->check_color_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('color_edit');
	}

	private function _editColorsStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'name' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$Inf = null;
		
		$this->check_color_by_id($Inf);
		
		$MySmartBB->rec->fields	=	array( 'name' => $MySmartBB->_POST['name'] );
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$update = $MySmartBB->toolbox->updateColor();
		
		if ($update)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'color_updated' ] );
			$MySmartBB->func->move('admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1');
		}
	}
	
	private function _delColorsMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = null;
		
		$this->check_color_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('color_del');
	}
	
	private function _delColorsStart()
	{
		global $MySmartBB;
		
		$Inf = null;
		
		$this->check_color_by_id($Inf);
		
		$MySmartBB->rec->filter = "id='" . $Inf[ 'id' ] . "'";
		
		$del = $MySmartBB->toolbox->deleteColor();
		
		if ($del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'color_deleted' ] );
			$MySmartBB->func->move('admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1');
		}
	}
	
	private function check_font_by_id(&$Inf)
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
	
		$Inf = $MySmartBB->toolbox->getFontInfo();
	
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'font_doesnt_exist' ] );
	}
	
	private function check_color_by_id(&$Inf)
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if (empty($MySmartBB->_GET['id']))
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
	
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
	
		$Inf = $MySmartBB->toolbox->getColorInfo();
	
		if ( !$Inf )
			$MySmartBB->func->error( $MySmartBB->lang[ 'font_doesnt_exist' ] );
	}
}

?>
