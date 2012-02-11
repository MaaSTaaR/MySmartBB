<?php

function getAPI()
{
    global $MySmartBB;
    
    require( 'includes/systems/PluginAPI.class.php' );

    return new PluginAPI( $MySmartBB, dirname( __FILE__ ), 'arabic' );
}

?>
