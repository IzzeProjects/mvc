<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types\Implementations;

use Core\Http\Responses\Response;
use Core\Http\Responses\Types\Interfaces\Simple;
use Core\Http\Responses\Types\Implementations\Response as BaseResponse;

class SimpleResponse extends BaseResponse implements Simple
{

    /**
     * @param string $data
     * @return Response
     */
    public function setBody(string $data): Response
    {
        $responseBody = $this->factory->createStream($data);
        $this->response = $this->response->withBody($responseBody);
        return $this;
    }

}