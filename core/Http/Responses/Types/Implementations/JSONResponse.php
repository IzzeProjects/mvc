<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types\Implementations;

use Core\Http\Responses\Response;
use Core\Http\Responses\Types\Interfaces\JSON;
use Core\Http\Responses\Types\Implementations\Response as BaseResponse;

class JSONResponse extends BaseResponse implements JSON
{

    /**
     * @param array $data
     * @return Response
     */
    public function setBody(array $data): Response
    {
        $responseBody = $this->factory->createStream(json_encode($data, JSON_PRETTY_PRINT));
        $this->response = $this->response->withBody($responseBody);
        return $this;
    }

}