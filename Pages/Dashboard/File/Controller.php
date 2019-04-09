<?php
/**
 * Created by PhpStorm.
 * User: iis
 * Date: 23.11.2018
 * Time: 17:49
 */

namespace Pages\Dashboard\File;


use Controller\Files;
use Controller\Routing\Abstractions\Response;
use Controller\Template;

class Controller extends Template
{

    /**
     * @param $data
     *
     * @return string|array|bool
     */
    function remove($data)
    {

        if (Response::$isPost && isset($data['id']) && intval($data['id']) > 0) {
            $file = Files::getFileById($data['id']);
            if (Files::remove($file['id'])) {

                if (Files::removeFile(\Config::$basePath . $file['path'] . $file['name'])) {
                    return [
                        'message' => 'Файл ' . $file['title'] . ' удалён.',
                        'error'   => null,
                        'status'  => true
                    ];
                }
                return [
                    'message' => null,
                    'status'  => false,
                    'error'   => 'Ошибка удаления, повторите позже'
                ];
            }
        }

        return parent::notFound(true);
    }
}