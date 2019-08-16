<?php
declare(strict_types=1);

return function (\Core\Route\Router $router) {
    $router->add('/simple', \Src\Controllers\IndexController::class, 'simple');
    $router->add('/json', \Src\Controllers\IndexController::class, 'json');
    $router->add('/', \Src\Controllers\IndexController::class, 'index');
};
