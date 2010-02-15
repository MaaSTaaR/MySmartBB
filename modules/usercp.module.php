<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_FUNCTIONS',true);
define('JAVASCRIPT_SMARTCODE',true);

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['ICONS'] 		= 	true;
$CALL_SYSTEM['TOOLBOX'] 	= 	true;
$CALL_SYSTEM['REQUEST'] 	= 	true;
$CALL_SYSTEM['MASSEGE'] 	= 	true;
$CALL_SYSTEM['AVATAR'] 		= 	true;
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['BOOKMARK'] 	= 	true;

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartUserCPMOD');

class MySmartUserCPMOD
{
	function run()
	{
		global $MySmartBB;
		
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->functions->error('المعذره .. هذه المنطقه للاعضاء فقط');
		}
		
		if ( isset( $MySmartBB->_GET['index'] ) )
		{
			$this->_Index();
		}
		
		/** Control **/
		elseif ( isset( $MySmartBB->_GET['control'] ) )
		{
			/** Persenol Information control **/
			if ( isset( $MySmartBB->_GET['info'] ) )
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_InfoMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_InfoChange();
				}
			}
			/** **/
			
			/** Options control **/
			elseif ( isset( $MySmartBB->_GET['setting'] ) )
			{
				if ($MySmartBB->_GET['main'])				
				{
					$this->_SettingMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_SettingChange();
				}
			}
			/** **/
			
			/** Signature control **/
			elseif ( isset( $MySmartBB->_GET['sign'] ) )
			{
				if (!$MySmartBB->_CONF['group_info']['sig_allow'])
				{
					$MySmartBB->functions->error('المعذره .. لا يمكنك استخدام هذه الميزه');
				}
				
				if ($MySmartBB->_GET['main'])
				{
					$this->_SignMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_SignChange();
				}
				elseif ($MySmartBB->_GET['subject'])
				{
					$this->_SignSubjectMain();
				}
				elseif ($MySmartBB->_GET['subject_start'])
				{
					$this->_SignSubjectChange();
				}
				elseif ($MySmartBB->_GET['reply'])
				{
					$this->_SignReplyMain();
				}
				elseif ($MySmartBB->_GET['reply_start'])
				{
					$this->_SignReplyChange();
				}
			}
			/** **/
			
			/** Password control **/
			elseif ( isset( $MySmartBB->_GET['password'] ) )
			{
				if ($MySmartBB->_GET['main'])				
				{
					$this->_PasswordMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_PasswordChange();
				}
			}
			/** **/
			
			/** Email control **/
			elseif ( isset( $MySmartBB->_GET['email'] ) )
			{
				if ($MySmartBB->_GET['main'])				
				{
					$this->_EmailMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_EmailChange();
				}
			}
			/** **/
			
			/** Avatar control **/
			elseif ($MySmartBB->_GET['avatar'])
			{
				if ($MySmartBB->_GET['main'])				
				{
					$this->_AvatarMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_AvatarChange();
				}
			}
			/** **/
		}
		/** **/
		
		/** Options **/
		elseif ( isset( $MySmartBB->_GET['options'] ) )
		{
			if ( isset( $MySmartBB->_GET['reply'] ) )
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_ReplyListMain();
				}
			}
			elseif ($MySmartBB->_GET['subject'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_SubjectListMain();
				}
			}
		}
		/** **/
		
		/** Bookmarks **/
		elseif ($MySmartBB->_GET['bookmark'])
		{
			if (!$MySmartBB->_CONF['info_row']['bookmark_feature'])
			{
				$MySmartBB->functions->error('المعذره .. خاصية مفضلة المواضيع موقوفة حاليا');
			}
			
			if ($MySmartBB->_GET['add'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_BookmarkAddMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_BookmarkAddStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				$this->_BookmarkDelStart();
			}
			elseif ($MySmartBB->_GET['show'])
			{
				$this->_BookmarkShow();
			}
		}
		/** **/
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->functions->GetFooter();
	}
	
	function _Index()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('لوحة تحكم العضو');
		
		//////////
		
		$ReplyArr 								= 	array();
		$ReplyArr['where'] 						= 	array();
		
		$ReplyArr['select']						=	'DISTINCT subject_id';
		
		$ReplyArr['where'][0] 					= 	array();
		$ReplyArr['where'][0]['name'] 			= 	'writer';
		$ReplyArr['where'][0]['oper'] 			= 	'=';
		$ReplyArr['where'][0]['value'] 			= 	$MySmartBB->_CONF['rows']['member_row']['username'];
		
		$ReplyArr['order'] 						=	 array();
		$ReplyArr['order']['field'] 			= 	'id';
		$ReplyArr['order']['type'] 				= 	'DESC';
		
		$ReplyArr['limit'] 						= 	'5';
		
		$ReplyArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$ReplyArr['proc']['write_time'] 		= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		
		$MySmartBB->_CONF['template']['while']['MemberReplys'] = $MySmartBB->subject->GetSubjectList($ReplyArr);
			
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['MemberReplys'],'html');
		
		//////////
		
		$SubjectArr 							= 	array();
		$SubjectArr['where'] 					= 	array();
		
		$SubjectArr['where'][0] 				= 	array();
		$SubjectArr['where'][0]['name'] 		= 	'writer';
		$SubjectArr['where'][0]['oper'] 		= 	'=';
		$SubjectArr['where'][0]['value'] 		= 	$MySmartBB->_CONF['rows']['member_row']['username'];
		
		$SubjectArr['order'] 					=	 array();
		$SubjectArr['order']['field'] 			= 	'id';
		$SubjectArr['order']['type'] 			= 	'DESC';
		
		$SubjectArr['limit'] 					= 	'5';
		
		$SubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$SubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		
		$MySmartBB->_CONF['template']['while']['MemberSubjects'] = $MySmartBB->subject->GetSubjectList($SubjectArr);
			
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['MemberSubjects'],'html');
		
      	$MySmartBB->template->display('usercp_index');
	}
	
	function _InfoMain()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تحرير المعلومات الشخصيه');
		
		$MySmartBB->template->display('usercp_control_info');
	}
	
	function _InfoChange()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية التحديث');
		
		$MySmartBB->functions->AddressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');
		
		$StartArr 			= 	array();
		$StartArr['field'] 	= 	array();
		
		$StartArr['field']['user_country'] 	= 	$MySmartBB->_POST['country'];
		$StartArr['field']['user_website'] 	= 	$MySmartBB->_POST['website'];
		$StartArr['field']['user_info'] 	= 	$MySmartBB->_POST['info'];
		$StartArr['field']['away'] 			= 	$MySmartBB->_POST['away'];
		$StartArr['field']['away_msg'] 		= 	$MySmartBB->_POST['away_msg'];
		$StartArr['where']					=	array('id',$MySmartBB->_CONF['member_row']['id']);
		
		$StartChange = $MySmartBB->member->UpdateMember($StartArr);
		
		if ($StartChange)
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح');
			$MySmartBB->functions->goto('index.php?page=usercp&amp;control=1&amp;info=1&amp;main=1');
		}
	}
	
	function _SettingMain()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تحرير خياراتك الخاصه');
		
		$GetStyleArr 						= 	array();
		
		$GetStyleArr['order'] 				= 	array();
		$GetStyleArr['order']['field'] 		= 	'style_order';
		$GetStyleArr['order']['type'] 		= 	'ASC';
		
		$MySmartBB->_CONF['template']['while']['StyleList'] = $MySmartBB->style->GetStyleList($GetStyleArr);
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['StyleList'],'html');
		
		$MySmartBB->template->display('usercp_control_setting');
	}
		
	function _SettingChange()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية التحديث');
		
		$MySmartBB->functions->AddressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');
		
		$UpdateArr 					= 	array();
		$UpdateArr['field']			=	array();
		
		$UpdateArr['field']['style'] 		= 	$MySmartBB->_POST['style'];
		$UpdateArr['field']['hide_online'] 	= 	$MySmartBB->_POST['hide_online'];
		$UpdateArr['field']['user_time'] 	= 	$MySmartBB->_POST['user_time'];
		$UpdateArr['field']['send_allow'] 	= 	$MySmartBB->_POST['send_allow'];
		$UpdateArr['where']					=	array('id',$MySmartBB->_CONF['member_row']['id']);
		
		$UpdateSetting = $MySmartBB->member->UpdateMember($UpdateArr);
		
		if ($UpdateSetting)
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح');
			$MySmartBB->functions->goto('index.php?page=usercp&amp;control=1&amp;setting=1&amp;main=1',2);
		}
	}
	
	function _SignMain()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تحرير توقيعك الخاص');
		
		$MySmartBB->functions->GetEditorTools();
		
		$MySmartBB->_CONF['template']['Sign'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['rows']['member_row']['user_sig']);
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['Sign']);
		
		$MySmartBB->template->display('usercp_control_sign');
	}
		
	function _SignChange()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية التحديث');
		
		$MySmartBB->functions->AddressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');
		
		$MySmartBB->_POST['text'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['text'],'trim');
		
		$SignArr 				= 	array();
		$SignArr['field']		=	array();
		
		$SignArr['field']['user_sig'] 	= 	$MySmartBB->_POST['text'];
		$SignArr['where']				=	array('id',$MySmartBB->_CONF['member_row']['id']);
		
		$UpdateSign = $MySmartBB->member->UpdateMember($SignArr);
			
		if ($UpdateSign)
		{
			$MySmartBB->functions->msg('تم تحديث التوقيع بنجاح !');
			$MySmartBB->functions->goto('index.php?page=usercp&amp;control=1&amp;sign=1&amp;main=1');
		}
	}
	
	function _SignSubjectMain()
	{
		global $MySmartBB;

		$MySmartBB->functions->ShowHeader('تحرير توقيعك الإفتراضي للمواضيع');

		$MySmartBB->functions->GetEditorTools();

		$MySmartBB->_CONF['template']['Sign'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['rows']['member_row']['subject_sig']);
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['Sign']);

		$MySmartBB->template->display('usercp_control_signsubject');
	}
	
	function _SignSubjectChange()
	{
		global $MySmartBB;

		$MySmartBB->functions->ShowHeader('تنفيذ عملية التحديث');

		$MySmartBB->functions->AddressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');

		$MySmartBB->_POST['text'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['text'],'trim');

		$SignArr = array();
		$SignArr['field'] = array();

		$SignArr['field']['subject_sig'] = $MySmartBB->_POST['text'];
		$SignArr['where'] = array('id',$MySmartBB->_CONF['member_row']['id']);

		$UpdateSign = $MySmartBB->member->UpdateMember($SignArr);

		if ($UpdateSign)
		{
			$MySmartBB->functions->msg('تم تحديث التوقيع الإفتراضي للمواضيع بنجاح !');
			$MySmartBB->functions->goto('index.php?page=usercp&control=1&subjects=1&main=1');
		}
	}
	
	function _SignReplyMain()
	{
		global $MySmartBB;

		$MySmartBB->functions->ShowHeader('تحرير توقيعك الإفتراضي الخاص بالردود');

		$MySmartBB->functions->GetEditorTools();

		$MySmartBB->_CONF['template']['Sign'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['rows']['member_row']['reply_sig']);
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['Sign']);

		$MySmartBB->template->display('usercp_control_signreply');
	}
	
	function _SignReplyChange()
	{
		global $MySmartBB;

		$MySmartBB->functions->ShowHeader('تنفيذ عملية التحديث');

		$MySmartBB->functions->AddressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');

		$MySmartBB->_POST['text'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['text'],'trim');

		$SignArr = array();
		$SignArr['field'] = array();

		$SignArr['field']['reply_sig'] = $MySmartBB->_POST['text'];
		$SignArr['where'] = array('id',$MySmartBB->_CONF['member_row']['id']);

		$UpdateSign = $MySmartBB->member->UpdateMember($SignArr);

		if ($UpdateSign)
		{
			$MySmartBB->functions->msg('تم تحديث التوقيع الإفتراضي للردود بنجاح !');
			$MySmartBB->functions->goto('index.php?page=usercp&control=1&replays=1&main=1');
		}
	}
		
	function _PasswordMain()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تغيير كلمة السر');
		
		$MySmartBB->template->display('usercp_control_password');
	}
	
	function _PasswordChange()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ العمليه');
		
		$MySmartBB->functions->AddressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ العمليه');
		
		//////////
		
		// Check if the information aren't empty
		if (empty($MySmartBB->_POST['old_password']) 
			or empty($MySmartBB->_POST['new_password']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		//////////
		
		// Clean the information from white spaces (only in the begin and in the end)
		$MySmartBB->_POST['old_password'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['old_password'],'trim');
		$MySmartBB->_POST['new_password'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['new_password'],'trim');
		
		//////////
		
		// Convert password to md5
		$MySmartBB->_POST['old_password'] = md5($MySmartBB->_POST['old_password']);
		$MySmartBB->_POST['new_password'] = md5($MySmartBB->_POST['new_password']);
		
		//////////
		
		// Ensure if the password is correct or not
		$PassArr 				= 	array();
		$PassArr['username'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		$PassArr['password'] 	= 	$MySmartBB->_POST['old_password'];
		
		$CheckPasswordCorrect = $MySmartBB->member->CheckMember($PassArr);
		
		// The password isn't correct, print error message
		if (!$CheckPasswordCorrect)
		{
			$MySmartBB->functions->error('المعذره .. كلمة المرور التي قمت بكتابتها غير صحيحه');
		}
		
		//////////
		
		if ($MySmartBB->_CONF['info_row']['confirm_on_change_pass'])
		{
			$Adress	= 	$MySmartBB->functions->GetForumAdress();
			$Code	=	$MySmartBB->functions->RandomCode();
			
			$ChangeAdress = $Adress . 'index.php?page=new_password&index=1&code=' . $Code;
			$CancelAdress = $Adress . 'index.php?page=cancel_requests&index=1&type=1&code=' . $Code;
		
			$ReqArr 					= 	array();
			$ReqArr['field']			=	array();
			
			$ReqArr['field']['random_url'] 		= 	$Code;
			$ReqArr['field']['username'] 		= 	$MySmartBB->_CONF['rows']['member_rows']['username'];
			$ReqArr['field']['request_type'] 	= 	1;
		
			$InsertReq = $MySmartBB->request->InsertRequest($ReqArr);
		
			if ($InsertReq)
			{
				$UpdateArr 				= 	array();
				$UpdateArr['field']		= 	array();
			
				$UpdateArr['field']['new_password'] 	= 	$MySmartBB->_POST['new_password'];
				$UpdateArr['where'] 					= 	array('id',$MySmartBB->_CONF['member_row']['id']);
			
				$UpdateNewPassword = $MySmartBB->member->UpdateMember($UpdateArr);
			
				if ($UpdateNewPassword)
				{
					$MsgArr 			= 	array();
					$MsgArr['where'] 	= 	array('id','1');
					
					$MassegeInfo = $MySmartBB->massege->GetMessageInfo($MsgArr);
				
					$MsgArr = array();
				
					$MsgArr['text'] 		= 	$MassegeInfo['text'];
					$MsgArr['change_url'] 	= 	$ChangeAdress;
					$MsgArr['cancel_url'] 	= 	$CancelAdress;
					$MsgArr['username']		=	$MySmartBB->_CONF['member_row']['username'];
					$MsgArr['title']		=	$MySmartBB->_CONF['info_row']['title'];
					
					$MassegeInfo['text'] = $MySmartBB->massege->MessageProccess($MsgArr);
					
					$Send = $MySmartBB->functions->mail($MySmartBB->_CONF['rows']['member_row']['email'],$MassegeInfo['title'],$MassegeInfo['text'],$MySmartBB->_CONF['info_row']['send_email']);
					
					if ($Send)
					{
						$MySmartBB->functions->msg('تم ارسال رسالة التأكيد إلى بريدك الالكتروني , يرجى مراجعته');
						$MySmartBB->functions->goto('index.php?page=usercp&index=1');
					}
				}
			}
		}
		else
		{
			$PassArr 				= 	array();
			$PassArr['field']		=	array();
			
			$PassArr['field']['password'] 	= 	md5($MySmartBB->_POST['new_password']);
			$PassArr['where'] 				= 	array('id',$MySmartBB->_CONF['member_row']['id']);
		
			$UpdatePassword = $MySmartBB->member->UpdateMember($PassArr);
		
			if ($UpdatePassword)
			{
				$MySmartBB->functions->msg('تم التحديث بنجاح !');
				$MySmartBB->functions->goto('index.php?page=usercp&amp;control=1&amp;password=1&amp;main=1');
			}
		}
	}
	
	function _EmailMain()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تغيير البريد الالكتروني');
		
		$MySmartBB->template->display('usercp_control_email');
	}
	
	function _EmailChange()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ العمليه');
		
		$MySmartBB->functions->AddressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ العمليه');
		
		$EmailArr = array();
		$EmailArr['where']	=	array('email',$MySmartBB->_POST['new_email']);
		
		$EmailExists = $MySmartBB->member->IsMember($EmailArr);
		
		if (empty($MySmartBB->_POST['new_email']))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		if (!$MySmartBB->functions->CheckEmail($MySmartBB->_POST['new_email']))
		{
			$MySmartBB->functions->error('يرجى كتابة بريدك الالكتروني الصحيح');
		}
		if ($EmailExists)
		{
			$MySmartBB->functions->error('المعذره .. البريد الالكتروني موجود مسبقاً');
		}
		
		$MySmartBB->_POST['new_email'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['new_email'],'trim');
		
		// We will send a confirm message, The confirm message will help user protect himself from crack
		if ($MySmartBB->_CONF['info_row']['confirm_on_change_mail'])
		{
			$Adress	= 	$MySmartBB->functions->GetForumAdress();
			$Code	=	$MySmartBB->functions->RandomCode();
		
			$ChangeAdress = $Adress . 'index.php?page=new_email&index=1&code=' . $Code;
			$CancelAdress = $Adress . 'index.php?page=cancel_requests&index=1&type=2&code=' . $Code;
		
			$ReqArr 			= 	array();
			$ReqArr['field'] 	= 	array();
			
			$ReqArr['field']['random_url'] 		= 	$Code;
			$ReqArr['field']['username'] 		= 	$MySmartBB->_CONF['member_rows']['username'];
			$ReqArr['field']['request_type'] 	= 	2;
		
			$InsertReq = $MySmartBB->request->InsertRequest($ReqArr);
		
			if ($InsertReq)
			{
				$UpdateArr = array();
			
				$UpdateArr['email'] 	= 	$MySmartBB->_POST['new_email'];
				$UpdateArr['where'] 	= 	array('id',$MySmartBB->_CONF['member_row']['id']);
			
				$UpdateNewEmail = $MySmartBB->member->UpdateNewEmail($UpdateArr);
			
				if ($UpdateNewEmail)
				{
					$MassegeInfo = $MySmartBB->massege->GetMessageInfo(array('id'	=>	2));
			
					$MsgArr = array();
					$MsgArr['text'] 		= 	$MassegeInfo['text'];
					$MsgArr['change_url'] 	= 	$ChangeAdress;
					$MsgArr['cancel_url'] 	= 	$CancelAdress;
					$MsgArr['username']		=	$MySmartBB->_CONF['member_row']['username'];
					$MsgArr['title']		=	$MySmartBB->_CONF['info_row']['title'];
				
					$MassegeInfo['text'] = $MySmartBB->massege->MessageProccess($MsgArr);
				
					$Send = $MySmartBB->functions->mail($MySmartBB->_CONF['rows']['member_row']['email'],$MassegeInfo['title'],$MassegeInfo['text'],$MySmartBB->_CONF['info_row']['send_email']);
				
					if ($Send)
					{
						$MySmartBB->functions->msg('تم ارسال رسالة التأكيد إلى بريدك الالكتروني , يرجى مراجعته');
						$MySmartBB->functions->goto('index.php?page=usercp&index=1');
					}
				}
			}
		}
		// Confirm message is off, so change email direct
		else
		{
			$EmailArr 			= 	array();
			$EmailArr['field']	=	array();
		
			$EmailArr['field']['email'] 	= 	$MySmartBB->_POST['new_email'];
			$EmailArr['where'] 				= 	array('id',$MySmartBB->_CONF['member_row']['id']);
		
			$UpdateEmail= $MySmartBB->member->UpdateMember($EmailArr);
		
			if ($UpdateEmail)
			{
				$MySmartBB->functions->msg('تم التحديث بنجاح !');
				$MySmartBB->functions->goto('index.php?page=usercp&amp;control=1&amp;email=1&amp;main=1');
			}
		}
	}
	
	function _AvatarMain()
	{
		global $MySmartBB;
		
		// This line will include jQuery (Javascript library)
		$MySmartBB->template->assign('JQUERY',true);
		
		$MySmartBB->functions->ShowHeader('الصوره الشخصيه');
				
		// Stop this feature if it's not allowed
		if (!$MySmartBB->_CONF['info_row']['allow_avatar'])
		{
			$MySmartBB->functions->error('المعذره .. لا يمكنك استخدام هذه الميزه');
		}
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$AvaArr 					= 	array();
		$AvaArr['proc'] 			= 	array();
		$AvaArr['proc']['*'] 		= 	array('method'=>'clean','param'=>'html');
		$AvaArr['order']			=	array();
		$AvaArr['order']['field']	=	'id';
		$AvaArr['order']['type']	=	'DESC';
		
		// Pager setup
		$AvaArr['pager'] 				= 	array();
		$AvaArr['pager']['total']		= 	$MySmartBB->avatar->GetAvatarNumber(null);
		$AvaArr['pager']['perpage'] 	= 	$MySmartBB->_CONF['info_row']['avatar_perpage'];
		$AvaArr['pager']['count'] 		= 	$MySmartBB->_GET['count'];
		$AvaArr['pager']['location'] 	= 	'index.php?page=usercp&amp;control=1&amp;avatar=1&amp;main=1';
		$AvaArr['pager']['var'] 		= 	'count';
		
		$MySmartBB->_CONF['template']['while']['AvatarList'] = $MySmartBB->avatar->GetAvatarList($AvaArr);
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->template->display('usercp_control_avatar');
	}
	
	function _AvatarChange()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية التحديث');
		
		$MySmartBB->functions->AddressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');
		
		$allowed_array = array('.jpg','.gif','.png');
		
		$UpdateArr 					= 	array();
		$UpdateArr['field']			=	array();
		
		$UpdateArr['where']					= 	array('id',$MySmartBB->_CONF['member_row']['id']);
		$UpdateArr['field']['avater_path'] 	= 	'';
		
		if ($MySmartBB->_POST['options'] == 'no')
		{
			$MySmartBB->_CONF['param']['UpdateArr']['path'] = '';
		}
		elseif ($MySmartBB->_POST['options'] == 'list')
		{
			if (empty($MySmartBB->_POST['avatar_list']))
			{
				$MySmartBB->functions->error('يرجى اختيار الصوره المطلوبه');
			}
			
			$UpdateArr['field']['path'] = $MySmartBB->_POST['avatar_list'];
		}
		elseif ($MySmartBB->_POST['options'] == 'site')
		{
			if (empty($MySmartBB->_POST['avatar'])
				or $MySmartBB->_POST['avatar'] == 'http://')
			{
				$MySmartBB->functions->error('يرجى اختيار الصوره المطلوبه');
			}
			elseif (!$MySmartBB->functions->IsSite($MySmartBB->_POST['avatar']))
			{
				$MySmartBB->functions->error('الموقع الذي قمت بكتابته غير صحيح !');
			}
				
			$extension = $MySmartBB->functions->GetURLExtension($MySmartBB->_POST['avatar']);
				
			if (!in_array($extension,$allowed_array))
			{
				$MySmartBB->functions->error('امتداد الصوره غير مسموح به !');
			}
			
			$size = @getimagesize($MySmartBB->_POST['avatar']);

			if ($size[0] > $MySmartBB->_CONF['info_row']['max_avatar_width'])
			{
				$MySmartBB->functions->error('عرض الصورة غير مقبول');
			}
			
			if ($size[1] > $MySmartBB->_CONF['info_row']['max_avatar_height'])
			{
				$MySmartBB->functions->error('طول الصورة غير مقبول');
			}
			
			$UpdateArr['field']['avater_path'] = $MySmartBB->_POST['avatar'];
		}
		elseif ($MySmartBB->_POST['options'] == 'upload')
		{
			$pic = $MySmartBB->_FILES['upload']['tmp_name'];

			$size = @getimagesize($pic);

			if ($size[0] > $MySmartBB->_CONF['info_row']['max_avatar_width'])
			{
				$MySmartBB->functions->error('عرض الصورة غير مقبول');
			}

			if ($size[1] > $MySmartBB->_CONF['info_row']['max_avatar_height'])
			{
				$MySmartBB->functions->error('طول الصورة غير مقبول');
			}
			
     		if (!empty($MySmartBB->_FILES['upload']['name']))
     		{
     			//////////
     				
     			// Get the extension of the file
     			$ext = $MySmartBB->functions->GetFileExtension($MySmartBB->_FILES['upload']['name']);
     			
     			// Bad try!
     			if ($ext == 'MULTIEXTENSION'
     				or !$ext)
     			{
     			}
     			else
     			{
	     			// Convert the extension to small case
    	 			$ext = strtolower($ext);
     			
    	 			// The extension is not allowed
    	 			if (!in_array($ext,$allowed_array))
					{
						$MySmartBB->functions->error('امتداد الصوره غير مسموح به !');
					}
    	 			else
    	 			{
    	 				// Set the name of the file
    	 				
    	 				$filename = $MySmartBB->_FILES['upload']['name'];
    	 				
    	 				// There is a file which has same name, so change the name of the new file
    	 				if (file_exists($MySmartBB->_CONF['info_row']['download_path'] . '/avatar/' . $filename))
    	 				{
    	 					$filename = $MySmartBB->_FILES['files']['upload'] . '-' . $MySmartBB->functions->RandomCode();
    	 				}
    	 					
    	 				//////////
    	 				
    	 				// Copy the file to download dirctory
    	 				$copy = copy($MySmartBB->_FILES['upload']['tmp_name'],$MySmartBB->_CONF['info_row']['download_path'] . '/avatar/' . $filename);	
    	 						
    	 				// Success
    	 				if ($copy)
    	 				{
    	 					// Change avatar to the new one
    	 					$UpdateArr['field']['avater_path'] = $MySmartBB->_CONF['info_row']['download_path'] . '/avatar/' . $filename;
    	 				}
    	 							
    	 				//////////
    	 			}				
    	 		}
    	 	}
    	}
		else
		{
			$MySmartBB->functions->msg('يرجى الانتظار');
			$MySmartBB->functions->goto('index.php?page=usercp&control=1&avatar=1&main=1',2);
			$MySmartBB->functions->stop();
		}
		
		$UpdateAvatar = $MySmartBB->member->UpdateMember($UpdateArr);
			
		if ($UpdateAvatar)
		{
			$MySmartBB->functions->msg('تم التحديث بنجاح !');
			$MySmartBB->functions->goto('index.php?page=usercp&control=1&avatar=1&main=1',2);
		}
	}
	
	function _ReplyListMain()
	{
		//TODO later ...
	}
	
	function _SubjectListMain()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('مواضيعك');
		
		$SubjectArr 							= 	array();
		$SubjectArr['where'] 					= 	array();
		
		$SubjectArr['where'][0] 				= 	array();
		$SubjectArr['where'][0]['name'] 		= 	'writer';
		$SubjectArr['where'][0]['oper'] 		= 	'=';
		$SubjectArr['where'][0]['value'] 		= 	$MySmartBB->_CONF['rows']['member_row']['username'];
		
		$SubjectArr['order'] 					=	 array();
		$SubjectArr['order']['field'] 			= 	'id';
		$SubjectArr['order']['type'] 			= 	'DESC';
		
		$SubjectArr['limit'] 					= 	'5';
		
		$SubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$SubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		
		$MySmartBB->_CONF['template']['while']['MemberSubjects'] = $MySmartBB->subject->GetSubjectList($SubjectArr);
			
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['MemberSubjects'],'html');
		
		$MySmartBB->template->display('usercp_options_subjects');
	}
	
	function _BookmarkAddMain()
	{
		global $MySmartBB;

		$MySmartBB->functions->ShowHeader('لوحة تحكم العضو');

		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');

		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}

		$MySmartBB->template->assign('subject',$MySmartBB->_GET['subject_id']);

		$MySmartBB->template->display('subject_bookmark_add');
	}

	function _BookmarkAddStart()
	{
		global $MySmartBB;

		$MySmartBB->functions->ShowHeader(' إضافة الموضوع الى المفضلة');

		$MySmartBB->_GET['subject_id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['subject_id'],'intval');

		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		/** Get the Subject information **/
		$SubArr = array();
		$SubArr['where'] = array('id',$MySmartBB->_GET['subject_id']);

		$Subject = $MySmartBB->subject->GetSubjectInfo($SubArr);
		
		if (!$Subject)
		{
			$MySmartBB->functions->error('الموضوع المطلوب غير موجود');
		}
		
		// TODO :: please check group information.
		
		$BookmarkArr 			= 	array();
		$BookmarkArr['field'] 	= 	array();

		$BookmarkArr['field']['member_id'] 		= 	$MySmartBB->_CONF['member_row']['id'];
		$BookmarkArr['field']['subject_id'] 	= 	$MySmartBB->_GET['subject_id'];
		$BookmarkArr['field']['subject_title'] 	= 	$Subject['title'];
		$BookmarkArr['field']['reason'] 		= 	$MySmartBB->_POST['reason'];
		$BookmarkArr['get_id'] 					= 	true;

		$insert = $MySmartBB->bookmark->InsertSubject($BookmarkArr);

		if ($insert)
		{
			$MySmartBB->functions->msg('تم إضافة الموضوع الى المفضلة');
			$MySmartBB->functions->goto('index.php?page=usercp&bookmark=1&show=1');
		}
	}
	
	function _BookmarkDelStart()
	{
		global $MySmartBB;

		$MySmartBB->functions->ShowHeader('حذف الموضوع من قائمة المواضيع المفضلة');

		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$DelArr = array();
		$DelArr['where'] = array('subject_id',$MySmartBB->_GET['id']);

		$del = $MySmartBB->bookmark->DeleteSubject($DelArr);


		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف الموضوع');
			$MySmartBB->functions->goto('index.php?page=usercp&bookmark=1&show=1');
		}
	}
	
	function _BookmarkShow()
	{
		global $MySmartBB;

		$MySmartBB->functions->ShowHeader('المواضيع المفضلة الخاصة بي');

		$SubjectArr = array();
		$SubjectArr['where'] = array();

		$SubjectArr['where'][0] = array();
		$SubjectArr['where'][0]['name'] = 'member_id';
		$SubjectArr['where'][0]['oper'] = '=';
		$SubjectArr['where'][0]['value'] = $MySmartBB->_CONF['rows']['member_row']['id'];

		$SubjectArr['order'] = array();
		$SubjectArr['order']['field'] = 'id';
		$SubjectArr['order']['type'] = 'DESC';

		$MySmartBB->_CONF['template']['while']['MemberSubjects'] = $MySmartBB->bookmark->GetSubjectList($SubjectArr);

		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['MemberSubjects'],'html');

		$MySmartBB->template->display('subject_bookmark_show');
	}
}

?>
