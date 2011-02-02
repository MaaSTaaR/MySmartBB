<?php

/** PHP5 **/

/****
			We have something TODO in this file
*****/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['CACHE'] 		= 	true;
$CALL_SYSTEM['STYLE'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');
	
define('CLASS_NAME','MySmartMemberMOD');
	
class MySmartMemberMOD extends _func
{
	function run()
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
			elseif ($MySmartBB->_GET['merge'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_mergeMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_mergeStart();
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
			elseif ($MySmartBB->_GET['search'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_searchMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_searchStart();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _addMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('member_add');
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
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['username'] . "'";
		
		$isMember = $MySmartBB->member->isMember();
		
		if ( $isMember )
		{
			$MySmartBB->func->error('اسم المستخدم موجود مسبقاً');
		}
		
		// Ensure there is no person used the same email
		$MySmartBB->rec->filter = "email='" . $MySmartBB->_POST['email'] . "'";
		
		$isMember = $MySmartBB->member->isMember();
		
		if ( $isMember )
		{
			$MySmartBB->func->error('البريد الالكتروني مسجل مسبقاً');
		}
		
		if ($MySmartBB->_POST['username'] == 'Guest')
		{
			$MySmartBB->func->error('لا يمكن التسجيل بهذا الاسم');
		}
		
		$MySmartBB->_POST['password'] = md5($MySmartBB->_POST['password']);
		
      	/* ... */
      	
      	// Get the information of default group to set username style cache
      	
		$MySmartBB->rec->filter = "id='4'";
		
		$GroupInfo = $MySmartBB->group->getGroupInfo();
		
		$style = $GroupInfo['username_style'];
		$username_style_cache = str_replace('[username]',$MySmartBB->_POST['username'],$style);
		
      	/* ... */
      	
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
		
		$MySmartBB->member->get_id = true;
		
		$insert = $MySmartBB->member->insertMember();
		
		if ($insert)
		{
			$MySmartBB->cache->updateLastMember( $MySmartBB->_CONF['info_row']['member_number'] , $MySmartBB->_POST['username'], $MySmartBB->member->id );

			$MySmartBB->func->msg('تم اضافة العضو بنجاح');
			$MySmartBB->func->goto('admin.php?page=member&amp;edit=1&amp;main=1&amp;id=' . $MySmartBB->member->id);
		}
	}
	
	private function _controlMain()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->order = "id DESC";
		
		$MySmartBB->member->getMemberList();
		
		$MySmartBB->template->display('members_main');
	}
	
	private function _MergeMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('merge_users');
	}

	private function _MergeStart()
	{
		global $MySmartBB;
		
		/* ... */
		
		$MySmartBB->_POST['user_get'] 	= 	trim( $MySmartBB->_POST['user_get'] );
		$MySmartBB->_POST['user_to'] 	= 	trim( $MySmartBB->_POST['user_to'] );

		/* ... */
		
		if (empty($MySmartBB->_POST['user_get'])
			or empty($MySmartBB->_POST['user_to']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['user_get'] . "'";
		
		$isMember = $MySmartBB->member->isMember();
		
		if ( !$isMember )
		{
			$MySmartBB->func->error('اسم العضو المراد اخذ بياناته غير موجود في قاعدة البيانات');
		}
		
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['user_to'] . "'";
		
		$isMember = $MySmartBB->member->isMember();
		
		if ( !$isMember )
		{
			$MySmartBB->func->error('اسم العضو المراد نقل البيانات له غير موجود في قاعدة البيانات');
		}
		
		/* ... */
		
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['user_get'] . "'";
		
		$GetMemInfo = $MySmartBB->member->getMemberInfo();
		
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['user_to'] . "'";
		
		$ToMemInfo = $MySmartBB->member->getMemberInfo();
		
		/* ... */
		
		$MySmartBB->rec->fields 				= 	array();
		$MySmartBB->rec->fields['writer'] 	= 	$ToMemInfo['username'];
		
		$MySmartBB->rec->filter = "writer='" . $GetMemInfo['username'] . "'";
		
		$u_subject = $MySmartBB->subject->updateSubject();
		
		/* ... */
		
		$MySmartBB->rec->fields 			= 	array();
		$MySmartBB->rec->fields['writer'] 	= 	$ToMemInfo['username'];
		
		$MySmartBB->rec->filter = "writer='" . $GetMemInfo['username'] . "'";

		$u_reply = $MySmartBB->reply->updateReply();
		
		/* ... */
		
		$MySmartBB->rec->fields 				= 	array();
		$MySmartBB->rec->fields['posts'] 		= 	$ToMemInfo['posts']+$GetMemInfo['posts'];
		$MySmartBB->rec->fields['visitor'] 		= 	$ToMemInfo['visitor']+$GetMemInfo['visitor'];
		
		$MySmartBB->rec->filter = "username='" . $ToMemInfo['username'] . "'";
		
		$u_member = $MySmartBB->member->updateMember();
		
		/* ... */
		
		$MySmartBB->rec->filter = "id='" . $GetMemInfo['id'] . "'";
		
		$del = $MySmartBB->member->deleteMember();

		if ($u_subject
			and $u_reply
			and $u_member
			and $del)
		{
			$MySmartBB->func->msg('تم دمج بيانات العضو بنجاح');
			$MySmartBB->func->goto('admin.php?page=member&control=1&main=1');
		}
	}
	 
	private function _editMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		/* ... */
		
		// Get styles list
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'style_res' ] = '';
		
		$MySmartBB->rec->order = 'id DESC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'style_res' ];
		
		$MySmartBB->style->getStyleList();
		
		/* ... */
		
		// Get groups list
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'group_res' ] = '';
		
		$MySmartBB->rec->order = 'id DESC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'group_res' ];
		
		$MySmartBB->group->getGroupList();
		
		/* ... */
		
		$MySmartBB->template->display('member_edit');
		
		/* ... */
	}
	
	private function _editStart()
	{
		global $MySmartBB;
		
		$MemInfo = false;
		
		$this->check_by_id($MemInfo);
		
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
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_POST['new_username'] . "'";
		
		$isMember = $MySmartBB->member->isMember();
		
		if ( $isMember )
		{
			$MySmartBB->func->error('اسم المستخدم موجود مسبقاً');
		}

		if ($MySmartBB->_POST['username'] == 'Guest')
		{
			$MySmartBB->func->error('لا يمكن التسجيل بهذا الاسم');
		}
		
		/* ... */
		
		$username = (!empty($MySmartBB->_POST['new_username'])) ? $MySmartBB->_POST['new_username'] : $MemInfo['username'];
		
		/* ... */
		
		// If the admin change the group of this member, so we should change the cache of username style
		
		if ($MySmartBB->_POST['usergroup'] != $MemInfo['usergroup'])
		{
			$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST['usergroup'] . "'";
			
			$GroupInfo = $MySmartBB->group->getGroupInfo();
			
			$style = $GroupInfo['username_style'];
			$username_style_cache = str_replace('[username]',$username,$style);			
		}
		else
		{
			$username_style_cache = null;
		}
		
		/* ... */
		
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
		$MySmartBB->rec->fields['review_subject'] 		= 	$MySmartBB->_POST['review_subject'];
		$MySmartBB->rec->fields['username_style_cache']	=	$username_style_cache;
		
		$MySmartBB->rec->filter = "id='" . $MemInfo['id'] . "'";
		
		$update = $MySmartBB->member->updateMember();
		
		if (!empty($MySmartBB->_POST['new_username']))
		{
			// TODO ;;;
			// Don't forget the cache of username style here
		}
		
		if ($update)
		{
			$MySmartBB->func->msg('تم تحديث بيانات العضو بنجاح');
			$MySmartBB->func->goto('admin.php?page=member&amp;control=1&amp;main=1');
		}
	}
	
	private function _delMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('member_del');
	}
	
	private function _delStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['id'] . "'";
		
		$del = $MySmartBB->member->deleteMember();
		
		if ($del)
		{
			$MySmartBB->func->msg('تم حذف العضو بنجاح !');
			$MySmartBB->func->goto('admin.php?page=member&amp;control=1&amp;main=1');
		}
	}
	
	private function _searchMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('member_search_main');
	}
	
	private function _searchStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['keyword']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		if ($MySmartBB->_POST['search_by'] == 'username')
		{
			$field = 'username';
		}
		elseif ($MySmartBB->_POST['search_by'] == 'email')
		{
			$field = 'email';
		}
		else
		{
			$field = 'id';
		}
		
		$MySmartBB->rec->filter = $field . "='" . $MySmartBB->_POST['keyword'] . "'";
		
		$MySmartBB->_CONF['template']['MemInfo'] = $MySmartBB->member->getMemberInfo();
		
		if ($MySmartBB->_CONF['template']['MemInfo'] == false)
		{
			$MySmartBB->func->error('لا يوجد نتائج');
		}
				
		$MySmartBB->template->display('member_search_result');
	}
}

class _func
{
	function check_by_id(&$MemInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$MemInfo = $MySmartBB->member->getMemberInfo();
		
		if ($MemInfo == false)
		{
			$MySmartBB->func->error('العضو المطلوب غير موجود');
		}
	}
}

?>
