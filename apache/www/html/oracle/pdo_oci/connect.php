<?php
$loader = require_once 'setAutoloader.php';

use App\OracleSettings;

if(!class_exists('PDO')){
    throw new Exception('class "PDO" is not exists');
}

$dsn = sprintf('oci:dbname=//%s:%s/%s',
    OracleSettings::$HOSTNAME,
    OracleSettings::$PORT,
    OracleSettings::$DATABASE
);
$pdo = new PDO(
    $dsn,
    OracleSettings::$USERNAME,
    OracleSettings::$PASSWORD,
    array(
        PDO::ATTR_PERSISTENT => false
    )
);

echo sprintf('<p>result:<span style="color:%s">%s</span></p>',
    $pdo === false ? 'red' : 'green',
    $pdo === false ? 'fail' : 'success'
);
var_dump($pdo);