<?php
$loader = require_once 'setAutoloader.php';

use App\PostgreSqlSettings;

if(!class_exists('PDO')){
    throw new Exception('class "PDO" is not exists');
}

$dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s',
    PostgreSqlSettings::$HOSTNAME,
    PostgreSqlSettings::$PORT,
    PostgreSqlSettings::$DATABASE
);
$pdo = new PDO(
    $dsn,
    PostgreSqlSettings::$USERNAME,
    PostgreSqlSettings::$PASSWORD,
    array(
        PDO::ATTR_PERSISTENT => false
    )
);

echo sprintf('<p>result:<span style="color:%s">%s</span></p>',
    $pdo === false ? 'red' : 'green',
    $pdo === false ? 'fail' : 'success'
);
var_dump($pdo);