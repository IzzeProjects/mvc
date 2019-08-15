<?php

namespace Src\Controllers;

use Core\Controller\Controller;
use Psr\Http\Message\ServerRequestInterface;


class IndexController implements Controller
{

    public function main()
    {
        echo '<pre>';
        echo 'main invoked';
        echo '</pre>';
        exit;
    }

    public function index()
    {

        echo '<pre>';
        echo 'index invoked';
        echo '</pre>';
        exit;
    }
}