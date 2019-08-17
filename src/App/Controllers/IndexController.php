<?php
declare(strict_types=1);

namespace Src\App\Controllers;

use Core\Controller\BaseController;
use Core\Http\Responses\Response;
use Core\View\ViewResolver;
use Src\App\Models\User;
use Src\App\Services\UserService;

class IndexController extends BaseController
{

    /**
     * @return Response
     */
    public function simple(): Response
    {
        return $this
            ->response()
            ->simple('simple text route check')
            ->send();
    }

    /**
     * @return Response
     */
    public function json(): Response
    {
        return $this
            ->response()
            ->json(['json' => 'json route check','some' => 'json'])
            ->send();
    }

    /**
     * @return Response
     */
    public function xml(): Response
    {
        $content = $this->view('xml')->render();
        return $this
            ->response()
            ->xml($content)
            ->send();
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->response()
            ->simple('This is main route :)')
            ->send();
    }

    /**
     * @return ViewResolver
     */
    public function viewAction(): ViewResolver // TODO cache twig
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
     * @param UserService $userService
     * @return Response
     * @throws \Exception
     */
    public function model(UserService $userService): Response
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
            ->simple($userService->formatDate())
            ->send();
    }

}