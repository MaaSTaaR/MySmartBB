<?php

/**
 * @package 	: 	MySmartSection
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @updated 	: 	Thu 28 Jul 2011 11:07:02 AM AST 
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
 		
 		$MySmartBB->rec->table = $this->table;
 		$MySmartBB->rec->filter = "id='" . $id . "' AND section_password='" . $password . "'";
 		
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
 		
 		$forum_res = &$this->engine->func->setResouce();
 		
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
}
 
?>
