<?php

function getAPI()
{
    global $MySmartBB;
    
    require_once( 'includes/systems/PluginAPI.class.php' );

    return new PluginAPI( $MySmartBB, dirname( __FILE__ ), 'arabic' );
}

?>
