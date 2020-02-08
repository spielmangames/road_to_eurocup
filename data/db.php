<?php

function dieHard($errorNo)
{
    die('There is some pain: ' . $errorNo);
}

$host = '127.0.0.1';
$username = 'root';
$password = '';

$connection = new mysqli($host, $username, $password);
if ($connection->connect_error) {
    dieHard(__LINE__ . ': ' . $connection->connect_error);
}

$dbName = 'road_to_eurocup';
if (!$connection->query("DROP DATABASE IF EXISTS `$dbName`;")) {
    dieHard(__LINE__);
}
if (!$connection->query("CREATE DATABASE `$dbName`;")) {
    dieHard(__LINE__);
}
if (!$connection->query("USE `$dbName`;")) {
    dieHard(__LINE__);
}

if (!$connection->multi_query(file_get_contents('db_scheme.sql'))) {
    dieHard(__LINE__);
}


$connection->close();
