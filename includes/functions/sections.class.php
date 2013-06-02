<?php

/**
 * @package MySmartSection
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @license GNU GPL
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
 	
	/**
	 * Checks if the provided password is correct for a forum.
	 * 
	 * @param $password The password which the member provided.
	 * @param $id The id of the forum to be checked.
	 * 
	 * @return true if the password correct, otherwise false
	 */
 	public function checkPassword( $password, $id )
 	{
 		if ( empty( $id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM checkPassword() -- EMPTY id OR password' );
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->filter = "id='" . $id . "' AND section_password='" . $password . "'";
 		
      	$num = $this->engine->rec->getNumber();
      	
      	return ($num <= 0) ? false : true;
 	}
 	
 	// ... //
 	
	/**
	 * Updates the information of latest topic of a forum.
	 * 
	 * @param $writer The username of topic's writer.
	 * @param $title The title of the topic.
	 * @param $subject_id The id of the topic.
	 * @param $date The date of the topic.
	 * 
	 * @return true for success, otherwise false
	 */
 	public function updateLastSubject( $writer, $title, $subject_id, $date, $section_id )
 	{
 		if ( empty( $section_id ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM updateLastSubject()' );
 		
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
	
 	/**
 	 * Gets the data of "all" children forums from the database then creates a serialized 
 	 * cache from this data.
 	 * 
 	 * @param $parent The id of the parent forum.
 	 * 
 	 * @return false if there is no data to be cached, or serialized cache.
 	 * 
 	 * @see MySmartSection::updateSectionsCache
 	 */
	public function createSectionsCache( $parent )
 	{
 		if ( empty( $parent ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM createSectionsCache()', E_USER_ERROR );
 		
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
 			
			$x++;
 		}
 		
 		if ( $x > 0 )
 		{
 			$cache = serialize( $cache );
 			$cache = base64_encode( $cache );
 			
 			return $cache;
 		}
 		
		return false;
	}
	
	// ... //

	/**
	 * Gets the data of a specific child forum from the database then creates a serialized 
	 * cache from this data.
	 * 
	 * @param $parent The id of child's parent, you can pass -1 to this parameter
	 * 					so the id of the parent will be grabbed automatically.
	 * @param $child The if of the child will be updated.
	 * 
	 * @return false or serialized cache, in the case of $parent = -1 the function returns
	 * 			and array with two keys 'parent' = parent's id, 'cache' = serialized cache.
	 * 
	 * @see MySmartSection::updateForumCache
	 */
	public function createForumCache( $parent, $child )
 	{
 		if ( empty( $parent ) or empty( $child ) )
 			trigger_error('ERROR::NEED_PARAMETER -- FROM createForumCache()',E_USER_ERROR);
 		
 		// ... //
 		
 		$return_parent = false; // Should we return the parent id?
 		$forum_info = null;
 		
 		// If the parameter $parent = -1, that's mean we should fetch the id
 		// of the parent from the database.
 		if ( $parent == -1 )
 		{
 			$this->engine->rec->table = $this->table;
 			$this->engine->rec->filter = "id='" . $child . "'";
 			
 			$forum_info = $this->engine->rec->getInfo();
 			
 			if ( !$forum_info )
 				return false;
 			
 			$parent = $forum_info[ 'parent' ];
 			
 			$return_parent = true;
 		}
 		
 		// ... //
 		
 		// Gets the cache array of the parent forum, so we can change $child entry
 		// to the new one.
 		$this->engine->rec->select = 'id,forums_cache';
		$this->engine->rec->table = $this->table;
 		$this->engine->rec->filter = "id='" . $parent . "'";
 		
 		$parent_info = $this->engine->rec->getInfo();
 		
 		$forums_cache = unserialize( base64_decode( $parent_info[ 'forums_cache' ] ) );
 		
 		if ( !is_array( $forums_cache ) )
 			return false;
 		
 		// ... //
 		
 		// Seeks the index number of the $child forum in the cache array
 		$key = -1;
 		$k = 0;
 		
 		foreach ( $forums_cache as $forum )
 		{
 			if ( $forum[ 'id' ] == $child )
 			{
 				$key = $k;
 				break;
 			}
 			
 			$k++;
 		}
 		
 		if ( $key == -1 )
 			trigger_error( 'ERROR: $child does not exist -- FROM createForumCache()', E_USER_ERROR );
 		
 		// ... //
 		
 		$cache = array();
 		$x = 0;
 		
 		// ... //
 		
 		// We didn't fetch the information of the forum, so we need to fetch it
 		// from the database
 		if ( is_null( $forum_info ) )
 		{
 			$this->engine->rec->table = $this->table;
 			$this->engine->rec->filter = "id='" . $child . "'";

 			$forum_info = $this->engine->rec->getInfo();
 		}
 		
 		if ( $forum_info != false )
 		{
			$cache 							= 	array();
			$cache['id'] 					= 	$forum_info['id'];
			$cache['title'] 				= 	$forum_info['title'];
			$cache['section_describe'] 		= 	$forum_info['section_describe'];
			$cache['parent'] 				= 	$forum_info['parent'];
			$cache['sort'] 					= 	$forum_info['sort'];
			$cache['section_picture'] 		= 	$forum_info['section_picture'];
			$cache['sectionpicture_type'] 	= 	$forum_info['sectionpicture_type'];
			$cache['use_section_picture'] 	= 	$forum_info['use_section_picture'];
			$cache['linksection'] 			= 	$forum_info['linksection'];
			$cache['linkvisitor'] 			= 	$forum_info['linkvisitor'];
			$cache['last_writer'] 			= 	$forum_info['last_writer'];
			$cache['last_subject'] 			= 	$forum_info['last_subject'];
			$cache['last_subjectid'] 		= 	$forum_info['last_subjectid'];
			$cache['last_date'] 			= 	$forum_info['last_date'];
			$cache['subject_num'] 			= 	$forum_info['subject_num'];
			$cache['reply_num'] 			= 	$forum_info['reply_num'];
			$cache['moderators'] 			= 	$forum_info['moderators'];
			$cache['forums_cache'] 			= 	$forum_info['forums_cache'];
			
			// ... //
			
			$cache['groups'] = array();
			
			$this->engine->rec->table = $this->engine->table[ 'section_group' ];
 			$this->engine->rec->filter = "section_id='" . $forum_info['id'] . "'";
 			$this->engine->rec->order = "id ASC";
 			
 			$group_res = &$this->engine->func->setResource();
 			
			$this->engine->rec->getList();
			
			while ( $group = $this->engine->rec->getInfo( $group_res ) )
			{
				$cache[ 'groups' ][ $group[ 'group_id' ] ] 						=	array();
				$cache[ 'groups' ][ $group[ 'group_id' ] ][ 'view_section' ] 	= 	$group[ 'view_section' ];
				$cache[ 'groups' ][ $group[ 'group_id' ] ][ 'main_section' ] 	= 	$group[ 'main_section' ];
			}
 			
 			// ... //
 			
 			$forums_cache[ $key ] = $cache;
 			
 			$cache = serialize( $forums_cache );
 			$cache = base64_encode( $cache );
 			
 			if ( !$return_parent )
 			{
 				return $cache;
 			}
 			else
 			{
 				return array( 'cache'	=>	$cache, 'parent'	=>	$parent );
 			}
 		}
 		
		return false;
	}
	
	// ... //
	
	/**
	 * Updates the cache of just one child forum, if we want to update the cache 
	 * of the whole list of children we should use "updateSectionsCache" 
	 * which based on "createSectionsCache", This function based on "createForumCache".
	 * 
	 * @param $parent The id of the parent forum of the forum that we want to update,
	 * 					this parameter can be "null" so the parent id will be grabbed automatically.
	 * @param $child The id of the forum which we want to update its cache.
	 * 
	 * @return true for success, otherwise false
	 * 
	 * @see MySmartSection::updateSectionsCache()
	 * @see MySmartSection::createForumCache()
	 */
	public function updateForumCache( $parent, $child )
	{
 		if ( empty( $child ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM updateForumCache()' );
 		
 		// We don't know parent's ID. Grab it from database.
 		if ( is_null( $parent ) )
 		{
 			$this->engine->rec->select = 'parent';
 			$this->engine->rec->table = $this->table;
 			$this->engine->rec->filter = "id='" . $child . "'";
 			
 			$child_info = $this->engine->rec->getInfo();
 			
 			$parent = $child_info[ 'parent' ];
 		}
 		
 		$update = $this->_updateCache( $parent, $child );
 		
 		return ($update) ? true : false;
	}
	
	// ... //
	
	/**
	 * Updates the cache of the whole list of children for a specific parent forum.
	 *
	 * @param $parent The id of the parent so the children cache of this forum will be updated.
	 *
	 * @return true for success, otherwise false
	 */
 	public function updateSectionsCache( $parent )
 	{
 		if ( empty( $parent ) )
 			trigger_error( 'ERROR::NEED_PARAMETER -- FROM updateSectionsCache()', E_USER_ERROR );
 		
 		$update = $this->_updateCache( $parent );
 		
 		return ( $update ) ? true : false;
 	}
 	
 	// ... //
 	
 	/**
 	 * Either updates the cache of the whole list of children or the cache of one children 
 	 * for a specific parent forum. This function is the base function for MySmartSection::updateForumCache
 	 * and MySmartSection::updateSectionsCache. Its only purpose is to kill duplicated code.
 	 * 
 	 * @param $parent The parent forum id, so the cache of the children (or one child) 
 	 * 					of this forum will be updated. If you don't know the parent id
 	 * 					and only know the child id you can pass the value -1 for this
 	 * 					parameter, so the correct parent id will be getten from the
 	 * 					database later.
 	 * @param $child If it's null the whole list of children will be updated. Otherwise it should contains the
 	 * 					id of the child that should be updated.
 	 * 
 	 * @return boolean
 	 * 
 	 * @see MySmartSection::createSectionCache
 	 * @see MySmartSection::createForumCache
 	 */
 	private function _updateCache( $parent, $child = null )
 	{
 		// Gets a serialized cache of children.
 		// If the parameter $child is null we'll call the function createSectionsCache
 		// which will create the cache by getting the data of the whole children from
 		// the database. Otherwise we'll call createForumCache which will create the cache
 		// by getting the data of only one child from the database and the remain child's cache
 		// will not changed.
 		// So, if we need to update the cache of one child it's better 
 		// to use createForumCache from optimization's perspective.
 		$cache = ( is_null( $child ) ) ? $this->createSectionsCache( $parent ) : $this->createForumCache( $parent, $child );
 		
 		// If the call of this function passed the child id but didn't pass the parent id (Actually passed as -1)
 		// so the $cache variable will be an array with two entries, the first one is the id of the parent
 		// the second one is the serialized cache. This case only occurred when we call createForumCache( -1, $child );
 		if ( !is_null( $child ) and $parent == -1 )
 		{
 			$parent = $cache[ 'parent' ];
 			$cache = $cache[ 'cache' ];
 		}
 		
 		if ( $cache == false )
 			$cache = '';
 		
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->fields = array(	'forums_cache'	=>	$cache	);
 		$this->engine->rec->filter = "id='" . $parent . "'";
 		
 		$update = $this->engine->rec->update();
 		
 		return ( $update ) ? true : false;
 	}
 	
 	// ... //
 	
 	/**
 	 * Updates the cache of all children for all parents.
 	 * 
 	 * @return boolean
 	 */
 	public function updateAllSectionsCache()
 	{
 		$this->engine->rec->table = $this->table;
 		$this->engine->rec->filter = "parent='0'";
 		
 		$forum_res = &$this->engine->func->setResource();
 		
 		$this->engine->rec->getList();
 		
 		$fail = false;
 		
 		while ( $row = $this->engine->rec->getInfo( $forum_res ) )
 		{
 			// ... //
 			
 			$cache = $this->createSectionsCache( $row[ 'id' ] );
 				
 			$this->engine->rec->table 	= 	$this->table;
 			$this->engine->rec->fields 	= 	array(	'forums_cache'	=>	$cache	);
 			$this->engine->rec->filter 	= 	"id='" . $row[ 'id' ] . "'";
 				
 			$update = $this->engine->rec->update();
 			
 			if ( !$update )
 				$fail = true;
 			
 			// ... //
 			
 			// TODO : I "think" we don't need this anymore please check it, see createSectionsCache
 			$permissions_update = $this->engine->group->updateSectionGroupCache( $row[ 'id' ] );
 			
 			if ( !$permissions_update )
 				$fail = true;
 		}
 		
 		return !$fail;
 	}
 	
 	// ... //
 	
 	/**
 	 * Returns a list of categories and forums with its details.
 	 * 
 	 * @param $check_group If it's true, check if the current member has
	 * 						permissions to view a specific category/forum from the list.
	 * 						If false the function will return the whole list of forums.
	 * 						Default value is true.
 	 * 
 	 * @return Array of categories and forums
 	 */
	public function getForumsList( $check_group = true )
	{
		$forums_list = array();
		
		$this->engine->rec->table = $this->engine->table[ 'section' ];
		$this->engine->rec->filter = 'parent=0';
		$this->engine->rec->order = 'sort ASC';
		
		$this->engine->rec->getList();
		
		while ( $cat = $this->engine->rec->getInfo() )
		{
			// Should we fetch the forums of this category or not?
			// if the group of the visitor can't view this category
			// so we shouldn't fetch the forums of this category.
			$fetch_forums = true;
			
			// ... //
			
			// Get the groups information to know view this section or not
			if ( $check_group )
			{
				// Visitor's group id
				$group_id = $this->engine->_CONF[ 'group_info' ][ 'id' ];
				
				$groups = unserialize( base64_decode( $cat[ 'sectiongroup_cache' ] ) );
				
				if ( is_array( $groups[ $group_id ] ) )
				{
					if ( $groups[ $group_id ][ 'view_section' ] )
					{
						$forums_list[ $cat[ 'id' ] . '_m' ] = $cat;
					}
					else
					{
						// This visitor has no permission to show the category, 
						// so don't fetch the forums which belong to this category.
						$fetch_forums = false;
					}
				}
			
				unset( $groups );
			}
			else
			{
				$forums_list[ $cat['id'] . '_m' ] = $cat;
			}
			
			// ... //
			
			if ( !empty( $cat[ 'forums_cache' ] ) and $fetch_forums )
			{
				$forums = $this->fetchForumsFromCache( $cat[ 'forums_cache' ], $check_group );
				
				if ( !is_null( $forums ) )
					$forums_list = array_merge( $forums_list, $forums );
				
				unset( $forums_list[ $cat[ 'id' ] . '_m' ][ 'forums_cache' ] );
				unset( $forums_list[ $cat[ 'id' ] . '_m' ][ 'sectiongroup_cache' ] );
			}
		}
		
		return $forums_list;
	}
	
	// ... //
	
	/**
	 * Returns a list of forums with its details from serialized cache.
	 * 
	 * @param $cache The serialized cache to obtain forums list from.
	 * @param $check_group If it's true, check if the current member has
	 * 						permissions to view a specific forum from the list.
	 * 						If false the function will return the whole list of forums.
	 * 						Default value is true.
	 * 
	 * @return Array of forums or null
	 */
	public function fetchForumsFromCache( $cache, $check_group = true )
	{
		$forums_list = array();
		$group_id = $this->engine->_CONF[ 'group_info' ][ 'id' ];
		
		$forums = unserialize( base64_decode( $cache ) );
		
		foreach ( $forums as $forum )
		{
			$show_forum = false;
			
			// Check if the visitor has the permission to view this forum.
			if ( $check_group )
			{
				if ( is_array( $forum[ 'groups' ][ $group_id ] ) )
					if ( $forum[ 'groups' ][ $group_id ][ 'view_section' ] )
						$show_forum = true;
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
							if ( is_array( $sub[ 'groups' ][ $group_id ] ) )
							{
								if ( $sub[ 'groups' ][ $group_id ][ 'view_section' ] )
								{
									if ( !$forum[ 'is_sub' ] )
										$forum[ 'is_sub' ] = 1;
	
									$forum[ 'sub' ] .= '<a href="' . $this->engine->_CONF[ 'init_path' ] . 'forum/' . $sub[ 'id' ] . '/' . $sub[ 'title' ] . '">' . $sub[ 'title' ] . '</a> ' . $this->engine->lang_common[ 'comma' ];
								}
							}
						}
					}
				}
	
				// ... //
	
				// Get the moderators list as a _link_ and store it in $forum['moderators_list']
				$forum[ 'is_moderators' ] 		= 	0;
				$forum[ 'moderators_list' ]		=	null;
	
				if ( !empty( $forum[ 'moderators' ] ) )
				{
					$moderators = unserialize( base64_decode( $forum[ 'moderators' ] ) );
					
					if ( is_array( $moderators ) )
					{
						foreach ( $moderators as $moderator )
						{
							if ( !$forum[ 'is_moderators' ] )
								$forum[ 'is_moderators' ] = 1;
	
							$forum[ 'moderators_list' ] .= '<a href="' . $this->engine->_CONF[ 'init_path' ] . 'profile/' . $moderator['member_id'] . '">' . $moderator['username'] . '</a> ' . $this->engine->lang_common[ 'comma' ];
						}
					}
				}
	
				// ... //
				
				unset( $forum[ 'groups' ] );
				
				// Interpret the date of the last post to a human-form date
				if ( is_numeric( $forum[ 'last_date' ] ) )
					$forum[ 'last_date' ] = $this->engine->func->date( $forum[ 'last_date' ] );
				
				$forums_list[ $forum[ 'id' ] . '_f' ] = $forum;
				
				unset( $forum );
			} // end if $show_forum
		} // end foreach ($forums)
		
		if ( sizeof( $forums_list ) <= 0 )
			$forums_list = null;
		
		return $forums_list;
	}
	
	// ... //
	
	
	/**
	 * Prevents member (or visitor) from view password-protected forum if the member 
	 * didn't provide the password, if he did checks the provided password,
	 * if there is no password for the forum just do nothing.
	 * 
	 * @param $section_id The id of the forum to be checked.
	 * @param $section_password The password of the forum.
	 * @param $password The password that the member provided. Should be provided encrypted using base64.
	 * 
	 * @return true for if the password correct, otherwise false. If the member
	 * 			didn't provide password ask the member for password.
	 * 
	 * @see MySmartSection::checkPassword()
	 */
	public function forumPassword( $section_id, $section_password, $password )
	{
		if ( !empty( $section_password ) and !$this->engine->_CONF[ 'group_info' ][ 'admincp_allow' ] )
		{
			if ( empty( $password ) )
	   		{
	   			$this->engine->template->assign( 'section_id', $section_id );
	   			
	 			$this->engine->template->display( 'forum_password' );
	 			$this->engine->func->stop();
			}
			else
			{
				$password = base64_decode( $password );
				
				if ( !$this->checkPassword( $password, $section_id ) )
				{
					$this->engine->func->error( $this->engine->lang[ 'incorrect_password' ] );
				}
				else
				{
					$this->engine->_CONF[ 'template' ][ 'password' ] = '&amp;password=' . base64_encode( $password );
					
					return true;
				}
			}
		}
	}
	
	// ... //
	
	/**
	 * Updates topics number of a forum.
	 *
	 * @param $section_id The id of the forum that will be updated.
	 * @param $subject_number If we already have the value of topics number of the forum 
	 * 						we can pass it to this parameter, otherwise keep it null so
	 * 						the number of topics will be getten automatically.
	 * @param $operation Can be "add" or "sub" or null, just use it if you want to add or substract
	 * 						a specific value to/from the number of topics.
	 * @param $operand The value of the oprand if $subject_number is not null.
	 * 
	 * @return true for success, otherwise false
	 */
	public function updateSubjectNumber( $section_id, $subject_number = null, $operation = 'add', $operand = 1 )
	{
		$do_operation = true;
		
		if ( !is_null( $subject_number ) )
		{
			$val = $subject_number;
		}
		else
		{
			$this->engine->rec->select = 'id';
			$this->engine->rec->table = $this->engine->table[ 'subject' ];
			$this->engine->rec->filter = "section='" . $section_id . "' AND delete_topic<>'1'";
			
			$val = $this->engine->rec->getNumber();
			
			$do_operation = false;
		}
		
		if ( !is_null( $operation ) and $do_operation )
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
			// Update the total of topics
			$this->engine->cache->updateSubjectNumber( $val, null );
			
			$this->updateForumCache( null, $section_id );
			
			return true;
		}
		
		return false;
	}
	
	// ... //
	
	/**
	 * Updates replies number of a forum.
	 *
	 * @param $section_id The id of the forum that will be updated.
	 * @param $reply_number If we already have the value of replies number of the forum 
	 * 						we can pass it to this parameter, otherwise keep it null so
	 * 						the number of replies will be getten automatically.
	 * @param $operation Can be "add" or "sub" or null, just use it if you want to add or substract
	 * 						a specific value from the number of replies.
	 * @param $operand The value of the oprand if $reply_number is not null.
	 * 
	 * @return true for success, otherwise false
	 */
	public function updateReplyNumber( $section_id, $reply_number = null, $operation = 'add', $operand = 1 )
	{
		$do_operation = true;
		
		if ( !is_null( $reply_number) )
		{
			$val = $reply_number;
		}
		else
		{
			$this->engine->rec->select = 'id';
			$this->engine->rec->table = $this->engine->table[ 'reply' ];
			$this->engine->rec->filter = "section='" . $section_id . "' AND delete_topic<>'1'";
			
			$val = $this->engine->rec->getNumber();

			$do_operation = false;
		}
		
		if ( !is_null( $operation ) and $do_operation )
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
			// The new number of replies will be shown correctly 
			// on the main page after updating cache.
			$this->updateForumCache( null, $section_id );
			
			return true;
		}
		
		return false;
	}
	
	// ... //
}
 
?>
