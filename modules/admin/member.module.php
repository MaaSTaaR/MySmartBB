<?php

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

include('common.php');
	
define('CLASS_NAME','MySmartMemberMOD');
	
class MySmartMemberMOD extends _functions
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
					$this->_AddMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_AddStart();
				}
			}
			elseif ($MySmartBB->_GET['control'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_ControlMain();
				}
			}
			elseif ($MySmartBB->_GET['merge'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_MergeMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_MergeStart();
				}

			}
			elseif ($MySmartBB->_GET['edit'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_EditMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_EditStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_DelMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_DelStart();
				}
			}
			elseif ($MySmartBB->_GET['search'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_SearchMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_SearchStart();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	function _AddMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('member_add');
	}
	
	function _AddStart()
	{
		global $MySmartBB;
					
		$MySmartBB->_POST['username'] 	= 	$MySmartBB->functions->CleanVariable($MySmartBB->_POST['username'],'trim');
		$MySmartBB->_POST['email'] 		= 	$MySmartBB->functions->CleanVariable($MySmartBB->_POST['email'],'trim');
		
		if (empty($MySmartBB->_POST['username']) 
			or empty($MySmartBB->_POST['password']) 
			or empty($MySmartBB->_POST['email']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!$MySmartBB->functions->CheckEmail($MySmartBB->_POST['email']))
		{
			$MySmartBB->functions->error('يرجى كتابة بريد إلكتروني صحيح');
		}
		
		if ($MySmartBB->member->IsMember(array('where' => array('username',$MySmartBB->_POST['username']))))
		{
			$MySmartBB->functions->error('اسم المستخدم موجود مسبقاً');
		}
		
		if ($MySmartBB->member->IsMember(array('where' => array('email',$MySmartBB->_POST['email']))))
		{
			$MySmartBB->functions->error('البريد الالكتروني مسجل مسبقاً');
		}
		
		if ($MySmartBB->_POST['username'] == 'Guest')
		{
			$MySmartBB->functions->error('لا يمكن التسجيل بهذا الاسم');
		}
		
		$MySmartBB->_POST['password'] = md5($MySmartBB->_POST['password']);
		
      	//////////
      	
      	// Get the information of default group to set username style cache
      	
		$GrpArr 			= 	array();
		$GrpArr['where'] 	= 	array('id',$MySmartBB->_CONF['info_row']['def_group']);
		
		$GroupInfo = $MySmartBB->group->GetGroupInfo($GrpArr);
		
		$style = $GroupInfo['username_style'];
		$username_style_cache = str_replace('[username]',$MySmartBB->_POST['username'],$style);
		
      	//////////
      	
		$InsertArr 					= 	array();
		$InsertArr['field']			=	array();
		
		$InsertArr['field']['username']				= 	$MySmartBB->_POST['username'];
		$InsertArr['field']['password']				= 	$MySmartBB->_POST['password'];
		$InsertArr['field']['email']				= 	$MySmartBB->_POST['email'];
		$InsertArr['field']['usergroup']			= 	4;
		$InsertArr['field']['user_gender']			= 	$MySmartBB->_POST['gender'];
		$InsertArr['field']['register_date']		= 	$MySmartBB->_CONF['now'];
		$InsertArr['field']['user_title']			= 	'عضو';
		$InsertArr['field']['style']				=	$MySmartBB->_CONF['info_row']['def_style'];
		$InsertArr['field']['username_style_cache']	=	$username_style_cache;
		$InsertArr['get_id']						=	true;
		
		$insert = $MySmartBB->member->InsertMember($InsertArr);
		
		if ($insert)
		{
			$member_num = $MySmartBB->member->GetMemberNumber(array('get_from'	=>	'cache'));
			
			$MySmartBB->cache->UpdateLastMember(array(	'username'		=>	$MySmartBB->_POST['username'],
      													'id'			=>	$MySmartBB->member->id,
      													'member_num'	=>	$member_num));

			$MySmartBB->functions->msg('تم اضافة العضو بنجاح');
			$MySmartBB->functions->goto('admin.php?page=member&amp;edit=1&amp;main=1&amp;id=' . $MySmartBB->member->id);
		}
	}
	
	function _ControlMain()
	{
		global $MySmartBB;
		
		$MemArr 					= 	array();
		$MemArr['order']			=	array();
		$MemArr['order']['field']	=	'id';
		$MemArr['order']['type']	=	'DESC';
		$MemArr['proc'] 			= 	array();
		$MemArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		
		$MySmartBB->_CONF['template']['while']['MembersList'] = $MySmartBB->member->GetMemberList($MemArr);
		
		$MySmartBB->template->display('members_main');
	}
	
	function _MergeMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('merge_users');
	}

	function _MergeStart()
	{
		global $MySmartBB;
		
		//////////
		
		$MySmartBB->_POST['user_get'] 	= 	$MySmartBB->functions->CleanVariable($MySmartBB->_POST['user_get'],'trim');
		$MySmartBB->_POST['user_to'] 	= 	$MySmartBB->functions->CleanVariable($MySmartBB->_POST['user_to'],'trim');

		//////////
		
		if (empty($MySmartBB->_POST['user_get'])
			or empty($MySmartBB->_POST['user_to']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}

		if (!$MySmartBB->member->IsMember(array('where' => array('username',$MySmartBB->_POST['user_get']))))
		{
			$MySmartBB->functions->error('اسم العضو المراد اخذ بياناته غير موجود في قاعدة البيانات');
		}
		
		if (!$MySmartBB->member->IsMember(array('where' => array('username',$MySmartBB->_POST['user_to']))))
		{
			$MySmartBB->functions->error('اسم العضو المراد نقل البيانات له غير موجود في قاعدة البيانات');
		}
		
		//////////
		
		$MemArr 			= 	array();
		$MemArr['get'] 		= 	'*';
		$MemArr['where'] 	= 	array('username',$MySmartBB->_POST['user_get']);

		$GetMemInfo = $MySmartBB->member->GetMemberInfo($MemArr);
		
		unset($MemArr);
		
		$MemArr 			= 	array();
		$MemArr['get'] 		= 	'*';
		$MemArr['where'] 	= 	array('username',$MySmartBB->_POST['user_to']);

		$ToMemInfo = $MySmartBB->member->GetMemberInfo($MemArr);
		
		//////////
		
		$UpdateSubjectArr 						= 	array();
		$UpdateSubjectArr['field'] 				= 	array();
		$UpdateSubjectArr['field']['writer'] 	= 	$ToMemInfo['username'];
		$UpdateSubjectArr['where'] 				= 	array('writer',$GetMemInfo['username']);

		$u_subject = $MySmartBB->subject->UpdateSubject($UpdateSubjectArr);
		
		$UpdateReplyArr 					= 	array();
		$UpdateReplyArr['field'] 			= 	array();
		$UpdateReplyArr['field']['writer'] 	= 	$ToMemInfo['username'];
		$UpdateReplyArr['where'] 			= 	array('writer',$GetMemInfo['username']);

		$u_reply = $MySmartBB->reply->UpdateReply($UpdateReplyArr);

		$UpdateMemberArr 						= 	array();
		$UpdateMemberArr['field'] 				= 	array();
		$UpdateMemberArr['field']['posts'] 		= 	$ToMemInfo['posts']+$GetMemInfo['posts'];
		$UpdateMemberArr['field']['visitor'] 	= 	$ToMemInfo['visitor']+$GetMemInfo['visitor'];
		$UpdateMemberArr['where'] 				= 	array('username',$ToMemInfo['username']);

		$u_member = $MySmartBB->member->UpdateMember($UpdateMemberArr);

		$DelArr 			= 	array();
		$DelArr['where'] 	= 	array('id',$GetMemInfo['id']);

		$del = $MySmartBB->member->DeleteMember($DelArr);

		if ($u_subject
			and $u_reply
			and $u_member
			and $del)
		{
			$MySmartBB->functions->msg('تم دمج بيانات العضو بنجاح');
			$MySmartBB->functions->goto('admin.php?page=member&control=1&main=1');
		}
	}
	 
	function _EditMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		//////////
		
		// Get styles list
		$StyleArr 							= 	array();
		$StyleArr['order']					=	array();
		$StyleArr['order']['field']			=	'id';
		$StyleArr['order']['type']			=	'DESC';
		
		$StyleArr['proc']					=	array();
		$StyleArr['*']						=	array('method'=>'clean','param'=>'html');
		
		// Store information in "StyleList"
		$MySmartBB->_CONF['template']['while']['StyleList'] = $MySmartBB->style->GetStyleList($StyleArr);
		
		//////////
		
		// Get groups list
		$GroupArr 							= 	array();
		
		$AdsArr['order']					=	array();
		$AdsArr['order']['field']			=	'id';
		$AdsArr['order']['type']			=	'DESC';
		
		$GroupArr['proc'] 					= 	array();
		$GroupArr['proc']['*'] 				= 	array('method'=>'clean','param'=>'html');
		
		// Store information in "GroupList"
		$MySmartBB->_CONF['template']['while']['GroupList'] = $MySmartBB->group->GetGroupList($GroupArr);
		
		//////////
		
		$MySmartBB->template->display('member_edit');
		
		//////////
	}
	
	function _EditStart()
	{
		global $MySmartBB;
		
		$MemInfo = false;
		
		$this->check_by_id($MemInfo);
		
		if (empty($MySmartBB->_POST['email']) 
			or empty($MySmartBB->_POST['user_title'])
			or !isset($MySmartBB->_POST['posts']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		if (!$MySmartBB->functions->CheckEmail($MySmartBB->_POST['email']))
		{
			$MySmartBB->functions->error('يرجى كتابة بريد إلكتروني صحيح');
		}
		
		if ($MySmartBB->member->IsMember(array('where' => array('username',$MySmartBB->_POST['new_username']))))
		{
			$MySmartBB->functions->error('اسم المستخدم موجود مسبقاً');
		}
		
		if ($MySmartBB->_POST['username'] == 'Guest')
		{
			$MySmartBB->functions->error('لا يمكن التسجيل بهذا الاسم');
		}
		
		//////////
		
		$username = (!empty($MySmartBB->_POST['new_username'])) ? $MySmartBB->_POST['new_username'] : $MemInfo['username'];
		
		//////////
		
		// If the admin change the group of this member, so we should change the cache of username style
		
		if ($MySmartBB->_POST['usergroup'] != $MemInfo['usergroup'])
		{
			$GrpArr 			= 	array();
			$GrpArr['where'] 	= 	array('id',$MySmartBB->_POST['usergroup']);
			
			$GroupInfo = $MySmartBB->group->GetGroupInfo($GrpArr);
			
			$style = $GroupInfo['username_style'];
			$username_style_cache = str_replace('[username]',$username,$style);			
		}
		else
		{
			$username_style_cache = null;
		}
		
		//////////
		
		$UpdateArr 				= 	array();
		$UpdateArr['field'] 	= 	array();
		
		$UpdateArr['field']['username'] 			= 	$username;
		$UpdateArr['field']['password'] 			= 	(!empty($MySmartBB->_POST['new_password'])) ? md5($MySmartBB->_POST['new_password']) : $MemInfo['password'];
		$UpdateArr['field']['email'] 				= 	$MySmartBB->_POST['email'];
		$UpdateArr['field']['user_gender'] 			= 	$MySmartBB->_POST['gender'];
		$UpdateArr['field']['style'] 				= 	$MySmartBB->_POST['style'];
		$UpdateArr['field']['avater_path'] 			= 	$MySmartBB->_POST['avater_path'];
		$UpdateArr['field']['user_info'] 			= 	$MySmartBB->_POST['user_info'];
		$UpdateArr['field']['user_title'] 			= 	$MySmartBB->_POST['user_title'];
		$UpdateArr['field']['posts'] 				= 	$MySmartBB->_POST['posts'];
		$UpdateArr['field']['user_website'] 		= 	$MySmartBB->_POST['user_website'];
		$UpdateArr['field']['user_country'] 		= 	$MySmartBB->_POST['user_country'];
		$UpdateArr['field']['usergroup'] 			= 	$MySmartBB->_POST['usergroup'];
		$UpdateArr['field']['username_style_cache']	=	$username_style_cache;
		$UpdateArr['where']							=	array('id',$MemInfo['id']);
		
		$update = $MySmartBB->member->UpdateMember($UpdateArr);
		
		if (!empty($MySmartBB->_POST['new_username']))
		{
			// TODO ;;;
			// Don't forget the cache of username style here
		}
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث بيانات العضو بنجاح');
			$MySmartBB->functions->goto('admin.php?page=member&amp;control=1&amp;main=1');
		}
	}
	
	function _DelMain()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$MySmartBB->template->display('member_del');
	}
	
	function _DelStart()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF['template']['Inf'] = false;
		
		$this->check_by_id($MySmartBB->_CONF['template']['Inf']);
		
		$DelArr 			= 	array();
		$DelArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$del = $MySmartBB->member->DeleteMember($DelArr);
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف العضو بنجاح !');
			$MySmartBB->functions->goto('admin.php?page=member&amp;control=1&amp;main=1');
		}
	}
	
	function _SearchMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('member_search_main');
	}
	
	function _SearchStart()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['keyword']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$GetArr 		= array();
		$GetArr['get'] 	= 'id,username';
		
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
		
		$GetArr['where'] = array($field,$MySmartBB->_POST['keyword']);
		
		$MySmartBB->_CONF['template']['MemInfo'] = $MySmartBB->member->GetMemberInfo($GetArr);
		
		if ($MySmartBB->_CONF['template']['MemInfo'] == false)
		{
			$MySmartBB->functions->error('لا يوجد نتائج');
		}
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['MemInfo'],'html');
				
		$MySmartBB->template->display('member_search_result');
	}
}

class _functions
{
	function check_by_id(&$MemInfo)
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره .. الطلب غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$MemArr 			= 	array();
		$MemArr['get'] 		= 	'*';
		$MemArr['where'] 	= 	array('id',$MySmartBB->_GET['id']);
		
		$MemInfo = $MySmartBB->member->GetMemberInfo($MemArr);
		
		if ($MemInfo == false)
		{
			$MySmartBB->functions->error('العضو المطلوب غير موجود');
		}
		
		$MySmartBB->functions->CleanVariable($MemInfo,'html');
		$MySmartBB->functions->CleanVariable($MemInfo,'sql');
	}
}

?>
