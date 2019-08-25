<?php
declare(strict_types=1);

namespace Core\Http\Response;

use Core\Http\Response\Interfaces\{Response, Facade};
use Core\View\ViewResolver;

class ResponseFacade implements Facade
{

    /**
     * @var Response
     */
    private $response;

    /**
     * @var ViewResolver
     */
    private $viewResolver;


    /**
     * @param Response $response
     * @param ViewResolver $viewResolver
     */
    public function __construct(
        Response $response,
        ViewResolver $viewResolver
    )
    {
        $this->response = $response;
        $this->viewResolver = $viewResolver;
    }

    /**
     * @param array $data
     * @return Response
     */
    public function json(array $data = []): Response
    {
        $this->response->addHeader('Content-Type', 'application/json');
        $this->response->setBody(json_encode($data, JSON_PRETTY_PRINT));
        return $this->response;
    }

    /**
     * @param string $data
     * @return Response
     */
    public function xml(string $data): Response
    {
        $this->response->addHeader('Content-Type', 'text/xml; charset=UTF-8');
        $this->response->setBody($data);
        return $this->response;
    }

    /**
     * @param string $data
     * @return Response
     */
    public function simple(string $data): Response
    {
        $this->response->setBody($data);
        return $this->response;
    }

}