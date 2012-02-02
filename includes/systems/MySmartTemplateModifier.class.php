<?php

/*
 * @package : MyTemplateModifier
 * @author : Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @started : Thu 02 Feb 2012 05:47:00 AM AST 
 * @license : GNU LGPL
 * @description : Special version of TemplateModifier for MySmartBB
*/

require( 'TemplateModifier.class.php' );

class MySmartTemplateModifier extends TemplateModifier
{
    function __construct( $template )
    {
        global $MySmartBB;
        
        $MySmartBB->rec->table = $MySmartBB->table[ 'style' ];
		
		$MySmartBB->rec->getList();
		
		$paths = array();
		
		while ( $r = $MySmartBB->rec->getInfo() )
		{
		    $paths[] = $r[ 'template_path' ];
		}
		
		parent::__construct( $template, $paths );
    }
    
    public function openTable( $id )
    {
        if ( !is_null( $this->table ) )
            trigger_error( 'MySmartTemplateModifier::openTable -> There is already opened table', E_USER_ERROR );
            
        $this->table = new MySmartTables( $id, $this->content );
    }
}

class MySmartTables extends Tables
{
    function __construct( $id, $contents )
    {
        if ( is_array( $contents ) )
        {
            foreach ( $contents as $key => $content )
            {
                $this->tables[] = new MySmartTable( $id, $content );
            }
        }
    }
}

class MySmartTable extends Table
{
    public function addRow( $html, $pos, $row_id )
    {
        parent::addRow( $html, $pos, $row_id );
        
        // If there is {/if} or {/Des::while} (for example) under the row
        // Ensure that we add the new row under the template's syntax
        $matches = array();
        
        $search = str_replace( array( '<', '>', '/' ), array( '\\<', '\\>', '\\/' ), $html );
        
        $find = preg_match( '/' . $search . '(.*?)\{\/(.*?)\}/s', $this->content, &$matches );
        
        if ( $find != 0 )
        {
            $to_replace = $matches[ 0 ];
            
            $replacement = str_replace( $html, '', $to_replace );
            $replacement = $replacement . "\n" . $html;
            
            $this->content = str_replace( $to_replace, $replacement, $this->content );            
        }
    }
}

?>
