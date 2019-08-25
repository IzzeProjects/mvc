<?php
declare(strict_types=1);

namespace Core\Http\Responses;

use Core\Http\Responses\Interfaces\Response as ResponseInterface;

class Response implements ResponseInterface
{

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var string
     */
    protected $body;


    /**
     * @param int $status
     * @return ResponseInterface
     */
    public function setStatus(int $status): ResponseInterface
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return ResponseInterface
     */
    public function addHeader(string $name, string $value): ResponseInterface
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    /**
     * @param string $body
     * @return ResponseInterface
     */
    public function setBody(string $body): ResponseInterface
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

}