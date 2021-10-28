<?php

namespace App;

class PostgreSqlSettings
{
    public static $HOSTNAME = 'localhost';
    public static $PORT = '5432';
    public static $USERNAME = 'postgres';
    public static $PASSWORD = 'Password123';
    public static $DATABASE = 'laminasdb_test';
}

$iniPath = __DIR__ . '/../config/postgres.ini';
if (file_exists($iniPath)) {
    $ini = parse_ini_file($iniPath);
    PostgreSqlSettings::$DATABASE = $ini['DATABASE'];
    PostgreSqlSettings::$PORT = @$ini['PORT'] ?? PostgreSqlSettings::$PORT;
    PostgreSqlSettings::$USERNAME = $ini['USERNAME'];
    PostgreSqlSettings::$HOSTNAME = $ini['HOSTNAME'];
    PostgreSqlSettings::$PASSWORD = $ini['PASSWORD'];
}