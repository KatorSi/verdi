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
            $month = DateTransformer::getCyrillicMonth((new \DateTime($event['date']))->format('m'));
            $result[$month][] = $event;
        }
        return $result;
    }
}