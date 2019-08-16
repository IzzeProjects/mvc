<?php
declare(strict_types=1);

namespace Core\DI\Dependencies;

use Core\DI\Dependency;
use Core\View\Types\TwigView;
use Core\View\ViewResolver;
use Psr\Container\ContainerInterface;

class View implements Dependency
{

    public function set(ContainerInterface $container)
    {
        $container->set(ViewResolver::class, \DI\autowire(TwigView::class));
    }

}