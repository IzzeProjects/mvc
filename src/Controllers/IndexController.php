<?php
declare(strict_types=1);

namespace Src\Controllers;

use Core\Controller\BaseController;
use Core\Http\Responses\Response;
use Core\View\ViewResolver;

class IndexController extends BaseController // TODO refactor src folder
{

    public function simple(): Response
    {
        return $this->response()->simple('simple text route check');
    }

    public function json(): Response
    {
        return $this->response()->json(
            [
                'json' => 'json route check',
                'some' => 'json'
            ]
        );
    }

    public function index(): Response
    {
        return $this->response()->simple('This is main route :)');
    }

    public function viewAction(): ViewResolver
    {
        return $this->view('index', [
            'h1' => 'Some title here :)',
            'items' => [
                'Twig loop 1',
                'Twig loop 2'
            ]
        ]);
    }

}