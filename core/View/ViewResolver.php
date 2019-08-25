<?php
declare(strict_types=1);

namespace Core\View;

use Core\Http\Responses\Interfaces\Response;

interface ViewResolver
{
    public function render(): string;

    public function send(): Response;

    public function setData(array $data);

    public function setName(string $name);
}