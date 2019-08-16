<?php
declare(strict_types=1);

namespace Core\Http\Responses;

interface Response
{
    public function write(): bool;
}