<?php
declare(strict_types=1);

namespace Src\App\Dependencies;

use Core\DI\Dependency;
use Psr\Container\ContainerInterface;
use Src\App\Services\UserService;

class Services implements Dependency
{

    public function set(ContainerInterface $container)
    {
        $container->set([UserService::class => \DI\autowire(UserService::class)]);
    }

}