<?php
/**
 * Created by PhpStorm.
 * User: anokhin.a
 * Date: 25.07.2018
 * Time: 10:09
 */

namespace Helpers\Blueimp;


class CustomUploader extends UploadHandler
{
    public function __construct($options = null, $initialize = true, $error_messages = null)
    {
        $options['accept_file_types'] = $options['inline_file_types'] = '/.+$/i';

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $_FILES[isset($options['param_name']) ? $options['param_name'] : $this->options['param_name']]['name'] = '';
        }

        parent::__construct($options, $initialize, $error_messages);
    }
}