<?php

namespace Pages\Dashboard\Poster;

use Pages\Poster\Model;

Class Controller extends \Pages\Abstractions\Dashboard
{
    public static $templates = [
        'default'   => 'dashboard/poster/index',
        'edit'      => 'dashboard/poster/edit',
    ];

    public $assets = [
        'scripts' => [
            'js/dashboard/posterPage.js',
            'lib/ckeditor/ckeditor.js',
            'js/dashboard/AutocompleteService.js',
        ],
        'styles'  => [
            'css/dashboard/poster.css',
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function response($data) { }

    /**
     * Страница афиши
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
     * Страница редактирования афиши
     *
     * @param array $data
     * $data[id] int идентификатор в бд
     *
     * @return string
     */
    public function edit($data)
    {
        if (!empty($data['id'])) {
            $vData['poster'] = \Pages\Poster\Model::selectSingle($data['id']);
            return $this->buildTemplate(self::$templates['edit'], $vData, $this->assets);
        }
        return parent::notFound(true);
    }


    /**
     * Сохранение афиши
     *
     * @param $data
     *
     * @return array
     */
    public function create($data)
    {

        if ($res = Model::createPoster($data)) {
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
     * Удаление афиши из бд
     *
     * @param $data
     *
     * @return array
     */
    public function delete($data)
    {
        if (!empty($data['id'])) {
            $result = Model::removePoster($data['id']);

            if (!$result) {
                return [
                    'status' => 'Ошибка удаления'
                ];
            }
        }

        return ['response' => true];
    }

    /**
     * Обновление афиши в бд
     *
     * @param $data
     *
     * @return array
     */
    public function update($data)
    {
        if ($res = Model::updatePoster($data)) {
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
}