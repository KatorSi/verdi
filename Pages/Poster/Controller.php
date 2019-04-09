<?php
/**
 * Created by PhpStorm.
 * User: iis
 * Date: 21.11.2018
 * Time: 12:13
 */

namespace Pages\Poster;


class Controller extends \Pages\Abstractions\Page
{
    private $templates = [
        'default'       => 'poster/index',
        'test'          => 'poster/test',
    ];

    public function __construct() { parent::__construct(); }

    public $assets = [
        'scripts' => [

        ],
        'styles'  => [
            //'css/bootstrap-components/css/bootstrap.min.css'
        ]
    ];

    public function response($data)
    {
        error_log('response 404', 3, \Config::$errorLog);
        return parent::notFound(true);
    }

    public function index()
    {
        $content = [
            'body' => [
                'composers' => \Pages\Composer\Model::selectAll(),
                'events' => \Pages\Poster\Model::selectAll(),
                'back' => ''
            ],
        ];
        return self::fullTemplate($this->templates['default'], $content, $this->assets);
    }

    public function test()
    {
        $content = [
            'body' => [
                'test' => 'test'
            ]
        ];

        return self::fullTemplate($this->templates['test'], $content);
    }
}