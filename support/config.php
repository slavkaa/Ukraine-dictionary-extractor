<?php 

// @link: http://phpfaq.ru/pdo

$host = '172.19.5.99';
//$host = '127.0.0.1';
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
