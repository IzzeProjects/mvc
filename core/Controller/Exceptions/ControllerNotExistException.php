<?php
declare(strict_types=1);

namespace Core\Controller\Exceptions;

class ControllerNotExistException extends ControllerException
{

    protected $message = 'Controller has been not found';

}