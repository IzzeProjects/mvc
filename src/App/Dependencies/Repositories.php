<?php
declare(strict_types=1);

namespace Src\App\Dependencies;

use Core\DI\Dependency;
use Psr\Container\ContainerInterface;
use Src\App\Models\Repository\User\UserRepository;

class Repositories implements Dependency
{

    public function set(ContainerInterface $container)
    {
        $container->set(
            UserRepository::class,
            \DI\autowire(\Src\App\Repositories\User\UserRepository::class)
        );
    }

}