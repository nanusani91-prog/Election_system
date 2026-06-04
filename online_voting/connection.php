<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$port = 4305;     
$user = 'root';
$pass = '';       
$db   = 'polls';


$mysqli = new mysqli($host, $user, $pass, $db, $port);


if ($mysqli->connect_errno) {
    die("Database connection failed: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

if (!$mysqli->set_charset("utf8")) {
    die("Error loading character set utf8: " . $mysqli->error);
}

?>
