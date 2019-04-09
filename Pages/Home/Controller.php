<?php

namespace Pages\Home;

use \Config;

class Controller extends \Pages\Abstractions\Page
{
    public $templates = [
        'default' => 'home/index',
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
}