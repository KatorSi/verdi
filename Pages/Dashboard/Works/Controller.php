<?php
namespace Pages\Dashboard\Works;

use Pages\Works\Model;

class Controller extends \Pages\Abstractions\Dashboard
{

    public static $templates = [
        'default'   => 'dashboard/works/index',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function response($data) { }

    public static function index($data)
    {
        $id = isset($data['additId']) ? $data['additId'] : 0;
        return Model::selectAllById($id);
    }

    public static function create($data)
    {
        if ($res = Model::createWork($data)) {
            return [
                'message' => null,
                'error'   => null,
                'status'  => 'Элемент сохранен'
            ];
        }
        return [
            'message' => null,
            'status'  => 'Ошибка сохранения',
            'error'   => 'Ошибка записи в БД'
        ];
    }
}