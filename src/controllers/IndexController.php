<?php

namespace Src\Controllers;

use Core\Controller\Controller;
use Psr\Http\Message\ServerRequestInterface;


class IndexController implements Controller
{

    public function index()
    {

        echo '<pre>';
        echo 'index invoked';
        echo '</pre>';
        exit;
    }
}