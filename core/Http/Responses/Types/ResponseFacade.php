<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types;

use Core\Http\Responses\Facade;


use Core\Http\Responses\Types\Interfaces\JSON;
use Core\Http\Responses\Types\Interfaces\Simple;

class ResponseFacade implements Facade
{

    /**
     * @var JSON
     */
    private $jsonResponse;

    /**
     * @var JSON
     */
    private $simpleResponse;

    /**
     * @param JSON $jsonResponse
     * @param Simple $simpleResponse
     */
    public function __construct(JSON $jsonResponse, Simple $simpleResponse)
    {
        $this->jsonResponse = $jsonResponse;
        $this->simpleResponse = $simpleResponse;
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

    public function view()
    {
        // TODO: Implement view() method.
    }

    public function simple(string $data)
    {
        $this->simpleResponse->setData($data);
        return $this->simpleResponse->write(); // TODO type hint
    }
}