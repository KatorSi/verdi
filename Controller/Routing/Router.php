<?php

namespace Controller\Routing;

use Config;
use Controller\Main as Main;
use Controller\Template as Template;

class Router
{
    private $getController = false;
    private $postController = false;
    private $putController = false;

    public function __construct()
    {
        new Main;
        new Template;
        $this->getController = new GetController;
        $this->postController = new PostController;
        $this->putController = new PutController;
    }

    private function getRouteForController($controller)
    {
        return isset(\Config::$routes[$controller]) && !empty(\Config::$routes[$controller]) ?
            \Config::$routes[$controller] :
            false;
    }

    public function dispatchURI()
    {
        $routeData = $this->getRouteData($_GET);
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->getController->getResponse($routeData);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $routeData['data'] = $_POST;
            $this->postController->getResponse($routeData);
        } elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $this->putController->getResponse($routeData);
        }
        return null;
    }

    private function getRouteData($request)
    {
        if (empty($request['route'])) {
            return ['controller' => \Config::$defaultRouteController, 'method' => \Config::$defaultRouteMethod];
        }
        $routeArray = explode('/', $request['route']);


        $controller = '';
        foreach ($routeArray as $part) {
            if (!is_numeric($part)) {
                $controller = ucfirst(strtolower($part));
                //error_log('Controller: '.$controller.PHP_EOL, 3, Config::$errorLog);
                break;
            }
        }

        $routeMatches = $this->getRouteForController($controller);

        if (false !== $routeMatches) {

            $routeData = [];

            foreach ($routeMatches as $routePattern => $method) {

                $routePattern = preg_replace('/\/$/', '', $routePattern);
                $request['route'] = preg_replace('/\/$/', '', mb_strtolower($request['route'])) . '/';

                preg_match_all('/<(' . implode('|', array_keys(\Config::$patterns)) . '):(.*?)>/', $routePattern, $matches);
                $routePattern = str_replace(['/'], ['\/'], $routePattern);
                if (sizeof($matches[1]) > 0) {
                    foreach ($matches[1] as $k => $match) {
                        $routePattern = str_replace('<' . $match . ':' . $matches[2][$k] . '>', '(?P<' . $matches[2][$k] . '>' . \Config::$patterns[$match] . ')', $routePattern);
                    }
                }

                $routePattern .= '(\/$|$)';

                if (preg_match('/^' . $routePattern . '/ui', $request['route'], $data)) {

                    $controllerKey = array_search('c', $matches[1]);
                    $newController = (false !== $controllerKey) ?
                        ucfirst(strtolower($data[$matches[2][$controllerKey]])) : '';

                    $methodKey = array_search('m', $matches[1]);

                    $data = sizeof($matches[2]) > 0 ? array_intersect_key($data, array_flip($matches[2])) : [];
                    $routeData['controller'] = (!empty($newController) && $newController !== $controller)
                        ? $controller . '/' . $newController
                        : $controller;

                    $routeData['method'] = (false !== $methodKey)
                        ? $data[$matches[2][$methodKey]]
                        : (!empty($method)
                            ? $method
                            : \Config::$defaultRouteMethod);

                    unset($data['controller']);
                    unset($data['method']);

                    $routeData['data'] = array_merge($request, $data);
                    unset($routeData['data']['route']);
                }
            }
            foreach ($routeData as $key => $value) {
                error_log('routeData: '.$key.' => '.$value.PHP_EOL, 3, Config::$errorLog);
            }
            return !empty($routeData) ? $routeData : false;
        }
        error_log('return false(',3, Config::$errorLog);
        return false;
    }
}