<?php

namespace Pages\Poster;

use \Controller\Main as Main;
use Helpers\Transformers\DateTransformer as DateTransformer;

class Model
{

    const TABLENAME = 'events';
    public static $THEATER = [
        'm-1'       => 'Мариинский театр-1',
        'm-2'       => 'Мариинский театр-2',
        'mix'       => 'Михайловский театр',
        'spb-opera' => 'Театр Санкт-Петербург Опера',
        'cap'       => 'Гос.академ. капелла СПб',
        'etc'       => 'Другие площадки',
    ];

    public function __construct()
    {
    }

    public static function selectAll()
    {
        Main::$pdo->query("
            SELECT * from ".static::TABLENAME."
            ORDER BY ".static::TABLENAME.".date ASC
        ");
        $data = Main::$pdo->resultset();
        return $data;
    }

    public static function selectAllAfterToday()
    {
        Main::$pdo->query("
            SELECT * from ".static::TABLENAME."
            WHERE date >= CURRENT_DATE
            ORDER BY ".static::TABLENAME.".date ASC
        ");
        $data = self::prepareData(Main::$pdo->resultset());
        return $data;
    }

    public static function selectSingle($id)
    {
        Main::$pdo->query("
            SELECT
                events.*,
                concat(composers.firstName, ' ', composers.lastName) as composer    
            FROM ".static::TABLENAME."
                LEFT JOIN composers ON events.composer_id = composers.id
            WHERE events.id = :id
        ");
        Main::$pdo->bind(":id", $id);
        return Main::$pdo->single();
    }


    public static function prepareData($data)
    {
        $data = array_map(function ($item) {
            $result = [];
            $item = array_merge($item, array_fill_keys(self::$THEATER, ''));
            $item[$item['theater']] = $item['title'];
            $date = new \DateTime($item['date']);
            $dateFormat = $date->format('Y-m-d');
            $item['date'] = $date->format('d').' '.DateTransformer::getCyrillicShortMonth($date->format('m'));
            $result[$dateFormat] = $item;
            return $result;
        }, $data);
        return $data;
    }

    public static function updatePoster($data)
    {
        if (!empty($data)) {
            var_dump(array_pop(explode(' ', $data['composer'])));
            Main::$pdo->query("UPDATE event SET title = :title, author = :composer, composer_id = :composer_id, date = :date, theater = :theater WHERE id = :id");
            Main::$pdo->bind(":title", !empty($data['title']) ? $data['title'] : '');
            Main::$pdo->bind(":composer", !empty($data['composer']) ? array_pop(explode(' ', $data['composer'])) : '');
            Main::$pdo->bind(':composer_id', !empty($data['composer_id']) ? $data['composer_id'] : null);
            Main::$pdo->bind(':date', !empty($data['date']) ? $data['date'] : null);
            Main::$pdo->bind(":theater", !empty($data['theater']) ? array_keys(\Pages\Poster\Model::$THEATER)[$data['theater']] : '');
            Main::$pdo->execute();
        }
        return $data;
    }

    public static function createPoster($data)
    {
        var_dump($data);
    }
}