<?php

namespace Pages\Composer;

use \Controller\Main as Main;
use Helpers\Transformers\DateTransformer;

class Model
{

    public function __construct()
    {
    }

    public static function createComposer($data)
    {
        if (empty($data['firstName']) && empty($data['lastName'])) return false;

        if (!empty($data['genre']) && empty($data['genre_id'])) $data['genre_id'] = self::createGenre($data['genre']);
        if (!empty($data['country']) && empty($data['country_id'])) $data['country_id'] = self::createCountry($data['country']);
        Main::$pdo->query("INSERT INTO composers (firstName, lastName, country_id, genre_id, deathDate,
            birthDate, bio,facts, sector) VALUES (:firstName,:lastName,:country_id, :genre_id, :deathDate, :birthDate, :bio,:facts, :sector_of, :city)");

        Main::$pdo->bind(':firstName', !empty($data['firstName']) ? $data['firstName'] : null);
        Main::$pdo->bind(':lastName', !empty($data['lastName']) ? $data['lastName'] : null);
        Main::$pdo->bind(':country_id', !empty($data['country_id']) ? $data['country_id'] : null);
        Main::$pdo->bind(':genre_id', !empty($data['genre_id']) ? $data['genre_id'] : null);
        Main::$pdo->bind(':deathDate', !empty($data['deathDate']) ? $data['deathDate'] : null);
        Main::$pdo->bind(':birthDate', !empty($data['birthDate']) ? $data['birthDate'] : null);
        Main::$pdo->bind(':bio', isset($data['bio']) ? $data['bio'] : '');
        Main::$pdo->bind(':facts', isset($data['facts']) ? $data['facts'] : '');
        Main::$pdo->bind(':sector_of', isset($data['sector']) ? $data['sector'] : '');
        Main::$pdo->bind(':city', isset($data['city']) ? $data['city'] : '');

        Main::$pdo->execute();

        return self::selectAll();
    }

