<?php

namespace Pages\Home;

use \Config;

class Controller extends \Pages\Abstractions\Page
{
    public $templates = [
        'default' => 'home/index',
        'poster' => 'home/poster',
    ];

    public function __construct() { parent::__construct(); }

    public function index($data)
    {
        $composers = \Pages\Composer\Model::selectAll();

//        $verdi = [];
//        $mozart = [];
//
//        foreach ($composers as $k => $composer){
//            if($composer['id'] == 132){
//                $verdi = $composer;
//                unset($composers[$k]);
//            }
//            if($composer['id'] == 39){
//                $mozart = $composer;
//                unset($composers[$k]);
//            }
//        }

        $content = [
            'body' => [
                'composers' => $composers,
//                'verdi' => $verdi,
//                'mozart' => $mozart,
                'countries' => \Pages\Country\Model::selectAll(),
                'genres'    => \Pages\Genre\Model::selectAll(),
            ]
        ];
        return self::fullTemplate($this->templates['default'], $content);
    }

    public function poster()
    {
        error_log('this is poster page'.PHP_EOL, 3, Config::$errorLog);
        //TODO:
        //забрать данные по афише
        //сформировать массив данных и отдать его
        $content = [
            'body' => [
                'test' => ['test'],
                'countries' => \Pages\Country\Model::selectAll(),
                'genres' => \Pages\Genre\Model::selectAll(),
            ],
        ];
        return self::fullTemplate($this->templates['poster'], $content);
    }
}