<?php

function getDatabaseConnection(): mysqli
{
    $host = '127.0.0.1';
    $port = (int)'3306';
    $dbname = 'bambustore';
    $username = 'root';
    $password = '140720RcPm_';

    $mysqli = new mysqli($host, $username, $password, $dbname, $port);

    if ($mysqli->connect_error) {
        throw new RuntimeException('Connessione al database fallita: ' . $mysqli->connect_error);
    }

    $mysqli->set_charset('utf8mb4');

    return $mysqli;
}

$mysqli = getDatabaseConnection();
