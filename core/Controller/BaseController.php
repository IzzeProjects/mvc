<?php
declare(strict_types=1);

namespace Core\Controller;

use Core\Http\Response\Interfaces\Facade as ResponseFacade;
use Core\Http\Response\Interfaces\Response;
use Core\View\ViewResolver;

abstract class BaseController
{

    /**
     * @var ResponseFacade
     */
    private $responseFacade;

    /**
     * @var ViewResolver
     */
    private $viewResolver;

    /**
     * @param ResponseFacade $responseFacade
     * @param ViewResolver $viewResolver
     */
    public function __construct(ResponseFacade $responseFacade, ViewResolver $viewResolver)
    {
        $this->responseFacade = $responseFacade;
        $this->viewResolver = $viewResolver;
    }

    /**
     * @return ResponseFacade
     */
    protected function response()
    {
        return $this->responseFacade;
    }

    /**
     * @param string $name
     * @param array $data
     * @param Response|null $customResponse
     * @return Response
     */
    protected function view(string $name, array $data = [], Response $customResponse = null)
    {
        $this->viewResolver->setName($name);
        $this->viewResolver->setData($data);
        if(isset($customResponse)) $this->viewResolver->setCustomResponse($customResponse);
        return $this->responseFacade->simple($this->viewResolver->render());
    }

}