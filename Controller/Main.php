<?php

namespace Controller;

use Controller\DBClass\PDOWrap as PDOWrap;

class Main
{
    private static $instance = false;
    public static $pdo;
    public static $user;
    public static $is_admin = false;
    public static $super_admin = false;

    public function __construct()
    {
        if (!self::$instance) {
            self::$pdo = new PDOWrap;
            self::$user = null;
            self::$instance = true;
            self::$is_admin = false;
            self::$super_admin = false;
        }
    }
}