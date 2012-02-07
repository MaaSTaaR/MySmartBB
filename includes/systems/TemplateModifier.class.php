<?php

/*
 * @package : TemplateModifier
 * @author : Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @started : Tue 26 Dec 2011 11:39 PM
 * @license : GNU LGPL
 * @description : This class make the life easier for plugin's developer who needs to modify existing templates for his/her plugin.
*/

define( 'TEMPLATES_EXT', '.tpl' );

class File
{
    private $path;
    private $fp;
    private $size;
    private $content;
    
    function __construct( $path, $mode )
    {
        $this->path = $path;
        $this->size = filesize( $this->path );
        
        // What if the user chooses w+ mode, then tries to read the content?
        // So, it's safer to get the content from the beginning.
        $this->content = file_get_contents( $this->path );
        
        $this->fp = fopen( $this->path, $mode );
        
        if ( $this->fp === false )
            return false;
    }
    
    public function write( $text )
    {
        $w = fwrite( $this->fp, $text );
        
        if ( $w != false )
            return true;
        else
            return false;
    }
    
    public function read()
    {
        return $this->content;
    }
    
    public function close()
    {
        fclose( $this->fp );
    }
}

class TemplateModifier
{
    protected $template_paths = array();
    protected $file = array();
    protected $content = array();
    protected $contents_num = 0;
    protected $table = null;
    protected $hook = null;
    
    function __construct( $template, $paths )
    {
        $x = 0;
        
        foreach ( $paths as $k => $path )
        {
            $this->template_paths[ $x ] = $path . '/' . $template . TEMPLATES_EXT;
        
            $this->file[ $x ]       = new File( $this->template_paths[ $x ], 'w+' /*'r'*/ );
            $this->content[ $x ]    = $this->file[ $x ]->read();
            
            $x++;
        }
        
        $this->contents_num = sizeof( $this->content );
    }
    
    public function openTable( $id )
    {
        if ( !is_null( $this->table ) )
            trigger_error( 'TemplateModifier::openTable -> There is already opened table', E_USER_ERROR );
            
        $this->table = new Tables( $id, $this->content );
    }
    
    public function closeTable()
    {
        $this->content = $this->table->getContent();
        $this->table = null;
    }
    
    public function getTable()
    {
        return $this->table;
    }
    
    public function openHook( $id )
    {
        if ( !is_null( $this->hook ) )
            trigger_error( 'TemplateModifier::openTable -> There is already opened hook', E_USER_ERROR );
        
        $this->hook = new Hooks( $id, $this->content );
    }
    
    public function closeHook()
    {
        $this->content = $this->hook->getContent();
        $this->hook = null;
    }
    
    public function getHook()
    {
        return $this->hook;
    }
    
    public function removeByID( $id, $tag )
    {
        for ( $k = 0; $k < $this->contents_num; $k++ )
        {
            $matches = array();
            
            // Note : We put "(.)" after ( ' . $tag . ' ) to fix a bug, but with this we have a limitation now
            // The function now can only find the tags that look like <tag [You can NOT put anything here] id="" [You can put anything here]>
            // So id attribute _should_ be the first attribute inside the tag
            $search = preg_match( '/\<' . $tag . '(.)id="' . $id . '"(.*?)\>(.*?)\<\/' . $tag . '\>/s', $this->content[ $k ], &$matches );
            
            $this->content[ $k ] = str_replace( $matches[ 0 ], '', $this->content[ $k ] );
        }
    }
    
    public function save()
    {
        // Write the new content
        for ( $k = 0; $k < $this->contents_num; $k++ )
        {
            $this->file[ $k ]->write( $this->content[ $k ] );
        
            $this->file[ $k ]->close();
        }
        
        return true;
    }
    
    static public function isValidID( $html )
    {
        $search = preg_match( '/\<(.*)id="plugin_(.*?)"(.*?)\>/s', $html );
        
        return ( $search == 0 ) ? false : true;
    }
}

class Tables
{
    protected $tables = array(); // Array of objects
    protected $contents = array();
    
    function __construct( $id, $contents )
    {
        if ( is_array( $contents ) )
        {
            foreach ( $contents as $key => $content )
            {
                $this->tables[] = new Table( $id, $content );
            }
        }
    }
    
    public function addRow( $html, $pos, $row_id )
    {
        foreach ( $this->tables as $k => $table )
        {
            $table->addRow( $html, $pos, $row_id );
        }
    }
    
    public function addRowAtEnd( $html )
    {
        foreach ( $this->tables as $k => $table )
        {
            $table->addRowAtEnd( $html );
        }
    }
    
    public function addCell( $html, $row_id, $pos, $cell_id )
    {
        foreach ( $this->tables as $k => $table )
        {
            $table->addCell( $html, $row_id, $pos, $cell_id );
        }
    }
    
    public function addCellAtEnd( $html, $row_id )
    {
        foreach ( $this->tables as $k => $table )
        {
            $table->addCellAtEnd( $html, $row_id );
        }
    }
    
    public function getContent()
    {
        foreach ( $this->tables as $k => $table )
        {
            $this->contents[] = $table->getContent();
        }
        
        return $this->contents;
    }
}

class Table
{
    const NO_SUCH_TABLE = -1;
    
    protected $id;
    protected $content;
    protected $body;
    protected $table;
    protected $rows_num;
    protected $rows;
    protected $cells;
    protected $updated_cells = false;
    
    function __construct( $id, $content )
    {
        $this->id = $id;
        $this->content = $content;
        
        $this->_findTable();
        $this->_setRowsAndCells();
    }
    
