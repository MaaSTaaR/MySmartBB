<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

define('IN_ADMIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartOptionsMOD');
	
class MySmartOptionsMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( $MySmartBB->_CONF[ 'member_permission' ] )
		{
		    $MySmartBB->loadLanguage( 'admin_options' );
		    
			$MySmartBB->load( 'group' );
			
			$MySmartBB->template->display( 'header' );
		
			if ($MySmartBB->_GET['index'])
			{
				$this->_indexPage();
			}
			elseif ($MySmartBB->_GET['general'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_generalMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_generalUpdate();
				}
			}
			elseif ($MySmartBB->_GET['features'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_featuresMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_featuresUpdate();
				}
			}
			elseif ($MySmartBB->_GET['time'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_timeMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_timeUpdate();
				}
			}
			elseif ($MySmartBB->_GET['pages'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_pagesMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_pagesUpdate();
				}
			}
			elseif ($MySmartBB->_GET['register'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_registerMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_registerUpdate();
				}
			}
			elseif ($MySmartBB->_GET['topics'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_topicsMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_topicsUpdate();
				}
			}
			elseif ($MySmartBB->_GET['fast_reply'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_fastReplyMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_fastReplyUpdate();
				}
			}
			elseif ($MySmartBB->_GET['member'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_memberMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_memberUpdate();
				}
			}
			elseif ($MySmartBB->_GET['avatar'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_avatarMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_avatarUpdate();
				}
			}
			elseif ($MySmartBB->_GET['close_days'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_closeDaysMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_closeDaysUpdate();
				}
			}
			elseif ($MySmartBB->_GET['close'])
			{
				if ($MySmartBB->_GET['main'])
				{
					$this->_closeMain();
				}
				elseif ($MySmartBB->_GET['update'])
				{
					$this->_closeUpdate();
				}
			}
			
			$MySmartBB->template->display('footer');
		}
	}
	
	private function _indexPage()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_main');
	}
	
	private function _generalMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_general');
	}
	
	private function _generalUpdate()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'title' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		$update = array();
		$update[0] = $MySmartBB->info->updateInfo( 'title', $MySmartBB->_POST['title'] );
		$update[1] = $MySmartBB->info->updateInfo( 'send_email', $MySmartBB->_POST['send_email'] );
		$update[2] = $MySmartBB->info->updateInfo( 'admin_email', $MySmartBB->_POST['admin_email'] );
		
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;general=1&amp;main=1');
		}
	}
	
	private function _featuresMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_features');
	}
	
	private function _featuresUpdate()
	{
		global $MySmartBB;
		
		$update = array();
		$update[0] = $MySmartBB->info->updateInfo( 'show_onlineguest', $MySmartBB->_POST['guest_online'] );
		$update[1] = $MySmartBB->info->updateInfo( 'pm_feature', $MySmartBB->_POST['pm_feature'] );
		$update[2] = $MySmartBB->info->updateInfo( 'describe_feature', $MySmartBB->_POST['describe_feature'] );
		
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;features=1&amp;main=1');
		}
	}
	
	private function _timeMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_time');
	}
	
	private function _timeUpdate()
	{
		global $MySmartBB;
		
		$update = array();
		$update[0] = $MySmartBB->info->updateInfo( 'timestamp', $MySmartBB->_POST['time_stamp'] );
		$update[1] = $MySmartBB->info->updateInfo( 'timesystem', $MySmartBB->_POST['time_system'] );
		
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;time=1&amp;main=1');
		}
	}
	
	private function _pagesMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_page');
	}
	
	private function _pagesUpdate()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['page_max']) 
			or empty($MySmartBB->_POST['subject_perpage']) 
			or empty($MySmartBB->_POST['reply_perpage'])
			or empty($MySmartBB->_POST['avatar_perpage']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$update = array();
		
		$update[0] = $MySmartBB->info->updateInfo( 'page_max', $MySmartBB->_POST['page_max'] );
		$update[1] = $MySmartBB->info->updateInfo( 'subject_perpage', $MySmartBB->_POST['subject_perpage'] );
		$update[2] = $MySmartBB->info->updateInfo( 'perpage', $MySmartBB->_POST['reply_perpage'] );
		$update[3] = $MySmartBB->info->updateInfo( 'avatar_perpage', $MySmartBB->_POST['avatar_perpage'] );
		
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;pages=1&amp;main=1');
		}
	}
	
	private function _registerMain()
	{
		global $MySmartBB;
		
		// ... //
		
		$MySmartBB->rec->select = 'id,title';
		$MySmartBB->rec->table = $MySmartBB->table[ 'group' ];
		$MySmartBB->rec->order = "group_order ASC";
		
		$MySmartBB->rec->getList();
		
		$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'groups' ] = array();
		$k = 0;
		
		while ( $r = $MySmartBB->rec->getInfo() )
		{
			$MySmartBB->_CONF[ 'template' ][ 'foreach' ][ 'groups' ][ $k ] = $r;
			
			$k++;
		}
		
		// ... //
		
		$MySmartBB->template->display('options_register');
	}
	
	private function _registerUpdate()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['reg_less_num']) 
			or empty($MySmartBB->_POST['reg_max_num']) 
			or empty($MySmartBB->_POST['reg_pass_min_num']) 
			or empty($MySmartBB->_POST['reg_pass_max_num']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$update = array();
		$update[0] = $MySmartBB->info->updateInfo( 'reg_close', $MySmartBB->_POST['reg_close'] );
		$update[1] = $MySmartBB->info->updateInfo( 'def_group', $MySmartBB->_POST['def_group'] );
		$update[2] = $MySmartBB->info->updateInfo( 'adef_group', $MySmartBB->_POST['adef_group'] );
		$update[3] = $MySmartBB->info->updateInfo( 'reg_o', $MySmartBB->_POST['reg_o'] );
		$update[4] = $MySmartBB->info->updateInfo( 'reg_less_num', $MySmartBB->_POST['reg_less_num'] );
		$update[5] = $MySmartBB->info->updateInfo( 'reg_max_num', $MySmartBB->_POST['reg_max_num'] );
		$update[6] = $MySmartBB->info->updateInfo( 'reg_pass_min_num', $MySmartBB->_POST['reg_pass_min_num'] );
		$update[7] = $MySmartBB->info->updateInfo( 'reg_pass_max_num', $MySmartBB->_POST['reg_pass_max_num'] );
		$update[8] = $MySmartBB->info->updateInfo( 'reg_Sat', $MySmartBB->_POST['Sat'] );
		$update[9] = $MySmartBB->info->updateInfo( 'reg_Sun', $MySmartBB->_POST['Sun'] );
		$update[10] = $MySmartBB->info->updateInfo( 'reg_Mon', $MySmartBB->_POST['Mon'] );
		$update[11] = $MySmartBB->info->updateInfo( 'reg_Tue', $MySmartBB->_POST['Tue'] );
		$update[12] = $MySmartBB->info->updateInfo( 'reg_Wed', $MySmartBB->_POST['Wed'] );
		$update[13] = $MySmartBB->info->updateInfo( 'reg_Thu', $MySmartBB->_POST['Thu'] );
		$update[14] = $MySmartBB->info->updateInfo( 'reg_Fri', $MySmartBB->_POST['Fri'] );
		$update[ 15 ] = $MySmartBB->info->updateInfo( 'register_rules', $MySmartBB->_POST[ 'register_rules' ] );
		
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;register=1&amp;main=1');
		}
	}
	
	private function _topicsMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_topics');
	}
	
	private function _topicsUpdate()
	{
		global $MySmartBB;
		
		if (!isset($MySmartBB->_POST['post_text_min']) 
			or !isset($MySmartBB->_POST['post_text_max']) 
			or !isset($MySmartBB->_POST['post_title_min']) 
			or !isset($MySmartBB->_POST['post_title_max']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
		
		$update = array();
		$update[0] = $MySmartBB->info->updateInfo( 'post_text_min', $MySmartBB->_POST['post_text_min'] );
		$update[1] = $MySmartBB->info->updateInfo( 'post_text_max', $MySmartBB->_POST['post_text_max'] );
		$update[2] = $MySmartBB->info->updateInfo( 'post_title_min', $MySmartBB->_POST['post_title_min'] );
		$update[3] = $MySmartBB->info->updateInfo( 'post_title_max', $MySmartBB->_POST['post_title_max'] );
		$update[4] = $MySmartBB->info->updateInfo( 'samesubject_show', $MySmartBB->_POST['samesubject_show'] );
		$update[5] = $MySmartBB->info->updateInfo( 'show_subject_all', $MySmartBB->_POST['show_subject_all'] );
		
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;topics=1&amp;main=1');
		}
	}
	
	private function _fastReplyMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_fast_reply');
	}
	
	private function _fastReplyUpdate()
	{
		global $MySmartBB;
		
		$update = array();
		$update[0] = $MySmartBB->info->updateInfo( 'fastreply_allow', $MySmartBB->_POST['fastreply_allow'] );
		$update[1] = $MySmartBB->info->updateInfo( 'toolbox_show', $MySmartBB->_POST['toolbox_show'] );
		$update[2] = $MySmartBB->info->updateInfo( 'smiles_show', $MySmartBB->_POST['smiles_show'] );
		$update[3] = $MySmartBB->info->updateInfo( 'icons_show', $MySmartBB->_POST['icons_show'] );
		$update[4] = $MySmartBB->info->updateInfo( 'title_quote', $MySmartBB->_POST['title_quote'] );
		$update[5] = $MySmartBB->info->updateInfo( 'activate_closestick', $MySmartBB->_POST['activate_closestick'] );
		
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;fast_reply=1&amp;main=1');
		}
	}
	
	private function _memberMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_member');
	}
	
	private function _memberUpdate()
	{
		global $MySmartBB;
		
		$update = array();
		$update[0] = $MySmartBB->info->updateInfo( 'allow_apsent', $MySmartBB->_POST['allow_apsent'] );
		
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;member=1&amp;main=1');
		}
	}

	private function _avatarMain()
	{
		global $MySmartBB;

		$MySmartBB->template->display('options_avatar');
	}
	
	private function _avatarUpdate()
	{
		global $MySmartBB;
		
		if (empty($MySmartBB->_POST['max_avatar_width'])
			and empty($MySmartBB->_POST['max_avatar_height']))
		{
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		}
			
		$update = array();
		$update[0] = $MySmartBB->info->updateInfo( 'allow_avatar', $MySmartBB->_POST['allow_avatar'] );
		$update[1] = $MySmartBB->info->updateInfo( 'upload_avatar', $MySmartBB->_POST['upload_avatar'] );
		$update[2] = $MySmartBB->info->updateInfo( 'max_avatar_width', $MySmartBB->_POST['max_avatar_width'] );
		$update[3] = $MySmartBB->info->updateInfo( 'max_avatar_height', $MySmartBB->_POST['max_avatar_height'] );
		$update[4] = $MySmartBB->info->updateInfo( 'default_avatar', $MySmartBB->_POST['default_avatar'] );
		
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;avatar=1&amp;main=1');
		}
	}

	private function _closeDaysMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_days');
	}
	
	private function _closeDaysUpdate()
	{
		global $MySmartBB;
			
		$update = array();
		$update[0] = $MySmartBB->info->updateInfo( 'Sat', $MySmartBB->_POST['Sat'] );
		$update[1] = $MySmartBB->info->updateInfo( 'Sun', $MySmartBB->_POST['Sun'] );
		$update[2] = $MySmartBB->info->updateInfo( 'Mon', $MySmartBB->_POST['Mon'] );
		$update[3] = $MySmartBB->info->updateInfo( 'Tue', $MySmartBB->_POST['Tue'] );
		$update[4] = $MySmartBB->info->updateInfo( 'Wed', $MySmartBB->_POST['Wed'] );
		$update[5] = $MySmartBB->info->updateInfo( 'Thu', $MySmartBB->_POST['Thu'] );
		$update[6] = $MySmartBB->info->updateInfo( 'Fri', $MySmartBB->_POST['Fri'] );
		
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;close_days=1&amp;main=1');
		}
	}
	
	private function _closeMain()
	{
		global $MySmartBB;
		
		$MySmartBB->template->display('options_close');
	}
	
	private function _closeUpdate()
	{
		global $MySmartBB;
			
		$update = array();
		$update[0] = $MySmartBB->info->updateInfo( 'board_close', $MySmartBB->_POST['board_close'] );
		$update[1] = $MySmartBB->info->updateInfo( 'board_msg', $MySmartBB->_POST['board_msg'] );
				
		if ( !in_array( false, $update ) )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'update_succeed' ] );
			$MySmartBB->func->move('admin.php?page=options&amp;close=1&amp;main=1');
		}
	}
}

?>
