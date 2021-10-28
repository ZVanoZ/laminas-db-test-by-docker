<?php
ini_set("display_errors", "on");
error_reporting(E_ALL);
error_reporting(E_ALL & ~E_WARNING);
//error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('html_errors', 'on');

$scripts = [
    'MSSQL' => [
        'mssql/pdo_sqlsrv/connect.php' => 'pdo_sqlsrv connect',
//        'mssql/sqlsrv/connect.php' => 'sqlsrv_connect',
    ],
    'MySql' => [
//        'mysql/mysql/connect.php' => 'mysql_connect',
        'mysql/mysqli/connect.php' => 'mysqli',
        'mysql/pdo_mysql/connect.php' => 'pdo_mysql',
    ],
    'Oracle' => [
        'oracle/oci8/connect.php' => 'Oracle OCI8 connect',
        'oracle/pdo_oci/connect.php' => 'Oracle PDO_OCI connect ("laminas-db" used)',
    ],
    'PostgreSQL' => [
        'postgres/pdo_pgsql/connect.php' => 'pdo_pgsql connect',
        'postgres/pgsql/connect.php' => 'pgsql connect',
    ],

];

set_error_handler(function (
    int $errno,
    string $errstr,
    string $errfile,
    int $errline,
    array $errcontext
) {
    echo '<br/>';
    echo '<p style="color: deeppink; font-weight: bold">Catch "set_error_handler"</p>';
    var_dump(func_get_args());
});
set_exception_handler(function ($exception) {
    echo '<br/>';
    echo '<b style="color: red; font-weight: bold">Catch "set_exception_handler"</b>';
    echo '<pre>';
    var_dump($exception);
    echo '</pre>';
});

foreach ($scripts as $dbName => $dbScripts) {
    echo sprintf('<hr><h2>%s</h2>', $dbName);
    foreach ($dbScripts as $dbScript => $dbAdapterDescription) {
        echo sprintf('<h3>%s</h3><br><b style="border-bottom: 1px solid;">%s</b>', $dbAdapterDescription, $dbScript);
        ob_start();
        try {
            include $dbScript;
        } catch (Exception $e) {
            var_dump($e);
        }
        $buf = ob_get_contents();
        ob_end_clean();
        echo sprintf('<pre>%s</pre>', $buf);

    }
}
