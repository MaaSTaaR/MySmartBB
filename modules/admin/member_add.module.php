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
		    $MySmartBB->loadLanguage( 'admin_member_add' );
		    
			$MySmartBB->load( 'cache' );
			
			$MySmartBB->template->display( 'header' );
			
			if ( $MySmartBB->_GET[ 'main' ] )
			{
				$this->_addMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_addStart();
			}
				
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display( 'member_add' );
	}
	
	private function _addStart()
	{
		global $MySmartBB;
					
		$MySmartBB->_POST['username'] 	= 	trim( $MySmartBB->_POST['username'] );
		$MySmartBB->_POST['email'] 		= 	trim( $MySmartBB->_POST['email'] );
		
		if (empty($MySmartBB->_POST['username']) 
			or empty($MySmartBB->_POST['password']) 
			or empty($MySmartBB->_POST['email']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!$MySmartBB->func->checkEmail( $MySmartBB->_POST['email'] ))
		{
			$MySmartBB->func->error('يرجى كتابة بريد إلكتروني صحيح');
		}
		
		// Ensure there is no person used the same username
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['username'] . "'";
		
		$isMember = $MySmartBB->rec->getNumber();
		
		if ( $isMember > 0 )
		{
			$MySmartBB->func->error('اسم المستخدم موجود مسبقاً');
		}
		
		// Ensure there is no person used the same email
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "email='" . $MySmartBB->_POST['email'] . "'";
		
		$isMember = $MySmartBB->rec->getNumber();
		
		if ( $isMember > 0 )
		{
			$MySmartBB->func->error('البريد الالكتروني مسجل مسبقاً');
		}
		
		if ($MySmartBB->_POST['username'] == 'Guest')
		{
			$MySmartBB->func->error('لا يمكن التسجيل بهذا الاسم');
		}
		
		$MySmartBB->_POST['password'] = md5($MySmartBB->_POST['password']);
		
      	// ... //
      	
      	// Get the information of default group to set username style cache
      	
      	$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->filter = "id='4'";
		
		$GroupInfo = $MySmartBB->rec->getInfo();
		
		$style = $GroupInfo['username_style'];
		$username_style_cache = str_replace('[username]',$MySmartBB->_POST['username'],$style);
		
      	// ... //
      	
      	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
      	
		$MySmartBB->rec->fields			=	array();
		
		$MySmartBB->rec->fields['username']				= 	$MySmartBB->_POST['username'];
		$MySmartBB->rec->fields['password']				= 	$MySmartBB->_POST['password'];
		$MySmartBB->rec->fields['email']				= 	$MySmartBB->_POST['email'];
		$MySmartBB->rec->fields['usergroup']			= 	4;
		$MySmartBB->rec->fields['user_gender']			= 	$MySmartBB->_POST['gender'];
		$MySmartBB->rec->fields['register_date']		= 	$MySmartBB->_CONF['now'];
		$MySmartBB->rec->fields['user_title']			= 	'عضو';
		$MySmartBB->rec->fields['style']				=	$MySmartBB->_CONF['info_row']['def_style'];
		$MySmartBB->rec->fields['username_style_cache']	=	$username_style_cache;
		
		$MySmartBB->rec->get_id = true;
		
		$insert = $MySmartBB->rec->insert();
		
		if ($insert)
		{
			$MySmartBB->cache->updateLastMember( 	$MySmartBB->_CONF['info_row']['member_number'], 
													$MySmartBB->_POST['username'], 
													$MySmartBB->rec->id );

			$MySmartBB->func->msg('تم اضافة العضو بنجاح');
			$MySmartBB->func->move('admin.php?page=member_edit&amp;main=1&amp;id=' . $MySmartBB->rec->id);
		}
	}
}

?>
