<?php
declare(strict_types=1);

namespace Src\App\Repositories;

use Psr\Container\ContainerInterface;

trait Storage
{

    /**
     * @var \mysqli
     */
    protected $mysql;

    public function __construct(ContainerInterface $container)
    {
        $this->mysql = $container->get('mysql');
    }

}