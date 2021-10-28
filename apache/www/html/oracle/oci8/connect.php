<?php
$loader = require_once 'setAutoloader.php';

use App\OracleSettings;

$connString = implode('/', [
    OracleSettings::$HOSTNAME,
    OracleSettings::$DATABASE
]);
$connRes = oci_connect(
    OracleSettings::$USERNAME,
    OracleSettings::$PASSWORD,
    $connString
);

echo sprintf('<p>result:<span style="color:%s">%s</span></p>',
    $connRes === false ? 'red' : 'green',
    $connRes === false ? 'fail' : 'success'
);
var_dump($connRes);