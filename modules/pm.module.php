<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM					=	array();
$CALL_SYSTEM['PM'] 				= 	true;
$CALL_SYSTEM['ICONS'] 			= 	true;
$CALL_SYSTEM['TOOLBOX'] 		= 	true;
$CALL_SYSTEM['FILESEXTENSION'] 	= 	true;
$CALL_SYSTEM['ATTACH'] 			= 	true;

define('JAVASCRIPT_SMARTCODE',true);

include('common.php');

define('CLASS_NAME','MySmartPrivateMassegeMOD');

class MySmartPrivateMassegeMOD
{
	function run()
	{
		global $MySmartBB;
		
		/** Can't use the private massege system **/
		if (!$MySmartBB->_CONF['rows']['group_info']['use_pm'])
		{
			$MySmartBB->functions->error('المعذره .. لا يمكنك استخدام الرسائل الخاصه');
		}
		/** **/
		
		/** Visitor can't use the private massege system **/
		if (!$MySmartBB->_CONF['member_permission'])
		{
			$MySmartBB->functions->error('المعذره .. هذه المنطقه للاعضاء فقط');
		}
		/** **/
		
		/** Action to send the masseges **/
		if ($MySmartBB->_GET['send'])
		{
			/** Show a nice form :) **/
			if ($MySmartBB->_GET['index'])
			{
				$this->_SendForm();
			}
			/** **/
			
			/** Start send the massege **/
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_StartSend();
			}
			/** **/
		}
		/** **/
		
		/** Get the list of masseges **/
		elseif ($MySmartBB->_GET['list'])
		{
			$this->_ShowList();
		}
		/** **/
		
		/** Read a massege **/
		elseif ($MySmartBB->_GET['show'])
		{
			$this->_ShowMassege();
		}
		/** **/
		
		/** Conrol private masseges **/
		elseif ($MySmartBB->_GET['cp'])
		{
			/** Delete private massege **/
			if ($MySmartBB->_GET['del'])
			{
				$this->_DeletePrivateMassege();
			}
			/** **/
		}
		/** **/
		
