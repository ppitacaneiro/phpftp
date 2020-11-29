<?php

require_once 'Ftp.php';

class Controlador {

    private $ftp;

    public function __construct() {
        if ($this->isFtpSettingsInUserSession()) {
            $this->ftp = new Ftp($_SESSION['host'],$_SESSION['port'],$_SESSION['user'],$_SESSION['password']);
        } else if ($this->isFtpSettingsPosted()) {
            $host = $this->sanitizeInputString($_GET['host']);
            $port = $this->sanitizeInputString($_GET['port']);
            $user = $this->sanitizeInputString($_GET['user']);
            $password = $this->sanitizeInputString($_GET['password']);
            $this->saveFtpSettingsInUserSession($host, $port, $user, $password);
            $this->ftp = new Ftp($host, $port, $user, $password);
        }
    }

    public function connect() {
        if ($this->ftp->connect()) {
            $response = $this->setResponse(HTTP_STATUS_CODE_200,STATUS_CODE_200,FTP_CONECTION_OK);
        } else {
            $response = $this->setResponse(HTTP_STATUS_CODE_401,STATUS_CODE_401,FTP_CONECTION_ERROR);
        }

        return $response;
    }

    public function get($serverFile,$ftpFile) {
        if ($this->ftp->connect()) {
            if ($this->ftp->get($serverFile,$ftpFile)) {
                $response = $this->setResponse(HTTP_STATUS_CODE_200,STATUS_CODE_200,FTP_GET_FILE_OK);
            } else {
                $response = $this->setResponse(HTTP_STATUS_CODE_401,STATUS_CODE_401,FTP_GET_FILE_ERROR);   
            }
        } else {
            $response = $this->setResponse(HTTP_STATUS_CODE_401,STATUS_CODE_401,FTP_CONECTION_ERROR);
        }

        return $response;
    }

    private function setResponse($statusCode,$code,$message) {
        $response['status_code_header'] = $statusCode;
        $response['body'] = json_encode(
            array
            (
                'code' => $code,
                'message' => $message    
            )
        );

        return $response;
    }

    private function sanitizeInputString($string) {
        return trim(filter_var($string,FILTER_SANITIZE_STRING));
    }

    private function saveFtpSettingsInUserSession($host,$port,$user,$password) {
        $_SESSION['host'] = $host;
        $_SESSION['port'] = $port;
        $_SESSION['user'] = $user;
        $_SESSION['password'] = $password;
    }

    private function isFtpSettingsInUserSession() {
        return (isset($_SESSION['host']) && $_SESSION['host'] != '') && (isset($_SESSION['port']) && $_SESSION['port'] != '') && (isset($_SESSION['user']) && $_SESSION['user'] != '') && (isset($_SESSION['password']) && $_SESSION['password'] != '');
    }

    private function isFtpSettingsPosted() {
        return isset($_GET['host']) && isset($_GET['port']) && isset($_GET['user']) && isset($_GET['password']);
    }
}

?>