<?php

// ... //

// General systems
require_once( DIR . 'includes/systems/functions.class.php' );
require_once( DIR . 'includes/systems/template.class.php' );
require_once( DIR . 'includes/systems/template.compiler.class.php' );
require_once( DIR . 'includes/systems/smartcodeparse.class.php' );
require_once( DIR . 'includes/systems/plugins.class.php' );
require_once( DIR . 'includes/systems/db.class.php');
require_once( DIR . 'includes/systems/records.class.php');
require_once( DIR . 'includes/systems/pager.class.php');

// Functions
require_once( DIR . 'includes/functions/member.class.php');
require_once( DIR . 'includes/functions/info.class.php');
require_once( DIR . 'includes/functions/online.class.php');
require_once( DIR . 'includes/functions/style.class.php');

require_once( DIR . 'includes/config.php');

// ... //

class MySmartBB
{
	// ... //
	
	// General systems
	public $func;
	public $template;
	public $smartparse;
	public $plugin;
	public $pager;
	public $rec;
	public $db;
	
	// Functions
	public $member = null;
	public $info = null;
	public $online = null;
	public $style = null;
	public $subject = null;
	public $reply = null;
	public $pm = null;
	public $section = null;
	public $cache = null;
	public $banned = null;
	public $massege = null;
	public $vote = null;
	public $group = null;
	public $moderator = null;
	public $icon = null;
	public $toolbox = null;
	public $poll = null;
	
	// ... //

	// Other variables
	public $_CONF		=	array();
	public $_GET		=	array();
	public $_POST		=	array();
	public $_COOKIE		=	array();
	public $_FILES		=	array();
	public $_SERVER		=	array();

	// ... //

	// Tables
	private $prefix 	= 	'MySmartBB_';
	public $table 		= 	array();

	// ... //
	
	private $func_list = null;
	
	function __construct()
	{
		global $config;
		
		// General systems
  		$this->db				= 	new MySmartSQL( $config['db']['server'], $config['db']['username'], 
  													$config['db']['password'], $config['db']['name'] );
  		$this->pager			=	new MySmartPager;
  		$this->func 			= 	new MySmartFunctions();
  		$this->rec				=	new MySmartRecords($this->db, $this->func, $this->pager); 
  		
  		// ... //
  		  		
  		$this->initTableList();
 		
 		// ... //
 		
 		$this->initDB();
  		
  		// ... //
  		
  		$this->initInfo();
 		
		// ... //
		
		$this->initPredefinedVars();
		
		// ... //
		
		$this->initVariables();
		
		// ... //
		
		$this->initClasses();
		
		// ... //
		
  		if (!is_bool($e)
  			and $e == 'ERROR::THE_TABLES_ARE_NOT_INSTALLED'
  			and !defined('INSTALL'))
  		{
  			$this->func->move( './setup/install/', 0 );
  			$this->func->stop( true );
  		}
  	}
  	
  	// ... //
  	
