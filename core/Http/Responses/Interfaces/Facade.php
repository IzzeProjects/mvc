<?php
declare(strict_types=1);

namespace Core\Http\Responses\Interfaces;

interface Facade
{
    public function json(array $data): Response;

    public function xml(string $data): Response;

    public function simple(string $data): Response;
}