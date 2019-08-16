<?php
declare(strict_types=1);

namespace Core\DI\Dependencies;

use Core\DI\Dependency;
use Core\Http\Responses\Facade;
use Psr\Container\ContainerInterface;
use Core\Http\Responses\Types\ResponseFacade;
use Core\Http\Responses\Types\Interfaces\{JSON, Simple, XML};
use Core\Http\Responses\Types\Implementations\{JSONResponse, SimpleResponse, XMLResponse};

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
        $container->set(Simple::class, \DI\autowire(SimpleResponse::class));
        $container->set(XML::class, \DI\autowire(XMLResponse::class));
    }

}