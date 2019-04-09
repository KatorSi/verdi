<?php

namespace Pages\Dashboard\Country;

use Controller\Routing\Abstractions\Response;
use Pages\Country\Model;

class Controller extends \Pages\Abstractions\Dashboard
{
    public static $templates = [
        'default' => 'dashboard/country/index'
    ];
    public $scripts = [];

    public function __construct() { parent::__construct(); }



    public function index($data)
    {
        if (Response::$isPost) {
            return Model::selectAll();
        }

        return $this->buildTemplate(self::$templates['default'], Model::selectAll(), $this->scripts);
    }

    public function edit($data)
    {
        // TODO: Implement edit() method.
    }

    public function create($data)
    {
        if (!empty($data['title']) && $res = Model::createCountry($data['title'])) {
            return [
                'message' => parent::template(self::$templates['default'], $res),
                'error'   => null,
                'status'  => 'Сохранение выполнено'
            ];
        } else {
            return [
                'error'  => 'Ошибка сохранения страны в базе данных',
                'status' => 'Страна не сохранена'
            ];
        }
    }

    public function delete($data)
    {
        $response = false;
        if (!empty($data['id'])) {
            $response = Model::removeCountry($data['id']);
        }
        if ($response) {
            return [
                'error' => null
            ];
        } else {
            return [
                'error'  => true,
                'status' => 'Ошибка удаления страны в базе даннных'
            ];
        }
    }
}