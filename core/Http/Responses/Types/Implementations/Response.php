<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types\Implementations;

use Core\Http\Responses\Response as ResponseInterface;
use Nyholm\Psr7\Factory\Psr17Factory;

abstract class Response implements ResponseInterface
{

    /**
     * @var Psr17Factory
     */
    protected $factory;

    /**
     * @var \Nyholm\Psr7\Response
     */
    protected $response;

    /**
     * Response constructor.
     * @param Psr17Factory $factory
     */
    public function __construct(Psr17Factory $factory)
    {
        $this->factory = $factory;
        $this->response = $factory->createResponse();
    }

    /**
     * @return ResponseInterface
     */
    public function send(): ResponseInterface
    {
        (new \Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($this->response);
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return ResponseInterface
     */
    public function setHeader(string $name, string $value): ResponseInterface
    {
        $this->response = $this->response->withHeader($name, $value);
        return $this;
    }

    /**
     * @param int $status
     * @return ResponseInterface
     */
    public function setStatus(int $status): ResponseInterface
    {
        $this->response = $this->response->withStatus($status);
        return $this;
    }

}