<?php

/**
 * Основная конфигурация
 */
class Config
{
    /** @var array Настройки базы данных */
    public static $db = [
        'db_host' => 'localhost', // имя хоста
        'db_user' => 'webadmin',  // имя пользователя
        'db_pass' => 'WebAdmin1', // пароль пользователя
        'db_name' => 'verdirf',   // база данных
    ];

    /** @var string путь корня проекта */
    public static $basePath = __DIR__;

    /** @var string имя хоста */
    public static $host = '';

    /** @var string текущая версия */
    public static $version = '0.1.7';

    /** @var string Контроллер по-умолчанию */
    public static $defaultRouteController = 'Home';

    /** @var string Метод по-умолчанию */
    public static $defaultRouteMethod = 'index';

    /** @var array Паттерны для разбора строки роутера */
    public static $patterns = [
        'i' => '(\d+?)',        // Определяет параметр как число
        's' => '([^\/]+?)',     // Определяет параметр как строку до 1 встреченного слеша
        'm' => '([a-zA-Z_]+?)', // Определяет метод
        'c' => '([a-zA-Z_]+?)', // Определяет контроллер
    ];

    /**
     * @var array Связи ссылок с контроллерами. <br>
     * Ключом основного массива определяется контроллер, <br>
     * ключом вложенного массива определяется связь контроллера с ссылкой, <br>
     * значением вложенного массива определяется метод контроллера, <br>
     * если метод не определён, то используется стандартный метод заданный в конфигурации. <br>
     * <br>
     * Динамические параметры задаются в виде <паттерн:имя_параметра>.
     *
     * @see Config::$defaultRouteMethod
     */
    public static $routes = [
        'Poster'  => [
            'composer/<i:composerId>'                   => 'biography',
            'composer/<i:composerId>/<m:method>'        => '',
            'composer/<i:composerId>/<m:method>/<i:id>' => '',
            'composer/<i:composerId>/operas/<i:id>/<s:page>' => 'operas',
        ],
        'Composer'  => [
            'composer/<i:composerId>'                   => 'biography',
            'composer/<i:composerId>/<m:method>'        => '',
            'composer/<i:composerId>/<m:method>/<i:id>' => '',
            'composer/<i:composerId>/operas/<i:id>/<s:page>' => 'operas',
        ],
        'Dashboard' => [
            'dashboard'                                       => '',
            'dashboard/<c:controller>'                        => '',
            'dashboard/<c:controller>/<i:id>'                 => 'edit',
            'dashboard/<c:controller>/<m:method>'             => '',
            'dashboard/<c:controller>/<i:id>/<m:method>'      => '',
            'dashboard/<c:controller>/<i:id>/upload/<s:type>' => 'upload',
            //'dashboard/file/remove'                           => 'remove',
        ],
        'Home' => [
            'home/<m:method>'   => '',
        ],
    ];

    /**
     * @var string Путь до лога ошибок php
     */
    public static $errorLog = __DIR__.'\error.log';
}
