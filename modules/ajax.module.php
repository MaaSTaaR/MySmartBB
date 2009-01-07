<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['MODERATORS'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;

define('JAVASCRIPT_SMARTCODE',true);

include('common.php');

define('CLASS_NAME','MySmartAJAXtMOD');

class MySmartAJAXtMOD
{
	function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['management'])
		{
			if ($MySmartBB->functions->ModeratorCheck())
			{
				$MySmartBB->_POST['subject'] = $MySmartBB->functions->CleanVariable($MySmartBB->_POST['subject'],'intval');
				
				if (empty($MySmartBB->_POST['subject']))
				{
					echo 'المسار المتبع غير صحيح';
				}
				else
				{
					if ($MySmartBB->_POST['oper'] == 'stick')
					{
						$UpdateArr 			= array();
						$UpdateArr['where'] = array('id',$MySmartBB->_POST['subject']);
		
						$update = $MySmartBB->subject->StickSubject($UpdateArr);
		
						if ($update)
						{
							echo 'تم تثبيت الموضوع';
						}
						else
						{
							echo 'لم يتم تثبيت الموضوع';
						}
					}
					else if ($MySmartBB->_POST['oper'] == 'unstick')
					{
						$UpdateArr 			= array();
						$UpdateArr['where'] = array('id',$MySmartBB->_POST['subject']);
		
						$update = $MySmartBB->subject->UnstickSubject($UpdateArr);
		
						if ($update)
						{
							echo 'تم إلغاء تثبيت الموضوع';
						}
						else
						{
							echo 'لم يتم إلغاء تثبيت الموضوع';
						}
					}
					else if ($MySmartBB->_POST['oper'] == 'close')
					{
						$UpdateArr 				= 	array();
						$UpdateArr['where'] 	= 	array('id',$MySmartBB->_POST['subject']);
						
						$update = $MySmartBB->subject->CloseSubject($UpdateArr);
						
						if ($update)
						{
							echo 'تم إغلاق الموضوع';
						}
						else
						{
							echo 'لم يتم اغلاق الموضوع';
						}
					}
					else if ($MySmartBB->_POST['oper'] == 'open')
					{
						$UpdateArr 				= 	array();
						$UpdateArr['where'] 	= 	array('id',$MySmartBB->_POST['subject']);
						
						$update = $MySmartBB->subject->OpenSubject($UpdateArr);
						
						if ($update)
						{
							echo 'تم فتح الموضوع';
						}
						else
						{
							echo 'لم يتم فتح الموضوع';
						}
					}
					else if ($MySmartBB->_POST['oper'] == 'delete')
					{
						$UpdateArr 				= 	array();
						$UpdateArr['where'] 	= 	array('id',$MySmartBB->_POST['subject']);
						
						$update = $MySmartBB->subject->MoveSubjectToTrash($UpdateArr);
						
						if ($update)
						{
							echo 'تم نقل الموضوع إلى سلة المحذوفات';
						}
						else
						{
							echo 'لم يتم نقل الموضوع إلى سلة المحذوفات';
						}
					}
					else if ($MySmartBB->_POST['oper'] == 'up')
					{
						$UpdateArr 							= 	array();
						$UpdateArr['field']['write_time'] 	= 	time() - ( intval('-42') );
						$UpdateArr['where'] 				= 	array('id',$MySmartBB->_POST['subject']);
						
						$update =  $MySmartBB->subject->UpdateSubject($UpdateArr);
						
						if ($update)
						{
							echo 'تم رفع الموضوع';
						}
						else
						{
							echo 'لم يتم رفع الموضوع';
						}
					}
					else if ($MySmartBB->_POST['oper'] == 'down')
					{
						$UpdateArr 							= 	array();
						$UpdateArr['field']['write_time'] 	= 	time() - ( intval('420000000000000000000') );
						$UpdateArr['where'] 				= 	array('id',$MySmartBB->_POST['subject']);
						
						$update = $MySmartBB->subject->UpdateSubject($UpdateArr);
						
						if ($update)
						{
							echo 'تم تنزيل الموضوع';
						}
						else
						{
							echo 'لم يتم تنزيل الموضوع';
						}
					}
				}
			}
			else
			{
				echo 'غير مسموح لك الوصول';
			}
		}
	}
}

?>
