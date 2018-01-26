<?php

namespace Library;

class Di
{
    private static $staticContainer;

    private $services = [];

    private $createdServices = [];

    public function registerService($name, callable $service)
    {
        $this->services[$name] = $service;
    }

    public function getService($name)
    {
        if (array_key_exists($name, $this->createdServices)) {
            return $this->createdServices[$name];
        } else if (array_key_exists($name, $this->services)) {
            $service = call_user_func($this->services[$name]);
            $this->createdServices[$name] = $service;

            return $service;
        }
    }

    /**
     * @return Di
     */
    public static function getStaticContainer()
    {
        return self::$staticContainer;
    }

    public static function setStaticContainer(Di $staticContainer)
    {
        self::$staticContainer = $staticContainer;
    }
}