<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types\Implementations;

use Core\Http\Responses\Response;
use Nyholm\Psr7\Factory\Psr17Factory;
use Core\Http\Responses\Types\Interfaces\Simple;

class SimpleResponse implements Simple
{
    /**
     * @var Psr17Factory
     */
    private $factory;

    /**
     * @var string
     */
    private $data;

    /**
     * @param Psr17Factory $factory
     */
    public function __construct(Psr17Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return Response
     */
    public function write(): Response // TODO Set status and headers
    {
        $responseBody = $this->factory->createStream($this->data);
        $response = $this->factory
            ->createResponse(200)
            ->withBody($responseBody);
        (new \Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
        return $this;
    }

    /**
     * @param string $data
     */
    public function setData(string $data)
    {
        $this->data = $data;
    }

}