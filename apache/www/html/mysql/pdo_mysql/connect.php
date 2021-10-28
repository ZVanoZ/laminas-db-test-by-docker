<?php
$loader = require_once 'setAutoloader.php';

use App\MySqlSettings;

if(!class_exists('PDO')){
    throw new Exception('class "PDO" is not exists');
}

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s',
    MySqlSettings::$HOSTNAME,
    MySqlSettings::$PORT,
    MySqlSettings::$DATABASE
);
$pdo = new PDO(
    $dsn,
    MySqlSettings::$USERNAME,
    MySqlSettings::$PASSWORD,
    array(
        PDO::ATTR_PERSISTENT => false
    )
);

echo sprintf('<p>result:<span style="color:%s">%s</span></p>',
    $pdo === false ? 'red' : 'green',
    $pdo === false ? 'fail' : 'success'
);
var_dump($pdo);