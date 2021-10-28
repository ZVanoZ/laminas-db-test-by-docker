<?php
$loader = require_once 'setAutoloader.php';

use App\PostgreSqlSettings;

if (!function_exists('pg_connect')) {
    throw new Exception('function "pg_connect" is not exists');
}

$connString = sprintf('host=%s port=%s dbname=%s user=%s password=%s',
    PostgreSqlSettings::$HOSTNAME,
    PostgreSqlSettings::$PORT,
    PostgreSqlSettings::$DATABASE,
    PostgreSqlSettings::$USERNAME,
    PostgreSqlSettings::$PASSWORD
);
$pdo = pg_connect($connString);

echo sprintf('<p>result:<span style="color:%s">%s</span></p>',
    $pdo === false ? 'red' : 'green',
    $pdo === false ? 'fail' : 'success'
);
var_dump($pdo);