<?php

// TODO : What about update to a new version of a plugin?

interface PluginInterface
{
    // ... //
    
    /* info() :
     *  Returns an array that contains the information about the plugin.
     *
     *  Array's keys :
     *                  title : The title of the plugin in human readable format
     *                  description : A brief description about the plugin and its functionality
     *                  author : The name(s) of the plugin's author(s)
     *                  license : The license of the plugin (e.g. GNU GPL)
    **/
	public function info();
	
	// ... //
	
	/* pages() :
	 *  Returns an array that contains the list of page(s) that the plugin has.
	 *
	 *  If the plugin has no page(s) so the function can be empty or returns null.
	 *
	 *  Example :
	 *              return array(   'show_microblog'    =>  'show.module.php'  );
	 *
	 *  The key (show_microblog) is the action name, and (show.module.php) is the file that will
	 *  be run when the user goes to http://[URL]/index.php?page=plugin&name=[plugin_name]&action=show_microblog
	 *
	**/
	public function pages();
	
	// ... //
	
	/* hooks() :
	 *  Returns an array that contains the list of hook(s) that the plugin should register on it
	 *  and the function that should be called when the hook(s) trigger.
	 *
	 *  Example :
	 *              array( 	'main_after_header' 	=> 'helloWorld,helloWorld2',
	 *					    'main_before_footer'	=> 'byeWorld'	);
	 *
	 *  So, the functions helloWorld() and helloWorld2() will be called when the hook "main_after_header" triggered
	 *  and the function byeWorld() will be called when the hook "main_before_footer" triggered
	 *
	 *  _Note_ : All the functions must be defined on the plugin's main class.
	**/
	public function hooks();
	
	// ... //
	
	/* install() :
	 *  The system calls this function when the user request install the plugin.
	 *
	 *  You can do the database (e.g. creating tables or adding fields) and template modifications stuff inside this function.
	**/
	public function install();
	
	// ... //
	
	/* activate() :
	 *  The system calls this function when the user activate the plugin.
	**/
	public function activate();
	
	// ... //
	
	/* deactivate() :
	 *  The system calls this function when the user deactivate the plugin.
	**/
	public function deactivate();
	
	// ... //
	
	/*
	 * uninstall() :
	 *  The system calls this function when the user uninstall the plugin.
	 *
	 *  _Note_ that you have nothing to do with hooks because the system will remove them automatically
	 *  but you have to remove the modifications on the database or templates manually.
	**/
	public function uninstall();
	
	// ... //
}

?>
