<?php
/**
 * Created by PhpStorm.
 * User: iis
 * Date: 22.11.2018
 * Time: 11:31
 */

namespace Pages\Dashboard\Composer;


use Controller\Files;
use Controller\Routing\Abstractions\Response;
use Helpers\Transformers\DateTransformer;
use Pages\Composer\Model;

class Controller extends \Pages\Abstractions\Dashboard
{
    public static $templates = [
        'default' => 'dashboard/composer/index',
        'new'     => 'dashboard/composer/new',
        'edit'    => 'dashboard/composer/edit'
    ];
    public $assets = [
        'scripts' => [
            'js/dashboard/AutocompleteService.js',
            'js/vendor/jquery.ui.widget.js',
            'js/jquery.iframe-transport.js',
            'js/jquery.fileupload.js',
            'js/dashboard/composerPage.js',
            'lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'lib/bootstrap-datepicker/locales/bootstrap-datepicker.ru.min.js',
            'lib/ckeditor/ckeditor.js',
            'lib/ckeditor/adapters/jquery.js',
        ],
        'styles'  => [
            'lib/bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css',
            'css/dashboard/composer.css',
        ]
    ];

    public static $uploadTypes = [
        'books',
        'films',
        'texts'
    ];

    public static $name = 'dashboard';

    public function __construct() { parent::__construct(); }

    public function response($data)
    {
        if (!empty($data['id']))
            return $this->buildTemplate(self::$templates['edit'], Model::selectSingle($data['id']), $this->assets);
        return $this->buildTemplate(self::$templates['default'], Model::selectAll(), $this->assets);
    }

    public function index($data)
    {
        if (Response::$isPost) {
            return Model::selectAll();
        }
        return $this->buildTemplate(self::$templates['default'], Model::selectAll(), $this->assets);
    }

    public function edit($data)
    {
        if (!empty($data['id'])) {
            return $this->buildTemplate(self::$templates['edit'], Model::selectSingle($data['id']), $this->assets);
        }

        return parent::notFound(true);
    }

    public function delete($data)
    {
        if (!empty($data['id']))
            $result = Model::removeComposer($data['id']);
        if (!$result) {
            return [
                'status' => 'Ошибка удаления'
            ];
        }
        return ['response' => true];
    }

    public function select()
    {
        return Model::selectAll();
    }

    public function create($data)
    {
        $data = DateTransformer::transform($data);
        if ($res = Model::createComposer($data)) {
            return [
                'message' => parent::template(self::$templates['default'], $res),
                'error'   => null,
                'status'  => 'Элемент сохранен'
            ];
        }
        return [
            'message' => null,
            'status'  => 'Ошибка сохранения',
            'error'   => 'Ошибка записи в БД',
        ];
    }

    public function update($data)
    {
        $data = DateTransformer::transform($data);
        if ($res = Model::updateComposer($data)) {
            return [
                'message' => parent::template(self::$templates['edit'], $res),
                'error'   => null,
                'status'  => 'Изменения сохранены'
            ];
        } else {

            return [
                'message' => null,
                'status'  => 'Ошибка обновления',
                'error'   => 'Ошибка обновления в БД',
            ];
        }
    }

    public function saveFilms($data)
    {
        if(Response::$isPost && isset($data['films']) && !empty($data['films'])) {
            $response = [];
            foreach($data['films'] as $idFilm => $film) {
                if (is_integer($idFilm)) {
                    $response[] = Model::updateFilms($idFilm, $film);
                }
                else {
                    $response[] = Model::createFilms($film);
                }
            }

            return $response;
        }
        return parent::notFound(true);
    }

    public function saveBooks($data)
    {
        if (Response::$isPost && isset($data['books']) && !empty($data['books'])) {
            $response = [];
            foreach ($data['books'] as $idBook => $book) {
                $response[] = Model::updateBook($idBook, $book);
            }
            return $response;
        }
        return parent::notFound(true);
    }

    /**
     * @param $data
     *
     * @return array|false
     */
    public function upload($data)
    {
        if (Response::$isPut && intval($data['id']) > 0 && in_array($data['type'], self::$uploadTypes)) {
            $fileClass = new Files();
            $fileData = $fileClass->upload($data['type'], 'composer', intval($data['id']));
            return $fileData;
        }

        return parent::notFound(true);
    }
}