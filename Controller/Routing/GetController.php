<?php

namespace Controller\Routing;

use Config;
use Controller\Template as Template;

class GetController extends Abstractions\Response
{
    public function getResponse($routeData)
    {
        if ($instance = $this->match($routeData['controller'])) {
            if (method_exists($instance, $routeData['method'])) {
                echo $instance->{$routeData['method']}($routeData['data']);
                return;
            }
        }

        http_response_code(404);
        echo Template::notFound(true);

        return;
    }
}