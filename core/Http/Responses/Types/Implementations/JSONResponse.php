<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types\Implementations;

use Core\Http\Responses\Types\Interfaces\JSON;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\StreamInterface;

class JSONResponse implements JSON
{

    /**
     * @var Psr17Factory
     */
    private $factory;

    /**
     * @var StreamInterface
     */
    private $responseBody;

    /**
     * @var array
     */
    private $data;

    /**
     * @param Psr17Factory $factory
     */
    public function __construct(Psr17Factory $factory)
    {
        $this->factory = $factory;
    }

    public function write(): bool
    {
        $this->responseBody = $this->factory->createStream(json_encode($this->data, JSON_PRETTY_PRINT));
        $response = $this->factory
            ->createResponse(200)
            ->withBody($this->responseBody)
            ->withHeader('Content-type', 'application/json');
        return (new \Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

}