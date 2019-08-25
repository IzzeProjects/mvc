<?php
declare(strict_types=1);

namespace Src\App\Controllers;

use Core\Controller\BaseController;
use Core\Http\Response\Interfaces\Response;
use Core\View\ViewResolver;
use Src\App\Models\Repository\User\UserRepository;
use Src\App\Models\User;
use Src\App\Services\UserModelService;

class IndexController extends BaseController
{

    /**
     * @return Response
     */
    public function simple(): Response
    {
        return $this
            ->response()
            ->simple('simple text route check');
    }

    /**
     * @return Response
     */
    public function json(): Response
    {
        return $this
            ->response()
            ->json(['json' => 'json route check','some' => 'json']);
    }

    /**
     * @param ViewResolver $view
     * @return Response
     */
    public function xml(ViewResolver $view): Response
    {
        $content = $view->setName('xml')->render();
        var_dump($content);
        $content = $this->view('xml')->render();
        return $this
            ->response()
            ->xml($content);
    }

    /**
     * @param UserRepository $repository
     * @return Response
     */
    public function index(UserRepository $repository): Response
    {

        $repository->get(123);
        return $this->response()
            ->simple('This is main route :)')
            ->setStatus(405);
    }

    public function test(UserRepository $repository)
    {
        return 123;
    }

    /**
     * @param Response $response
     * @return Response
     */
    public function viewAction(Response $response): Response
    {
        $response->setStatus(401);
        $response->addHeader('check', 'RRR');
        $response->addHeader('check', 'RRR');

        return $this->view('index', [
            'h1' => 'Some title here :)',
            'items' => [
                'Twig loop 1',
                'Twig loop 2'
            ]
        ], $response);
    }

    /**
     * @param UserModelService $userService
     * @return Response
     * @throws \Exception
     */
    public function model(UserModelService $userService): Response
    {
        $user = new User(10,
            'Username',
            password_hash('fdfgsd43534543dfg',
                PASSWORD_BCRYPT),
            new \DateTime('now')
        );
        $userService->setModel($user);
        return $this
            ->response()
            ->simple($userService->formatDate());
    }

}