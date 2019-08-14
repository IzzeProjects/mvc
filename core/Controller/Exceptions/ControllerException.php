<?php
declare(strict_types=1);

namespace Core\Controller\Exceptions;

use Exception;

abstract class ControllerException extends Exception
{

    protected $message = 'Controller exception';

    public function __construct()
    {
        http_response_code(500);
        parent::__construct($this->message, 500, null);
    }
}