  	private function initTableList()
  	{
  		global $config;
  		
  		if (!empty($config['db']['prefix']))
  		{
  			$this->prefix = $config['db']['prefix'];
  		}

  		$this->table['ads'] 				= 	$this->prefix . 'ads';
  		$this->table['announcement'] 		= 	$this->prefix . 'announcement';
  		$this->table['attach'] 				= 	$this->prefix . 'attach';
  		$this->table['avatar'] 				= 	$this->prefix . 'avatar';
  		$this->table['banned'] 				= 	$this->prefix . 'banned';
  		$this->table['email_msg'] 			= 	$this->prefix . 'email_msg';
  		$this->table['extension'] 			= 	$this->prefix . 'extension';
  		$this->table['group'] 				= 	$this->prefix . 'group';
  		$this->table['info'] 				= 	$this->prefix . 'info';
  		$this->table['member']				= 	$this->prefix . 'member';
  		$this->table['online'] 				= 	$this->prefix . 'online';
  		$this->table['pages'] 				= 	$this->prefix . 'pages';
  		$this->table['pm'] 					= 	$this->prefix . 'pm';
  		$this->table['pm_folder'] 			= 	$this->prefix . 'pm_folder';
  		$this->table['pm_lists'] 			= 	$this->prefix . 'pm_lists';
  		$this->table['poll'] 				= 	$this->prefix . 'poll';
  		$this->table['reply'] 				= 	$this->prefix . 'reply';
  		$this->table['requests'] 			= 	$this->prefix . 'requests';
  		$this->table['section'] 			= 	$this->prefix . 'section';
  		$this->table['smiles'] 				= 	$this->prefix . 'smiles';
  		$this->table['style'] 				= 	$this->prefix . 'style';
  		$this->table['subject'] 			= 	$this->prefix . 'subject';
  		$this->table['sm_logs'] 			= 	$this->prefix . 'supermemberlogs';
  		$this->table['today'] 				= 	$this->prefix . 'today';
  		$this->table['toolbox'] 			= 	$this->prefix . 'toolbox';
  		$this->table['usertitle'] 			= 	$this->prefix . 'usertitle';
  		$this->table['vote'] 				= 	$this->prefix . 'vote';
  		$this->table['section_group']		=	$this->prefix . 'sectiongroup';
  		$this->table['extension']			=	$this->prefix . 'ex';
  		$this->table['moderators']			=	$this->prefix . 'moderators';
  		$this->table['cats']				=	$this->prefix . 'cats';
  		$this->table['tag']					=	$this->prefix . 'tags';
  		$this->table['tag_subject']			=	$this->prefix . 'tags_subject';
  		$this->table['subjects_bookmark'] 	= 	$this->prefix . 'subjects_bookmark';
  		$this->table[ 'plugin' ]			=	$this->prefix . 'plugins';
  		$this->table[ 'hook' ]				=	$this->prefix . 'plugins_hooks';
  	}
  	
  	// ... //
  	
  	private function initVariables()
  	{
    	$this->_CONF['temp']					=	array();
    	$this->_CONF['now']						=	time();
 		$this->_CONF['timeout']					=	time()-300;
 		$this->_CONF['date']					=	date('j/n/Y');
 		$this->_CONF['day']						=	date('D');
 		$this->_CONF['temp']['query_num']		=	0;
 		$this->_CONF['username_cookie']			=	'MySmartBB_username';
 		$this->_CONF['password_cookie']			=	'MySmartBB_password';
 		$this->_CONF['lastvisit_cookie']		=	'MySmartBB_lastvisit';
 		$this->_CONF['admin_username_cookie']	=	'MySmartBB_admin_username';
 		$this->_CONF['admin_password_cookie']	=	'MySmartBB_admin_password';
 		$this->_CONF['style_cookie']			=	'MySmartBB_style';
 		$this->_CONF['ip'] 						= 	$this->_SERVER['REMOTE_ADDR'];
  	}
  	
  	// ... //
  	
  	private function initFuncList()
  	{
  		$func_list = array();
  		
  		// Library's object name -> Filename, Class name
  		$this->func_list[ 'banned' ] 		= 	array( 'banned.class.php', 'MySmartBanned' );
  		$this->func_list[ 'cache' ] 		= 	array( 'cache.class.php', 'MySmartCache' );
  		$this->func_list[ 'group' ] 		= 	array( 'group.class.php', 'MySmartGroup' );
  		$this->func_list[ 'icon' ] 			= 	array( 'icons.class.php', 'MySmartIcons' );
  		$this->func_list[ 'massege' ] 		= 	array( 'messages.class.php', 'MySmartMessages' );
  		$this->func_list[ 'moderator' ] 	= 	array( 'moderators.class.php', 'MySmartModerators' );
  		$this->func_list[ 'pm' ] 			= 	array( 'pm.class.php', 'MySmartPM' );
  		$this->func_list[ 'reply' ] 		= 	array( 'reply.class.php', 'MySmartReply' );
  		$this->func_list[ 'section' ] 		= 	array( 'sections.class.php', 'MySmartSection' );
  		$this->func_list[ 'subject' ] 		= 	array( 'subject.class.php', 'MySmartSubject' );
  		$this->func_list[ 'toolbox' ] 		= 	array( 'toolbox.class.php', 'MySmartToolbox' );
  		$this->func_list[ 'vote' ] 			= 	array( 'vote.class.php', 'MySmartVote' );
  		$this->func_list[ 'poll' ] 			= 	array( 'poll.class.php', 'MySmartPoll' );
  	}
  	
