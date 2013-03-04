<?php

use Tonic\UnauthorizedException;
use Tonic\Response;
/**
 * @uri /hello
 * 
 */
class HelloApp extends BaseResource {

	/**
	 * @method GET
	 */
	function hello() {
		$smarty = $this->container['smarty'];
		$log = $this->container['log'];
		$log->addDebug($this->getLoggedUsername().' executing '.get_class($this).'.'.__FUNCTION__.'() '.$_SERVER['REQUEST_URI'], array("GET"=>$_GET, "POST"=>$_POST));
		
		$smarty->assign('hello', "Hello world!");
		
		return $smarty->fetch('hello.html');
	}
	
}

?>