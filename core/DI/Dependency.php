<?php
declare(strict_types=1);

namespace Core\DI;

use Psr\Container\ContainerInterface;

interface Dependency // TODO pattern || name replace
{
    public function set(ContainerInterface $container);
}