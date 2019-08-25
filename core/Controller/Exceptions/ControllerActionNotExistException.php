<?php
declare(strict_types=1);

namespace Core\Controller\Exceptions;

class ControllerActionNotExistException extends ControllerException
{

    protected $message = 'Controller action has been not found';

}