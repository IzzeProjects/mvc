<?php
declare(strict_types=1);

namespace Core;

use Core\Controller\BaseController;
use Core\Controller\Exceptions\ControllerActionReturnTypeException;
use Core\Controller\Exceptions\ControllerNotExistException;
use Core\Http\Responses\Interfaces\Response;
use Core\Route\{DefaultRouter, Router};
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
        $this->container = $builder->build(); // TODO compile cache
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
     * Dispatch action by route
     * @throws \ReflectionException
     * @throws ControllerNotExistException
     * @throws ControllerActionReturnTypeException
     */
    public function dispatchAction()
    {
        $this->setInvokedControllerToContainer();
        $router = $this->container->get(Router::class);
        $route = $router->requestedRoute();
        $action = $route->getAction();
        $controller = $this->container->get(BaseController::class);
        $ref = new \ReflectionMethod($controller, $action);

        $params = [];

        foreach ($ref->getParameters() as $param) {
            $params[] = $this->container->get($param->getType()->getName());
        };

        $response = call_user_func_array([$controller, $action], $params);
        if(!($response instanceof Response)) throw  new ControllerActionReturnTypeException();


        $this->createAndSendBasicResponse($response);
    }

    private function createAndSendBasicResponse(Response $response){
        $basicResponse = $this->factory->createResponse();
        $responseBody = $this->factory->createStream($response->getBody());
        $basicResponse = $basicResponse->withBody($responseBody);

        foreach ($response->getHeaders() ?? [] as $name => $value) {
            $basicResponse = $basicResponse->withHeader($name, $value);
        }

        $basicResponse = $basicResponse->withStatus($response->getStatus() ?? 200);
        (new \Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($basicResponse);
    }

    /**
     * Set controller in DI container
     * @throws ControllerNotExistException
     */
    private function setInvokedControllerToContainer()
    {
        $router = $this->container->get(Router::class);
        $route = $router->requestedRoute();
        $controller = $route->getController();
        if(!class_exists($controller)) throw new ControllerNotExistException();
        $this->container->set(BaseController::class, \DI\autowire($controller));
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
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
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

}