<?php
namespace Pages\Abstractions;
use Controller\Template as Template;
abstract class Dashboard extends Template {


    protected function buildTemplate($template, $data = [], $assets = []) {
        if(false === \Auth_client_api::$user){
            header('location: //' . $_SERVER['HTTP_HOST']);
        }
        $header = self::template('dashboard/parts/header', $assets);
        $nav = self::template('dashboard/parts/nav', ['menu' => []]);
        $content = self::template($template, $data);
        $footer = self::template('dashboard/parts/footer', $assets);
        return $header.$nav.$content.$footer;
    }
}