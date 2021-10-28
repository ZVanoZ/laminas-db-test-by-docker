<?php
$loader = require_once 'setAutoloader.php';

use App\MsSqlSettings;

if (!function_exists('sqlsrv_connect')) {
    throw new Exception('function "sqlsrv_connect" is not exists');
}
$serverName = sprintf('%s\laminasdb_test',
    MsSqlSettings::$HOSTNAME
);
$connectionInfo = array(
    'Database' => MsSqlSettings::$DATABASE
);

$connRes = sqlsrv_connect($serverName, $connectionInfo);

echo sprintf('<p>result:<span style="color:%s">%s</span></p>',
    $connRes === false ? 'red' : 'green',
    $connRes === false ? 'fail' : 'success'
);
echo '<pre>';
var_dump($connRes);
echo '</pre>';