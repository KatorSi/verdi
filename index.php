<?php
ini_set("display_errors", 0);
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    include_once(dirname(__FILE__) . '/' . $class . '.php');
});
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$api_adr = "https://auth.006.spb.ru";
function runCurl($action)
{
    global $api_adr;
    if ($curl = curl_init()) {
        curl_setopt($curl, CURLOPT_URL, $api_adr . "/");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array("type" => "indexFile", "action" => $action));
        $out = curl_exec($curl);
        curl_close($curl);
        return $out;
    }

    return false;
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/auth")) {
    echo '<span style="color: red;">Для работы авторизации требуется папка "./auth" с правами записи для "www-data".</span>';
    die;
} else {
    $index_file = $_SERVER['DOCUMENT_ROOT'] . '/auth/index.php';
    // если файл не существует, то запросим его с сервера
    if (!file_exists($index_file)) {
        $fileContent = runCurl("getFile");
        file_put_contents($index_file, $fileContent);
    } else {
        $index_file_hash = md5_file($index_file);
        $newHash = runCurl("getHash");
        if ($newHash !== $index_file_hash) {
            $fileContent = runCurl("getFile");
            file_put_contents($index_file, $fileContent);
        }
    }
}


/** @var string $index_file */
require_once $index_file;
$user = Auth_client_api::$user;


Config::$host = '//' . $_SERVER['HTTP_HOST'] . '/';

$R = new Controller\Routing\Router;
$R->dispatchURI();
