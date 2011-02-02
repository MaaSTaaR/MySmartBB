<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

$CALL_SYSTEM				=	array();
$CALL_SYSTEM['SUBJECT'] 	= 	true;
$CALL_SYSTEM['SECTION'] 	= 	true;
$CALL_SYSTEM['MODERATORS'] 	= 	true;
$CALL_SYSTEM['REPLY'] 		= 	true;

define('JAVASCRIPT_SMARTCODE',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartAJAXtMOD');

class MySmartAJAXtMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ($MySmartBB->_GET['management'])
		{
			$MySmartBB->_POST['section'] = (int) $MySmartBB->_POST['section'];
			
			if ($MySmartBB->func->moderatorCheck( $MySmartBB->_POST['section'] ))
			{
				$MySmartBB->_POST['subject'] = (int) $MySmartBB->_POST['subject'];
				
				if (empty($MySmartBB->_POST['subject']))
				{
					echo 'المسار المتبع غير صحيح';
				}
				else
				{
					if ($MySmartBB->_POST['oper'] == 'stick')
					{
						$update = $MySmartBB->subject->stickSubject($MySmartBB->_POST['subject']);
		
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
						$update = $MySmartBB->subject->unStickSubject( $MySmartBB->_POST['subject'] );
		
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
						$update = $MySmartBB->subject->closeSubject( $MySmartBB->_POST['subject'] );
						
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
						$update = $MySmartBB->subject->openSubject( $MySmartBB->_POST['subject'] );
						
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
						$update = $MySmartBB->subject->moveSubjectToTrash( $MySmartBB->_POST['subject'] );
						
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
						$MySmartBB->rec->fields = array(	'write_time'	=>	time() - ( intval('-42') ) );
						$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST['subject'] . "'";
						
						$update =  $MySmartBB->subject->updateSubject();
						
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
						$MySmartBB->rec->fields = array(	'write_time'	=>	time() - ( intval('420000000000000000000') ) );
						$MySmartBB->rec->filter = "id='" . $MySmartBB->_POST['subject'] . "'";
						
						$update = $MySmartBB->subject->updateSubject();
						
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
