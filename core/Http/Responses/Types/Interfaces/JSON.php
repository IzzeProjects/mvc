<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types\Interfaces;

use Core\Http\Responses\Response;

interface JSON extends Response
{
    public function setData(array $data);
}