  	// ... //
  	
  	private function initDB()
  	{
 		// Connect to database
 		$this->db->sql_connect();
  		$this->db->sql_select_db();
  		
  		// ... //
  		
  		// Ensure if tables are installed or not
  		$check = $this->db->check($this->prefix . 'info');
  		
  		// Well, the table "MySBB_info" isn't exists, so return an error message
  		if (!$check
  			and !defined('INSTALL'))
  		{
  			return 'ERROR::THE_TABLES_ARE_NOT_INSTALLED';
  		}
  	}
  	
  	// ... //
  	
  	private function initInfo()
  	{
  		// Get information from info table
  		if ( !defined( 'NO_INFO' ) )
  		{
 			// TODO :: Cache me please!
 			
 			$this->_CONF['info']					=	array();
    		$this->_CONF['info_row']				=	array();
				
			$this->rec->table = $this->table[ 'info' ];
		
			$this->rec->getList();
		
			while ( $r = $this->rec->getInfo() )
			{
				$this->_CONF[ 'info_row' ][ $r[ 'var_name' ] ] = $r[ 'value' ];
			}
			
			$this->_CONF[ 'info_row' ][ 'adress_bar_separate' ] = $this->func->htmlDecode( $this->_CONF[ 'info_row' ][ 'adress_bar_separate' ] );
 		}
  	}
  	
  	// ... //
  	
  	private function initPredefinedVars()
  	{
		$this->_POST 	= 	$_POST;
		$this->_GET 	= 	$_GET;
		$this->_COOKIE 	= 	$_COOKIE;
		$this->_FILES 	= 	$_FILES;
		$this->_SERVER 	= 	$_SERVER;
		
		// Prevent the programmer from using the normal variable.
		unset( $_POST, $_GET, $_COOKIE, $_FILES, $_SERVER );
		
		/** Clean values in the local arrays to prevent SQL Injection **/
		$vars = array( '_POST', '_GET', '_COOKIE', '_FILES', '_SERVER' );
		
		// Is magic quotes on or off?
		$magic = get_magic_quotes_gpc();
		
		foreach ( $vars as $name )
		{
			if ( !$magic )
			{
				$this->func->cleanArray( $this->$name, 'sql' );
			}
		}
  	}
  	
  	// ... //
  	
  	private function initClasses()
  	{
		if (!defined('INSTALL'))
		{
			$compiler = new MySmartTemplateCompiler( $this );
			
  			$this->template		=	new MySmartTemplate( $compiler );
  			$this->smartparse	=	new MySmartCodeParse; // TODO : only call it when we need it
  			$this->plugin		=	new MySmartPlugins( $this );
  		}
  		
  		// ... //
  		
  		// Common classes, So load them without $MySmartBB->load function
  		$this->member 	= new MySmartMember( $this );
  		$this->info 	= new MySmartInfo( $this );
  		$this->online 	= new MySmartOnline( $this );
  		$this->style 	= new MySmartStyle( $this );
  	}
  	
  	// ... //
  	
  	public function getPrefix()
  	{
  		return $this->prefix;
  	}
  	
  	// ... //
  	
  	public function load( $lib )
  	{
  		if ( is_null( $this->func_list ) )
  			$this->initFuncList();
  		
  		// Loads multiple libraries
  		if ( strstr( $lib, ',' ) != false )
  		{
  			$list = explode( ',', $lib );
  			
  			foreach ( $list as $lib )
  			{
  				$this->load( $lib );
  			}
  		}
  		else
  		{
  			// The Library doesn't exist
  			if ( !array_key_exists( $lib, $this->func_list ) )
  			{
  				return false;
  			}
  			
  			if ( is_null( $this->$lib ) )
  			{
  				require_once( DIR . 'includes/functions/' . $this->func_list[ $lib ][ 0 ] );
  			
  				$this->$lib = new $this->func_list[ $lib ][ 1 ]( $this );
  			}
  		}
  	}
}

// ... //

?>
