<?php
declare(strict_types=1);

namespace Core\Route;

use Nyholm\Psr7\Request;
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
        $this->routes[trim($uri, '/')] = compact('controller', 'action');

        return $this;
    }

    /**
     * @return string
     */
    public function requestedController(): string
    {
        $path = $this->request->getUri()->getPath();
        $destination = $this->routes[trim($path, '/')];
        return (string)$destination['controller'];
    }

    /**
     * @return string
     */
    public function requestedAction(): string
    {
        $path = $this->request->getUri()->getPath();
        $destination = $this->routes[trim($path, '/')];
        return (string)$destination['action'];
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