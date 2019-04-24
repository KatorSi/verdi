<?php
namespace Pages\Works;

use \Controller\Main;

class Model
{
    public static $tableName = 'works';

    public function __construct()
    {
    }

    public static function selectAll()
    {
        Main::$pdo->query("SELECT * FROM ".static::$tableName);
        return Main::$pdo->resultset();
    }

    public static function selectAllById($id)
    {
        Main::$pdo->query("SELECT * FROM ".static::$tableName." WHERE composer_id = :id");
        Main::$pdo->bind(':id', $id);
        $data = Main::$pdo->resultset();
        return $data;
    }

    public static function createWork($data)
    {
        if (empty($data['title'])) return false;
        Main::$pdo->query("INSERT INTO ".self::$tableName." (composer_id, title) VALUES (:composer_id, :title)");
        Main::$pdo->bind(':composer_id', $data['id']);
        Main::$pdo->bind(':title', $data['title']);
        try {
            Main::$pdo->execute();
        }
        catch(\Exception $e) {
            return false;
        }
        return ['status' => 'Запись добавлена', 'message' => 'Все хорошо'];
    }

}