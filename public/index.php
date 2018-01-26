<?php

require_once("../vendor/autoload.php");

$di = new Library\Di();

Library\Di::setStaticContainer($di);

require('../config/services.php');

$router = $di->getService('router');
$router->setDi($di);

echo $router->handle($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);