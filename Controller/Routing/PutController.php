<?php

namespace Controller\Routing;

class PutController extends Abstractions\Response
{
    public function getResponse($routeData)
    {
        parent::$isPut = true;

        if ($instance = $this->match($routeData['controller'])) {
            if (method_exists($instance, $routeData['method'])) {
                
                echo json_encode([
                    'error'    => null,
                    'response' => $instance->{$routeData['method']}($routeData['data'])
                ]);
                return;
            }
        }


        http_response_code(404);
        echo json_encode([
            'error'    => 'Not Found',
            'response' => null
        ]);

        return;
    }
}