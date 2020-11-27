<?php

require_once './ftp.class.php';

$ftp = new Ftp('ftp.pablopita.es',21,'u340982879.ppita_test','R/s2s*EBs$e');
echo $ftp->connect();
// echo $ftp->put('pruebas.txt');
echo $ftp->get('pruebas.txt');

?>