<?php
declare(strict_types=1);

namespace Core\Http\Request;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;

class RequestInit
{

    /**
     * @param Psr17Factory $factory
     * @return ServerRequestInterface
     */
    public function init(Psr17Factory $factory): ServerRequestInterface
    {
        $creator = new ServerRequestCreator(
            $factory,
            $factory,
            $factory,
            $factory
        );
        $request = $creator->fromGlobals();
        return $request;
    }

}