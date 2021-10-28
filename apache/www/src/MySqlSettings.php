<?php

namespace App;

class MySqlSettings
{
    public static $HOSTNAME = 'localhost';
    public static $PORT = '3306';
    public static $USERNAME = 'root';
    public static $PASSWORD = 'Password123';
    public static $DATABASE = 'laminasdb_test';
}

$iniPath = __DIR__ . '/../config/mysql.ini';
if (file_exists($iniPath)) {
    $ini = parse_ini_file($iniPath);
    MySqlSettings::$DATABASE = $ini['DATABASE'];
    MySqlSettings::$PORT = @$ini['PORT'] ?? MySqlSettings::$PORT;
    MySqlSettings::$USERNAME = $ini['USERNAME'];
    MySqlSettings::$HOSTNAME = $ini['HOSTNAME'];
    MySqlSettings::$PASSWORD = $ini['PASSWORD'];
}