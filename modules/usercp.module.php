<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('JAVASCRIPT_func',true);
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
	public function run()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
		{
			$MySmartBB->func->error( 'المعذره .. هذه المنطقه للاعضاء فقط' );
		}
		
		if ( isset( $MySmartBB->_GET['index'] ) )
		{
			$this->_index();
		}
		
		/** Control **/
		elseif ( isset( $MySmartBB->_GET['control'] ) )
		{
			/** Persenol Information control **/
			if ( isset( $MySmartBB->_GET['info'] ) )
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_infoMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_infoChange();
				}
			}
			/** **/
			
			/** Options control **/
			elseif ( isset( $MySmartBB->_GET['setting'] ) )
			{
				if ($MySmartBB->_GET['main'])				
				{
					$this->_settingMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_settingChange();
				}
			}
			/** **/
			
			/** Signature control **/
			elseif ( isset( $MySmartBB->_GET['sign'] ) )
			{
				if (!$MySmartBB->_CONF['group_info']['sig_allow'])
				{
					$MySmartBB->func->error('المعذره .. لا يمكنك استخدام هذه الميزه');
				}
				
				if ($MySmartBB->_GET['main'])
				{
					$this->_signMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_signChange();
				}
				elseif ($MySmartBB->_GET['subject'])
				{
					$this->_SignSubjectMain(); // TODO : Kill Me Please
				}
				elseif ($MySmartBB->_GET['subject_start'])
				{
					$this->_SignSubjectChange(); // TODO : Kill Me Please
				}
				elseif ($MySmartBB->_GET['reply'])
				{
					$this->_SignReplyMain(); // TODO : Kill Me Please
				}
				elseif ($MySmartBB->_GET['reply_start'])
				{
					$this->_SignReplyChange(); // TODO : Kill Me Please
				}
			}
			/** **/
			
			/** Password control **/
			elseif ( isset( $MySmartBB->_GET['password'] ) )
			{
				if ($MySmartBB->_GET['main'])				
				{
					$this->_passwordMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_passwordChange();
				}
			}
			/** **/
			
			/** Email control **/
			elseif ( isset( $MySmartBB->_GET['email'] ) )
			{
				if ($MySmartBB->_GET['main'])				
				{
					$this->_emailMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_emailChange();
				}
			}
			/** **/
			
			/** Avatar control **/
			elseif ($MySmartBB->_GET['avatar'])
			{
				if ($MySmartBB->_GET['main'])				
				{
					$this->_avatarMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_avatarChange();
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
				$MySmartBB->func->error('المعذره .. خاصية مفضلة المواضيع موقوفة حاليا');
			}
			
			if ($MySmartBB->_GET['add'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_bookmarkAddMain();
				}
				elseif ($MySmartBB->_GET['start'])
				{
					$this->_bookmarkAddStart();
				}
			}
			elseif ($MySmartBB->_GET['del'])
			{
				$this->_bookmarkDelStart();
			}
			elseif ($MySmartBB->_GET['show'])
			{
				$this->_bookmarkShow();
			}
		}
		/** **/
		else
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح !');
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _index()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('لوحة تحكم العضو');
		
		/* ... */
		
		// [MaaSTaaR] TODO
		/*$ReplyArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$ReplyArr['proc']['write_time'] 		= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);*/
		
		$MySmartBB->_CONF['template']['res']['reply_res'] = '';
		
		$MySmartBB->rec->table		=	$MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter 	= 	"writer='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		$MySmartBB->rec->order 		= 	'id DESC';
		$MySmartBB->rec->limit 		= 	'5';
		$MySmartBB->rec->result 	= 	&$MySmartBB->_CONF['template']['res']['last_subjects_res'];
		
		$MySmartBB->subject->getList();
		
		/* ... */
		
      	$MySmartBB->template->display('usercp_index');
	}
	
	private function _infoMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->ShowHeader('تحرير المعلومات الشخصيه');
		
		$MySmartBB->template->display('usercp_control_info');
	}
	
	private function _infoChange()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تنفيذ عملية التحديث');
		
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'user_country'	=>	$MySmartBB->_POST['country'],
											'user_website'	=>	$MySmartBB->_POST['website'],
											'user_info'	=>	$MySmartBB->_POST['info'],
											'away'	=>	$MySmartBB->_POST['away'],
											'away_msg'	=>	$MySmartBB->_POST['away_msg']	);
		
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
			$MySmartBB->func->msg('تم التحديث بنجاح');
			$MySmartBB->func->goto('index.php?page=usercp&amp;control=1&amp;info=1&amp;main=1');
		}
	}
	
	private function _settingMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تحرير خياراتك الخاصه');
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'style_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'style '];
		$MySmartBB->rec->order = 'style_order ASC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'style_res' ];
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('usercp_control_setting');
	}
		
	private function _settingChange()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تنفيذ عملية التحديث');
		
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'style'	=>	$MySmartBB->_POST['style'],
											'hide_online'	=>	$MySmartBB->_POST['hide_online'],
											'user_time'	=>	$MySmartBB->_POST['user_time'],
											'send_allow'	=>	$MySmartBB->_POST['send_allow']	);
		
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
		
		if ( $update )
		{
			$MySmartBB->func->msg('تم التحديث بنجاح');
			$MySmartBB->func->goto('index.php?page=usercp&amp;control=1&amp;setting=1&amp;main=1',2);
		}
	}
	
	private function _signMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->ShowHeader('تحرير توقيعك الخاص');
		
		$MySmartBB->func->getEditorTools();
		
		$MySmartBB->_CONF['template']['Sign'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['member_row']['user_sig']);
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['Sign']);
		
		$MySmartBB->template->display('usercp_control_sign');
	}
	
	private function _signChange()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader('تنفيذ عملية التحديث');
		
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');
		
		// ... //
		
		$MySmartBB->_POST['text'] = trim( $MySmartBB->_POST['text'] );
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->fields = array(	'user_sig'	=>	$MySmartBB->_POST['text']	);
		$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
		$update = $MySmartBB->rec->update();
				
		// ... //
		
		if ( $update )
		{
			$MySmartBB->func->msg('تم تحديث التوقيع بنجاح !');
			$MySmartBB->func->goto('index.php?page=usercp&amp;control=1&amp;sign=1&amp;main=1');
		}
		
		// ... //
	}
	
	/* Kill ME 
	function _SignSubjectMain()
	{
		global $MySmartBB;

		$MySmartBB->func->ShowHeader('تحرير توقيعك الإفتراضي للمواضيع');

		$MySmartBB->func->GetEditorTools();

		$MySmartBB->_CONF['template']['Sign'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['rows']['member_row']['subject_sig']);
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['Sign']);

		$MySmartBB->template->display('usercp_control_signsubject');
	}
	
	function _SignSubjectChange()
	{
		global $MySmartBB;

		$MySmartBB->func->ShowHeader('تنفيذ عملية التحديث');

		$MySmartBB->func->AddressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');

		$MySmartBB->_POST['text'] = $MySmartBB->func->CleanVariable($MySmartBB->_POST['text'],'trim');

		$SignArr = array();
		$SignArr['field'] = array();

		$SignArr['field']['subject_sig'] = $MySmartBB->_POST['text'];
		$SignArr['where'] = array('id',$MySmartBB->_CONF['member_row']['id']);

		$UpdateSign = $MySmartBB->member->UpdateMember($SignArr);

		if ($UpdateSign)
		{
			$MySmartBB->func->msg('تم تحديث التوقيع الإفتراضي للمواضيع بنجاح !');
			$MySmartBB->func->goto('index.php?page=usercp&control=1&subjects=1&main=1');
		}
	}
	
	function _SignReplyMain()
	{
		global $MySmartBB;

		$MySmartBB->func->ShowHeader('تحرير توقيعك الإفتراضي الخاص بالردود');

		$MySmartBB->func->GetEditorTools();

		$MySmartBB->_CONF['template']['Sign'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['rows']['member_row']['reply_sig']);
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['Sign']);

		$MySmartBB->template->display('usercp_control_signreply');
	}
	
	function _SignReplyChange()
	{
		global $MySmartBB;

		$MySmartBB->func->ShowHeader('تنفيذ عملية التحديث');

		$MySmartBB->func->AddressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');

		$MySmartBB->_POST['text'] = $MySmartBB->func->CleanVariable($MySmartBB->_POST['text'],'trim');

		$SignArr = array();
		$SignArr['field'] = array();

		$SignArr['field']['reply_sig'] = $MySmartBB->_POST['text'];
		$SignArr['where'] = array('id',$MySmartBB->_CONF['member_row']['id']);

		$UpdateSign = $MySmartBB->member->UpdateMember($SignArr);

		if ($UpdateSign)
		{
			$MySmartBB->func->msg('تم تحديث التوقيع الإفتراضي للردود بنجاح !');
			$MySmartBB->func->goto('index.php?page=usercp&control=1&replays=1&main=1');
		}
	}
	*/
	
	private function _passwordMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تغيير كلمة السر');
		
		$MySmartBB->template->display('usercp_control_password');
	}
	
	private function _passwordChange()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader('تنفيذ العمليه');
		
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ العمليه');
		
		// ... //
		
		// Check if the information aren't empty
		if (empty($MySmartBB->_POST['old_password']) 
			or empty($MySmartBB->_POST['new_password']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		
		// ... //
		
		$MySmartBB->_POST['old_password'] = md5( trim( $MySmartBB->_POST['old_password'] ) );
		$MySmartBB->_POST['new_password'] = md5( trim( $MySmartBB->_POST['new_password'] ) );
		
		// ... //

		// Ensure if the password is correct or not
		// [WE NEED A SYSTEM]
		$checkPasswordCorrect = $MySmartBB->member->checkMember( $MySmartBB->_CONF['member_row']['username'], $MySmartBB->_POST['old_password'] );
		
		if (!$checkPasswordCorrect)
		{
			$MySmartBB->func->error('المعذره .. كلمة المرور التي قمت بكتابتها غير صحيحه');
		}
		
		// ... //
		
		if ( $MySmartBB->_CONF['info_row']['confirm_on_change_pass'] )
		{
			$adress	= 	$MySmartBB->func->getForumAdress();
			$code	=	$MySmartBB->func->randomCode();
			
			$ChangeAdress = $adress . 'index.php?page=new_password&index=1&code=' . $code;
			$CancelAdress = $adress . 'index.php?page=cancel_requests&index=1&type=1&code=' . $code;
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
			$MySmartBB->rec->fields = array(	'random_url'	=>	$code,
												'username'	=>	$MySmartBB->_CONF['member_rows']['username'],
												'request_type'	=>	'1'	);
												
			$insert = $MySmartBB->rec->insert();
		
			if ( $insert )
			{
				$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
				$MySmartBB->rec->fields = array(	'new_password'	=>	$MySmartBB->_POST['new_password']	);
				$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['id'] . "'";
				
				$update = $MySmartBB->rec->update();
			
				if ( $update )
				{
					// ... //
					
					$MySmartBB->rec->table = $MySmartBB->rec->table[ 'email_msg' ];
					$MySmartBB->rec->filter = "id='1'";
					
					$MassegeInfo = $MySmartBB->rec->getInfo();
					
					// ... //
					
					$MassegeInfo['text'] = $MySmartBB->massege->messageProccess( 	$MySmartBB->_CONF['member_row']['username'], 
																					$MySmartBB->_CONF['info_row']['title'], 
																					null, 
																					$ChangeAdress, 
																					$CancelAdress, 
																					$MassegeInfo['text'] );
					
					// ... //
					
					$send = $MySmartBB->func->mail(	$MySmartBB->_CONF['member_row']['email'],
													$MassegeInfo['title'],
													$MassegeInfo['text'],
													$MySmartBB->_CONF['info_row']['send_email'] );
					
					// ... //
					
					if ($send)
					{
						$MySmartBB->func->msg('تم ارسال رسالة التأكيد إلى بريدك الالكتروني , يرجى مراجعته');
						$MySmartBB->func->goto('index.php?page=usercp&index=1');
					}
				}
			}
		}
		else
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
			$MySmartBB->rec->fields = array(	'password'	=>	$MySmartBB->_POST['new_password']	);
			$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['id'] . "'";
				
			$update = $MySmartBB->rec->update();
		
			if ( $update )
			{
				$MySmartBB->func->msg('تم التحديث بنجاح !');
				$MySmartBB->func->goto('index.php?page=usercp&amp;control=1&amp;password=1&amp;main=1');
			}
		}
	}
	
	private function _emailMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تغيير البريد الالكتروني');
		
		$MySmartBB->template->display('usercp_control_email');
	}
	
	private function _emailChange()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->func->showHeader('تنفيذ العمليه');
		
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ العمليه');
		
		// ... //
		
		$MySmartBB->rec->filter = "email='" .  $MySmartBB->_POST['new_email']. "'";
		
		// [WE NEED A SYSTEM]
		$EmailExists = $MySmartBB->member->isMember();
		
		if (empty($MySmartBB->_POST['new_email']))
		{
			$MySmartBB->func->error('يرجى تعبئة كافة المعلومات');
		}
		if (!$MySmartBB->func->checkEmail($MySmartBB->_POST['new_email']))
		{
			$MySmartBB->func->error('يرجى كتابة بريدك الالكتروني الصحيح');
		}
		if ($EmailExists)
		{
			$MySmartBB->func->error('المعذره .. البريد الالكتروني موجود مسبقاً');
		}
		
		$MySmartBB->_POST['new_email'] = trim( $MySmartBB->_POST['new_email'] );
		
		// We will send a confirm message, The confirm message will help user protect himself from crack
		if ($MySmartBB->_CONF['info_row']['confirm_on_change_mail'])
		{
			$adress	= 	$MySmartBB->func->getForumAdress();
			$code	=	$MySmartBB->func->randomCode();
		
			$ChangeAdress = $adress . 'index.php?page=new_email&index=1&code=' . $code;
			$CancelAdress = $adress . 'index.php?page=cancel_requests&index=1&type=2&code=' . $code;
			
			$MySmartBB->rec->table = $MySmartBB->table[ 'requests' ];
			$MySmartBB->rec->fields = array(	'random_url'	=>	$code,
												'username'	=>	$MySmartBB->_CONF['member_rows']['username'],
												'request_type'	=>	'2'	);
		
			$insert = $MySmartBB->rec->insert();
		
			if ( $insert )
			{
				$UpdateArr = array();
			
				$UpdateArr['email'] 	= 	$MySmartBB->_POST['new_email'];
				$UpdateArr['where'] 	= 	array('id',$MySmartBB->_CONF['member_row']['id']);
			
				$UpdateNewEmail = $MySmartBB->member->UpdateNewEmail($UpdateArr); /* TODO : may you tell me please, where is this function? */
			
				if ($UpdateNewEmail)
				{
					$MassegeInfo = $MySmartBB->massege->GetMessageInfo(array('id'	=>	2));
					
					$MassegeInfo['text'] = $MySmartBB->massege->messageProccess( $MySmartBB->_CONF['member_row']['username'], $MySmartBB->_CONF['info_row']['title'], null, $ChangeAdress, $CancelAdress, $MassegeInfo['text'] );
				
					$send = $MySmartBB->func->mail($MySmartBB->_CONF['rows']['member_row']['email'],$MassegeInfo['title'],$MassegeInfo['text'],$MySmartBB->_CONF['info_row']['send_email']);
				
					if ( $send )
					{
						$MySmartBB->func->msg('تم ارسال رسالة التأكيد إلى بريدك الالكتروني , يرجى مراجعته');
						$MySmartBB->func->goto('index.php?page=usercp&index=1');
					}
				}
			}
		}
		// Confirm message is off, so change email direct
		else
		{
			$MySmartBB->rec->fields = array(	'new_email'	=>	$MySmartBB->_POST['new_email']	);
			$MySmartBB->rec->filter = "id='" . (int) $MySmartBB->_CONF['member_row']['id'] . "'";
					
			$update = $MySmartBB->member->updateMember();
		
			if ( $update )
			{
				$MySmartBB->func->msg('تم التحديث بنجاح !');
				$MySmartBB->func->goto('index.php?page=usercp&amp;control=1&amp;email=1&amp;main=1');
			}
		}
	}
	
	private function _avatarMain()
	{
		global $MySmartBB;
		
		// This line will include jQuery (Javascript library)
		$MySmartBB->template->assign('JQUERY',true);
		
		$MySmartBB->func->showHeader('الصوره الشخصيه');
		
		if (!$MySmartBB->_CONF['info_row']['allow_avatar'])
		{
			$MySmartBB->func->error('المعذره .. لا يمكنك استخدام هذه الميزه');
		}
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'avatar' ];
		
		$MySmartBB->rec->pager 				= 	array();
		$MySmartBB->rec->pager['total']		= 	$MySmartBB->avatar->getAvatarNumber();
		$MySmartBB->rec->pager['perpage'] 	= 	$MySmartBB->_CONF['info_row']['avatar_perpage'];
		$MySmartBB->rec->pager['count'] 	= 	$MySmartBB->_GET['count'];
		$MySmartBB->rec->pager['location'] 	= 	'index.php?page=usercp&amp;control=1&amp;avatar=1&amp;main=1';
		$MySmartBB->rec->pager['var'] 		= 	'count';
		
		$MySmartBB->rec->order = 'id DESC';
		
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['avatar_res'];
		
		$MySmartBB->avatar->getList();
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->template->display('usercp_control_avatar');
	}
	
	private function _avatarChange()
	{
		global $MySmartBB;
		
		$MySmartBB->func->showHeader('تنفيذ عملية التحديث');
		
		$MySmartBB->func->addressBar('<a href="index.php?page=usercp&index=1">لوحة تحكم العضو</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية التحديث');
		
		$allowed_array = array('.jpg','.gif','.png');
		
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
		
		$MySmartBB->rec->fields['avater_path'] = '';
		
		if ($MySmartBB->_POST['options'] == 'no')
		{
			$MySmartBB->rec->fields['avater_path'] = '';
		}
		elseif ($MySmartBB->_POST['options'] == 'list')
		{
			if (empty($MySmartBB->_POST['avatar_list']))
			{
				$MySmartBB->func->error('يرجى اختيار الصوره المطلوبه');
			}
			
			$MySmartBB->rec->fields['avater_path'] = $MySmartBB->_POST['avatar_list'];
		}
		elseif ($MySmartBB->_POST['options'] == 'site')
		{
			if (empty($MySmartBB->_POST['avatar'])
				or $MySmartBB->_POST['avatar'] == 'http://')
			{
				$MySmartBB->func->error('يرجى اختيار الصوره المطلوبه');
			}
			elseif (!$MySmartBB->func->IsSite($MySmartBB->_POST['avatar']))
			{
				$MySmartBB->func->error('الموقع الذي قمت بكتابته غير صحيح !');
			}
				
			$extension = $MySmartBB->func->GetURLExtension($MySmartBB->_POST['avatar']);
				
			if (!in_array($extension,$allowed_array))
			{
				$MySmartBB->func->error('امتداد الصوره غير مسموح به !');
			}
			
			$size = @getimagesize($MySmartBB->_POST['avatar']);

			if ($size[0] > $MySmartBB->_CONF['info_row']['max_avatar_width'])
			{
				$MySmartBB->func->error('عرض الصورة غير مقبول');
			}
			
			if ($size[1] > $MySmartBB->_CONF['info_row']['max_avatar_height'])
			{
				$MySmartBB->func->error('طول الصورة غير مقبول');
			}
			
			$MySmartBB->rec->fields['avater_path'] = $MySmartBB->_POST['avatar'];
		}
		elseif ($MySmartBB->_POST['options'] == 'upload')
		{
			$pic = $MySmartBB->_FILES['upload']['tmp_name'];

			$size = @getimagesize($pic);

			if ($size[0] > $MySmartBB->_CONF['info_row']['max_avatar_width'])
			{
				$MySmartBB->func->error('عرض الصورة غير مقبول');
			}

			if ($size[1] > $MySmartBB->_CONF['info_row']['max_avatar_height'])
			{
				$MySmartBB->func->error('طول الصورة غير مقبول');
			}
			
     		if (!empty($MySmartBB->_FILES['upload']['name']))
     		{
     			//////////
     				
     			// Get the extension of the file
     			$ext = $MySmartBB->func->GetFileExtension($MySmartBB->_FILES['upload']['name']);
     			
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
						$MySmartBB->func->error('امتداد الصوره غير مسموح به !');
					}
    	 			else
    	 			{
    	 				// Set the name of the file
    	 				
    	 				$filename = $MySmartBB->_FILES['upload']['name'];
    	 				
    	 				// There is a file which has same name, so change the name of the new file
    	 				if (file_exists($MySmartBB->_CONF['info_row']['download_path'] . '/avatar/' . $filename))
    	 				{
    	 					$filename = $MySmartBB->_FILES['files']['upload'] . '-' . $MySmartBB->func->RandomCode();
    	 				}
    	 					
    	 				//////////
    	 				
    	 				// Copy the file to download dirctory
    	 				$copy = copy($MySmartBB->_FILES['upload']['tmp_name'],$MySmartBB->_CONF['info_row']['download_path'] . '/avatar/' . $filename);	
    	 						
    	 				// Success
    	 				if ($copy)
    	 				{
    	 					// Change avatar to the new one
    	 					$MySmartBB->rec->fields['avater_path'] = $MySmartBB->_CONF['info_row']['download_path'] . '/avatar/' . $filename;
    	 				}
    	 							
    	 				//////////
    	 			}				
    	 		}
    	 	}
    	}
		else
		{
			$MySmartBB->func->msg('يرجى الانتظار');
			$MySmartBB->func->goto('index.php?page=usercp&control=1&avatar=1&main=1',2);
			$MySmartBB->func->stop();
		}
		
		$update = $MySmartBB->member->updateMember();
			
		if ( $update )
		{
			$MySmartBB->func->msg('تم التحديث بنجاح !');
			$MySmartBB->func->goto('index.php?page=usercp&control=1&avatar=1&main=1',2);
		}
	}
	
	private function _replyListMain()
	{
		//TODO later ...
	}
	
	private function _subjectListMain()
	{
		global $MySmartBB;
		
		$MySmartBB->func->ShowHeader('مواضيعك');
		
		/*$SubjectArr['proc']['native_write_time'] 	= 	array('method'=>'date','store'=>'write_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);
		$SubjectArr['proc']['write_time'] 			= 	array('method'=>'date','store'=>'reply_date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);*/
		
		$MySmartBB->_CONF['template']['res']['subject_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		
		$MySmartBB->rec->filter = "writer='" . $MySmartBB->_CONF['member_row']['username'] . "'";
		$MySmartBB->rec->order = 'id DESC';
		$MySmartBB->rec->limit = '5';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['subject_res'];
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->template->display('usercp_options_subjects');
	}
	
	private function _bookmarkAddMain()
	{
		global $MySmartBB;

		$MySmartBB->func->ShowHeader('لوحة تحكم العضو');

		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];

		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}

		$MySmartBB->template->assign('subject',$MySmartBB->_GET['subject_id']);

		$MySmartBB->template->display('subject_bookmark_add');
	}

	private function _bookmarkAddStart()
	{
		global $MySmartBB;

		$MySmartBB->func->showHeader(' إضافة الموضوع الى المفضلة');

		$MySmartBB->_GET['subject_id'] = (int) $MySmartBB->_GET['subject_id'];

		if (empty($MySmartBB->_GET['subject_id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $MySmartBB->_GET['subject_id'] . "'";
		
		$subject = $MySmartBB->rec->getInfo();
		
		if (!$subject)
		{
			$MySmartBB->func->error('الموضوع المطلوب غير موجود');
		}
		
		// TODO :: please check group information.
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'bookmark' ];
		$MySmartBB->rec->fields = array(	'member_id'	=>	$MySmartBB->_CONF['member_row']['id'],
											'subject_id'	=>	$MySmartBB->_GET['subject_id'],
											'subject_title'	=>	$Subject['title'],
											'reason'	=>	$MySmartBB->_POST['reason']	);
		
		
		$insert = $MySmartBB->rec->insert();

		if ($insert)
		{
			$MySmartBB->func->msg('تم إضافة الموضوع الى المفضلة');
			$MySmartBB->func->goto('index.php?page=usercp&bookmark=1&show=1');
		}
	}
	
	private function _bookmarkDelStart()
	{
		global $MySmartBB;

		$MySmartBB->func->ShowHeader('حذف الموضوع من قائمة المواضيع المفضلة');

		$MySmartBB->_GET['id'] = (int) $MySmartBB->_GET['id'];

		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->func->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'bookmark' ];
		$MySmartBB->rec->filter = "subject_id='" . $MySmartBB->_GET[ 'id' ] . "'";
		
		$del = $MySmartBB->rec->delete();
		
		if ( $del )
		{
			$MySmartBB->func->msg('تم حذف الموضوع');
			$MySmartBB->func->goto('index.php?page=usercp&bookmark=1&show=1');
		}
	}
	
	private function _bookmarkShow()
	{
		global $MySmartBB;

		$MySmartBB->func->ShowHeader('المواضيع المفضلة الخاصة بي');
		
		$MySmartBB->_CONF['template']['res']['subject_res'] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'bookmark' ];
		$MySmartBB->rec->filter = "member_id='" . $MySmartBB->_CONF['member_row']['id'] . "'";
		$MySmartBB->rec->order = 'id DESC';
		$MySmartBB->rec->result = &$MySmartBB->_CONF['template']['res']['subject_res'];
		
		$MySmartBB->rec->getList();

		$MySmartBB->template->display('subject_bookmark_show');
	}
}

?>
