<?php
session_start();

require_once 'config.php';
require_once 'classes/Controlador.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_POST['action']))
{
    $controlador = new Controlador();
    switch ($_POST['action']) {
        case 'FTP_CONNECT':
            $response = $controlador->connect();
            break;
        case 'FTP_GET':
            $response = ftpGet($controlador);
            break;
        case 'FTP_PUT':
            $response = ftpPut($controlador);
            break;
    }

    header($response['status_code_header']);
    if ($response['body']) {
        echo $response['body'];
    }
} 

function ftpPut($controlador) {
    if (isset($_POST['file'])) {
        
    }
}

function ftpGet($controlador) {
    if (isset($_POST['file']) && isset($_POST['dir'])) {
        $fileServer = TMP_USER_FILES . $_POST['file'];
        $response = $controlador->get($_POST['dir'],$fileServer, $_POST['file']);
    } else if (!isset($_POST['file'])) {
        $response = $controlador->setResponse(HTTP_STATUS_CODE_400,STATUS_CODE_400,FTP_BAD_REQUEST_FILE);
    } else if (!isset($_POST['dir'])) {
        $response = $controlador->setResponse(HTTP_STATUS_CODE_400,STATUS_CODE_400,FTP_BAD_REQUEST_DIR);
    }
    return $response;
}

?>