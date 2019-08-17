<?php
declare(strict_types=1);

namespace Core\Http\Responses;

use Nyholm\Psr7\Factory\Psr17Factory;

interface Response
{
    public function __construct(Psr17Factory $factory);

    public function send(): self;

    public function setHeader(string $name, string $value): self;

    public function setStatus(int $status): self;
}