		elseif ($MySmartBB->_GET['setting'])
		{
			if ($MySmartBB->_GET['index'])
			{
				$this->_SettingIndex();
			}
			elseif ($MySmartBB->_GET['start'])
			{
				$this->_SettingStart();
			}
		}
		else
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح !');
		}
					
		$MySmartBB->functions->GetFooter();
	}
	
	/**
	 * Show send form for the sender , Get the colors , fonts , icons and smiles list
	 */
	function _SendForm()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إرسال رساله خاصه');
		
		$MySmartBB->functions->GetEditorTools();
		
		if (isset($MySmartBB->_GET['username']))
		{
			$ToArr 				= 	array();
			$ToArr['get'] 		= 	'usergroup,username,pm_senders,pm_senders_msg,away,away_msg';		
			$ToArr['where']		=	array('username',$MySmartBB->_GET['username']);
		
			$GetToInfo = $MySmartBB->member->GetMemberInfo($ToArr);
															
			if (!$GetToInfo)
			{
				$MySmartBB->functions->error('العضو المطلوب غير موجود');
			}
			
			$MySmartBB->template->assign('SHOW_MSG',$GetToInfo['pm_senders']);
			$MySmartBB->template->assign('SHOW_MSG1',$GetToInfo['away']);
			$MySmartBB->template->assign('MSG',$GetToInfo['pm_senders_msg']);
			$MySmartBB->template->assign('MSG1',$GetToInfo['away_msg']);
			$MySmartBB->template->assign('to',$GetToInfo['username']);
		}
		
		// Finally , show the form :)
		$MySmartBB->template->display('pm_send');
	}
		
	/**
	 * Check if the necessary informations is not empty , 
	 * and some checks about the sender and resiver then send the massege .
	 */
	function _StartSend()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية الارسال');
		
		$MySmartBB->functions->AddressBar('<a href="index.php?page=pm&amp;list=1&amp;folder=inbox">الرسائل الخاصه</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية الارسال');
		
		if (empty($MySmartBB->_POST['to'][0]))
		{
			$MySmartBB->functions->error('يجب كتابة اسم المستخدم الذي تريد الارسال إليه');
		}
		
		if (empty($MySmartBB->_POST['title']))
		{
			$MySmartBB->functions->error('يجب كتابة عنوان الرساله');
		}
		
		if (empty($MySmartBB->_POST['text']))
		{
			$MySmartBB->functions->error('يجب كتابة الرساله الخاصه');
		}
		
		$size = sizeof($MySmartBB->_POST['to']);
		
		$success 	= 	array();
		$fail		=	array();
		
     	if ($size > 0)
     	{
     		$x = 0;
     		
     		while ($x < $size)
     		{
     			// Ensure there is no repeat
     			if (in_array($MySmartBB->_POST['to'][$x],$success)
     				or in_array($MySmartBB->_POST['to'][$x],$fail))
     			{
     				$x += 1;
     				
     				continue;
     			}
     			
				$ToArr 				= 	array();
				$ToArr['get'] 		= 	'usergroup,username,autoreply,autoreply_title,autoreply_msg';		
				$ToArr['where']		=	array('username',$MySmartBB->_POST['to'][$x]);
		
				$GetToInfo = $MySmartBB->member->GetMemberInfo($ToArr);
				
				if (!$GetToInfo
					and $size > 1)
				{
					$fail[] = $MySmartBB->_POST['to'][$x];
					
					unset($GetToInfo,$GetMemberOptions);
				
					$x += 1;
				
					continue;
				}
				elseif (!$GetToInfo
						and $size == 1)
				{
					$MySmartBB->functions->error('العضو المطلوب غير موجود');
				}
		
				$GroupInfo 				= 	array();
				$GroupInfo['where'] 	= 	array('id',$GetToInfo['usergroup']);
		
				$GetMemberOptions = $MySmartBB->group->GetGroupInfo($GroupInfo);
				
				if (!$GetMemberOptions['resive_pm']
					and $size > 1)
				{
					$fail[] = $MySmartBB->_POST['to'][$x];
					
					unset($GetToInfo,$GetMemberOptions);
				
					$x += 1;
				
					continue;
				}
				elseif (!$GetMemberOptions['resive_pm']
						and $size == 1)
				{
					$MySmartBB->functions->error('المعذره , هذا العضو لا يمكن ان يستقبل الرسائل الخاصه');
				}
		
				if ($GetMemberOptions['max_pm'] > 0)
				{
					$PMNumberArr 				= 	array();
					$PMNumberArr['username'] 	= 	$GetToInfo['username'];
			
					$PrivateMassegeNumber = $MySmartBB->pm->GetPrivateMassegeNumber($PMNumberArr);
					
					if ($PrivateMassegeNumber > $GetMemberOptions['max_pm']
						and $size > 1)
					{
						$fail[] = $MySmartBB->_POST['to'][$x];
						
						unset($GetToInfo,$GetMemberOptions);
				
						$x += 1;
						
						continue;
					}
					elseif ($PrivateMassegeNumber > $GetMemberOptions['max_pm']
							and $size == 1)
					{
						$MySmartBB->functions->error('المعذره .. استهلك هذا العضو الحد الاقصى لرسائله , لذلك لا يمكنه استقبال رسائل جديده');
					}
				}
		     	
				$MsgArr 				= 	array();
				$MsgArr['get_id']		=	true;
				$MsgArr['field']		=	array();
				
				$MsgArr['field']['user_from'] 	= 	$MySmartBB->_CONF['member_row']['username'];
				$MsgArr['field']['user_to'] 	= 	$GetToInfo['username'];
				$MsgArr['field']['title'] 		= 	$MySmartBB->_POST['title'];
				$MsgArr['field']['text'] 		= 	$MySmartBB->_POST['text'];
				$MsgArr['field']['date'] 		= 	$MySmartBB->_CONF['now'];
				$MsgArr['field']['icon'] 		= 	$MySmartBB->_POST['icon'];
				$MsgArr['field']['folder'] 		= 	'inbox';
		
				$Send = $MySmartBB->pm->InsertMassege($MsgArr);
														
				if ($Send)
				{
     				if ($MySmartBB->_POST['attach'])
     				{	
     					$files_error	=	array();
     					$files_success	=	array();
     					$files_number 	= 	sizeof($MySmartBB->_FILES['files']['name']);
     					$stop			=	false;
     				
     					if ($files_number > 0)
     					{
     						// All of these variables use for loop and arrays
     						$x = 0; // For the main loop
     						$y = 0; // For error array
     						$z = 0; // For success array
     					
     						while ($files_number > $x)
     						{
     							if (!empty($MySmartBB->_FILES['files']['name'][$x]))
     							{
     								//////////
     							
     								// Get the extension of the file
     								$ext = $MySmartBB->functions->GetFileExtension($MySmartBB->_FILES['files']['name'][$x]);
     							
     								// Bad try!
     								if ($ext == 'MULTIEXTENSION'
     									or !$ext)
     								{
     									$files_error[$y] = $MySmartBB->_FILES['files']['name'][$x];
     									
     									$y += 1;
     								}
     								else
     								{
     									// Convert the extension to small case
     									$ext = strtolower($ext);
     									
     									//////////
     									
     									// Check if the extenstion is allowed or not (TODO : cache me please)
     									$ExtArr 			= 	array();
     									$ExtArr['where'] 	= 	array('Ex',$ext);
     									
     									$extension = $MySmartBB->extension->GetExtensionInfo($ExtArr);
     								
     									// The extension is not allowed
     									if (!$extension)
     									{
     										$files_error[$y] = $MySmartBB->_FILES['files']['name'][$x];
     										
     										$y += 1;
     									}
     									else
     									{
     										if (!empty($extension['mime_type']))
     										{
     											if ($MySmartBB->_FILES['files']['type'][$x] != $extension['mime_type'])
     											{
     												$files_error[$y] = $MySmartBB->_FILES['files']['name'][$x];
     												
     												$stop = true;
     												
     												$y += 1;
     											}
     										}
     										
     										//////////
     									
     										// Check the size
     									
     										// Change the size from bytes to KB
     										$filesize = ceil(($MySmartBB->_FILES['files']['size'][$x] / 1024));
     									
     										// oooh! the file is very large
     										if ($filesize > $extension['max_size'])
     										{
     											$files_error[$y] = $MySmartBB->_FILES['files']['name'][$x];
     											
     											$stop = true;
     											
     											$y += 1;
     										}
     									
     										//////////
     										
     										if (!$stop)
     										{
     											// Set the name of the file
     									
     											$filename = $MySmartBB->_FILES['files']['name'][$x];
     									
     											// There is a file which has same name, so change the name of the new file
     											if (file_exists($MySmartBB->_CONF['info_row']['download_path'] . '/' . $filename))
     											{
     												$filename = $MySmartBB->_FILES['files']['name'][$x] . '-' . $MySmartBB->functions->RandomCode();
     											}
     										
     											//////////
     										
     											// Copy the file to download dirctory
     											$copy = copy($MySmartBB->_FILES['files']['tmp_name'][$x],$MySmartBB->_CONF['info_row']['download_path'] . '/' . $filename);		
     										
     											// Success
     											if ($copy)
     											{
     												// Add the file to the success array 
     												$files_success[$z] = $MySmartBB->_FILES['files']['name'][$x];
     											
     												// Insert attachment to the database
     												$AttachArr 							= 	array();
     												$AttachArr['field'] 				= 	array();
     												$AttachArr['field']['filename'] 	= 	$MySmartBB->_FILES['files']['name'][$x];
     												$AttachArr['field']['filepath'] 	= 	$MySmartBB->_CONF['info_row']['download_path'] . '/' . $filename;
     												$AttachArr['field']['filesize'] 	= 	$MySmartBB->_FILES['files']['size'][$x];
     												$AttachArr['field']['pm_id'] 		= 	$MySmartBB->pm->id;
     												
     												$InsertAttach = $MySmartBB->attach->InsertAttach($AttachArr);
     											
    										
     												$z += 1;
     											} // End of if ($copy)
     									
     											//////////
     										
     										} // End of if (!$stop)
     									
     										//////////
     									} // End of else
     								}
     							
     								$x += 1;	
     							}
     						}
     					}
     				}
     				
     				//////////
					
					$MsgArr 				= 	array();
					$MsgArr['field']		=	array();
					
					$MsgArr['field']['user_from'] 	= $MySmartBB->_CONF['member_row']['username'];
					$MsgArr['field']['user_to'] 	= $GetToInfo['username'];
					$MsgArr['field']['title'] 		= $MySmartBB->_POST['title'];
					$MsgArr['field']['text'] 		= $MySmartBB->_POST['text'];
					$MsgArr['field']['date'] 		= $MySmartBB->_CONF['date'];
					$MsgArr['field']['icon'] 		= $MySmartBB->_POST['icon'];
					$MsgArr['field']['folder'] 		= 'sent';
			
					$SentBox = $MySmartBB->pm->InsertMassege($MsgArr);
														
					if ($SentBox)
					{
						/** Auto reply **/
						if ($GetToInfo['autoreply'])
						{
							$MsgArr 			= 	array();
							$MsgArr['field'] 	= 	array();
							
							$MsgArr['field']['user_from'] 	= 	$GetToInfo['username'];
							$MsgArr['field']['user_to'] 	= 	$MySmartBB->_CONF['member_row']['username'];
							$MsgArr['field']['title'] 		= 	'[الرد الآلي] ' . $GetToInfo['autoreply_title'];
							$MsgArr['field']['text'] 		= 	$GetToInfo['autoreply_msg'];
							$MsgArr['field']['date'] 		= 	$MySmartBB->_CONF['now'];
							$MsgArr['field']['folder'] 		= 	'inbox';
			
							$AutoReply = $MySmartBB->pm->InsertMassege($MsgArr);
						}
						
						$NumberArr 				= 	array();
						$NumberArr['username'] 	= 	$GetToInfo['username'];
						
						$Number = $MySmartBB->pm->NewMessageNumber($NumberArr);
		      															
						$CacheArr 					= 	array();
						$CacheArr['field']			=	array();
						
						$CacheArr['field']['unread_pm'] 	= 	$Number;
						$CacheArr['where'] 					= 	array('username',$GetToInfo['username']);
				
						$Cache = $MySmartBB->member->UpdateMember($CacheArr);
						
						if ($Cache)
						{
							$success[] = $MySmartBB->_POST['to'][$x];
						}
					}
				}
				
				unset($GetToInfo,$GetMemberOptions);
				
				$x += 1;
			}
     	}
     	else
     	{
     		$MySmartBB->functions->error('المسار المتبع غير صحيح');
     	}
     	
     	$sucess_number 	= 	sizeof($success);
     	$fail_numer		=	sizeof($fail);

     	if ($sucess_number == $size)
     	{
     		$MySmartBB->functions->msg('تم إرسال الرساله الخاصه بنجاح');	
     	}
     	elseif ($fail_number == $size)
     	{
     		$MySmartBB->functions->msg('لم يتم إرسال الرساله الخاصه');
     	}
     	elseif ($sucess_number < $size)
     	{
     		$MySmartBB->functions->msg('تم إرسال الرساله الخاصه إلى البعض');
     	}
     	
     	$MySmartBB->functions->goto('index.php?page=pm&amp;list=1&amp;folder=inbox');
	}
	
	/**
	 * Get the list of masseges
	 */
	function _ShowList()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('قائمة الرسائل');
		
		if (empty($MySmartBB->_GET['folder']))
		{
			$MySmartBB->functions->error('المعذره .. المسار المتبع غير صحيح');
		}
		
		
		$MySmartBB->_GET['count'] = (!isset($MySmartBB->_GET['count'])) ? 0 : $MySmartBB->_GET['count'];
		
		//////////
		
		$NumArr 						= 	array();
		$NumArr['where'] 				= 	array();
		
		$NumArr['where'][0] 			= 	array();
		$NumArr['where'][0]['name'] 	= 	($MySmartBB->_GET['folder'] == 'inbox') ? 'user_to' : 'user_from';
		$NumArr['where'][0]['oper'] 	= 	'=';
		$NumArr['where'][0]['value'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		
		$NumArr['where'][1] 			= 	array();
		$NumArr['where'][1]['con'] 		= 	'AND';
		$NumArr['where'][1]['name'] 	= 	'folder';
		$NumArr['where'][1]['oper'] 	= 	'=';
		$NumArr['where'][1]['value'] 	= 	($MySmartBB->_GET['folder'] == 'inbox') ? 'inbox' : 'sent';
		
		//////////
		
		$MsgArr = array();
		
		$MsgArr['username'] 			= 	$MySmartBB->_CONF['member_row']['username'];
		
		$MsgArr['proc'] 				= 	array();
		$MsgArr['proc']['*'] 			= 	array('method'=>'clean','param'=>'html');
		$MsgArr['proc']['date'] 		= 	array('method'=>'date','store'=>'date','type'=>$MySmartBB->_CONF['info_row']['timesystem']);

		$MsgArr['order']				=	array();
		$MsgArr['order']['field']		=	'id';
		$MsgArr['order']['type']		=	'DESC';
		
		// Pager setup
		$MsgArr['pager'] 				= 	array();
		$MsgArr['pager']['total']		= 	$MySmartBB->pm->GetPrivateMassegeNumber($NumArr);
		$MsgArr['pager']['perpage'] 	= 	$MySmartBB->_CONF['info_row']['perpage'];
		$MsgArr['pager']['count'] 		= 	$MySmartBB->_GET['count'];
		$MsgArr['pager']['location'] 	= 	'index.php?page=pm&amp;show=1';
		$MsgArr['pager']['var'] 		= 	'count';
		
		if ($MySmartBB->_GET['folder'] == 'sent')
		{
			$GetMassegeList = $MySmartBB->pm->GetSentList($MsgArr);
		}
		else
		{
			$GetMassegeList = $MySmartBB->pm->GetInboxList($MsgArr);
		}
		
		$MySmartBB->_CONF['template']['while']['MassegeList'] = $GetMassegeList;
		
		$MySmartBB->template->assign('pager',$MySmartBB->pager->show());
		
		$MySmartBB->template->display('pm_list');
	}
	
	/**
	 * Get a massege information to show it
	 */
	function _ShowMassege()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إرسال رساله خاصه');
		
		if (empty($MySmartBB->_GET['id']))		
		{
			$MySmartBB->functions->error('المسار المتبع غير صحيح');
		}
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$MsgArr 			= 	array();
		$MsgArr['id'] 		= 	$MySmartBB->_GET['id'];
		$MsgArr['username'] = 	$MySmartBB->_CONF['member_row']['username'];
		
		$MySmartBB->_CONF['template']['MassegeRow'] = $MySmartBB->pm->GetPrivateMassegeInfo($MsgArr);
																		
		if (!$MySmartBB->_CONF['template']['MassegeRow'])
		{
			$MySmartBB->functions->error('الرساله المطلوبه غير موجوده');
		}
		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['MassegeRow'],'html');
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['MassegeRow'],'sql');
		
		$get_list  = 'id,username,user_sig,user_country,user_gender,register_date';
		$get_list .= ',posts,user_title,avater_path,away,away_msg,hide_online';
		
		$SenderArr = array();
		
		$SenderArr['get'] 		= 	$get_list;
		$SenderArr['where']		=	array('username',$MySmartBB->_CONF['template']['MassegeRow']['user_from']);
		
		$MySmartBB->_CONF['template']['Info'] = $MySmartBB->member->GetMemberInfo($SenderArr);
																		
		$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['Info'],'html');
		
		$send_text = $MySmartBB->_CONF['template']['MassegeRow']['text'];
		
		if (is_numeric($MySmartBB->_CONF['template']['Info']['register_date']))
		{
			$MySmartBB->_CONF['template']['Info']['register_date'] = $MySmartBB->functions->date($MySmartBB->_CONF['template']['Info']['register_date']);
		}
		
		$MySmartBB->_CONF['template']['Info']['user_gender'] 	= 	str_replace('m','ذكر',$MySmartBB->_CONF['template']['Info']['user_gender']);
		$MySmartBB->_CONF['template']['Info']['user_gender'] 	= 	str_replace('f','انثى',$MySmartBB->_CONF['template']['Info']['user_gender']);
		$MySmartBB->_CONF['template']['MassegeRow']['title']	=	str_replace('رد :','',$MySmartBB->_CONF['template']['MassegeRow']['title']);
		$MySmartBB->_CONF['template']['MassegeRow']['text'] 	=	$MySmartBB->smartparse->replace($MySmartBB->_CONF['template']['MassegeRow']['text']);
		
		$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['MassegeRow']['text']);
		
		if (is_numeric($MySmartBB->_CONF['template']['MassegeRow']['date']))
		{
			$MassegeDate = $MySmartBB->functions->date($MySmartBB->_CONF['template']['MassegeRow']['date']);
			$MassegeTime = $MySmartBB->functions->time($MySmartBB->_CONF['template']['MassegeRow']['date']);
			
			$MySmartBB->_CONF['template']['MassegeRow']['date'] = $MassegeDate . ' ; ' . $MassegeTime;
		}
		
		$AttachArr 				= 	array();
		$AttachArr['where'] 	= 	array('pm_id',$MySmartBB->_GET['id']);
		
		// Get the attachment information
		$MySmartBB->_CONF['template']['while']['AttachList'] = $MySmartBB->attach->GetAttachList($AttachArr);
		
		if ($MySmartBB->_CONF['template']['while']['AttachList'] != false)
		{
			$MySmartBB->template->assign('ATTACH_SHOW',true);

			$MySmartBB->functions->CleanVariable($MySmartBB->_CONF['template']['while']['AttachList'],'html');
		}
		
		// The writer signture isn't empty 
		if (!empty($MySmartBB->_CONF['template']['Info']['user_sig']))
		{
			// So , use the SmartCode in it
			$MySmartBB->_CONF['template']['Info']['user_sig'] = $MySmartBB->smartparse->replace($MySmartBB->_CONF['template']['Info']['user_sig']);
			$MySmartBB->smartparse->replace_smiles($MySmartBB->_CONF['template']['Info']['user_sig']);
		}
		
		$MySmartBB->template->assign('send_title','رد : ' . $MySmartBB->_CONF['template']['MassegeRow']['title']);
		$MySmartBB->template->assign('send_text','[quote]' . $send_text . '[/quote]');
		$MySmartBB->template->assign('to',$MySmartBB->_CONF['template']['MassegeRow']['user_from']);
				
		$MySmartBB->functions->GetEditorTools();
		
		$OnlineArr 				= 	array();	
		$OnlineArr['way'] 		= 	'username';
		$OnlineArr['username'] 	= 	$MySmartBB->_CONF['template']['MassegeRow']['user_from'];
		$OnlineArr['timeout'] 	= 	$MySmartBB->_CONF['timeout'];
		
		$CheckOnline = $MySmartBB->online->IsOnline($OnlineArr);
											
		($CheckOnline) ? $MySmartBB->template->assign('status',"<font class='online'>متصل</font>") : $MySmartBB->template->assign('status',"<font class='offline'>غير متصل</font>");
		
		/*if (!$MySmartBB->_CONF['template']['MassegeRow']['user_read'])
		{*/
			$ReadArr 						= 	array();
			$ReadArr['where'] 				= 	array();
			
			$ReadArr['where'][0] 			= 	array();
			$ReadArr['where'][0]['name'] 	= 	'id';
			$ReadArr['where'][0]['oper'] 	= 	'=';
			$ReadArr['where'][0]['value'] 	= 	$MySmartBB->_GET['id'];
			
			$Read = $MySmartBB->pm->MakeMassegeRead($ReadArr);
			
			if ($Read)
			{
				$NumArr 						= 	array();
				$NumArr['where'] 				= 	array();
		
				$NumArr['where'][0] 			= 	array();
				$NumArr['where'][0]['name'] 	= 	'user_to';
				$NumArr['where'][0]['oper'] 	= 	'=';
				$NumArr['where'][0]['value'] 	= 	$MySmartBB->_CONF['member_row']['username'];
		
				$NumArr['where'][1] 			= 	array();
				$NumArr['where'][1]['con'] 		= 	'AND';
				$NumArr['where'][1]['name'] 	= 	'folder';
				$NumArr['where'][1]['oper'] 	= 	'=';
				$NumArr['where'][1]['value'] 	= 	'inbox';
		
				$NumArr['where'][2] 			= 	array();
				$NumArr['where'][2]['con'] 		= 	'AND';
				$NumArr['where'][2]['name'] 	= 	'user_read';
				$NumArr['where'][2]['oper'] 	= 	'=';
				$NumArr['where'][2]['value'] 	= 	'1';
		
				$Number = $MySmartBB->pm->GetPrivateMassegeNumber($NumArr);
		      															
				$CacheArr 					= 	array();
				$CacheArr['field']			=	array();
				
				$CacheArr['field']['unread_pm'] 	= 	$Number;
				$CacheArr['where'] 					= 	array('username',$MySmartBB->_CONF['member_row']['username']);
				
				$Cache = $MySmartBB->member->UpdateMember($CacheArr);
			}
		//}
				
		$MySmartBB->template->display('usercp_menu');
		$MySmartBB->template->display('pm_show');
	}
		
	function _DeletePrivateMassege()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('تنفيذ عملية الحذف');
		
		$MySmartBB->_GET['id'] = $MySmartBB->functions->CleanVariable($MySmartBB->_GET['id'],'intval');
		
		$MySmartBB->functions->AddressBar('<a href="index.php?page=pm&amp;list=1&amp;folder=inbox">الرسائل الخاصه</a> ' . $MySmartBB->_CONF['info_row']['adress_bar_separate'] . ' تنفيذ عملية الحذف');
		
		if (empty($MySmartBB->_GET['id']))
		{
			$MySmartBB->functions->error('المعذره المسار المتبع غير صحيح .');
		}
		
		$DelArr 			= 	array();
		$DelArr['user_to'] 	= 	true;
		$DelArr['username']	=	$MySmartBB->_CONF['member_row']['username'];
		$DelArr['id']		=	$MySmartBB->_GET['id'];
		
		$del = $MySmartBB->pm->DeleteFromSenderList($DelArr);
		
		if ($del)
		{
			$MySmartBB->functions->msg('تم حذف الرساله بنجاح !');
			$MySmartBB->functions->goto('index.php?page=pm&list=1&folder=inbox');
		}
	}
		
	function _SettingIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إعدادات الرسائل الخاصه');
		
		$MySmartBB->template->display('pm_setting');
	}
	
	function _SettingStart()
	{
		global $MySmartBB;
		
		$MySmartBB->functions->ShowHeader('إعدادات الرسائل الخاصه');
		
		if ($MySmartBB->_POST['autoreply']
			and (!isset($MySmartBB->_POST['title']) or !isset($MySmartBB->_POST['msg'])))
		{
			$MySmartBB->functions->error('يرجى تعبئة كافة المعلومات');
		}
		
		$UpdateArr 				= 	array();
		$UpdateArr['field']		=	array();
		
		$UpdateArr['field']['autoreply'] 		= 	$MySmartBB->_POST['autoreply'];
		$UpdateArr['field']['autoreply_title'] 	= 	$MySmartBB->_POST['title'];
		$UpdateArr['field']['autoreply_msg'] 	= 	$MySmartBB->_POST['msg'];
		$UpdateArr['field']['pm_senders'] 		= 	$MySmartBB->_POST['pm_senders'];
		$UpdateArr['field']['pm_senders_msg'] 	= 	$MySmartBB->_POST['pm_senders_msg'];
		$UpdateArr['where']						=	array('id',$MySmartBB->_CONF['member_row']['id']);
		
		$update = $MySmartBB->member->UpdateMember($UpdateArr);
		
		if ($update)
		{
			$MySmartBB->functions->msg('تم تحديث البيانات بنجاح');
			$MySmartBB->functions->goto('index.php?page=pm&amp;setting=1&amp;index=1');
		}
	}
}

?>
