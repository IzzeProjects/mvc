<?php
declare(strict_types=1);

namespace Core\Route;

class Route
{

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    /**
     * Route constructor.
     * @param string $uri
     * @param string $controller
     * @param string $action
     */
    public function __construct(string $uri, string $controller, string $action)
    {
        $this->uri = $uri;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

}