<?php
/**
 * Created by PhpStorm.
 * User: anokhin.a
 * Date: 23.07.2018
 * Time: 10:56
 */

namespace Helpers\Transformers;


class DateTransformer
{
    public static function transform($data)
    {
        if (isset($data['birthDate']) and isset($data['deathDate'])) {
            $birthDate = new \DateTime($data['birthDate']);
            $deathDate = new \DateTime($data['deathDate']);
            $data['birthDate'] = $birthDate->format('Y-m-d');
            $data['deathDate'] = $deathDate->format('Y-m-d');
        }
        return $data;
    }
    public static function dateFormat($date)
    {
        $resultDate = new \DateTime($date);
        return $resultDate->format('Y-m-d');
    }
}