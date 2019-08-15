<?php
declare(strict_types=1);

namespace Core\Route;

use Core\Controller\Controller;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface;

interface Router
{
    public function __construct(ServerRequestInterface $request);
    public function add(string $uri, string $controller, string $action): self;
    public function requestedController(): string ;
    public function requestedAction(): string ;
}