<?php
declare(strict_types=1);

namespace Core\DI;

use Core\Route\DefaultRouter;
use Core\Route\Router;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class ContainerInit
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param array $defaultDependencies
     * @return \DI\Container
     * @throws \Exception
     */
    public function init(array $defaultDependencies)
    {
        $builder = new ContainerBuilder();
        $builder = $this->setDefaultDependencies($builder, $defaultDependencies);
        $this->container = $builder->build();// TODO compile cache
        $this->setDependencies();
        return $this->container;
    }

    /**
     * Default dependencies to start app
     * @param ContainerBuilder $builder
     * @param array $defaultDependencies
     * @return ContainerBuilder
     */
    private function setDefaultDependencies(
        ContainerBuilder &$builder,
        array $defaultDependencies
    ): ContainerBuilder
    {
        foreach ($defaultDependencies as $name => $value) {
            $builder->addDefinitions([$name => $value]);
        }
        $builder->addDefinitions([Router::class => function (ServerRequestInterface $request) {
            $router = new DefaultRouter($request);
            $routes = require_once __DIR__ . '/../../src/routes/config.php';
            $routes($router);
            return $router;
        }]);
        return $builder;
    }

    /**
     * Set dependencies
     */
    private function setDependencies()
    {
        $coreConfig = require_once __DIR__ . '/../../core/Configs/dependencies.php';
        $this->resolveDependencies($coreConfig['dependencies']);
        $clientConfig = require_once __DIR__ . '/../../src/configs/dependencies.php';
        $this->resolveDependencies($clientConfig['dependencies']);
    }

    /**
     * Resolve dependencies
     * @param array $dependencies
     */
    private function resolveDependencies(array $dependencies)
    {
        foreach ($dependencies as $dependency) {
            $dependencySetter = new $dependency();
            $dependencySetter->set($this->container);
        }
    }

}