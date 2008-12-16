<?php

/**
 * MySmartBB Engine
 */

////////////
// General systems
require_once('config.php');
require_once('libs/functions.class.php');
require_once('libs/db.class.php');
require_once('libs/records.class.php');
require_once('libs/pager.class.php');

////////////

if (is_array($CALL_SYSTEM))
{
	////////////
	
	$files = array();
	
	$files[] = ($CALL_SYSTEM['INFO']) 				? 'info.class.php' : null;
	$files[] = ($CALL_SYSTEM['ADS']) 				? 'ads.class.php' : null;
	$files[] = ($CALL_SYSTEM['ANNOUNCEMENT']) 		? 'announcement.class.php' : null;
	$files[] = ($CALL_SYSTEM['AVATAR']) 			? 'avatar.class.php' : null;
	$files[] = ($CALL_SYSTEM['BANNED']) 			? 'banned.class.php' : null;
	$files[] = ($CALL_SYSTEM['GROUP']) 				? 'group.class.php' : null;
	$files[] = ($CALL_SYSTEM['MEMBER']) 			? 'member.class.php' : null;
	$files[] = ($CALL_SYSTEM['ONLINE']) 			? 'online.class.php' : null;
	$files[] = ($CALL_SYSTEM['PAGES']) 				? 'pages.class.php' : null;
	$files[] = ($CALL_SYSTEM['PM']) 				? 'pm.class.php' : null;
	$files[] = ($CALL_SYSTEM['REPLY']) 				? 'reply.class.php' : null;
	$files[] = ($CALL_SYSTEM['SEARCH']) 			? 'search.class.php' : null;
	$files[] = ($CALL_SYSTEM['SECTION']) 			? 'sections.class.php' : null;
	$files[] = ($CALL_SYSTEM['STYLE']) 				? 'style.class.php' : null;
	$files[] = ($CALL_SYSTEM['SUBJECT']) 			? 'subject.class.php' : null;
	$files[] = ($CALL_SYSTEM['CACHE']) 				? 'cache.class.php' : null;
	$files[] = ($CALL_SYSTEM['REQUEST']) 			? 'request.class.php' : null;
	$files[] = ($CALL_SYSTEM['MISC']) 				? 'misc.class.php' : null;
	$files[] = ($CALL_SYSTEM['MESSAGE']) 			? 'messages.class.php' : null;
	$files[] = ($CALL_SYSTEM['ATTACH']) 			? 'attach.class.php' : null;
	$files[] = ($CALL_SYSTEM['FIXUP']) 				? 'fixup.class.php' : null;
	$files[] = ($CALL_SYSTEM['FILESEXTENSION']) 	? 'extension.class.php' : null;
	$files[] = ($CALL_SYSTEM['USERTITLE']) 			? 'usertitle.class.php' : null;
	$files[] = ($CALL_SYSTEM['ICONS']) 				? 'icons.class.php' : null;
	$files[] = ($CALL_SYSTEM['TOOLBOX']) 			? 'toolbox.class.php' : null;
	$files[] = ($CALL_SYSTEM['MODERATORS']) 		? 'moderators.class.php' : null;
	$files[] = ($CALL_SYSTEM['POLL']) 				? 'poll.class.php' : null;
	$files[] = ($CALL_SYSTEM['VOTE']) 				? 'vote.class.php' : null;
	$files[] = ($CALL_SYSTEM['TAG']) 				? 'tags.class.php' : null;
	
	////////////

	if (sizeof($files) > 0)
	{
		foreach ($files as $filename)
		{
			if (!is_null($filename))
			{
				require_once(DIR . 'engine/systems/' . $filename);
			}
		}
	}
	
	////////////
}

////////////

class Engine
{
	////////////
	
	// General systems
	var $DB;
	var $sys_functions;
	var $records;
	var $pager;
	
	////////////
	
	// Systems
	var $ads;
	var $announcement;
	var $avatar;
	var $banned;
	var $group;
	var $member;
	var $online;
	var $pages;
	var $pm;
 	var $postcontrol;
	var $reply;
	var $search;
	var $section;
	var $style;
	var $subject;
	var $cache;
	var $misc;
	var $smartcode;
	var $request;
	var $massege;
	var $attach;
	var $info;
	var $usertitle;
	var $toolbox;
	var $fixup;
	var $extension;
	
	////////////
 	// Other variables
	var $_CONF		=	array();
	var $_GET		=	array();
	var $_POST		=	array();
	var $_COOKIE	=	array();
	var $_FILES		=	array();
	var $_SERVER	=	array();
	
	////////////
	
