<?php
declare(strict_types=1);

namespace Core\Http\Responses;

interface Facade
{
    public function json(array $data);
    public function xml();
    public function view();
    public function simple(string $data);
}