<?php

/**
 * @package MySmartAttach
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @since Wed 31 Aug 2011 08:08:01 AM AST 
 * @license GNU GPL
 */

class MySmartAttach
{
	private $engine;
	
	const FORBIDDEN_EXTENTION = 0;
	const LARGE_SIZE = 1;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //
	
	/**
	 * Upload a list of files as an attachment of a topic, reply or private message.
	 * 
	 * It makes all necessary checks before upload the file(s) and insert them into database.
	 * 
	 * It's the most high-level function to upload attachments, Therefore use it for this stuff.
	 * 
	 * @param $upload_permission This parameter indicates if the current member has 
	 * 								the permission of uploading attachment of not, It's usually
	 * 								taken from "section_group" table.
	 * @param $files_limit The value of this parameter is the maximum number
	 * 						of attachments the the current member can upload at once, It's usually
	 * 						taken from "group" table.
	 * @param $id The id of topic, reply or private message which the attachments belong to.
	 * @param $field The name of files filed in $_FILES array.
	 * @param $type The value of the parameter can be "subject" to indicates that the attachments belong
	 * 				to the topic with $id, also can be "reply" or "pm".
	 * @param $succeed Can be null, otherwise a reference array which will contain 
	 * 					a list of successfully uploaded files.
	 * @param $failed Can be null, otherwise a reference array which will contain 
	 * 					a list of failed uploaded files.
	 * 
	 * @see MySmartAttach::addAttach()
	 */
	public function uploadAttachments( $upload_permission, $files_limit, $id, $field, $type, &$succeed = null, &$failed = null )
	{
		if ( !$upload_permission )
			return false;
		
		$files_number = sizeof( $this->engine->_FILES[ $field ][ 'name' ] );
		
		// ... //
		
		// The member exceeded the number of allowed number of attachments at once
		if ( $files_number > $files_limit and !$this->engine->_CONF[ 'group_info' ][ 'admincp_allow' ] )
			$this->engine->func->error( $this->engine->lang[ 'cant_upload_more_than' ] . ' ' . $files_limit );

		// ... //
		
		// Do the real job. Upload files and insert them into database.
		$this->addAttach( 	$this->engine->_FILES[ $field ], 
							$type, $id, true, 
							$succ, $fail  );
		
		// Free some memory.
		unset( $this->engine->_FILES[ $field ] );
	}
	
	// ... //
	
	/**
	 * Uploads attachments and link them to a specific topic, reply or private message.
	 * 
	 * @param $files An array of the files as represented on _FILES array.
	 * @param $type The value of the parameter can be "subject" to indicates that the attachments belong
	 * 				to the topic with $id, also can be "reply" or "pm".
	 * @param $id The id of topic, reply or private message which the attachments belong to.
	 * @param $update_db_state The default value is false, set it as true so the function
	 * 							will update attach_subject/attach_reply field of the
	 * 							topic/reply with the $id number, if the topic/reply
	 * 							already indicated that it has attachments so keep it false.
	 * @param $succeed Can be null, otherwise a reference array which will contain 
	 * 					a list of successfully uploaded files.
	 * @param $failed Can be null, otherwise a reference array which will contain 
	 * 					a list of failed uploaded files.
	 * 
	 * @return boolean
	 * 
	 * @see MySmartAttach::uploadFile()
	 */
	public function addAttach( $files, $type, $id, $update_db_state = false, &$succeed = null, &$failed = null )
	{
		// ... //
		
		if ( !is_null( $succeed ) and !is_array( $succeed ) )
			$succeed = null;
		
		if ( !is_null( $failed ) and !is_array( $failed ) )
			$failed = null;
		
		// ... //
		
		$files_num = sizeof( $files[ 'name' ] );
		$k = 0;
		
		for ( $k = 0; $k < $files_num; $k++ )
		{
			// ... //
			
			if ( empty( $files[ 'name' ][ $k ] ) )
				continue;
			
			// ... //
			
			$path = null;
			
			$file = array( 	'name'		=>	$files[ 'name' ][ $k ], 
							'type'		=>	$files[ 'type' ][ $k ], 
							'tmp_name'	=>	$files[ 'tmp_name' ][ $k ],
							'size'		=>	$files[ 'size' ][ $k ],	
							'error'		=>	$files[ 'error' ][ $k ]	);
				
			$upload = $this->uploadFile( $file, $path );
			
			if ( $upload )
			{
				if ( !is_null( $succeed ) )
					$succeed[] = $files[ 'name' ][ $k ];
				
				$this->engine->rec->table = $this->engine->table[ 'attach' ];
				$this->engine->rec->fields = array(	'filename'		=>	$files[ 'name' ][ $k ],
													'filepath'		=>	$path,
													'filesize'		=>	$files[ 'size' ][ $k ] );
     			
     			if ( $type != 'pm' )
     			{
     				$this->engine->rec->fields[ 'subject_id' ] = $id;
     				$this->engine->rec->fields[ 'reply' ] = ( $type == 'reply' ) ? '1' : '0';
     			}
     			else
     			{
     				$this->engine->rec->fields[ 'pm_id' ] = $id;
     			}
     			
				$insert = $this->engine->rec->insert();
     									
				if ( $insert )
				{
					if ( $update_db_state and ( $type == 'subject' or $type == 'reply' ) )
					{
						$this->engine->rec->table = ( $type == 'subject' ) ? $this->engine->table[ 'subject' ] : $this->engine->table[ 'reply' ];
						$this->engine->rec->fields = ( $type == 'subject' ) ? array(	'attach_subject' => '1'	) : array( 'attach_reply' => '1' );
						$this->engine->rec->filter = "id='" . $id . "'";
     										
						$update = $this->engine->rec->update();
					}
				}
			}
			else
			{
				if ( !is_null( $failed ) )
					$failed[ $files[ 'name' ][ $k ] ] = $upload;
			}
		}
		
		return true;
	}
	
