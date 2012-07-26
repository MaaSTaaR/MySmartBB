<?php

/**
 * @package 	: 	MySmartAttach
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @started 	: 	Wed 31 Aug 2011 08:08:01 AM AST 
 * @updated 	:	-
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
	
	// The most high-level function
	public function uploadAttachments( $upload_permission, $files_limit, $id, $field, $type, &$succeed = null, &$failed = null )
	{
		if ( $upload_permission )
		{
			$files_number = sizeof( $this->engine->_FILES[ $field ][ 'name' ] );
			
			if ( $files_number > 0 )
			{
				if ( $files_number > $files_limit
					and !$this->engine->_CONF[ 'group_info' ][ 'admincp_allow' ] )
				{
					$this->engine->func->error( $this->engine->lang[ 'cant_upload_more_than' ] . ' ' . $files_limit );
				}
				
				$this->engine->attach->addAttach( $this->engine->_FILES[ $field ], $type, $id, true, $succ, $fail  );
					
				unset( $this->engine->_FILES[ $field ] );
			}
		}
	}
	
	// ... //
	
	public function addAttach( $files, $type, $id, $update_db_state = false, &$succeed = null, &$failed = null )
	{
		if ( !is_null( $succeed ) and !is_array( $succeed ) )
			$succeed = null;
		
		if ( !is_null( $failed ) and !is_array( $failed ) )
			$failed = null;
		
		$files_num = sizeof( $files[ 'name' ] );
		$k = 0;
		
		while ( $k < $files_num )
		{
			if ( !empty( $files[ 'name' ][ $k ] ) )
			{
				$path = null;
				
				$file = array( 'name'	=>	$files[ 'name' ][ $k ], 'type'	=>	$files[ 'type' ][ $k ], 'tmp_name'	=>	$files[ 'tmp_name' ][ $k ],
								'size'	=>	$files[ 'size' ][ $k ],	'error'	=>	$files[ 'error' ][ $k ]	);
				
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
						if (  $update_db_state )
						{
							if ( $type == 'subject' )
							{
								$this->engine->rec->table = $this->engine->table[ 'subject' ];
								$this->engine->rec->fields = array(	'attach_subject'	=>	'1'	);
							}
							elseif ( $type == 'reply' )
							{
								$this->engine->rec->table = $this->engine->table[ 'reply' ];
								$this->engine->rec->fields = array(	'attach_reply'	=>	'1'	);
							}
							
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
				
				$k++;
			}
			else
			{
				break;
			}
		}
		
		return true;
	}
	
	public function uploadFile( $file, &$returned_path, $allowed_extentions = null, $target_dir = null )
	{
		if ( !is_array( $file ) )
			trigger_error( 'ERROR: $file should be an array -- FROM uploadFile()',E_USER_ERROR );
		
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
	
	public function isAllowedFile( &$filename, $type, $size, $allowed_extentions = null )
	{
		$ext = $this->getFileExtension( $filename );
     	
     	if ( $ext == 'MULTIEXTENSION' )
     	{
     		
     	}
		elseif ( !$ext )
		{
			return self::FORBIDDEN_EXTENTION;
		}
		else
		{
			// If the parameter "$allowed_extentions" is null, so get the allowed extention list
			// from the database.
			if ( is_null( $allowed_extentions ) )
			{
				// TODO : cache me please
				$this->engine->rec->table = $this->engine->table[ 'extension' ];
				$this->engine->rec->filter = "Ex='" . $ext . "'";
     						
				$extension = $this->engine->rec->getInfo();
			
				if (!$extension)
				{
					return self::FORBIDDEN_EXTENTION;
				}
				else
				{
					if ( !empty( $extension['mime_type'] ) )
					{
						if ( $type != $extension['mime_type' ])
						{
							return self::FORBIDDEN_EXTENTION;
						}
					}
				}
			
				// Convert the size from bytes to KB
				$size = ceil( ( $size / 1024 ) );
     					
				if ( $size > $extension[ 'max_size' ] )
				{
					return self::LARGE_SIZE;
				}
				else
				{
					return true;
				}
			}
			else
			{
				if ( !is_array( $allowed_extentions ) )
					return null;
				
				return ( !in_array( $ext, $allowed_extentions ) ) ? false : true;
			}
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
    	
  		/*$ex = explode( '.', $filename );
  		
  		$size = sizeof( $ex );
  		
  		if ( $size == 2 )
  			return '.' . strtolower( $ex[1] );
  		elseif ( $size > 2 )
  			return 'MULTIEXTENSION';
  		else
  			return false;*/
 	}
}

?>
