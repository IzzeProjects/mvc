<?php
declare(strict_types=1);

return function (\Core\Route\Router $router) {
    $router->add('/simple', \Src\Controllers\IndexController::class, 'simple');
    $router->add('/view', \Src\Controllers\IndexController::class, 'viewAction');
    $router->add('/json', \Src\Controllers\IndexController::class, 'json');
    $router->add('/xml', \Src\Controllers\IndexController::class, 'xml');
    $router->add('/', \Src\Controllers\IndexController::class, 'index');
};
