<?php

namespace App;

class OracleSettings
{
    public static $HOSTNAME = 'localhost';
    public static $PORT = '1521';
    public static $USERNAME = 'ldbtUser';
    public static $PASSWORD = 'Password123';
    public static $DATABASE = 'laminasdb_test';
}

$iniPath = __DIR__ . '/../config/oracle.ini';
if (file_exists($iniPath)) {
    $ini = parse_ini_file($iniPath);
    OracleSettings::$DATABASE = $ini['DATABASE'];
    OracleSettings::$PORT = @$ini['PORT'] ?? OracleSettings::$PORT;
    OracleSettings::$USERNAME = $ini['USERNAME'];
    OracleSettings::$HOSTNAME = $ini['HOSTNAME'];
    OracleSettings::$PASSWORD = $ini['PASSWORD'];
}