    private function _findTable()
    {
        $matches = array();
        
        $search = preg_match( '/\<table(.*)id="' . $this->id . '"(.*?)\>(.*?)\<\/table\>/s', $this->content, &$matches );
        
        if ( $search == 0 )
        {
            $this->table = $this->body = Table::NO_SUCH_TABLE;
        }
        else
        {
            $this->table = $matches[ 0 ];
            $this->body = $matches[ 3 ];
        }
    }
    
    private function _setRowsAndCells()
    {
        if ( $this->body == Table::NO_SUCH_TABLE )
        {
            $this->rows = $this->cells = Table::NO_SUCH_TABLE;
        }
        else
        {
            $matches = array();
            
            preg_match_all( '/\<tr(.*?)\>(.*?)\<\/tr\>/s', $this->body, &$matches );
        
            $this->rows_num = sizeof( $matches[ 0 ] );
            $this->rows = $matches[ 0 ];
                
            // Store cells
            foreach ( $this->rows as $k => $row )
            {
                $matches = array();
        
                preg_match_all( '/\<td(.*?)\>(.*?)\<\/td\>/s', $row, &$matches );
            
                $this->cells[ $k ] = $matches[ 0 ];
            }
        }
    }
    
    public function addRow( $html, $pos, $row_id )
    {
        if ( !TemplateModifier::isValidID( $html ) )
            trigger_error( 'Table::addRow -> Invalid ID', E_USER_ERROR );
        
        if ( $row_id < 1 )
            return false;
        
        if ( $this->rows == Table::NO_SUCH_TABLE )
            return false;
        
        if ( $row_id > $this->rows_num )
            $row_id = $this->rows_num;
        
        $row_id--;
        
        if ( $pos == 'before' )
        {
            $text = $html . $this->rows[ $row_id ];
        }
        else
        {
            $text = $this->rows[ $row_id ] . $html; 
        }
        
        $this->content = str_replace( $this->rows[ $row_id ], $text, $this->content );
        
        return true;
    }
    
    public function addRowAtEnd( $html )
    {
        return $this->addRow( $html, 'after', $this->rows_num );
    }
    
    public function addCell( $html, $row_id, $pos, $cell_id )
    {
        if ( !TemplateModifier::isValidID( $html ) )
            trigger_error( 'Table::addCell -> Invalid ID', E_USER_ERROR );
        
        if ( $row_id < 1 or $cell_id < 1 )
            return false;

        if ( $this->rows == Table::NO_SUCH_TABLE )
            return false;
        
        if ( $row_id > $this->rows_num )
            $row_id = $this->rows_num;
        
        $row_id--;
        
        $cells_num = sizeof( $this->cells[ $row_id ] );
        
        if ( $cell_id > $cells_num )
            $cell_id = $cells_num;
        
        $cell_id--;
        
        if ( $pos == 'before' )
        {
            $text = $html . $this->cells[ $row_id ][ $cell_id ];
        }
        else
        {
            $text = $this->cells[ $row_id ][ $cell_id ] . $html; 
        }
        
        $this->content = str_replace( $this->cells[ $row_id ][ $cell_id ], $text, $this->content );
        
        // There is a new cell, so we have to update the "colspan" atrribute of table's head tag
        $this->updated_cells = true;
        
        return true;
    }
    
    public function addCellAtEnd( $html, $row_id )
    {
        return $this->addCell( $html, $row_id, 'after', sizeof( $this->cells[ $row_id ] ) );
    }
    
    public function getContent()
    {
        if ( $this->updated_cells )
            // Until now, we only solved a part of colspan problem
            // We just update the colspan of table's head but what if we have a colspan
            // in a row other than the head row?
            $this->_updateHeadColSpan();
        
        return $this->content;
    }
    
    private function _updateHeadColSpan()
    {
        // Quick and Dirty :-( to get the new number of colspan
        $this->_findTable();
        $this->_setRowsAndCells();
        
        $max_colspan = 0;
        
        foreach ( $this->rows as $k => $row )
        {   
            $max_colspan = max( $max_colspan, sizeof( $this->cells[ $k ] ) );
        }
        
        $replacement = preg_replace( "/colspan=\"(.*?)\"/", "colspan=\"" . $max_colspan . "\"", $this->rows[ 0 ] );
        
        $this->content = str_replace( $this->rows[ 0 ], $replacement, $this->content );
        
        $updated_cells = false;
    }
}

class Hooks
{
    private $hooks = array(); // Array of objects
    private $contents = array();
    
    function __construct( $id, $contents )
    {
        if ( is_array( $contents ) )
        {
            foreach ( $contents as $key => $content )
            {
                $this->hooks[] = new Hook( $id, $content );
            }
        }
    }
    
    public function addContent( $html )
    {
        foreach ( $this->hooks as $k => $hook )
        {
            $hook->addContent( $html );
        }
    }
    
    public function getContent()
    {
        foreach ( $this->hooks as $k => $hook )
        {
            $this->contents[] = $hook->getContent();
        }
        
        return $this->contents;
    }
}

class Hook
{
    private $id;
    private $content;
    private $hook_tag;
    
    function __construct( $id, $content )
    {
        $this->id = $id;
        $this->content = $content;
        
        $this->hook_tag = '{hook}' . $this->id . '{/hook}';
        
        $this->_findHook();
    }
    
    private function _findHook()
    {
        $search = strstr( $this->content, $this->hook_tag );
        
        if ( !$search )
            return false;
        else
            return true;
    }
    
    public function addContent( $html )
    {
        if ( !TemplateModifier::isValidID( $html ) )
            trigger_error( 'Hook::addContent -> Invalid ID', E_USER_ERROR );
        
        $text = $this->hook_tag . "\n" . $html;
        
        $this->content = str_replace( $this->hook_tag, $text, $this->content );
    }
    
    public function getContent()
    {
        return $this->content;
    }
}

?>
