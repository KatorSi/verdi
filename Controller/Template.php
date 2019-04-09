<?php

namespace Controller;
class Template
{
    public static $template_folder;

    public function __construct()
    {
        self::$template_folder = dirname(__FILE__) . '/../templates/';
    }

    public static function fullTemplate($name, $data = [], $objects = [], $opt_options = [])
    {
        $header = self::template('parts/header', !empty($data['header']) ? $data['header'] : []);
        $footer = self::template('parts/footer', !empty($data['footer']) ? $data['footer'] : []);
        $body = self::template($name, !empty($data['body']) ? $data['body'] : [], $objects, $opt_options);
        return $header . $body . $footer;
    }

    public static function template($name, $data = [], $objects = [], $opt_options = [])
    {
        if (file_exists(self::$template_folder . $name . '.tpl')) {
            if (!empty($objects)) extract($objects, EXTR_SKIP);
            $is_admin = Main::$is_admin;
            ob_start();
            include(self::$template_folder . $name . '.tpl');
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
        return self::notFound();
    }

    public static function notFound($full = false)
    {
        if ($full) {
            return self::fullTemplate('not_found');
        }
        ob_start();
        include(self::$template_folder . 'not_found.tpl');
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}