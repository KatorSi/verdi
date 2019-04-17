<?php

namespace Pages\Poster;

use \Controller\Main as Main;
use Helpers\Transformers\DateTransformer as DateTransformer;

class Model
{

    const TABLENAME = 'events';
    public static $THEATER = [
        'm-1' => 'Мариинский театр-1',
        'm-2' => 'Мариинский театр-2',
        'mix' => 'Михайловский театр',
        'spb-opera' => 'Театр Санкт-Петербург Опера',
        'cap' => 'Гос.академ. капелла СПб',
        'etc' => 'Другие площадки',
    ];

    public function __construct()
    {
    }

    public static function selectAll()
    {
        Main::$pdo->query("
            SELECT * from ".static::TABLENAME."
            WHERE date >= CURRENT_DATE
            ORDER BY ".static::TABLENAME.".date ASC
        ");
        $data = self::prepareData(Main::$pdo->resultset());
        return $data;
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
        /*foreach ($data as $key => $event) {

            //$month = DateTransformer::getCyrillicMonth($date->format('m'));
            // склеивание мероприятий, проходящих в один день
            if (isset($result[$dateFormat][$theater])) {
                $result[$dateFormat][$dateFormat]['author'] = array($result[$month][$dateFormat]['author'], $event['author']);
                $result[$month][$dateFormat]['theater'] = array($result[$month][$dateFormat]['theater'], $event['theater']);
                $result[$month][$dateFormat]['title'] = array($result[$month][$dateFormat]['title'], $event['title']);
            }
            else {
                $result[$dateFormat][$theater][] = $event;
            }
        }*/
        return $data;
    }
}