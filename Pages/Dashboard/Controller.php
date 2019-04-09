<?php

namespace Pages\Dashboard;
class Controller extends \Pages\Abstractions\Dashboard
{
    public $templates = [
        'default' => 'dashboard/index'
    ];

    public function __construct() { parent::__construct(); }


    public function index($data)
    {
        return $this->buildTemplate($this->templates['default']);
    }
}