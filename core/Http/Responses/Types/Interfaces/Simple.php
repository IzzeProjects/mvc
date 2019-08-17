<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types\Interfaces;

use Core\Http\Responses\Response;

interface Simple extends Response
{
    public function setBody(string $data): Response;
}