    public static function updateComposer($data)
    {
        if (empty($data['firstName']) && empty($data['lastName']) && empty($data['id'])) return false;

        if (!empty($data['genre']) && empty($data['genre_id'])) $data['genre_id'] = self::createGenre($data['genre']);
        if (!empty($data['country']) && empty($data['country_id'])) $data['country_id'] = self::createCountry($data['country']);
        Main::$pdo->query("UPDATE composers SET firstName = :firstName, lastName = :lastName, country_id = :country_id, genre_id = :genre_id, 
        birthDate = :birth, deathDate = :death, bio = :bio, facts = :facts, sector = :sector_of, city = :city, opera = :opera, symphony = :symphony,
        concert = :concert, sonata = :sonata, brass = :brass, instrumental = :instrumental, vocal = :vocal WHERE id = :id");


        Main::$pdo->bind(':id', $data['id']);
        Main::$pdo->bind(':firstName', !empty($data['firstName']) ? $data['firstName'] : null);
        Main::$pdo->bind(':lastName', !empty($data['lastName']) ? $data['lastName'] : null);
        Main::$pdo->bind(':country_id', !empty($data['country_id']) ? $data['country_id'] : null);
        Main::$pdo->bind(':genre_id', !empty($data['genre_id']) ? $data['genre_id'] : null);
        Main::$pdo->bind(':birth', !empty($data['birthDate']) ? DateTransformer::dateFormat($data['birthDate']) : null);
        Main::$pdo->bind(':death', !empty($data['deathDate']) ? DateTransformer::dateFormat($data['deathDate']) : null);
        Main::$pdo->bind(':bio', isset($data['bio']) ? $data['bio'] : '');
        Main::$pdo->bind(':facts', isset($data['facts']) ? $data['facts'] : '');
        Main::$pdo->bind(':sector_of', isset($data['sector']) ? $data['sector'] : '');
        Main::$pdo->bind(':city', isset($data['city']) ? $data['city'] : '');
        Main::$pdo->bind(':opera', isset($data['opera']) ? $data['opera'] : '');
        Main::$pdo->bind(':symphony', isset($data['symphony']) ? $data['symphony'] : '');
        Main::$pdo->bind(':concert', isset($data['concert']) ? $data['concert'] : '');
        Main::$pdo->bind(':sonata', isset($data['sonata']) ? $data['sonata'] : '');
        Main::$pdo->bind(':brass', isset($data['brass']) ? 1 : 0);
        Main::$pdo->bind(':instrumental', isset($data['instrumental']) ? 1 : 0);
        Main::$pdo->bind(':vocal', isset($data['vocal']) ? 1 : 0);

        Main::$pdo->execute();

        return $data;
    }

    public static function createGenre($genreTitle)
    {
        Main::$pdo->query("INSERT INTO genres (title) VALUES (:title)");
        Main::$pdo->bind(':title', $genreTitle);
        Main::$pdo->execute();
        return Main::$pdo->lastInsertId();
    }

    public static function createCountry($countryTitle)
    {
        Main::$pdo->query("INSERT INTO countries (title) VALUES (:title)");
        Main::$pdo->bind(':title', $countryTitle);
        Main::$pdo->execute();
        return Main::$pdo->lastInsertId();
    }

    public static function selectAll()
    {
        Main::$pdo->query("
SELECT composers.*,
	   concat(composers.lastName, ' ', composers.firstName) as title,
	   countries.title                                      as country,
	   genres.title                                         as genre,
	   genres.id                                            as genre_id,
	   date_format(composers.birthDate, '%d.%m.%Y')         as birthDate,
	   date_format(composers.deathDate, '%d.%m.%Y')         as deathDate,
	   date_format(composers.birthDate, '%Y')               as birthYear,
	   date_format(composers.deathDate, '%Y')               as deathYear
FROM composers
		 LEFT JOIN countries ON countries.id = composers.country_id
		 LEFT JOIN genres ON genres.id = composers.genre_id
ORDER BY composers.birthDate ASC
");

        return Main::$pdo->resultset();
    }

    public static function selectSingle($id)
    {
        Main::$pdo->query("
SELECT composers.*,
	   concat(composers.firstName, ' ', composers.lastName) as title,
       countries.title as country,
       genres.title as genre,
       count(operas.id) as numOperas,
	   date_format(composers.birthDate, '%d.%m.%Y')         as birthDate,
	   date_format(composers.deathDate, '%d.%m.%Y')         as deathDate
FROM composers
		 LEFT JOIN countries ON countries.id = composers.country_id
		 LEFT JOIN genres ON genres.id = composers.genre_id
		 LEFT JOIN operas ON operas.composer_id = composers.id
WHERE composers.id = :id");
        Main::$pdo->bind(':id', $id);

        $composer = Main::$pdo->single();

        if (false !== $composer) {
            /*Main::$pdo->query("SELECT files.id, concat(files.path, files.name) as file, files.title
FROM files
WHERE files.type = 'films' AND files.owner = 'composer' AND files.owner_id = :id");*/
            Main::$pdo->query("SELECT filmsdata.*
            FROM filmsdata
            WHERE filmsdata.owner_id = :id");
            Main::$pdo->bind(':id', $id);
            $composer['films'] = Main::$pdo->resultset();

            Main::$pdo->query("SELECT files.id, concat(files.path, files.name) as `filePath`, files.title
FROM files
WHERE files.type = 'books' AND files.owner = 'composer' AND files.owner_id = :id");
            Main::$pdo->bind(':id', $id);
            $composer['books'] = Main::$pdo->resultset();
        }

        return $composer;
    }

    public static function selectFullNameById($id)
    {
        $id = intval($id);
        if ($id > 0) {
            Main::$pdo->query("SELECT concat(composers.firstName, ' ', composers.lastName) as title FROM composers where composers.id=:id");
            Main::$pdo->bind(':id', $id);

            return Main::$pdo->single();
        }

        return false;
    }

    public static function removeComposer($id)
    {
        Main::$pdo->query("DELETE FROM composers WHERE id = :id");
        Main::$pdo->bind(':id', $id);
        return Main::$pdo->execute();
    }

    public static function updateFilms($idFilm, $film)
    {
        $update = Main::$pdo->update(['title' => $film['title']], ['id', $idFilm], 'files');
        if (true === $update['status']) {
            $update = Main::$pdo->update([
                'year'        => $film['year'],
                'creator'     => $film['creator'],
                'actors'      => $film['actors'],
                'description' => $film['description']
            ], ['id', $idFilm], 'filmsdata');
            return $update;
        }
        return false;
    }

    public static function createFilms($film)
    {
        $create = Main::$pdo->insert([
            'title'       => $film['title'],
            'year'        => $film['year'],
            'owner_id'    => $film['owner_id'],
            'creator'     => $film['creator'],
            'actors'      => $film['actors'],
            'description' => $film['description'],
        ], 'filmsdata');
        return $create;
    }

    public static function updateBook($idBook, $book)
    {
        $update = Main::$pdo->update(['title' => $book['title']], ['id', $idBook], 'files');
        if ($update['status'] === true) {
            $update = Main::$pdo->update([
                'year' => $book['year'],
                'author' => $book['author'],
                'title' => $book['title'],
                'description' => $book['description']
            ], ['id' => $idBook], 'booksdata');
            return $update;
        }
        return false;
    }
}