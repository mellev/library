<?php

namespace Library;

class Route
{
    private $name;

    private $handler;

    private $segments;

    public function __construct($name, array $handler, $template)
    {
        $this->handler = $handler;
        $this->name = $name;
        $this->segments = $this->parseTemplate($template);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function check($url)
    {
        $urlSegments = $this->parseTemplate($url);

        $match = true;

        if (count($urlSegments) == $this->getSegmentsCount()) {
            foreach ($this->segments as $i => $segment) {
                if (! $this->checkIsParam($segment) && $segment != $urlSegments[$i]) {
                    $match = false;
                    break;
                }
            }
        } else {
            $match = false;
        }

        return $match;
    }

    public function getParamsValuesFromUrl($url)
    {
        $urlSegments = $this->parseTemplate($url);

        $values = [];

        foreach ($this->segments as $i => $segment) {
            if ($this->checkIsParam($segment)) {
                if (array_key_exists($i, $urlSegments)) {
                    $values[substr($segment, 1)] = $urlSegments[$i];
                }
            }
        }

        return $values;
    }

    public function getSegmentsCount()
    {
        return count($this->segments);
    }

    public function generateUrl($params)
    {
        $url = '/';

        foreach ($this->segments as $i => $segment) {
            if (strlen($segment) == 0) {
                continue;
            }

            $url .= (($i == 1) ? '' : '/') . ($this->checkIsParam($segment) ? $params[substr($segment, 1)] : $segment);
        }

        return $url;
    }

    private function parseTemplate($template)
    {
        return explode('/', $template);
    }

    private function checkIsParam($segment)
    {
        return substr($segment, 0, 1 ) == ':';
    }
}