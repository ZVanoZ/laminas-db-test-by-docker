<?php

namespace App;

class MsSqlSettings
{
    public static $HOSTNAME = 'localhost';
    public static $PORT = '1433';
    public static $USERNAME = 'sa';
    public static $PASSWORD = 'Password123';
    public static $DATABASE = 'laminasdb_test';
}

$iniPath = __DIR__ . '/../config/mssql.ini';
if (file_exists($iniPath)) {
    $ini = parse_ini_file($iniPath);
    MsSqlSettings::$DATABASE = $ini['DATABASE'];
    MsSqlSettings::$PORT = @$ini['PORT'] ?? MsSqlSettings::$PORT;
    MsSqlSettings::$USERNAME = $ini['USERNAME'];
    MsSqlSettings::$HOSTNAME = $ini['HOSTNAME'];
    MsSqlSettings::$PASSWORD = $ini['PASSWORD'];
}