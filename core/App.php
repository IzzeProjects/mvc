<?php
declare(strict_types=1);

namespace Core;

use Core\DI\ContainerInit;
use Core\Http\Request\RequestInit;
use Core\Route\DispatchAction;
use Nyholm\Psr7\Factory\Psr17Factory;
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

    public function __construct()
    {
        $this->factory = new Psr17Factory();
    }

    /**
     * @throws \Exception
     */
    public function initApp()
    {
        $this->serverRequest = (new RequestInit)->init($this->factory);
        $this->container = (new ContainerInit())->init([
            Psr17Factory::class => $this->factory,
            ServerRequestInterface::class => $this->serverRequest
        ]);
        (new DispatchAction())->dispatch($this->container);
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

}