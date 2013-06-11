<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define('CLASS_NAME','MySmartTemplateMOD');

class MySmartTemplateMOD extends _func
{
	public function run()
	{
		global $MySmartBB;

		if ($MySmartBB->_CONF['member_permission'])
		{
		    $MySmartBB->loadLanguage( 'admin_template' );
		    
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

				elseif ($MySmartBB->_GET['show'])
				{
					$this->_controlShow();
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
					$this->_delStart();
				}

			}

			$MySmartBB->template->display('footer');
		}
	}

	private function _addMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->rec->getList();

		$MySmartBB->template->display('template_add');
	}

	private function _addStart()
	{
		global $MySmartBB;

		if (empty($MySmartBB->_POST['filename'])
			or empty($MySmartBB->_POST['style'])
			or empty($MySmartBB->_POST['context']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST['style'] . "'";
		
		$StyleInfo = $MySmartBB->rec->getInfo();

		if (!$StyleInfo)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'style_doesnt_exist' ] );
		}

	     $MySmartBB->_POST['context'] = $MySmartBB->func->cleanVariable($MySmartBB->_POST['context'],'unhtml');
	     $MySmartBB->_POST['context'] = stripslashes($MySmartBB->_POST['context']);
	     
	     $fp = fopen('./' . $StyleInfo['template_path'] . '/' . $MySmartBB->_POST['filename'],'w');
	     $fw = fwrite($fp,$MySmartBB->_POST['context']);
	     
	     fclose($fp);
	     
	     if ($fw)
	     {
	     	$MySmartBB->func->msg( $MySmartBB->lang[ 'template_added' ] );
	     	$MySmartBB->func->move('admin.php?page=template&amp;&amp;control=1&amp;main=1');
	     }
	}

	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->order = "style_order ASC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('templates_main');
	}

	private function _controlShow()
	{
		global $MySmartBB;

		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$StyleInfo = $MySmartBB->rec->getInfo();

		if (!$StyleInfo)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'style_doesnt_exist' ] );
		}
		
		$TemplatesList = array();

		if (is_dir($StyleInfo['template_path']))
		{
			$dir = opendir($StyleInfo['template_path']);

			if ($dir)
			{
				while (($file = readdir($dir)) !== false)
				{
					if ($file == '.'
						or $file == '..')
					{
						continue;
					}

					$TemplatesList[]['filename'] = $file;
				}

				closedir($dir);
			}
		}

		$MySmartBB->_CONF['template']['foreach']['TemplatesList'] = $TemplatesList;

		$MySmartBB->template->assign('StyleInfo',$StyleInfo);

		$MySmartBB->template->display('templates_show_templates_list');

	}

    private function _editMain()
    {
    	global $MySmartBB;
    	
    	$MySmartBB->_CONF['template']['Inf'] = false;
    	
    	$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
    	
    	if (empty($MySmartBB->_GET['filename']))
    	{
    		$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
    	}
    	
    	$MySmartBB->_GET['filename'] = $MySmartBB->func->cleanVariable($MySmartBB->_GET['filename'],'html');
    	
    	$path = './' . $MySmartBB->_CONF['template']['Inf']['template_path'] . '/' . $MySmartBB->_GET['filename'];

    	if (!file_exists($path))
    	{
    		$MySmartBB->func->error( $MySmartBB->lang[ 'template_doesnt_exist' ] );
    	}
    	
    	$lines = file($path);
    	$context = '';
    	
    	foreach ($lines as $line)
    	{
    		$context .= $line;
    	}
    	
    	$context = $MySmartBB->func->cleanVariable($context,'unhtml');
    	
    	$last_edit = date("d. M. Y", filectime($path));
    	
    	$MySmartBB->template->assign('filename',$MySmartBB->_GET['filename']);
    	$MySmartBB->template->assign('last_edit',$last_edit);
    	$MySmartBB->template->assign('context',$context);
    	
    	$MySmartBB->template->display('template_edit');
	}

	private function _editStart()
	{
		global $MySmartBB;

    	$StyleInfo = false;
    	
    	$this->check_by_id($StyleInfo);
    	
    	if (empty($MySmartBB->_GET['filename']))
    	{
    		$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
    	}
    	
    	$MySmartBB->_GET['filename'] = $MySmartBB->func->cleanVariable($MySmartBB->_GET['filename'],'html');
    	
    	$path = './' . $StyleInfo['template_path'] . '/' . $MySmartBB->_GET['filename'];

    	if (!file_exists($path))
    	{
    		$MySmartBB->func->error( $MySmartBB->lang[ 'template_doesnt_exist' ] );
    	}
    	
    	// To be more advanced :D
    	if (!is_writable($path))
    	{
    		$MySmartBB->func->error( $MySmartBB->lang[ 'template_unwritable' ] );
    	}
    	
    	$MySmartBB->_POST['context'] = stripslashes($MySmartBB->_POST['context']);
    	
    	$fp = fopen($path,'w+');
    	$fw = fwrite($fp,$MySmartBB->_POST['context']);
    	
    	if ($fw)
    	{
    		$compiled_filename = str_replace('.tpl','-compiler.php',$MySmartBB->_GET['filename']);
    		
    		// Use @ to avoid error messages such as (No such file or directory)
    		// Simply we can't ensure we have $compiled_filename in $StyleInfo['cache_path'] or not
    		$del = @unlink('./' . $StyleInfo['cache_path'] . '/' . $compiled_filename);
    		
    		$MySmartBB->func->msg( $MySmartBB->lang[ 'template_updated' ] );
			$MySmartBB->func->move('admin.php?page=template&amp;control=1&amp;show=1&amp;id=' . $StyleInfo['id']);
    	}
    }


	private function _delStart()
	{
		global $MySmartBB;

    	$StyleInfo = false;
    	
    	$this->check_by_id($StyleInfo);
    	
    	if (empty($MySmartBB->_GET['filename']))
    	{
    		$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
    	}
    	
    	$MySmartBB->_GET['filename'] = $MySmartBB->func->cleanVariable($MySmartBB->_GET['filename'],'html');
    	
    	$path = './' . $StyleInfo['template_path'] . '/' . $MySmartBB->_GET['filename'];

    	if (!file_exists($path))
    	{
    		$MySmartBB->func->error( $MySmartBB->lang[ 'template_doesnt_exist' ] );
    	}
    	
    	$del = unlink($path);

		if ($del)
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'delete_succeed' ] );
			$MySmartBB->func->move('admin.php?page=template&amp;control=1&amp;show=1&amp;id=' . $StyleInfo['id']);
		}
	}
}

class _func
{
	function check_by_id(&$StyleInfo)
	{
		global $MySmartBB;

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		}

		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$StyleInfo = $MySmartBB->rec->getInfo();

		if ($StyleInfo == false)
		{
			$MySmartBB->func->error( $MySmartBB->lang[ 'style_doesnt_exist' ] );
		}
	}
}

?>
