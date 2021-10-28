<?php
$loader = require_once 'setAutoloader.php';

use App\MySqlSettings;

if(!function_exists('mysqli_report')){
    throw new Exception('function "mysqli_report" is not exists');
}
if(!function_exists('mysqli')){
    throw new Exception('function "mysqli" is not exists');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$connRes = new mysqli(
    MySqlSettings::$HOSTNAME,
    MySqlSettings::$USERNAME,
    MySqlSettings::$PASSWORD,
    MySqlSettings::$DATABASE
);

echo sprintf('<p>result:<span style="color:%s">%s</span></p>',
    $connRes === false ? 'red' : 'green',
    $connRes === false ? 'fail' : 'success'
);
echo '<pre>';
var_dump($connRes);
echo '</pre>';