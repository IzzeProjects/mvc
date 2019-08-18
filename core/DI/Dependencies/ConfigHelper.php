<?php
declare(strict_types=1);

namespace Core\DI\Dependencies;

use Core\DI\Dependency;
use Psr\Container\ContainerInterface;

class ConfigHelper implements Dependency
{

    public function set(ContainerInterface $container)
    {
        $container->set(
            \Core\Services\Config::class,
            \DI\autowire(\Core\Services\Config::class)
        );
    }

}