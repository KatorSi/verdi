<?php
/**
 * Created by PhpStorm.
 * User: iis
 * Date: 22.11.2018
 * Time: 11:20
 */

namespace Pages\Dashboard\Opera;


use Controller\Files;
use Controller\Routing\Abstractions\Response;
use Helpers\Transformers\DateTransformer;
use Pages\Opera\Model;

class Controller extends \Pages\Abstractions\Dashboard
{
    public static $templates = [
        'default'   => 'dashboard/opera/index',
        'edit'      => 'dashboard/opera/edit',
        'filesList' => 'dashboard/opera/files'
    ];
    public $assets = [
        'scripts' => [
            'js/dashboard/AutocompleteService.js',
            'js/vendor/jquery.ui.widget.js',
            'js/jquery.iframe-transport.js',
            'js/jquery.fileupload.js',
            'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'lib/bootstrap-datepicker/locales/bootstrap-datepicker.ru.min.js',
            'lib/ckeditor/ckeditor.js',
            'lib/ckeditor/adapters/jquery.js',
            'js/dashboard/operaPage.js',
        ],
        'styles'  => [
            'css/dashboard/opera.css',
            'lib/bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css',
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function response($data) { }


    /**
     * Страница списка опер
     *
     * @param array $data
     * $data[id] int идентификатор в бд
     *
     * @return string
     */
    public function index($data)
    {
        return $this->buildTemplate(self::$templates['default'], Model::selectAll(), $this->assets);
    }


    /**
     * Страница редактирования оперы
     *
     * @param array $data
     * $data[id] int идентификатор в бд
     *
     * @return string
     */
    public function edit($data)
    {
        if (!empty($data['id'])) {
            $vData = [];
            $vData['opera'] = Model::selectSingle($data['id']);
            $vData['video'] = Model::selectVideo($data['id']);
            $vData['audio'] = Model::selectAudio($data['id']);
            //            $vData['score'] = Model::selectScore($data['id']);
            return $this->buildTemplate(self::$templates['edit'], $vData, $this->assets);
        }

        return parent::notFound(true);
    }


    /**
     * Сохранение новой оперы в бд
     *
     * @param $data
     *
     * @return array
     */
    public function create($data)
    {

        $data = DateTransformer::transform($data);
        if ($res = Model::createOpera($data)) {
            return [
                'message' => self::template(self::$templates['default'], $res),
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

    /**
     * Удаление оперы из бд
     *
     * @param $data
     *
     * @return array
     */
    public function delete($data)
    {
        if (!empty($data['id'])) {
            $result = Model::removeOpera($data['id']);

            if (!$result) {
                return [
                    'status' => 'Ошибка удаления'
                ];
            }
        }

        return ['response' => true];
    }

    /**
     * Обновление оперы в бд
     *
     * @param $data
     *
     * @return array
     */
    public function update($data)
    {
        if ($res = Model::updateOpera($data)) {
            return [
                parent::template(self::$templates['edit'], $res),
                'error'  => null,
                'status' => 'Изменения сохранены'
            ];
        } else {
            return [
                'message' => null,
                'status'  => 'Ошибка обновления',
                'error'   => 'Ошибка обновления в БД',
            ];
        }
    }

    /**
     * @param $data
     *
     * @return array|false
     */
    public function upload($data)
    {
        if (Response::$isPut && intval($data['id']) > 0 && in_array($data['type'], ['audio', 'video', 'score'])) {
            $fileClass = new Files();

            $fileData = $fileClass->upload($data['type'], 'opera', intval($data['id']));

            return $fileData;
        }

        return parent::notFound(true);
    }
}