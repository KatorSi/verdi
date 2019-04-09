<?php
/**
 * Created by PhpStorm.
 * User: anokhin.a
 * Date: 12.07.2018
 * Time: 14:19
 */

namespace Pages\Librettist;

use \Controller\Main;

class Model
{
    private static $table = 'librettists';

    public function __construct()
    {
    }

    public static function selectAll()
    {
        Main::$pdo->query("SELECT `id`, `name` as `title` FROM librettists");
        return Main::$pdo->resultset();
    }

    public static function selectSingle($id)
    {
        //        Main::$pdo->query("SELECT
        //	operas.*,
        //	concat(composers.firstName, ' ', composers.lastName) as composer,
        //	date_format(operas.premiereYear, '%Y')               as premiereYear
        //FROM operas
        //		 LEFT JOIN composers ON operas.composer_id = composers.id
        //WHERE operas.id = :id");
        //        Main::$pdo->bind(':id', $id);
        //        return Main::$pdo->single();
    }

    public static function selectSingleMult($id)
    {
        //        Main::$pdo->query("
        //SELECT
        //	operas.*,
        //	concat(composers.firstName, ' ', composers.lastName) as composer,
        //    date_format(operas.premiereYear, '%Y')               as premiereYear,
        //	COUNT(video.id) as numVideo,
        //	COUNT(audio.id) as numAudio
        //FROM operas
        //		 LEFT JOIN composers ON operas.composer_id = composers.id
        //		 LEFT JOIN files as video ON video.type='video' and video.owner='opera' and video.owner_id=operas.id
        //		 LEFT JOIN files as audio ON audio.type='audio' and audio.owner='opera' and audio.owner_id=operas.id
        //WHERE operas.composer_id = :id
        //GROUP BY operas.id");
        //        Main::$pdo->bind(':id', $id);
        //        return Main::$pdo->resultset();
    }


    public static function create($data)
    {
        $validate = self::valid($data);

        if (true === $validate['success']) {
            return Main::$pdo->insert($validate['data'], self::$table);
        }

        return ['status' => false, 'error' => $validate['errors']];
    }

    public static function remove($data)
    {
        return Main::$pdo->delete(self::$table, ['id' => intval($data)]);
    }

    public static function update($data)
    {
        $validate = self::valid($data);

        if (true === $validate['success']) {
            return Main::$pdo->update(['id' => $validate['data']['id']], $validate['data'], self::$table);
        }

        return ['status' => false, 'error' => $validate['error']];
    }

    private static function valid($data)
    {
        $validData = [];
        $error = '';

        if (isset($data['id']) && !empty($data['id'])) {
            $validData['id'] = intval($data['id']);
        }

        $validData['name'] = isset($data['name']) && !empty($data['name']) ? trim(strip_tags($data['name'])) : '';
        if (empty($validData['name'])) {
            $error = 'Незаполнено поле name';
        }

        return ['success' => empty($error), 'data' => $validData, 'error' => $error];
    }
}