	// Tables
	var $prefix 	= 	'MySmartBB_';
	var $table 		= 	array();
	
	////////////

	// Main system
	function Engine()
	{
		global $config,$_VARS,$CALL_SYSTEM;
		
		////////////
		
		// General systems
  		$this->DB				= 	new MySmartSQL;
  		$this->pager			=	new MySmartPager;
  		$this->sys_functions	=	new MySmartSystemFunctions($this);
  		$this->records			=	new MySmartRecords($this);  	
  		
  		////////////	
  		
  		$this->DB->SetInformation(	$config['db']['server'],
  									$config['db']['username'],
  									$config['db']['password'],
  									$config['db']['name']);
  									
  		////////////
  		
  		if (!empty($config['db']['prefix']))
  		{
  			$this->prefix = $config['db']['prefix'];
  		}
  		
  		////////////
  		
  		$this->table['ads'] 			= 	$this->prefix . 'ads';
  		$this->table['announcement'] 	= 	$this->prefix . 'announcement';
  		$this->table['attach'] 			= 	$this->prefix . 'attach';
  		$this->table['avatar'] 			= 	$this->prefix . 'avatar';
  		$this->table['banned'] 			= 	$this->prefix . 'banned';
  		$this->table['email_msg'] 		= 	$this->prefix . 'email_msg';
  		$this->table['extension'] 		= 	$this->prefix . 'extension';
  		$this->table['group'] 			= 	$this->prefix . 'group';
  		$this->table['info'] 			= 	$this->prefix . 'info';
  		$this->table['member']			= 	$this->prefix . 'member';
  		$this->table['online'] 			= 	$this->prefix . 'online';
  		$this->table['pages'] 			= 	$this->prefix . 'pages';
  		$this->table['pm'] 				= 	$this->prefix . 'pm';
  		$this->table['pm_folder'] 		= 	$this->prefix . 'pm_folder';
  		$this->table['pm_lists'] 		= 	$this->prefix . 'pm_lists';
  		$this->table['poll'] 			= 	$this->prefix . 'poll';
  		$this->table['reply'] 			= 	$this->prefix . 'reply';
  		$this->table['requests'] 		= 	$this->prefix . 'requests';
  		$this->table['section'] 		= 	$this->prefix . 'section';
  		$this->table['smiles'] 			= 	$this->prefix . 'smiles';
  		$this->table['style'] 			= 	$this->prefix . 'style';
  		$this->table['subject'] 		= 	$this->prefix . 'subject';
  		$this->table['sm_logs'] 		= 	$this->prefix . 'supermemberlogs';
  		$this->table['today'] 			= 	$this->prefix . 'today';
  		$this->table['toolbox'] 		= 	$this->prefix . 'toolbox';
  		$this->table['usertitle'] 		= 	$this->prefix . 'usertitle';
  		$this->table['vote'] 			= 	$this->prefix . 'vote';
  		$this->table['section_group']	=	$this->prefix . 'sectiongroup';
  		$this->table['extension']		=	$this->prefix . 'ex';
  		$this->table['moderators']		=	$this->prefix . 'moderators';
  		$this->table['cats']			=	$this->prefix . 'cats';
  		$this->table['tag']				=	$this->prefix . 'tags';
  		$this->table['tag_subject']		=	$this->prefix . 'tags_subject';
  		
  		////////////
  		
    	$this->_CONF['temp']					=	array();
    	$this->_CONF['info']					=	array();
    	$this->_CONF['info_row']				=	array();
    	
    	$this->_CONF['now']						=	time();
 		$this->_CONF['timeout']					=	time()-300;
 		$this->_CONF['date']					=	date('j/n/Y');
 		$this->_CONF['day']						=	date('D');
 		$this->_CONF['temp']['query_num']		=	0;
 		$this->_CONF['username_cookie']			=	'MySmartBB_username';
 		$this->_CONF['password_cookie']			=	'MySmartBB_password';
 		$this->_CONF['admin_username_cookie']	=	'MySmartBB_admin_username';
 		$this->_CONF['admin_password_cookie']	=	'MySmartBB_admin_password';
 		$this->_CONF['style_cookie']			=	'MySmartBB_style';
 		
 		////////////
 		
 		// Connect to database
 		$this->DB->sql_connect();
  		$this->DB->sql_select_db();
  		
  		////////////
  		
  		// Ensure if tables are installed or not
  		$check = $this->DB->check($this->prefix . 'info');
  		
  		// Well, the table "MySBB_info" isn't exists, so return an error message
  		if (!$check
  			and !defined('INSTALL'))
  		{
  			return 'ERROR::THE_TABLES_ARE_NOT_INSTALLED';
  		}
  		
  		////////////
  		
  		// Get informations from info table
  		if (!defined('NO_INFO'))
  		{
 			$this->_GetInfoRows();
 		}
 		
 		////////////
 		
 		$this->sys_functions->LocalArraySetup();
 		
 		////////////
 		
 		$this->_CONF['ip'] = $this->_SERVER['REMOTE_ADDR'];
  		
  		////////////
  		
		$this->info 			= 	($CALL_SYSTEM['INFO']) 				? new MySmartInfo($this) : null;
		$this->ads 				= 	($CALL_SYSTEM['ADS']) 				? new MySmartAds($this) : null;
		$this->announcement 	= 	($CALL_SYSTEM['ANNOUNCEMENT']) 		? new MySmartAnnouncement($this) : null;
		$this->avatar 			= 	($CALL_SYSTEM['AVATAR']) 			? new MySmartAvatar($this) : null;
		$this->banned 			= 	($CALL_SYSTEM['BANNED']) 			? new MySmartBanned($this) : null;
		$this->group 			= 	($CALL_SYSTEM['GROUP']) 			? new MySmartGroup($this) : null;
		$this->member 			= 	($CALL_SYSTEM['MEMBER']) 			? new MySmartMember($this) : null;
		$this->online 			= 	($CALL_SYSTEM['ONLINE']) 			? new MySmartOnline($this) : null;
		$this->pages 			= 	($CALL_SYSTEM['PAGES']) 			? new MySmartPages($this) : null;
		$this->pm 				= 	($CALL_SYSTEM['PM']) 				? new MySmartPM($this) : null;
		$this->reply 			= 	($CALL_SYSTEM['REPLY']) 			? new MySmartReply($this) : null;
		$this->search 			= 	($CALL_SYSTEM['SEARCH']) 			? new MySmartSearch($this) : null;
		$this->section 			= 	($CALL_SYSTEM['SECTION']) 			? new MySmartSection($this) : null;
		$this->style 			= 	($CALL_SYSTEM['STYLE']) 			? new MySmartStyle($this) : null;
		$this->subject 			= 	($CALL_SYSTEM['SUBJECT']) 			? new MySmartSubject($this) : null;
		$this->cache 			= 	($CALL_SYSTEM['CACHE']) 			? new MySmartCache($this) : null;
		$this->misc 			= 	($CALL_SYSTEM['MISC']) 				? new MySmartMisc($this) : null;
		$this->request 			= 	($CALL_SYSTEM['REQUEST']) 			? new MySmartRequest($this) : null;
		$this->message 			= 	($CALL_SYSTEM['MESSAGE']) 			? new MySmartMessages($this) : null;
		$this->attach 			= 	($CALL_SYSTEM['ATTACH']) 			? new MySmartAttach($this) : null;
		$this->fixup 			= 	($CALL_SYSTEM['FIXUP']) 			? new MySmartFixup($this) : null;
		$this->extension 		= 	($CALL_SYSTEM['FILESEXTENSION']) 	? new MySmartFileExtension($this) : null;
		$this->usertitle 		= 	($CALL_SYSTEM['USERTITLE']) 		? new MySmartUsertitle($this) : null;
		$this->icon 			= 	($CALL_SYSTEM['ICONS']) 			? new MySmartIcons($this) : null;
		$this->toolbox 			= 	($CALL_SYSTEM['TOOLBOX']) 			? new MySmartToolBox($this) : null;
		$this->moderator 		= 	($CALL_SYSTEM['MODERATORS']) 		? new MySmartModerators($this) : null;
		$this->poll 			= 	($CALL_SYSTEM['POLL']) 				? new MySmartPoll($this) : null;
		$this->vote 			= 	($CALL_SYSTEM['VOTE']) 				? new MySmartVote($this) : null;
		$this->tag 				= 	($CALL_SYSTEM['TAG']) 				? new MySmartTag($this) : null;
		
		////////////
		
		// Free memory
		unset($CALL_SYSTEM);
	
		////////////
		
		return true;
		
		////////////
 	}
 	
 	////////////
 	
 	function _GetInfoRows()
	{
		// TODO :: Cache me please!
		
		$arr 				= 	array();
		$arr['select'] 		= 	'*';
		$arr['from'] 		= 	$this->table['info'];
		
		$rows = $this->records->GetList($arr);
		
		$x = 0;
		$y = sizeof($rows);
		
		while ($x <= $y)
		{
			$this->_CONF['info_row'][$rows[$x]['var_name']] = $rows[$x]['value'];
				
			$x += 1;
		}
	}
	
	////////////
}

?>
