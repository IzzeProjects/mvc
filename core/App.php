<?php
declare(strict_types=1);

namespace Core;

use Core\Controller\BaseController;
use Core\Route\{DefaultRouter, Router};
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
        $this->factory = new Psr17Factory();
        $creator = new ServerRequestCreator(
            $this->factory,
            $this->factory,
            $this->factory,
            $this->factory
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
            $router = new DefaultRouter($request); // TODO router implementation
            $routes = require_once __DIR__ . '/../src/routes/config.php';
            $routes($router);
            return $router;
        }]);
    }

    /**
     * Dispatch action by URL
     * @throws \ReflectionException
     */
    public function dispatchAction()
    {
        $this->addInvokedAction();
        $this->container->get(BaseController::class);
    }

    /**
     * Add action in DI container
     * @throws \ReflectionException
     */
    private function addInvokedAction()
    {
        $router = $this->container->get(Router::class);
        $action = $router->requestedAction();
        $controller = $router->requestedController();
        $ref = new \ReflectionMethod($controller, $action);
        $controllerAutowire = \DI\autowire($controller);
        $controllerAutowire->method($action);
        foreach ($ref->getParameters() as $param) {
            $controllerAutowire->methodParameter($action, $param->getName(), \DI\get($param->getType()->getName()));
        };
        $this->container->set(BaseController::class, $controllerAutowire);
    }

    /**
     * Set dependencies
     */
    public function setDependencies()
    {
        $coreConfig = require_once __DIR__ . '/../core/Configs/dependencies.php';
        $this->resolveDependencies($coreConfig['dependencies']);
        $clientConfig = require_once __DIR__ . '/../src/configs/dependencies.php';
        $this->resolveDependencies($clientConfig['dependencies']);
    }

    /**
     * Resolve dependencies
     * @param array $dependencies
     */
    private function resolveDependencies(array $dependencies)
    {

        foreach ($dependencies as $dependency) {
            $dependencySetter = new $dependency();
            $dependencySetter->set($this->container);
        }
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