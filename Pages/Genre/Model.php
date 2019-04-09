<?php

namespace Pages\Genre;

use \Controller\Main as Main;

class Model
{
    public function __construct() { }

    public static function selectAll()
    {
        Main::$pdo->query("SELECT * FROM genres ORDER BY title ASC");
        return Main::$pdo->resultset();
    }

    public static function createGenre($title)
    {
        Main::$pdo->query("INSERT INTO genres (title) VALUES (:title)");
        Main::$pdo->bind(':title', $title);
        Main::$pdo->execute();
        return self::selectAll();
    }

    public static function updateGenre($title, $id)
    {
        Main::$pdo->query("UPDATE genres SET title = :title WHERE id = :id");
        Main::$pdo->bind(':id', $id);
        Main::$pdo->bind(':title', $title);
        return Main::$pdo->execute();
    }

    public static function removeGenre($id)
    {
        Main::$pdo->query("DELETE FROM genres WHERE id = :id");
        Main::$pdo->bind(':id', $id);
        return Main::$pdo->execute();
    }
}