	/**
	 * Uploads an array of files after checking if the type of files allowed or not according
	 * to extension table or $allowed_extensions parameter.
	 * 
	 * @param $file Array of the file.
	 * @param $returned_path A reference variable, will contain the path of uploaded files.
	 * @param $allowed_extentions The default value is null, otherwise an array of
	 * 								allowed file extensions.
	 * @param $target_dir The default value is null so the file will be uploaded
	 * 						to the default attachments directory, otherwise
	 * 						the directory wich the file will be uploaded to.
	 * 
	 * @return true when success otherwise false.
	 * 
	 */
	public function uploadFile( $file, &$returned_path, $allowed_extentions = null, $target_dir = null )
	{
		if ( !is_array( $file ) )
			trigger_error( 'ERROR: $file should be an array -- FROM uploadFile()', E_USER_ERROR );
		
		// ... //
		
		$allowed = $this->isAllowedFile( $file[ 'name' ], $file[ 'type' ], $file[ 'size' ], $allowed_extentions );
		
		if ( $allowed != true )
			return $allowed;
		
		// ... //
		
		if ( is_null( $target_dir ) )
			$dir = $this->engine->_CONF[ 'info_row' ][ 'download_path' ];
		else
			$dir = $target_dir;
		
		// ... //
		
		if ( file_exists( $dir . '/' . $file[ 'name' ] ) )
			$file[ 'name' ] = $this->engine->func->randomCode() . '-' . $file[ 'name' ];
     	
     	// ... //
     	
     	$returned_path = $dir . '/' . $file[ 'name' ];
     	
		$upload = move_uploaded_file( $file[ 'tmp_name' ], $returned_path );
		
		return ( $upload ) ? true : false;
	}
	
	/**
	 * Checks if the file is allowed to upload according to its type (AKA extension)
	 * and its size.
	 * 
	 * @param $filename The name of file, it's a reference variable, it may be changed
	 * 					if there is a file which has the same name.
	 * @param $type The MIME type.
	 * @param $size The size of the file in bytes.
	 * @param $allowed_extentions Can be null, so the allowed extensions will be obtained
	 * 								from the table "extensions", otherwise a numeric
	 * 								array of allowed extensions.
	 * 
	 * @return true, false, null if $allowed_extentions neither null nor an array, MySmartAttach::FORBIDDEN_EXTENTION or MySmartAttach::LARGE_SIZE. 
	 */
	public function isAllowedFile( &$filename, $type, $size, $allowed_extentions = null )
	{
		$ext = $this->getFileExtension( $filename );
		
		// If the parameter "$allowed_extentions" is null, so get the allowed extention list
		// from the database.
		if ( is_null( $allowed_extentions ) )
		{
			// TODO : cache me please
			$this->engine->rec->table = $this->engine->table[ 'extension' ];
			$this->engine->rec->filter = "Ex='" . $ext . "'";
     					
			$extension = $this->engine->rec->getInfo();
		
			if ( !$extension )
			{
				return self::FORBIDDEN_EXTENTION;
			}
			else
			{
				if ( !empty( $extension[ 'mime_type' ] ) )
					if ( $type != $extension[ 'mime_type' ] )
						return self::FORBIDDEN_EXTENTION;
			}
		
			// Convert the size from bytes to KB
			$size = ceil( ( $size / 1024 ) );
     				
			if ( $size > $extension[ 'max_size' ] )
				return self::LARGE_SIZE;
			else
				return true;
		}
		else
		{
			if ( !is_array( $allowed_extentions ) )
				return null;
			
			return ( !in_array( $ext, $allowed_extentions ) ) ? false : true;
		}
	}
	
 	public function getFileExtension( &$filename )
    {
    	$ex = pathinfo( $filename );
    	
    	$extension = '.' . strtolower( $ex[ 'extension' ] );
    	
    	// Kill multi-extension
    	$filename = str_replace( '.', '-', $ex[ 'filename' ] );
    	$filename = $filename . $extension;
    	
    	return $extension;
 	}
}

?>
