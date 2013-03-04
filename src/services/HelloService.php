<?php

use Tonic\UnauthorizedException;
use Tonic\Response;

/**
 * @uri /services/hello
 * 
 */
class HelloService extends BaseResource {

	/**
	 * @method GET
	 * @secure
	 * @json
	 */
	function hello() {
		$log = $this->container['log'];
		$log->addDebug($this->getLoggedUsername().' executing '.get_class($this).'.'.__FUNCTION__.'() '.$_SERVER['REQUEST_URI'], array("GET"=>$_GET, "POST"=>$_POST));
				
		return new Response(200, array( "hello"=>"world!" ) );
	}
	
}

?>