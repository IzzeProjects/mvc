<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types;

use Core\Http\Responses\Facade;
use Core\Http\Responses\Response;
use Core\Http\Responses\Types\Interfaces\{JSON, Simple, XML};
use Core\View\ViewResolver;

class ResponseFacade implements Facade
{

    /**
     * @var JSON
     */
    private $jsonResponse;

    /**
     * @var Simple
     */
    private $simpleResponse;

    /**
     * @var ViewResolver
     */
    private $viewResolver;

    /**
     * @var XML
     */
    private $xmlResponse;

    /**
     * @param JSON $jsonResponse
     * @param Simple $simpleResponse
     * @param ViewResolver $viewResolver
     * @param XML $xmlResponse
     */
    public function __construct(
        JSON $jsonResponse,
        Simple $simpleResponse,
        ViewResolver $viewResolver,
        XML $xmlResponse
    )
    {
        $this->jsonResponse = $jsonResponse;
        $this->simpleResponse = $simpleResponse;
        $this->viewResolver = $viewResolver;
        $this->xmlResponse = $xmlResponse;
    }

    /**
     * @param array $data
     * @return Response
     */
    public function json(array $data = []): Response
    {
        $this->jsonResponse->setHeader('Content-Type', 'application/json');
        $this->jsonResponse->setBody($data);
        return $this->jsonResponse;
    }

    /**
     * @param string $data
     * @return Response
     */
    public function xml(string $data): Response
    {
        $this->xmlResponse->setHeader('Content-Type', 'text/xml; charset=UTF-8');
        $this->xmlResponse->setBody($data);
        return $this->xmlResponse;
    }

    /**
     * @param string $data
     * @return Response
     */
    public function simple(string $data): Response
    {
        $this->simpleResponse->setBody($data);
        return $this->simpleResponse;
    }

}