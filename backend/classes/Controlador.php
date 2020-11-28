<?php

require_once 'Ftp.php';

class Controlador {

    private $ftp;

    public function __construct($host,$port,$user,$password) {
        $this->ftp = new Ftp($host,$port,$user,$password);
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
}

?>