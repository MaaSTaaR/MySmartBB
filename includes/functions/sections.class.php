<?php

/**
 * @package 	: 	MySmartSection
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @updated 	: 	Sat 03 Sep 2011 03:36:57 AM AST 
 */
 
class MySmartSection
{
	private $engine;
	private $table;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
		$this->table = $this->engine->table[ 'section' ];
	}
	
 	// ... //
 	
 	public function checkPassword( $password, $id )
 	{
 		if ( empty( $id )
 			or empty( $password ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM checkPassword() -- EMPTY id OR password',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->filter = "id='" . $id . "' AND section_password='" . $password . "'";
 		
      	$num = $this->engine->rec->getNumber();
      	
      	return ($num <= 0) ? false : true;
 	}
 	
 	// ... //
 	
 	public function updateLastSubject( $writer, $title, $subject_id, $date, $section_id )
 	{
 		if ( empty( $writer )
 			or empty( $title )
 			or empty( $subject_id )
 			or empty( $date )
 			or empty( $section_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateLastSubject()',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->table;
 		
 		$this->engine->rec->fields = array(	'last_writer'	=>	$writer,
 											'last_subject'	=>	$title,
 											'last_subjectid'	=>	$subject_id,
 											'last_date'	=>	$date	);
 		
 		$this->engine->rec->filter = "id='" . $section_id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	// ... //
 	
	public function createSectionsCache( $parent )
 	{
 		if ( empty( $parent ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM createSectionsCache()',E_USER_ERROR);
 		}
 		
 		// ... //
 		
 		$cache = array();
 		$x = 0;
 		
 		// ... //
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->filter = "parent='" . $parent . "'";
 		$this->engine->rec->order = "sort ASC";
 		
 		$forum_res = &$this->engine->func->setResource();
 		
 		$this->engine->rec->getList();
 		
 		while ( $forum = $this->engine->rec->getInfo( $forum_res ) )
 		{
 			$cache[$x] 							= 	array();
			$cache[$x]['id'] 					= 	$forum['id'];
			$cache[$x]['title'] 				= 	$forum['title'];
			$cache[$x]['section_describe'] 		= 	$forum['section_describe'];
			$cache[$x]['parent'] 				= 	$forum['parent'];
			$cache[$x]['sort'] 					= 	$forum['sort'];
			$cache[$x]['section_picture'] 		= 	$forum['section_picture'];
			$cache[$x]['sectionpicture_type'] 	= 	$forum['sectionpicture_type'];
			$cache[$x]['use_section_picture'] 	= 	$forum['use_section_picture'];
			$cache[$x]['linksection'] 			= 	$forum['linksection'];
			$cache[$x]['linkvisitor'] 			= 	$forum['linkvisitor'];
			$cache[$x]['last_writer'] 			= 	$forum['last_writer'];
			$cache[$x]['last_subject'] 			= 	$forum['last_subject'];
			$cache[$x]['last_subjectid'] 		= 	$forum['last_subjectid'];
			$cache[$x]['last_date'] 			= 	$forum['last_date'];
			$cache[$x]['subject_num'] 			= 	$forum['subject_num'];
			$cache[$x]['reply_num'] 			= 	$forum['reply_num'];
			$cache[$x]['moderators'] 			= 	$forum['moderators'];
			$cache[$x]['forums_cache'] 			= 	$forum['forums_cache'];
			
			// ... //
			
			$cache[$x]['groups'] 				= 	array();
			
			$this->engine->rec->table = $this->engine->table[ 'section_group' ];
 			$this->engine->rec->filter = "section_id='" . $forum['id'] . "'";
 			$this->engine->rec->order = "id ASC";
 			
 			$group_res = &$this->engine->func->setResource();
 			
			$this->engine->rec->getList();
			
			while ( $group = $this->engine->rec->getInfo( $group_res ) )
			{
				$cache[ $x ][ 'groups' ][ $group[ 'group_id' ] ] 					=	array();
				$cache[ $x ][ 'groups' ][ $group[ 'group_id' ] ][ 'view_section' ] 	= 	$group[ 'view_section' ];
				$cache[ $x ][ 'groups' ][ $group[ 'group_id' ] ][ 'main_section' ] 	= 	$group[ 'main_section' ];
			}
 			
 			// ... //
 			
			$x += 1;
 		}
 		
 		if ( $x > 0 )
 		{
 			$cache = serialize( $cache );
 			$cache = base64_encode( $cache );
 		}
 		else
 		{
 			$cache = false;
 		}
 		
		return $cache;
	}
	
	// ... //
	
 	public function updateSectionsCache( $parent )
 	{
 		if ( empty( $parent ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateSectionsCache()',E_USER_ERROR);
 		}
 		
 		$cache = $this->createSectionsCache( $parent );
 		
 		if ( $cache == false )
 		{
 			$cache = '';
 		}
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'forums_cache'	=>	$cache	);
 		$this->engine->rec->filter = "id='" . $parent . "'";
 		
 		$update = $this->engine->rec->update();
 		
 		return ($update) ? true : false;
 	}
 	
 	// ... //
 	
 	public function updateAllSectionsCache()
 	{
 		$this->engine->rec->table = $this->table;
 		
 		$forum_res = &$this->engine->func->setResource();
 		
 		$this->engine->rec->getList();
 		
 		$fail = false;
 		
 		while ( $row = $this->engine->rec->getInfo( $forum_res ) )
 		{
 			// This section is a parent section
 			if ( !empty( $row[ 'forums_cache' ] ) )
 			{
 				$cache = $this->createSectionsCache( $row[ 'id' ] );
 				
 				$this->engine->rec->table 	= 	$this->table;
 				$this->engine->rec->fields 	= 	array(	'forums_cache'	=>	$cache	);
 				$this->engine->rec->filter 	= 	"id='" . $row[ 'id' ] . "'";
 				
 				$update = $this->engine->rec->update();
 				
 				if (!$update)
 				{
 					$fail = true;
 				}
 			}
 			else
 			{
 				continue;
 			}
 		}
 		
 		return ( $fail ) ? false : true;
 	}
 	
 	// ... //
 	
	public function getForumsList( $check_group = true )
	{
		$forums_list = array();
		
		$this->engine->rec->table = $this->engine->table[ 'section' ];
		$this->engine->rec->filter = 'parent=0';
		$this->engine->rec->order = 'sort ASC';
		
		// Get main sections
		$this->engine->rec->getList();
		
		// Loop to read the information of main sections
		while ( $cat = $this->engine->rec->getInfo() )
		{
			// ... //
			
			// Get the groups information to know view this section or not
			
			if ( $check_group )
			{
				$groups = unserialize( base64_decode( $cat[ 'sectiongroup_cache' ] ) );
			
				if ( is_array( $groups[ $this->engine->_CONF[ 'group_info' ][ 'id' ] ] ) )
				{
					if ( $groups[ $this->engine->_CONF[ 'group_info' ][ 'id' ] ][ 'view_section' ] )
					{
						$forums_list[ $cat['id'] . '_m' ] = $cat;
					}
				}
			
				unset($groups);
			}
			else
			{
				$forums_list[ $cat['id'] . '_m' ] = $cat;
			}
			
			// ... //
			
			if ( !empty( $cat[ 'forums_cache' ] ) )
			{
				$forums = $this->fetchForumsFromCache( $cat[ 'forums_cache' ], $check_group );
				
				if ( !is_null( $forums ) )
					$forums_list = array_merge( $forums_list, $forums );
				
				
				// Save some memory
				unset( $forums );
				
				unset( $forums_list[ $cat['id'] . '_m' ][ 'forums_cache' ] );
				unset( $forums_list[ $cat['id'] . '_m' ][ 'sectiongroup_cache' ] );
			}
		}
		
		return $forums_list;
	}
	
	// ... //
	
	public function fetchForumsFromCache( $cache, $check_group = true )
	{
		$forums_list = array();
		
		$forums = unserialize( base64_decode( $cache ) );
	
		foreach ($forums as $forum)
		{
			$show_forum = false;
	
			if ( $check_group )
			{
				// Check if the visitor have the permission to see this forum or not
				if ( is_array( $forum[ 'groups' ][ $this->engine->_CONF[ 'group_info' ][ 'id' ] ] ) )
				{
					if ( $forum[ 'groups' ][ $this->engine->_CONF[ 'group_info' ][ 'id' ] ][ 'view_section' ] )
					{
						$show_forum = true;
					}
				}
			}
			else
			{
				$show_forum = true;
			}
	
			// ... //
	
			if ( $show_forum )
			{
				// Get the first-level sub forums as a _link_ and store it in $forum['sub']	
				$forum[ 'is_sub' ] 	= 	0;
				$forum[ 'sub' ]		=	null;
	
				if ( !empty( $forum[ 'forums_cache' ] ) )
				{
					$subs = unserialize( base64_decode( $forum[ 'forums_cache' ] ) );
		
					if ( is_array( $subs ) )
					{
						foreach ( $subs as $sub )
						{
							if ( is_array( $sub[ 'groups' ][ $this->engine->_CONF[ 'group_info' ][ 'id' ] ] ) )
							{
								if ( $sub[ 'groups' ][ $this->engine->_CONF[ 'group_info' ][ 'id' ] ][ 'view_section' ] )
								{
									if ( !$forum[ 'is_sub' ] )
									{
										$forum[ 'is_sub' ] = 1;
									}
	
									$forum['sub'] .= '<a href="index.php?page=forum&amp;show=1&amp;id=' . $sub[ 'id' ] . '">' . $sub[ 'title' ] . '</a> ، ';
								}
							}
						}
					}
				}
	
				// ... //
	
				// Get the moderators list as a _link_ and store it in $forum['moderators_list']
	
				$forum['is_moderators'] 		= 	0;
				$forum['moderators_list']		=	null;
	
				if ( !empty( $forum[ 'moderators' ] ) )
				{
					$moderators = unserialize( $forum[ 'moderators' ] );
	
					if ( is_array( $moderators ) )
					{
						foreach ( $moderators as $moderator )
						{
							if ( !$forum[ 'is_moderators' ] )
							{
								$forum[ 'is_moderators' ] = 1;
							}
	
							$forum[ 'moderators_list' ] .= '<a href="index.php?page=profile&amp;show=1&amp;id=' . $moderator['member_id'] . '">' . $moderator['username'] . '</a> ، ';
						}
					}
				}
	
				// ... //
				
				unset( $forum[ 'groups' ] );
				
				$forums_list[ $forum[ 'id' ] . '_f' ] = $forum;
				
				unset( $forum );
			} // end if $show_forum
		} // end foreach ($forums)
		
		if ( sizeof( $forums_list ) <= 0 )
			$forums_list = null;
		
		return $forums_list;
	}
	
	// ... //
	
	public function forumPassword( $section_id, $section_password, $password )
	{
		if ( !empty( $section_password ) and !$this->engine->_CONF[ 'group_info' ][ 'admincp_allow' ] )
		{
			if ( empty( $password ) )
	   		{
	 			$this->engine->template->display( 'forum_password' );
	 			$this->engine->func->stop();
			}
			else
			{												
				if (! $this->checkPassword( $password, $section_id ) )
					$this->engine->func->error( 'المعذره .. كلمة المرور غير صحيحه' );
				else
					$this->engine->_CONF[ 'template' ][ 'password' ] = '&amp;password=' . $password;
			}
		}
	}
	
	// ... //
	
	public function updateSubjectNumber( $section_id, $subject_number = null, $operation = 'add', $operand = 1 )
	{
		if ( !is_null( $subject_number) )
		{
			$val = $subject_number;
		}
		else
		{
			$this->engine->rec->table = $this->engine->table[ 'section' ];
			$this->engine->rec->select = 'subject_num';
			$this->engine->rec->filter = "id='" . $section_id . "'";
			
			$section_info = $this->engine->rec->getInfo();
			
			$val = $section_info[ 'subject_num' ];
		}
		
		if ( !is_null( $operation ) )
		{
			if ( $operation == 'add' )
				$val += $operand;
			else
				$val -= $operand;
		}
		
		$this->engine->rec->table = $this->table;
		$this->engine->rec->fields = array(	'subject_num'	=>	$val	);
		$this->engine->rec->filter = "id='" . $section_id . "'";
		
		$update = $this->engine->rec->update();
		
		if ( $update )
		{
			// Update the total of subjects
			$this->engine->cache->updateSubjectNumber( $val );
		}
	}
	
	// ... //
	
	public function updateReplyNumber( $section_id, $reply_number = null, $operation = 'add', $operand = 1 )
	{
		if ( !is_null( $reply_number) )
		{
			$val = $reply_number;
		}
		else
		{
			$this->engine->rec->table = $this->engine->table[ 'section' ];
			$this->engine->rec->select = 'reply_num';
			$this->engine->rec->filter = "id='" . $section_id . "'";
			
			$section_info = $this->engine->rec->getInfo();
			
			$val = $section_info[ 'reply_num' ];
		}
		
		if ( !is_null( $operation ) )
		{
			if ( $operation == 'add' )
				$val += $operand;
			else
				$val -= $operand;
		}
		
		$this->engine->rec->table = $this->table;
		$this->engine->rec->fields = array(	'reply_num'	=>	$val	);
		$this->engine->rec->filter = "id='" . $section_id . "'";
		
		$update = $this->engine->rec->update();
		
		if ( $update )
		{
			// Update the total of subjects
			$this->engine->cache->updateSubjectNumber( $val );
		}
	}
	
	// ... //
}
 
?>
