<?php
declare(strict_types=1);

namespace Core;

use Core\Controller\Controller;
use Core\Route\DefaultRouter;
use Core\Route\Router;
use Core\View\ViewResolver;
use DI\ContainerBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{

    /**
     * @var ServerRequestInterface
     */
    private $serverRequest;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ViewResolver
     */
    private $viewResolver;

    /**
     * @var Psr17Factory
     */
    private $factory;

    /**
     * Make request from global variables
     */
    public function makeServerRequest()
    {
        $factory = new Psr17Factory();
        $creator = new ServerRequestCreator(
            $factory,
            $factory,
            $factory,
            $factory
        );
        $request = $creator->fromGlobals();
        $this->serverRequest = $request;
    }

    /**
     * Make dependency injection container
     */
    public function makeDIContainer()
    {
        $builder = new ContainerBuilder();
        $this->defaultDependencies($builder);
        $this->container = $builder->build();

    }

    /**
     * Default dependencies to start app
     * @param ContainerBuilder $builder
     */
    private function defaultDependencies(ContainerBuilder &$builder)
    {
        $builder->addDefinitions([Psr17Factory::class => $this->factory]);
        $builder->addDefinitions([ServerRequestInterface::class => $this->serverRequest]);
        $builder->addDefinitions([Router::class => function (ServerRequestInterface $request) {
            $router = new DefaultRouter($request);
            $routes = require_once __DIR__ . '/../src/routes/config.php';
            $routes($router);
            return $router;
        }]);
    }

    /**
     * Dispatch action by URL
     */
    public function dispatchAction()
    {
        $this->addInvokedAction();
        $this->container->get(Controller::class);
    }

    /**
     * Add action in DI container
     */
    private function addInvokedAction()
    {
        $router = $this->container->get(Router::class);
        $action = $router->requestedAction();
        $controller = $router->requestedController();
        $this->container->set(
            Controller::class,
            \DI\autowire($controller)
                ->method($action, \DI\get(ServerRequestInterface::class))
        );
    }

    /**
     * @return ServerRequestInterface
     */
    public function getServerRequest(): ServerRequestInterface
    {
        return $this->serverRequest;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @return ViewResolver
     */
    public function getViewResolver(): ViewResolver
    {
        return $this->viewResolver;
    }

}