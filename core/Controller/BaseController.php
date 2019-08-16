<?php
declare(strict_types=1);

namespace Core\Controller;

use Core\Http\Responses\Facade;

abstract class BaseController
{

    /**
     * @var Facade
     */
    protected $responseFacade;

    /**
     * BaseController constructor.
     * @param Facade $responseFacade
     */
    public function __construct(Facade $responseFacade)
    {
        $this->responseFacade = $responseFacade;
    }

    protected function response()
    {
        return $this->responseFacade;
    }

}