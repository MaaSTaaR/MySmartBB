<?php

/*
 * @package : PluginAPI
 * @author : Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @started : Sat 11 Feb 2012 05:56:12 AM AST 
 * @license : GNU LGPL
 * @description : A set of APIs for plugin's developers.
*/

class PluginAPI
{
    private $engine;
    private $path; // Plugin's path
    private $lang_path = null;
    private $def_lang = null;
    
    function __construct( $engine, $path, $def_lang = null )
    {
        $this->engine = $engine;
        $this->path = $path . '/';
        $this->def_lang = $def_lang;
    }
    
    public function loadLanguage( $file )
    {
        if ( is_null( $this->lang_path ) )
            $this->_initLanguage();
        
        require_once( $this->lang_path . $file . '.lang.php' );
        
        return $lang;
    }
    
    private function _initLanguage()
    {
        $def_lang = $this->engine->getLanguageDir();
        
        if ( is_dir( $def_lang ) )
            $this->lang_path = $this->path . $this->engine->getLanguageDir() . '/';
        else
            $this->lang_path = $this->path . $this->def_lang . '/';
    }
}

?>
