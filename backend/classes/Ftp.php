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
        $this->connection = false;
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
        $this->connection = @ftp_connect($this->host,$this->port);
         
        if (@ftp_login($this->connection,$this->user,$this->password)) {
            return true;
        } 

        return false;
    }

    public function put($serverFile,$ftpFile):bool {
        return ftp_put($this->connection,$ftpFile,$serverFile,FTP_ASCII);
    }

    public function get($serverFile,$ftpFile):bool {
        return ftp_get($this->connection,$serverFile,$ftpFile,FTP_ASCII);
    }

    public function list($dir):array {
        return ftp_nlist($this->connection,$dir);
    }

    public function delete($file):bool {
        return ftp_delete($this->connection, $file);
    }

    public function disconnect():bool {
        return ftp_close($this->connection);
    }

    public function createDir($dir):string {
        return ftp_mkdir($this->connection,$dir);
    }
    
    public function deleteDir($dir):bool {
        return ftp_rmdir($this->connection,$dir);
    }

    public function find($dir,$fileToSearch):bool {
        $files = $this->list($dir);
        foreach ($files as $file) {
            if ($file == $fileToSearch) {
                return true;
            }
        }

        return false;
    }
}

?>