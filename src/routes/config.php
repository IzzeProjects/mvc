<?php
declare(strict_types=1);

return function (\Core\Route\Router $router) {
    $router->add('/main', \Src\Controllers\IndexController::class, 'index');
};
