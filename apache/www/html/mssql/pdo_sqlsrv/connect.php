<?php
$loader = require_once 'setAutoloader.php';

use App\MsSqlSettings;

if(!class_exists('PDO')){
    throw new Exception('class "PDO" is not exists');
}

$dsn = sprintf('sqlsrv:Server=%s,%s;Database=%s',
    MsSqlSettings::$HOSTNAME,
    MsSqlSettings::$PORT,
    MsSqlSettings::$DATABASE
);

$pdo = new PDO(
    $dsn,
    MsSqlSettings::$USERNAME,
    MsSqlSettings::$PASSWORD,
    array(
        PDO::ATTR_PERSISTENT => false
    )
);

echo sprintf('<p>result:<span style="color:%s">%s</span></p>',
    $pdo === false ? 'red' : 'green',
    $pdo === false ? 'fail' : 'success'
);
var_dump($pdo);