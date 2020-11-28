<?php
session_start();

if (isset($_GET)) {
    
    $_SESSION['host'] = $_GET['host'];
    $_SESSION['port'] = $_GET['port'];
    $_SESSION['user'] = $_GET['user'];
    $_SESSION['password'] = $_GET['password'];
}

?>