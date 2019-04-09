<?php
/**
 * Created by PhpStorm.
 * User: iis
 * Date: 03.12.2018
 * Time: 16:25
 */

namespace Pages\Dashboard\Librettist;

use Controller\Routing\Abstractions\Response;
use Pages\Librettist\Model;

class Controller extends \Pages\Abstractions\Dashboard
{
    public static $templates = [
        'default' => 'dashboard/librettist/index'
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
        $res = Model::create($data);

        if (true === $res['status']) {
            return [
                'message' => 'Либреттист добавлен',
                'error'   => null,
                'status'  => true
            ];
        } else {
            return [
                'error'  => $res['error'],
                'status' => false
            ];
        }
    }

    public function delete($data)
    {
        $response = false;
        if (!empty($data['id'])) {
            $response = Model::remove($data['id']);
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