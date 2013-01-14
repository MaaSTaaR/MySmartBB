<?php

/**
 * @package MySmartAds
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @since Mon 19 Mar 2012 12:36:58 AM AST 
 * @license GNU GPL
 */

class MySmartAds
{
	private $engine;
	
	// ... //
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	// ... //
	
	/**
	 * Updates the cache of ads.
	 * 
	 * @return boolean
	 */
	public function updateAdsCache()
	{
        $this->engine->rec->table = $this->engine->table[ 'ads' ];
        
        $ads_res = &$this->engine->func->setResource();
        
        $this->engine->rec->getList();
        
        $num = $this->engine->rec->getNumber( $ads_res );
        
        // If there is no ads entries in the database, don't bother yourself too much
        if ( $num <= 0 )
        {
            $storable_cache = '';
        }
        else
        {
            $cache = array();

            while ( $r = $this->engine->rec->getInfo( $ads_res ) )
            {
                $cache[] = $r;
            }
            

            $storable_cache = base64_encode( serialize( $cache ) );
        }
        
        $update = $this->engine->info->updateInfo( 'ads_cache', $storable_cache );
        
        if ( $update )
        {
            $update = $this->engine->info->updateInfo( 'ads_num', $num );
            
            return ( $update ) ? true : false;
        }
        else
        {
            return false;
        }
	}
}

?>
