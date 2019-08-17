<?php
declare(strict_types=1);

return function (\Core\Route\Router $router) {
    $router->add('/model', \Src\App\Controllers\IndexController::class, 'model');
    $router->add('/simple', \Src\App\Controllers\IndexController::class, 'simple');
    $router->add('/view', \Src\App\Controllers\IndexController::class, 'viewAction');
    $router->add('/json', \Src\App\Controllers\IndexController::class, 'json');
    $router->add('/xml', \Src\App\Controllers\IndexController::class, 'xml');
    $router->add('/', \Src\App\Controllers\IndexController::class, 'index');
};
