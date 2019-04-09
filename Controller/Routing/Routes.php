<?php


namespace Controller\Routing;


class Routes
{
    public static $patterns = [
        'i' => '(\d+?)',
        's' => '([^\/]+?)',
        'm' => '([a-zA-Z_]+?)',
        'c' => '([a-zA-Z_]+?)',
    ];
    /**
     * @var array
     */
    private static $routes = [
        'Home' => [
            'home' => '',
        ],
        'Composer' => [
            'composer/<i:composerId>' => 'biography',
            'composer/<i:composerId>/<m:method>' => '',
            'composer/<i:composerId>/<m:method>/<i:id>' => '',
        ],
        'Dashboard' => [
            'dashboard' => '',
            'dashboard/<c:controller>' => 'viewAll',
            'dashboard/<c:controller>/<i:id>' => 'edit',
            'dashboard/<c:controller>/<m:method>' => '',
            'dashboard/<c:controller>/<i:id>/<m:method>' => '',
            'dashboard/<c:controller>/<i:id>/upload/<s:type>' => 'upload',
            'dashboard/file/remove' => 'remove',
        ],
    ];

    public static function getRouteForController($controller){
        return isset(self::$routes[$controller]) && !empty(self::$routes[$controller]) ? self::$routes[$controller] : false;
    }
}