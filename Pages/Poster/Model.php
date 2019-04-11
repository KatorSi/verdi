<?php

namespace Pages\Poster;

use \Controller\Main as Main;
use Helpers\Transformers\DateTransformer as DateTransformer;

class Model
{

    const TABLENAME = 'events';

    public function __construct()
    {
    }

    public static function selectAll()
    {
        Main::$pdo->query("
            SELECT * from ".static::TABLENAME."
            ORDER BY ".static::TABLENAME.".date ASC
        ");
        $data = self::prepareData(Main::$pdo->resultset());
        return $data;
    }

    public static function prepareData($data)
    {
        $result = [];
        foreach ($data as $key => $event) {
            $date = new \DateTime($event['date']);
            $dateFormat = $date->format('Y-m-d');
            $month = DateTransformer::getCyrillicMonth($date->format('m'));
            // склеивание мероприятий, проходящих в один день
            if (isset($result[$month][$dateFormat])) {
                $result[$month][$dateFormat]['author'] = array($result[$month][$dateFormat]['author'], $event['author']);
                $result[$month][$dateFormat]['theater'] = array($result[$month][$dateFormat]['theater'], $event['theater']);
                $result[$month][$dateFormat]['title'] = array($result[$month][$dateFormat]['title'], $event['title']);
            }
            else {
                $result[$month][$dateFormat] = $event;
            }
        }
        return $result;
    }
}