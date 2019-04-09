<?php

namespace Pages\Country;

use Controller\Main as Main;

class Model
{
    public function __construct() { }

    public static function selectAll()
    {
        Main::$pdo->query("SELECT * FROM countries ORDER BY title ASC");
        return Main::$pdo->resultset();
    }

    public static function createCountry($title)
    {
        Main::$pdo->query("INSERT INTO countries (title) VALUES (:title)");
        Main::$pdo->bind(':title', $title);
        Main::$pdo->execute();
        return self::selectAll();
    }

    public static function updateCountry($title, $id)
    {
        Main::$pdo->query("UPDATE countries SET title = :title WHERE id = :id");
        Main::$pdo->bind(':id', $id);
        Main::$pdo->bind(':title', $title);
        return Main::$pdo->execute();
    }

    public static function removeCountry($id)
    {
        Main::$pdo->query("DELETE FROM countries WHERE id = :id");
        Main::$pdo->bind(':id', $id);
        return Main::$pdo->execute();
    }
}