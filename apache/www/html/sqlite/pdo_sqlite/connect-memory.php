<?php
$loader = require_once 'setAutoloader.php';
//use App\SqliteSettings;

if(!class_exists('PDO')){
    throw new Exception('class "PDO" is not exists');
}

$pdo = new PDO(
    'sqlite::memory:',
    null,
    null,
    array(PDO::ATTR_PERSISTENT => true)
);

echo sprintf('<p>result:<span style="color:%s">%s</span></p>',
    $pdo === false ? 'red' : 'green',
    $pdo === false ? 'fail' : 'success'
);
var_dump($pdo);