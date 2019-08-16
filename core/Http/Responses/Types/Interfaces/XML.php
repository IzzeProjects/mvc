<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types\Interfaces;

use Core\Http\Responses\Response;

interface XML extends Response
{
    public function setData(string $data);
}