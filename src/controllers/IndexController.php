<?php
declare(strict_types=1);

namespace Src\Controllers;

use Core\Controller\BaseController;

class IndexController extends BaseController // TODO refactor src folder
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
        return $this->response()->json(['json' => 'write some data here, for example']);
    }
}