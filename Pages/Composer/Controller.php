<?php
/**
 * Created by PhpStorm.
 * User: iis
 * Date: 21.11.2018
 * Time: 12:13
 */

namespace Pages\Composer;


class Controller extends \Pages\Abstractions\Page
{
    private static $templates = [
        'default'      => 'composer/biography',
        'biography'    => 'composer/biography',
        'operas'       => 'composer/operas',
        'bibliography' => 'composer/bibliography',
        'films'        => 'composer/films',
        'facts'        => 'composer/facts',
        'header'       => 'composer/header',
        'header_works' => 'composer/header_works',
        'header_about' => 'composer/header_about',
        'about'        => 'composer/about',

        'singleOpera'      => 'operas/single',
        'descriptionOpera' => 'operas/description',
        'scoreOpera'       => 'operas/score',
        'clavierOpera'     => 'operas/clavier',
        'reviewsOpera'     => 'operas/reviews',
    ];

    public $assets = [
        'scripts' => [
            'js/pages/composer.js'
        ],
        'styles'  => [

        ]
    ];

    public function response($data)
    {
        return parent::notFound(true);
    }

    public function biography($data)
    {
        $composerId = intval($data['composerId']);

        if ($composerId > 0) {
            $composer = Model::selectSingle($composerId);
            $data = [
                'composer'   => $composer,
                'active'     => 'about',
                'operaTitle' => 'Биография',
            ];

            $data['header'] = parent::template(self::$templates['header'], $data);
            $data['header_about'] = parent::template(self::$templates['header_about'], $data);
            return parent::fullTemplate(self::$templates['biography'], ['body' => $data]);
        } else {
            return parent::notFound(true);
        }
    }

    public function operas($data)
    {
        $composerId = intval($data['composerId']);
        $operaId = intval($data['id']);

        if ($composerId > 0) {
            $composer = Model::selectSingle($composerId);
            $dataPage = [];
            $dataPage['composer'] = $composer;
            $dataPage['active'] = 'operas';

            if (0 === $operaId) {
                $dataPage['header'] = self::template(self::$templates['header'], $dataPage, $this->assets);
                $dataPage['header_works'] = self::template(self::$templates['header_works'], $dataPage);
                $dataPage['operas'] = \Pages\Opera\Model::selectSingleMult($composerId);

                return parent::fullTemplate(self::$templates['operas'], ['body' => $dataPage]);
            } else {
                $dataPage['opera'] = \Pages\Opera\Model::selectSingle($operaId);
                $dataPage['opera']['video'] = \Pages\Opera\Model::selectVideo($dataPage['opera']['id']);
                $dataPage['operaTitle'] = $dataPage['opera']['title'];
                $dataPage['back'] = '/composer/' . $composerId . '/operas';
                $dataPage['page'] = isset($data['page']) ? $data['page'] : '';
                $dataPage['pageTitle'] = '';

                switch($dataPage['page']){
                    case '':
                        $dataPage['pageTitle'] = 'История создания';
                        break;
                    case 'description':
                        $dataPage['pageTitle'] = 'Краткое содержание';
                        break;
                }

                $dataPage['header'] = self::template(self::$templates['header'], $dataPage, $this->assets);

                return parent::fullTemplate(isset($data['page']) && !empty($data['page']) ? self::$templates[$data['page'].'Opera'] : self::$templates['singleOpera'], ['body' => $dataPage]);
            }

        } else {
            return parent::notFound(true);
        }
    }

    public function bibliography($data)
    {
        $composerId = intval($data['composerId']);

        if ($composerId > 0) {
            $composer = Model::selectSingle($composerId);
            $data = [
                'composer' => $composer,
                'active'   => 'bibliography',
            ];

            $data['header'] = parent::template(self::$templates['header'], $data);
            $data['header_about'] = parent::template(self::$templates['header_about'], $data);
            return parent::fullTemplate(self::$templates['bibliography'], ['body' => $data]);
        } else {
            return parent::notFound(true);
        }
    }

    public function films($data)
    {
        $composerId = intval($data['composerId']);
        if ($composerId > 0) {
            $composer = Model::selectSingle($composerId);
            $data = [
                'composer' => $composer,
                'active'   => 'films',
            ];

            $data['header'] = parent::template(self::$templates['header'], $data);
            $data['header_about'] = parent::template(self::$templates['header_about'], $data);
            return parent::fullTemplate(self::$templates['films'], ['body' => $data]);
        } else {
            return parent::notFound(true);
        }
    }

    public function facts($data)
    {
        $composerId = intval($data['composerId']);

        if ($composerId > 0) {
            $composer = Model::selectSingle($composerId);
            $data = [
                'composer'   => $composer,
                'active'     => 'facts',
                'operaTitle' => 'Другие факты',
            ];

            $data['header'] = parent::template(self::$templates['header'], $data);
            return parent::fullTemplate(self::$templates['facts'], ['body' => $data]);
        } else {
            return parent::notFound(true);
        }
    }

    public function about($data) {
        $composerId = intval($data['composerId']);

        if ($composerId > 0) {
            $composer = Model::selectSingle($composerId);
            $data = [
                'composer' => $composer,
                'active' => 'about',
                ''
            ];
        }

        $data['header'] = parent::template(self::$templates['header'], $data);
        $data['header_about'] = parent::template(self::$templates['header_about'], $data);
        return parent::fullTemplate(self::$templates['about'], ['body' => $data]);
    }
}