<?php
declare(strict_types=1);

namespace Src\App\Controllers;

use Core\Controller\BaseController;
use Core\Http\Responses\Interfaces\Response;
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
     * @return Response
     */
    public function xml(): Response
    {
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
     * @return ViewResolver
     */
    public function viewAction(): Response
    {
        return $this->view('index', [
            'h1' => 'Some title here :)',
            'items' => [
                'Twig loop 1',
                'Twig loop 2'
            ]
        ])->send();
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