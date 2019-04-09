<?php

namespace Controller\Routing\Abstractions;


use ReflectionClass;

abstract class Response
{
    public static $isPost = false;
    public static $isPut = false;


    protected function match($controller)
    {

        $basePath = __DIR__ . "/../../../Pages/{$controller}";

        if (file_exists("$basePath/Controller.php")) {
            $namespace = 'Pages\\' . preg_replace('/\//', '\\', $controller);
            try {
                $class = new ReflectionClass("$namespace\\Controller");

                return $class->newInstance();
            } catch (\ReflectionException $e) {
                return false;
            }

        }

        return false;
    }

    abstract protected function getResponse($request);
}