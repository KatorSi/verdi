<?php

namespace Pages\Composer;

class Get extends \Pages\Abstractions\Page
{
    public $templates = [
        'default' => 'composer/biography',
    ];

    public function __construct() { parent::__construct(); }

    public function response($data)
    {

        preg_match('/(?P<id>[0-9]*)(\/|)$/', $data['route'], $matches);

        if (!empty($matches['id'])) {
//            $content = [
//                'body' => [
//                    'composers' => \Pages\Dashboard\Composer\Model::selectAll(),
//                    'countries' => \Pages\Dashboard\Country\Model::selectAll(),
//                    'genres'    => \Pages\Dashboard\Genre\Model::selectAll(),
//                ]
//            ];

            return self::fullTemplate($this->templates['default'], ['body' => '1234']);
        }
        else{
            return parent::notFound(true);
        }

    }
}