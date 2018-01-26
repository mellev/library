<?php

$di->registerService('router', function () {
    $router = new \Library\Router();

    require('routes.php');

    return $router;
});

$di->registerService('config', function () {
    return require('config.php');
});

$di->registerService('db', function () use ($di) {
    $config = $di->getService('config');

    return new \Library\Db($config['database']);
});