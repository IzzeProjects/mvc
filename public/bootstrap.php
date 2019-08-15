<?php
declare(strict_types=1);

$container = new DI\Container();

$factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $factory,
    $factory,
    $factory,
    $factory
);

$request = $creator->fromGlobals();

$builder = new DI\ContainerBuilder();

$builder->addDefinitions([\Psr\Http\Message\ServerRequestInterface::class => $request]);

$builder->addDefinitions([\Core\Route\Router::class => DI\autowire(\Core\Route\DefaultRouter::class)]);

$builder->addDefinitions([\Core\Controller\Controller::class => function(\Core\Route\Router $router) {
    $routes = require_once __DIR__ . '/../src/routes/config.php';
    $routes($router);

    return $router->dispatchController();
}]);

$container = $builder->build();
$controller = $container->get(\Core\Controller\Controller::class);
$container->call(function (\Core\Controller\Controller $controller){

});
//$container->set(\Core\Route\Router::class, DI\autowire())
$controller = $container->get(\Core\Controller\Controller::class);


exit;
$routes = require __DIR__ . '/../src/routes/config.php';

$routes($router);

$router->dispatchAction($container);
