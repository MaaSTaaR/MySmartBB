<?php

/**
 * @package MySmartTags
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @since Wed 31 Aug 2011 06:07:49 AM AST 
 * @license GNU GPL
 */

class MySmartTags
{
	private $engine;

	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //
	
	/**
	 * Registers tags for a topic.
	 * 
	 * @param $tags The array of the tags.
	 * @param $subject_id The id of the topic that will be tagged.
	 * @param $subject_title The title of the topic.
	 * 
	 * @return true for success, otherwise false.
	 */
	public function taggingSubject( $tags, $subject_id, $subject_title )
	{
		if ( !is_array( $tags ) or ( empty( $subject_id ) or $subject_id == 0 ) or empty( $subject_title ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM taggingSubject()', E_USER_ERROR  );
		
		// ... //
		
		// TODO : This is a temporary way to solve the problem, We have to prevent queries inside loops!
		foreach ( $tags as $tag )
		{
			$tag_id = 1;
			
			$this->engine->rec->table = $this->engine->table[ 'tag' ];
			$this->engine->rec->filter = "tag='" . $tag . "'";
			
			$Tag = $this->engine->rec->getInfo();
			
			// This tag doesn't exist, insert it into database.
			if ( !$Tag )
			{
				$this->engine->rec->table = $this->engine->table[ 'tag' ];
				$this->engine->rec->fields = array(	'tag'	=>	$tag, 'number'	=>	1	);
				$this->engine->rec->get_id = true;
						
				$insert = $this->engine->rec->insert();
						
				$tag_id = $this->engine->rec->id;
			}
			else
			{
				$this->engine->rec->table = $this->engine->table[ 'tag' ];
				$this->engine->rec->fields = array(	'number'	=>	$Tag[ 'number' ] + 1 );
				$this->engine->rec->filter = "id='" . $Tag[ 'id' ] . "'";
						
				$update = $this->engine->rec->update();
						
				$tag_id = $Tag[ 'id' ];
			}
					
			$this->engine->rec->table = $this->engine->table[ 'tag_subject' ];
			$this->engine->rec->fields = array(	'tag_id'		=>	$tag_id,
												'subject_id'	=>	$subject_id,
												'tag'			=>	$tag,
												'subject_title'	=>	$subject_title);
			
			$insert = $this->engine->rec->insert();
		}
		
		return true;
	}
}

?>
