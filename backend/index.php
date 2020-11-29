<?php
session_start();

require_once 'config.php';
require_once 'classes/Controlador.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['action']))
{
    $controlador = new Controlador();
    switch ($_GET['action']) {
        case 'FTP_CONNECT':
            $response = $controlador->connect();
            break;
        case 'FTP_GET':
            if (isset($_GET['file'])) {
                $fileServer = TMP_USER_FILES . $_GET['file'];
                $response = $controlador->get($fileServer, $_GET['file']);
            }
            break;
    }

    header($response['status_code_header']);
    if ($response['body']) {
        echo $response['body'];
    }
} 

?>