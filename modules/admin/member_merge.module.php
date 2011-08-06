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
				$this->_mergeMain();
			}
			elseif ( $MySmartBB->_GET[ 'start' ] )
			{
				$this->_mergeStart();
			}
				
			$MySmartBB->template->display( 'footer' );
		}
	}
	
	private function _mergeMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display( 'merge_users' );
	}

	private function _mergeStart()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->_POST['user_get'] 	= 	trim( $MySmartBB->_POST['user_get'] );
		$MySmartBB->_POST['user_to'] 	= 	trim( $MySmartBB->_POST['user_to'] );

		// ... //
		
		if (empty($MySmartBB->_POST['user_get'])
			or empty($MySmartBB->_POST['user_to']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['user_get'] . "'";
		
		$isMember = $MySmartBB->rec->getNumber();
		
		if ( $isMember <= 0 )
		{
			$MySmartBB->func->error('اسم العضو المراد اخذ بياناته غير موجود في قاعدة البيانات');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['user_to'] . "'";
		
		$isMember = $MySmartBB->rec->getNumber();
		
		if ( $isMember <= 0 )
		{
			$MySmartBB->func->error('اسم العضو المراد نقل البيانات له غير موجود في قاعدة البيانات');
		}
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['user_get'] . "'";
		
		$GetMemInfo = $MySmartBB->rec->getInfo();
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['user_to'] . "'";
		
		$ToMemInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		
		$MySmartBB->rec->fields 				= 	array();
		$MySmartBB->rec->fields['writer'] 	= 	$ToMemInfo['username'];
		
		$MySmartBB->rec->filter = "writer='" . $GetMemInfo['username'] . "'";
		
		$u_subject = $MySmartBB->rec->update();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
		
		$MySmartBB->rec->fields 			= 	array();
		$MySmartBB->rec->fields['writer'] 	= 	$ToMemInfo['username'];
		
		$MySmartBB->rec->filter = "writer='" . $GetMemInfo['username'] . "'";

		$u_reply = $MySmartBB->rec->update();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		
		$MySmartBB->rec->fields 				= 	array();
		$MySmartBB->rec->fields['posts'] 		= 	$ToMemInfo['posts']+$GetMemInfo['posts'];
		$MySmartBB->rec->fields['visitor'] 		= 	$ToMemInfo['visitor']+$GetMemInfo['visitor'];
		
		$MySmartBB->rec->filter = "username='" . $ToMemInfo['username'] . "'";
		
		$u_member = $MySmartBB->rec->update();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "id='" . $GetMemInfo['id'] . "'";
		
		$del = $MySmartBB->rec->delete();

		if ($u_subject
			and $u_reply
			and $u_member
			and $del)
		{
			$MySmartBB->func->msg('تم دمج بيانات العضو بنجاح');
			$MySmartBB->func->move('admin.php?page=member&control=1&main=1');
		}
	}
}

?>
