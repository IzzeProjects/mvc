<?php
declare(strict_types=1);

$factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $factory,
    $factory,
    $factory,
    $factory
);

$request = $creator->fromGlobals();

$router = new \Core\Route\DefaultRouter($request);

$routes = require __DIR__ . '/../src/routes/config.php';

$routes($router);

$router->dispatchAction();
