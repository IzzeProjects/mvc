<?php
declare(strict_types=1);

namespace Core\View\Types;

use Core\Http\Responses\Interfaces\Response;
use Core\View\ViewResolver;

class TwigView implements ViewResolver
{

    const VIEWS_PATH = __DIR__ . '/../../../src/views/';

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Response
     */
    private $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
        $this->init();
    }

    /**
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render(): string
    {
        return $this->twig->render($this->name . '.twig', $this->data);
    }

    /**
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function send(): Response
    {
        $this->response->setBody($this->render());
        return $this->response;
    }

    protected function init()
    {
        $loader = new \Twig_Loader_Filesystem(self::VIEWS_PATH);
        $this->twig = new \Twig_Environment($loader, [
            'cache' => __DIR__.'/../../../storage/cache/twig',
        ]);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

}