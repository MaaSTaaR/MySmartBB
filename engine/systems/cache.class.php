<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */

/**
 * @package 	: 	MySmartCache
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @start 		: 	15/6/2006 , 10:46 PM
 * @updated 	: 	01/15/2008 06:04:39 PM 
 */

class MySmartCache
{
	var $Engine;
	
	function MySmartCache($Engine)
	{
		$this->Engine = $Engine;
	}
	
	/**
	 * Update the last member
	 *
	 * $param =
	 *			array(	'username'=>'the username of new member',
	 *					'id'=>'the id of new member');
	 *
	 * @return
	 *			true -> when success
	 *			false -> when fail
	 */
	function UpdateLastMember($param)
	{
		if (!isset($param['member_num'])
			or empty($param['id']))
		{
			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
		}
		
		$updates = array();
		
		// Get member number
		$member_num 	= 	$param['member_num'];
		// Add 1 to member number
		$member_num 	+= 	1;
		
		$update[0] = $this->Engine->info->UpdateInfo(array('var_name'=>'last_member','value'=>$param['username']));
		$update[1] = $this->Engine->info->UpdateInfo(array('var_name'=>'last_member_id','value'=>$param['id']));
		$update[2] = $this->Engine->info->UpdateInfo(array('var_name'=>'member_number','value'=>$member_num));
		
		return ($update[0] and $update[1] and $update[2]) ? true : false;
	}
	
	/**
	 * Update the total of subjects
	 *
	 * $param =
	 *			array('subject_num'=>'the total of subject');
	 *
	 * @return 
	 *			true -> when success
	 *			false -> when fail
	 */
	function UpdateSubjectNumber($param)
	{
		if (empty($param['subject_num']))
		{
			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
		}
		
		$val = $param['subject_num'] + 1;
		
		$update = $this->Engine->info->UpdateInfo(array('var_name'=>'subject_number','value'=>$val));
		
		return ($update) ? true : false;
	}
	
	/**
	 * Update the total of replys
	 *
	 * $param =
	 *			array('reply_num'=>'the total of replies');
	 *
	 * @return
	 *			true -> when success
	 *			false -> when fail
	 */
	function UpdateReplyNumber($param)
	{
		if (!isset($param['reply_num']))
		{
			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
		}
		
		$val = $param['reply_num'] + 1;
		
		$update = $this->Engine->info->UpdateInfo(array('var_name'=>'reply_number','value'=>$val));
		
		return ($update) ? true : false;
	}
}

?>
