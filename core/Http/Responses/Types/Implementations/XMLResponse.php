<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types\Implementations;

use Core\Http\Responses\Response;
use Nyholm\Psr7\Factory\Psr17Factory;
use Core\Http\Responses\Types\Interfaces\XML;

class XMLResponse implements XML
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
    public function write(): Response
    {
        $responseBody = $this->factory->createStream($this->data);
        $response = $this->factory
            ->createResponse(200)
            ->withBody($responseBody)
            ->withHeader('Content-type', 'text/xml');
        (new \Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data)
    {
        $this->data = $data;
    }

}