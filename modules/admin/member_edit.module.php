<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartMemberMOD');
	
class MySmartMemberMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_editMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_editStart();
			}
				
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->checkID($MySmartBB->_CONF['template']['Inf']);
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->func->setResource( 'style_res' );
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->func->setResource( 'group_res' );
		
		$MySmartBB->rec->getList();
		
		// ... //
		
		$MySmartBB->template->display('member_edit');
		
		// ... //
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$MemInfo = false;
		
		$this->checkID($MemInfo);
		
		if (empty($MySmartBB->_POST['email']) 
			or empty($MySmartBB->_POST['user_title'])
			or !isset($MySmartBB->_POST['posts']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!$MySmartBB->func->checkEmail( $MySmartBB->_POST['email'] ))
		{
			$MySmartBB->func->error('يرجى كتابة بريد إلكتروني صحيح');
		}
		
		// Ensure there is no person used the same username
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['new_username'] . "'";
		
		$isMember = $MySmartBB->rec->getNumber();
		
		if ( $isMember > 0 )
		{
			$MySmartBB->func->error('اسم المستخدم موجود مسبقاً');
		}

		if ($MySmartBB->_POST['username'] == 'Guest')
		{
			$MySmartBB->func->error('لا يمكن التسجيل بهذا الاسم');
		}
		
		// ... //
		
		$username = (!empty($MySmartBB->_POST['new_username'])) ? $MySmartBB->_POST['new_username'] : $MemInfo['username'];
		
		// ... //
		
		// If the admin change the group of this member, so we should change the cache of username style
		
		if ($MySmartBB->_POST['usergroup'] != $MemInfo['usergroup'])
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST['usergroup'] . "'";
			
			$GroupInfo = $MySmartBB->rec->getInfo();
			
			$style = $GroupInfo['username_style'];
			$username_style_cache = str_replace('[username]',$username,$style);			
		}
		else
		{
			$username_style_cache = null;
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		
		$MySmartBB->rec->fields 	= 	array();
		
		$MySmartBB->rec->fields['username'] 			= 	$username;
		$MySmartBB->rec->fields['password'] 			= 	(!empty($MySmartBB->_POST['new_password'])) ? md5($MySmartBB->_POST['new_password']) : $MemInfo['password'];
		$MySmartBB->rec->fields['email'] 				= 	$MySmartBB->_POST['email'];
		$MySmartBB->rec->fields['user_gender'] 			= 	$MySmartBB->_POST['gender'];
		$MySmartBB->rec->fields['style'] 				= 	$MySmartBB->_POST['style'];
		$MySmartBB->rec->fields['avater_path'] 			= 	$MySmartBB->_POST['avater_path'];
		$MySmartBB->rec->fields['user_info'] 			= 	$MySmartBB->_POST['user_info'];
		$MySmartBB->rec->fields['user_title'] 			= 	$MySmartBB->_POST['user_title'];
		$MySmartBB->rec->fields['posts'] 				= 	$MySmartBB->_POST['posts'];
		$MySmartBB->rec->fields['user_website'] 		= 	$MySmartBB->_POST['user_website'];
		$MySmartBB->rec->fields['user_country'] 		= 	$MySmartBB->_POST['user_country'];
		$MySmartBB->rec->fields['usergroup'] 			= 	$MySmartBB->_POST['usergroup'];
		$MySmartBB->rec->fields['username_style_cache']	=	$username_style_cache;
		
		$MySmartBB->rec->filter = "id='" . $MemInfo['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if (!empty($MySmartBB->_POST['new_username']))
		{
			// TODO ;;;
			// Don't forget the cache of username style here
		}
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث بيانات العضو بنجاح');
			$MySmartBB->func->move('admin.php?page=member&amp;control=1&amp;main=1');
		}
	}
	
	private function checkID(&$MemInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$MemInfo = $MySmartBB->rec->getInfo();
		
		if ($MemInfo == false)
		{
			$MySmartBB->func->error('العضو المطلوب غير موجود');
		}
	}
}

?>
