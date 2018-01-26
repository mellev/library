<?php

namespace Library;

class Router
{
    use DiInjectionTrait;

    private $routes = [];

    private $routesByMethod = [];

    private $notFoundHandler;

    public function handle($path, $method)
    {
        $route = $this->findRoute($path, $method);
        $handler = $route ? $route->getHandler() : $this->notFoundHandler;
        $controller = new $handler['controller']($route ? $route->getParamsValuesFromUrl($path) : [], $this, $method, $_REQUEST);
        $controller->setDi($this->di);
        $action = $handler['action'];
        return $controller->$action();
    }

    public function addRoute(array $methods = ['GET', 'POST'], $name, $template, array $handler)
    {
        $route = new Route($name, $handler, $template);
        $this->routes[] = $route;

        foreach ($methods as $method) {
            if (array_key_exists($method, $this->routesByMethod)) {
                $this->routesByMethod[$method][] = $route;
            } else {
                $this->routesByMethod[$method] = [$route];
            }
        }
    }

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    public function generateUrl($routeName, array $params)
    {
        foreach ($this->routes as $route) {
            if ($route->getName() == $routeName) {
                return $route->generateUrl($params);
            }
        }
    }

    public function setNotFoundHandler(array $handler)
    {
        $this->notFoundHandler = $handler;
    }

    private function findRoute($path, $method)
    {
        if (array_key_exists($method, $this->routesByMethod)) {
            $routes = $this->routesByMethod[$method];

            $foundRoute = null;

            foreach ($routes as $route) {
                if ($route->check($path)) {
                    if ($foundRoute == null || ($foundRoute->getSegmentsCount() <= $route->getSegmentsCount())) {
                        $foundRoute = $route;
                    }
                }
            }

            return $foundRoute;
        }
    }
}