<?php

class Ftp {

    private $host;
    private $port;
    private $user;
    private $password;
    private $connection;

    public function __construct($host,$port,$user,$password) {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->connection = null;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function connect()
    {
        $connect = ftp_connect($this->host,$this->port) or die("No se puede conectar al FTP : " . $this->host);

        if (@ftp_login($connect,$this->user,$this->password)) {
            $this->connection = $connect;
            return true;
        }
        return false;
    }

    public function put($file) {
        if ($this->connection != null) {
            if (ftp_put($this->connection,$file,$file,FTP_ASCII)) {
                return true;
            }
        }
        return false;
    }

    public function get($file) {
        if ($this->connection != null) {
            if (ftp_get($this->connection,$file,$file,FTP_ASCII)) {
                return true;
            }
        }
        return false;
    }
}

?>