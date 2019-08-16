<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types;

use Core\Http\Responses\Facade;
use Core\Http\Responses\Types\Interfaces\{JSON, Simple};
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
     * @param JSON $jsonResponse
     * @param Simple $simpleResponse
     * @param ViewResolver $viewResolver
     */
    public function __construct(JSON $jsonResponse, Simple $simpleResponse, ViewResolver $viewResolver)
    {
        $this->jsonResponse = $jsonResponse;
        $this->simpleResponse = $simpleResponse;
        $this->viewResolver = $viewResolver;
    }

    public function json(array $data = [])
    {
        $this->jsonResponse->setData($data);
        return $this->jsonResponse->write(); // TODO type hint
    }

    public function xml()
    {
        // TODO: Implement xml() method.
    }

    public function simple(string $data)
    {
        $this->simpleResponse->setData($data);
        return $this->simpleResponse->write(); // TODO type hint
    }
}