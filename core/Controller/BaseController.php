<?php
declare(strict_types=1);

namespace Core\Controller;

use Core\Http\Responses\Facade;
use Core\Http\Responses\Types\Interfaces\Simple;
use Core\View\ViewResolver;

abstract class BaseController
{

    /**
     * @var Facade
     */
    private $responseFacade;

    /**
     * @var ViewResolver
     */
    private $viewResolver;

    /**
     * @var Simple
     */
    private $simpleResponse;

    /**
     * BaseController constructor.
     * @param Facade $responseFacade
     * @param ViewResolver $viewResolver
     * @param Simple $simpleResponse
     */
    public function __construct(Facade $responseFacade, ViewResolver $viewResolver, Simple $simpleResponse)
    {
        $this->responseFacade = $responseFacade;
        $this->viewResolver = $viewResolver;
        $this->simpleResponse = $simpleResponse;
    }

    /**
     * @return Facade
     */
    protected function response()
    {
        return $this->responseFacade;
    }

    /**
     * @param string $name
     * @param array $data
     * @return ViewResolver
     */
    protected function view(string $name, array $data = [])
    {
        $this->viewResolver->setName($name);
        $this->viewResolver->setData($data);
        $this->simpleResponse->setData($this->viewResolver->render());
        $this->simpleResponse->write();
        return $this->viewResolver;
    }

}