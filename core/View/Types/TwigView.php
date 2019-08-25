<?php
declare(strict_types=1);

namespace Core\View\Types;

use Core\Http\Response\Interfaces\Response;
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
        return $this->twig->render($this->name . '.twig', $this->data ?? []);
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
     * @return ViewResolver
     */
    public function setData(array $data): ViewResolver
    {
        $this->data = $data;
        return $this;
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
     * @return ViewResolver
     */
    public function setName(string $name): ViewResolver
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param Response $response
     * @return ViewResolver
     */
    public function setCustomResponse(Response $response): ViewResolver
    {
        $this->response = $response;
        return $this;
    }

}