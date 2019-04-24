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
            Main::$pdo->query("UPDATE events SET title = :title, author = :composer, date = :date, theater = :theater, composer_id = :composer_id, ticket_link = :ticket_link WHERE id = :id");
            Main::$pdo->bind(':id', $data['id']);
            Main::$pdo->bind(":title", !empty($data['works']) ? $data['works'] : '');
            Main::$pdo->bind(":composer", !empty($data['composer']) ? array_pop(explode(' ', $data['composer'])) : '');
            Main::$pdo->bind(':composer_id', !empty($data['composer_id']) ? $data['composer_id'] : 0);
            Main::$pdo->bind(':date', !empty($data['date']) ? $data['date'] : null);
            Main::$pdo->bind(":theater", !empty($data['theater']) ? $data['theater'] : '');
            Main::$pdo->bind(':ticket_link', !empty($data['ticket_link']) ? $data['ticket_link'] : '');
            Main::$pdo->execute();
        }
        return $data;
    }

    public static function createPoster($data)
    {
        if (!empty($data)) {
            Main::$pdo->query("INSERT INTO ".static::TABLENAME." (date, title, theater, author, composer_id, ticket_link)
            VALUES (:date, :title, :theater, :author, :composer_id, :ticket_link)");
            Main::$pdo->bind(":date", $data['date']);
            Main::$pdo->bind(":title", $data['title']);
            Main::$pdo->bind(":theater", $data['theater']);
            Main::$pdo->bind(":author", $data['composer']);
            Main::$pdo->bind(":composer_id", $data['composer_id']);
            Main::$pdo->bind(":ticket_link", $data['ticket_link']);
            try {
                Main::$pdo->execute();
            }
            catch (\Exception $e) {
                return ['status' => 'error', 'message' => $e->getMessage()];
            }
            return self::selectAll();
        }
    }

    public static function removePoster($id)
    {
        Main::$pdo->query("DELETE FROM ".self::TABLENAME." WHERE id = :id");
        Main::$pdo->bind(':id', $id);
        return Main::$pdo->execute();
    }
}