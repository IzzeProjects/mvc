<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types;

use Core\Http\Responses\Facade;
use Core\Http\Responses\Types\Interfaces\JSON;

class ResponseFacade implements Facade
{

    /**
     * @var JSON
     */
    private $jsonResponse;

    /**
     * @param JSON $jsonResponse
     */
    public function __construct(JSON $jsonResponse)
    {
        $this->jsonResponse = $jsonResponse;
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
}