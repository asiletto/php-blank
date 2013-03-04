<?php 

#monolog
require_once 'Psr/Log/LoggerInterface.php';
require_once 'Monolog/Logger.php';

require_once 'Monolog/Formatter/FormatterInterface.php';
require_once 'Monolog/Formatter/NormalizerFormatter.php';
require_once 'Monolog/Formatter/LineFormatter.php';
require_once 'Monolog/Handler/HandlerInterface.php';
require_once 'Monolog/Handler/AbstractHandler.php';
require_once 'Monolog/Handler/AbstractProcessingHandler.php';
require_once 'Monolog/Handler/StreamHandler.php';

#Pimple
require_once 'Pimple/Pimple.php';

#Smarty
require_once 'Smarty/Smarty.class.php';

#Tonic
require_once 'Tonic/Autoloader.php';

?>