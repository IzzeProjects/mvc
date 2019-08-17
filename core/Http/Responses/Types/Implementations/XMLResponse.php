<?php
declare(strict_types=1);

namespace Core\Http\Responses\Types\Implementations;

use Core\Http\Responses\Response;
use Core\Http\Responses\Types\Interfaces\XML;
use Core\Http\Responses\Types\Implementations\Response as BaseResponse;

class XMLResponse extends BaseResponse implements XML
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