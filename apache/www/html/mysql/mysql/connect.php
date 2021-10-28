<?php
$loader = require_once 'setAutoloader.php';
echo '<p style="color: red;"><b>mysql_connect</b> is deprecated since  PHP 5.5.0 and removed in PHP 7.0.0! Use MySQLi or PDO_MySQL instead. </p>';

use App\MySqlSettings;

if(!function_exists('mysql_connect')){
    throw new Exception('function "mysql_connect" is not exists');
}

$connRes = mysql_connect(
    MySqlSettings::$HOSTNAME,
    MySqlSettings::$USERNAME,
    MySqlSettings::$PASSWORD
);

echo sprintf('<p>result:<span style="color:%s">%s</span></p>',
    $connRes === false ? 'red' : 'green',
    $connRes === false ? 'fail' : 'success'
);