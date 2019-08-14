<?php
declare(strict_types=1);

use Core\Route\Router;

return function (Router $router) {
    $router->add('/main', \Src\Controllers\IndexController::class, 'index');
};
