<?php
declare(strict_types=1);

namespace Core\Route;

use Core\Controller\BaseController;
use Core\Controller\Exceptions\{ControllerActionReturnTypeException, ControllerNotExistException};
use Core\Http\Response\Interfaces\Response;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class DispatchAction
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     * @throws ControllerActionReturnTypeException
     * @throws ControllerNotExistException
     * @throws \ReflectionException
     */
    public function dispatch(ContainerInterface $container)
    {
        $this->container = $container;

        $this->setInvokedControllerToContainer();

        $route = $this->getRequestedRoute();

        $parameters = $this->getAutowiredParametersForAction($route);

        $response = call_user_func_array([
            $container->get(BaseController::class),
            $route->getAction()], $parameters);

        if (!($response instanceof Response)) throw new ControllerActionReturnTypeException();

        $basicResponse = $this->createBasicResponse($response);

        $this->writeBasicResponse($basicResponse);
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
        if (!class_exists($controller)) throw new ControllerNotExistException();
        $this->container->set(BaseController::class, \DI\autowire($controller));
    }

    /**
     * @return Route
     */
    private function getRequestedRoute(): Route
    {
        $router = $this->container->get(Router::class);
        $route = $router->requestedRoute();
        return $route;
    }

    /**
     * @param Route $route
     * @return array
     * @throws \ReflectionException
     */
    private function getAutowiredParametersForAction(Route $route): array
    {
        $ref = new \ReflectionMethod($route->getController(), $route->getAction());
        $parameters = [];
        foreach ($ref->getParameters() as $param) {
            $parameters[] = $this->container->get($param->getType()->getName());
        };
        return $parameters;
    }

    /**
     * @param Response $response
     * @return ResponseInterface
     */
    private function createBasicResponse(Response $response): ResponseInterface
    {
        $factory = $this->container->get(Psr17Factory::class);
        $basicResponse = $factory->createResponse();
        $responseBody = $factory->createStream($response->getBody());
        $basicResponse = $basicResponse->withBody($responseBody);
        foreach ($response->getHeaders() ?? [] as $name => $value) {
            $basicResponse = $basicResponse->withHeader($name, $value);
        }
        return $basicResponse->withStatus($response->getStatus() ?? 200);
    }

    /**
     * @param ResponseInterface $basicResponse
     */
    private function writeBasicResponse(ResponseInterface $basicResponse)
    {
        (new \Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($basicResponse);
    }

}