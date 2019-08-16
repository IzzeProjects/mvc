<?php
declare(strict_types=1);

namespace Core\DI\Dependencies;

use Core\DI\Dependency;
use Core\Http\Responses\Facade;
use Core\Http\Responses\Types\Implementations\JSONResponse;
use Core\Http\Responses\Types\Interfaces\JSON;
use Core\Http\Responses\Types\ResponseFacade;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class Responses implements Dependency
{

    public function set(ContainerInterface $container)
    {
        $this->types($container);
        $container->set(Facade::class, \DI\autowire(ResponseFacade::class));
    }

    private function types(ContainerInterface $container)
    {
        $container->set(JSON::class, \DI\autowire(JSONResponse::class));
    }

}