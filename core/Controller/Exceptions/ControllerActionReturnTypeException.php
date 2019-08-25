<?php
declare(strict_types=1);

namespace Core\Controller\Exceptions;

class ControllerActionReturnTypeException extends ControllerException
{

    protected $message = 'Controller must return response instance';

}