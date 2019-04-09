<?php
namespace Helpers\Transformers;
use Pages\Dashboard\Opera\Model as Model;
use Helpers\Transformers\DateTransformer as DateTransformer;
class DataTransformer
{
   public static function transform($data)
   {
       foreach($data as $key=>$val)
       {
            $audios = Model::selectAudios($data[$key]['id']);
            $videos = Model::selectVideos($data[$key]['id']);
            $audios = $audios['audios'];
            $videos = $videos['videos'];
            $data[$key]['audios'] = $audios;
            $data[$key]['videos'] = $videos;
            $data[$key]['partituraExists'] = self::partituraTranslator($data[$key]['partituraExists']);
            $data[$key]['premiereYear'] = DateTransformer::dateFormat($data[$key]['premiereYear']);
       }
       return $data;
   }
   public static function partituraTranslator($val)
   {
       switch ($val) {
           case 'yes' :
               $val = 'Есть';
               return $val;
               break;
           case 'no' :
               $val = 'Нет';
               return $val;
               break;
       }
   }
}