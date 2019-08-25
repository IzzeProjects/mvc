<?php
declare(strict_types=1);

namespace Core\Http\Response\Interfaces;

interface Response
{
    public function addHeader(string $name, string $value): self;

    public function setStatus(int $status): self;

    public function getStatus(): ?int;

    public function getHeaders(): ?array;

    public function setBody(string $body): self;

    public function getBody(): string;
}