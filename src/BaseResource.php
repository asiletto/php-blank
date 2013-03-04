<?php

use Tonic\Resource;
use Tonic\UnauthorizedException;

class BaseResource extends Resource {
	
	function json(){
		$this->before(function ($request) {
			if ($request->contentType == "application/json") {
				$request->data = json_decode($request->data);
			}
		});
		$this->after(function ($response) {
			$response->contentType = "application/json";
			if (isset($_GET['jsonp'])) {
				$response->body = $_GET['jsonp'].'('.json_encode($response->body).');';
			} else {
				$response->body = json_encode($response->body);
			}
		});
	}
	
	function getLoggedUsername(){
		return $_SERVER['PHP_AUTH_USER'];
	}
	
	/*
	 * example basic authentication
	 */
	function secure() {
		$technicalAccts = array(
			"test" => "test"
		);
		foreach($technicalAccts as $username=>$password){
			if (
					isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == $username &&
					isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] == $password
			) {
				return;
			}
		}
	
		throw new UnauthorizedException;
	}
	
	function getCollection($collectionName){
		return $this->container['database']->selectCollection($this->container['dbcoll'][$collectionName]);
	}
		
	function startsWith($haystack,$needle,$case=true){
		if($case)
			return strpos($haystack, $needle, 0) === 0;
	
		return stripos($haystack, $needle, 0) === 0;
	}
	
	function endsWith($haystack,$needle,$case=true){
		$expectedPosition = strlen($haystack) - strlen($needle);
	
		if($case)
			return strrpos($haystack, $needle, 0) === $expectedPosition;
	
		return strripos($haystack, $needle, 0) === $expectedPosition;
	}
}

?>