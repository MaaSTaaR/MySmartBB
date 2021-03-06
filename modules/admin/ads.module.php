<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartAdsMOD');

class MySmartAdsMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_CONF['member_permission'])
		{
		    $MySmartBB->load( 'ads' );
		    
		    $MySmartBB->loadLanguage( 'admin_ads' );
		    
			$MySmartBB->template->display( 'header' );
		
			if ( $MySmartBB->_GET[ 'add' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_addMain();
				}
				elseif ( $MySmartBB->_GET[ 'start' ] )
				{
					$this->_addStart();
				}
			}
			elseif ( $MySmartBB->_GET[ 'control' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_controlMain();
				}
			}
			elseif ( $MySmartBB->_GET[ 'edit' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_editMain();
				}
				elseif ( $MySmartBB->_GET[ 'start' ] )
				{
					$this->_editStart();
				}
			}
			elseif ( $MySmartBB->_GET[ 'del' ] )
			{
				if ( $MySmartBB->_GET[ 'main' ] )
				{
					$this->_delMain();
				}
				elseif ( $MySmartBB->_GET[ 'start' ] )
				{
					$this->_delStart();
				}
			}
			
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display( 'ads_add' );
	}
	
	private function _addStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'name' ] ) 
			or empty( $MySmartBB->_POST[ 'link' ] ) 
			or empty( $MySmartBB->_POST[ 'picture' ] ) )
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		
		$MySmartBB->rec->fields	=	array();
		
		$MySmartBB->rec->fields['sitename'] 	= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['site'] 		= 	$MySmartBB->_POST['link'];
		$MySmartBB->rec->fields['picture'] 		= 	$MySmartBB->_POST['picture'];
		$MySmartBB->rec->fields['width'] 		= 	$MySmartBB->_POST['width'];
		$MySmartBB->rec->fields['height'] 		= 	$MySmartBB->_POST['height'];
		$MySmartBB->rec->fields['clicks'] 		= 	0;
				
		$insert = $MySmartBB->rec->insert();
			
		if ($insert)
		{
			$update = $MySmartBB->ads->updateAdsCache();
			
			if ($update)
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'ad_added' ] );
				$MySmartBB->func->move('admin.php?page=ads&amp;control=1&amp;main=1');
			}
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->getList();
				
		$MySmartBB->template->display('ads_main');
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->__checkID($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('ads_edit');
	}
	
	private function _editStart()
	{
		global $MySmartBB;
				
		if (empty($MySmartBB->_POST['name']) 
			or empty($MySmartBB->_POST['link']) 
			or empty($MySmartBB->_POST['picture']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$info = null;
		
		$this->__checkID( $info );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		
		$MySmartBB->rec->fields	=	array();
		$MySmartBB->rec->fields['sitename'] 	= 	$MySmartBB->_POST['name'];
		$MySmartBB->rec->fields['site'] 		= 	$MySmartBB->_POST['link'];
		$MySmartBB->rec->fields['picture'] 		= 	$MySmartBB->_POST['picture'];
		$MySmartBB->rec->fields['width'] 		= 	$MySmartBB->_POST['width'];
		$MySmartBB->rec->fields['height'] 		= 	$MySmartBB->_POST['height'];
		$MySmartBB->rec->fields['clicks'] 		= 	$info['clicks'];
		
		$MySmartBB->rec->filter = "id='" . $info['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ($update)
		{
		    $update = $MySmartBB->ads->updateAdsCache();
		    
			$MySmartBB->func->msg( $MySmartBB->lang[ 'ad_updated' ] );
			$MySmartBB->func->move('admin.php?page=ads&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->__checkID($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('ads_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$info = null;
		
		$this->__checkID( $info );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		$MySmartBB->rec->filter = "id='" . $info['id'] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ($del)
		{
			$update = $MySmartBB->ads->updateAdsCache();
			
			if ($update)
			{
				$MySmartBB->func->msg( $MySmartBB->lang[ 'ad_deleted' ] );
				$MySmartBB->func->move('admin.php?page=ads&amp;control=1&amp;main=1');
			}
		}
	}
	
	private function __checkID( &$AdsInfo )
	{
		global $MySmartBB;
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		if ( empty( $MySmartBB->_GET[ 'id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'ads' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$AdsInfo = $MySmartBB->rec->getInfo();
		
		if ( !$AdsInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'ad_doesnt_exist' ] );
	}
}

?>
