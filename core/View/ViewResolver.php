<?php
declare(strict_types=1);

namespace Core\View;

use Core\Http\Response\Interfaces\Response;

interface ViewResolver
{
    public function render(): string;

    public function setData(array $data): self;

    public function setName(string $name): self;

    public function setCustomResponse(Response $response): self;
}