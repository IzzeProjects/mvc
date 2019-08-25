<?php
declare(strict_types=1);

namespace Core\Route;

use Core\Controller\Exceptions\ControllerActionNotExistException;
use Nyholm\Psr7\Request;
use Psr\Http\Message\ServerRequestInterface;

class DefaultRouter implements Router
{

    /**
     * @var Route[]
     */
    private $routes;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $uri
     * @param string $controller
     * @param string $action
     * @return Router
     */
    public function add(string $uri, string $controller, string $action): Router
    {
        $uri = trim($uri, '/');
        $this->routes[$uri] = new Route($uri, $controller, $action);
        return $this;
    }

    /**
     * @return Route
     * @throws ControllerActionNotExistException
     */
    public function requestedRoute(): Route
    {
        $path = $this->request->getUri()->getPath();
        $this->routes[trim($path, '/')];
        $route = $this->routes[trim($path, '/')];
        if(is_null($route)) throw new ControllerActionNotExistException();
        return $this->routes[trim($path, '/')];
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

}