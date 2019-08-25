<?php
declare(strict_types=1);

namespace Core\DI\Dependencies;

use Core\DI\Dependency;
use Core\Http\Responses\Interfaces\{Facade, Response};
use Core\Http\Responses\ResponseFacade;
use Psr\Container\ContainerInterface;
use Core\Http\Responses\Response as HttpResponse;

class Responses implements Dependency
{

    public function set(ContainerInterface $container)
    {
        $container->set(Response::class, \DI\autowire(HttpResponse::class));
        $container->set(Facade::class, \DI\autowire(ResponseFacade::class));
    }

}