<?php
/**
 * Created by PhpStorm.
 * User: anokhin.a
 * Date: 12.07.2018
 * Time: 14:19
 */

namespace Pages\Opera;

use Controller\Files;
use \Controller\Main;
use Helpers\Transformers\DateTransformer;

class Model
{
    public function __construct()
    {
    }

    public static function selectAll()
    {
        Main::$pdo->query("
SELECT 
       operas.*, 
       concat(composers.firstName, ' ', composers.lastName) as composer,
       librettists.name as librettist,
       date_format(operas.premiereYear, '%Y')               as premiereYear,
	   date_format(operas.premiereYear, '%d.%m.%Y')               as premiereDate,
       COUNT(video.id) as numVideo,
       COUNT(audio.id) as numAudio
FROM operas
		 LEFT JOIN composers ON operas.composer_id = composers.id
		 LEFT JOIN librettists ON operas.librettist_id = librettists.id
		 LEFT JOIN files as video ON video.type='video' and video.owner='opera' and video.owner_id=operas.id
		 LEFT JOIN files as audio ON audio.type='audio' and audio.owner='opera' and audio.owner_id=operas.id
GROUP BY operas.id
ORDER BY operas.premiereYear ASC");
        return Main::$pdo->resultset();
    }

    public static function selectSingle($id)
    {
        Main::$pdo->query("SELECT
	operas.*,
	concat(composers.firstName, ' ', composers.lastName) as composer,
    librettists.name as librettist,
	date_format(operas.premiereYear, '%Y')               as premiereYear,
	date_format(operas.premiereYear, '%d.%m.%Y')               as premiereDate
FROM operas
        LEFT JOIN composers ON operas.composer_id = composers.id
        LEFT JOIN librettists ON operas.librettist_id = librettists.id
WHERE operas.id = :id");
        Main::$pdo->bind(':id', $id);
        return Main::$pdo->single();
    }

    public static function selectSingleMult($id)
    {
        Main::$pdo->query("
SELECT
	operas.*,
	concat(composers.firstName, ' ', composers.lastName) as composer,
    librettists.name as librettist,
    date_format(operas.premiereYear, '%Y')               as premiereYear,
	date_format(operas.premiereYear, '%d.%m.%Y')               as premiereDate,
	COUNT(video.id) as numVideo,
	COUNT(audio.id) as numAudio
FROM operas
		 LEFT JOIN composers ON operas.composer_id = composers.id
        LEFT JOIN librettists ON operas.librettist_id = librettists.id
		 LEFT JOIN files as video ON video.type='video' and video.owner='opera' and video.owner_id=operas.id
		 LEFT JOIN files as audio ON audio.type='audio' and audio.owner='opera' and audio.owner_id=operas.id
WHERE operas.composer_id = :id
GROUP BY operas.id");
        Main::$pdo->bind(':id', $id);
        return Main::$pdo->resultset();
    }

    public static function selectName($id)
    {
        Main::$pdo->query("SELECT concat(composers.firstName, ' ', composers.lastName) as title FROM composers WHERE composers.id = :id");
        Main::$pdo->bind(':id', $id);
        return Main::$pdo->single();
    }

    public static function selectVideo($id)
    {
        return Files::getFilesByOwnerId('opera', $id, 'video');
    }

    public static function selectAudio($id)
    {
        return Files::getFilesByOwnerId('opera', $id, 'audio');
    }

    public static function createOpera($data)
    {
        if ($data['composer_id']) {

            if (!empty($data['title']) and !empty($data['composer_id'])) {

                Main::$pdo->query("
INSERT INTO operas (title, composer_id, basedOn, librettist, premierePlace,
					premiereYear, partituraExists, duration, history, description)
VALUES (:title, :composer_id, :basedOn, :librettist, :premierePlace,
		:premiereYear, :partituraExists, :duration, :history, :description)");
                Main::$pdo->bind(':title', !empty($data['title']) ? $data['title'] : null);
                Main::$pdo->bind(':composer_id', !empty($data['composer_id']) ? $data['composer_id'] : null);
                Main::$pdo->bind(':basedOn', !empty($data['basedOn']) ? $data['basedOn'] : null);
                Main::$pdo->bind(':librettist', !empty($data['librettist']) ? $data['librettist'] : null);
                Main::$pdo->bind(':premierePlace', !empty($data['premierePlace']) ? $data['premierePlace'] : null);
                Main::$pdo->bind(':premiereYear', !empty($data['premiereYear']) ? DateTransformer::dateFormat($data['premiereYear']) : null);
                Main::$pdo->bind(':partituraExists', 'no');
                Main::$pdo->bind(':duration', !empty($data['duration']) ? $data['duration'] : null);
                Main::$pdo->bind(':history', isset($data['history']) && !empty($data['history']) ? $data['history'] :
                    null);
                Main::$pdo->bind(':description', isset($data['history']) && !empty($data['description']) ?
                    $data['description'] : null);
                Main::$pdo->execute();
                return self::selectAll();
            }
        }

        return false;
    }

    public static function removeOpera($id)
    {
        Main::$pdo->query("DELETE FROM operas WHERE id = :id");
        Main::$pdo->bind(':id', $id);
        return Main::$pdo->execute();
    }

    public static function updateOpera($data)
    {
        if (!empty($data['librettist']) && empty($data['librettist_id'])) {
            $res = \Pages\Librettist\Model::create(['name' => $data['librettist']]);
            if (true === $res['success']) {
                $data['librettist_id'] = $res['message'];
            }
        }
        Main::$pdo->query("UPDATE operas SET title = :titleOf, basedOn = :literature, librettist = :libretto, librettist_id = :librettist_id, composer_id = :composer_id, 
        premierePlace = :place, premiereYear = :premiereYear, partituraExists = :partituraEx, duration= :timeOf, description= :description , history= :history WHERE id = :id");
        Main::$pdo->bind(':titleOf', !empty($data['title']) ? $data['title'] : null);
        Main::$pdo->bind(':id', $data['id']);
        Main::$pdo->bind(':literature', !empty($data['basedOn']) ? $data['basedOn'] : null);
        Main::$pdo->bind(':composer_id', !empty($data['composer_id']) ? $data['composer_id'] : 0);
        Main::$pdo->bind(':libretto', !empty($data['librettist']) ? $data['librettist'] : null);
        Main::$pdo->bind(':librettist_id', !empty($data['librettist_id']) ? $data['librettist_id'] : 0);
        Main::$pdo->bind(':place', !empty($data['premierePlace']) ? $data['premierePlace'] : null);
        Main::$pdo->bind(':premiereYear', !empty($data['premiereYear']) ?
            DateTransformer::dateFormat($data['premiereYear']) : null);
        Main::$pdo->bind(':partituraEx', !empty($data['partituraExists']) ? $data['partituraExists'] : null);
        Main::$pdo->bind(':timeOf', !empty($data['duration']) ? $data['duration'] : null);
        Main::$pdo->bind(':history', isset($data['history']) && !empty($data['history']) ? $data['history'] : null);
        Main::$pdo->bind(':description', isset($data['history']) && !empty($data['description']) ?
            $data['description'] : null);
        Main::$pdo->execute();


        return $data;
    }

}