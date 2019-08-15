<?php
declare(strict_types=1);

namespace Core\Route;

use Core\Controller\Controller;
use DI\Container;
use Nyholm\Psr7\Request;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class DefaultRouter implements Router
{

    /**
     * @var array
     */
    private $routes; // TODO route separate item

    /**
     * @var Request
     */
    private $request;


    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function add(string $uri, string $controller, string $action): Router
    {
        $this->routes[trim($uri, '/')] = compact('controller', 'action');

        return $this;
    }

    public function dispatchController(): Controller
    {
        $path = $this->request->getUri()->getPath();
        $destination = $this->routes[trim($path, '/')];
        $controller = (string)$destination['controller'];
        $controller = new $controller();

        return $controller;
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