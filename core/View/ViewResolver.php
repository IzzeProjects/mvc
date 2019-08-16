<?php
declare(strict_types=1);

namespace Core\View;

interface ViewResolver
{
    public function render(): string;
    public function setData(array $data);
    public function setName(string $name);
}