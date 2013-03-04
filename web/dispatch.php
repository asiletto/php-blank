<?php

require_once '../lib/loader.php';

session_start();
error_reporting(E_ALL ^ E_NOTICE);

$container = new Pimple();
// mongodb configuration
$container['connection_url'] = "mongodb://username:password@hostname:12345/databasename";
// log configuration
$container['log_dateformat'] = "Y-m-d H:i:s";
$container['log_logformat'] = "[%datetime%] %channel%.%level_name%: %message% %context%\n";
$container['log_file'] = "/tmp/application.log";
$container['log_appender'] = "appname";
// smarty configuration
$container['smarty_template_dir'] = '../views';
$container['smarty_compile_dir'] = sys_get_temp_dir();
// mongodb collections
$container['dbcoll'] = array(
		"test" => "test"
	);

$container['smarty'] = function($c){
	$smarty = new Smarty();
	$smarty->setTemplateDir($c['smarty_template_dir']);
	$smarty->setCompileDir($c['smarty_compile_dir']);
	$smarty->error_reporting = E_ALL & ~E_NOTICE;
	return $smarty;
};

$container['log'] = function($c){
	$logger = new Monolog\Logger($c['log_appender']);
	$formatter = new Monolog\Formatter\LineFormatter($c['log_logformat'], $c['log_dateformat']);
	$stream = new Monolog\Handler\StreamHandler($c['log_file'], Monolog\Logger::DEBUG);
	$stream->setFormatter($formatter);
	$logger->pushHandler($stream);
	return $logger;
};

$container['database'] = function($c) {
	$m = new Mongo($c["connection_url"]);
	$url = parse_url($c["connection_url"]);
	$db_name = preg_replace('/\/(.*)/', '$1', $url['path']);
	$db = $m->selectDB($db_name);
	return $db;
};

include_once '../src/BaseResource.php';

$config = array(
    'load' => array(
    	  '../src/webapp/*',
       	  '../src/services/*'
    ),
   	#'cache' => new Tonic\MetadataCacheFile('/tmp/tonic.cache') // use the metadata cache
    #'cache' => new Tonic\MetadataCacheAPC // use the metadata cache
);

$app = new Tonic\Application($config);
$request = new Tonic\Request();

try {

    $resource = $app->getResource($request);
    
    $resource->container = $container;
    
    $response = $resource->exec();

} catch (Tonic\NotFoundException $e) {

	$response = new Tonic\Response(404, $e->getMessage());
	
} catch (Tonic\UnauthorizedException $e) {
    
	$response = new Tonic\Response(401, $e->getMessage());
    $response->wwwAuthenticate = 'Basic realm="appname"';

} catch (Tonic\Exception $e) {
    
	$response = new Tonic\Response($e->getCode(), $e->getMessage());

}

$response->output();
?>