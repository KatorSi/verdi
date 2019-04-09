<?php

namespace Pages\Dashboard\Genre;

use Controller\Routing\Abstractions\Response;
use Pages\Genre\Model;

class Controller extends \Pages\Abstractions\Dashboard
{
    public static $templates = [
        'default' => 'dashboard/genre/index'
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

    public function select() {
        return Model::selectAll();
    }
    public function create($data) {
        if(!empty($data['title']) && $res = Model::createGenre($data['title']))
        {
            return [
                'message' => parent::template(self::$templates['default'], $res),
                'status' => 'Сохранеие нового жанра прошло успешно',
                'error' => null
            ];
        } else {
            return [
                'status' => 'Не удалось сохранить новый жанр',
                'error' => 'Ошибка сохранения нового жанра в базе данных'
            ];
        }
    }
    public function delete($data) {
        if(!empty($data['id']))
            $response =  Model::removeGenre($data['id']);
        if($response) {
            return [
                'error' => null
            ];
        } else {
            return [
                'error' => true,
                'status' => 'Ошибка удаления жанра в базе даннных'
            ];
        }
        return false;
    }
}