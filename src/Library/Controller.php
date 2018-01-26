<?php

namespace Library;

/**
 * Базовый класс для контроллеров
 *
 * Class Controller
 * @package Library
 */
abstract class Controller
{
    use DiInjectionTrait;

    protected $viewData = [];

    protected $urlParams;

    protected $router;

    protected $method;

    protected $request;

    public function __construct($urlParams = [], Router $router, $method, $request)
    {
        $this->urlParams = $urlParams;
        $this->router = $router;
        $this->method = $method;
        $this->request = $request;
    }

    protected function renderView($viewPath, $data = [])
    {
        if (! count($data)) {
            $data = $this->viewData;
        }

        extract($data);

        ob_start();

        $viewsRoot = $this->di->getService('config')['structure']['views'];

        include $viewsRoot . $viewPath;
    }

    /**
     * @param string $url
     */
    protected function redirectToUrl($url)
    {
        header('Location: ' . $url);
    }

    /**
     * @param string $routeName
     * @param array $params
     */
    protected function redirectToRoute($routeName, $params = [])
    {
        $this->redirectToUrl(
            $this->router->generateUrl($routeName, $params)
        );
    }

    /**
     * Получение из данных запроса только необходимые параметры
     * @param string[] $names
     * @return array
     */
    protected function getRequestData(array $names) {
        return array_intersect_key($this->request, array_flip($names));
    }
}