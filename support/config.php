<?php

exec('chcp 65001');

// @link: http://phpfaq.ru/pdo

$mac = GetMAC();

if ("00-50-56-C0-00-01" === $mac) { // must be "..."
    $host = '127.0.0.1';
} else {
    $host = '172.19.5.99';
}

$db   = 'url_dictionary';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    die('Connection fail: ' . $e->getMessage());
}

/**

 @result $dbh - data base handler.

**/

/**
 * @return string
 */
function GetMAC()
{
    ob_start();
    system('getmac');
    $Content = ob_get_contents();
    ob_clean();
    ob_end_flush();

    return substr($Content, strpos($Content,'\\')-20, 17);
}