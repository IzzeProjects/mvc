<?php
declare(strict_types=1);

namespace Core\Http;

interface Response
{
    public function write(): string;
}