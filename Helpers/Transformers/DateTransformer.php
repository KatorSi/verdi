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

    public static $MONTH = [
        '',
        'январь',
        'февраль',
        'март',
        'апрель',
        'май',
        'июнь',
        'июль',
        'август',
        'сентябрь',
        'октябрь',
        'ноябрь',
        'декабрь'
    ];
    public static $SHORTMONTH = [
        '',
        'янв',
        'фев',
        'мар',
        'апр',
        'май',
        'июн',
        'июл',
        'авг',
        'сен',
        'окт',
        'ноя',
        'дек'
    ];
    public static $WEEKSDAY = [
        'Mon' => 'пн',
        'Tue' => 'вт',
        'Wed' => 'ср',
        'Thu' => 'чт',
        'Fri' => 'пт',
        'Sat' => 'сб',
        'Sun' => 'вс',
    ];

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

    public static function getCyrillicMonth($number)
    {
        $number = (strpos($number, '0') === 0) ? substr($number, 1, 1) : $number;
        return self::$MONTH[$number];
    }

    public static function getCyrillicShortMonth($number)
    {
        $number = (strpos($number, '0') === 0) ? substr($number, 1, 1) : $number;
        return self::$SHORTMONTH[$number];
    }

    public static function getCyrillicDay($day)
    {
        return self::$WEEKSDAY[$day];
    }

    public static function getToday()
    {
        $today = new \DateTime();
        return $today->format('d').' '.self::getCyrillicShortMonth($today->format('m')).' '.$today->format('Y');
    }
}