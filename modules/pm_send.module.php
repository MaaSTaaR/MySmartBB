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

define('CLASS_NAME','MySmartPrivateMassegeSendMOD');

class MySmartPrivateMassegeSendMOD
{
	function run()
	{
		global $MySmartBB;
		
		if (!$MySmartBB->_CONF['info_row']['pm_feature'])
		{
			$MySmartBB->functions->error('المعذره .. خاصية الرسائل الخاصة موقوفة حاليا');
		}
		
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
     	
     	$MySmartBB->functions->goto('index.php?page=pm_list&amp;list=1&amp;folder=inbox');
	}
}

?>
		
