<?php
declare(strict_types=1);

namespace Core\DI\Dependencies;

use Core\DI\Dependency;
use Core\Services\Config;
use Psr\Container\ContainerInterface;

class Databases implements Dependency
{

    public function set(ContainerInterface $container)
    {
        $config = $container->get(Config::class);

        $container->set('mysql', function () use ($config) {
            $mysql = $config->get('databases')['mysql'];
            return new \mysqli(
                $mysql['host'],
                $mysql['user'],
                $mysql['password'],
                $mysql['database']
            );
        });
    }

}