<?php
/**
 * Created by PhpStorm.
 * User: MadsNorby
 * Date: 2019-03-12
 * Time: 19:28
 */

function getConnection() {

    $hostname = '127.0.0.1';
    $username = 'root';
    $password = 'nqg69yhk';
    $db = 'internet_technology';
    $port = 3306;
    $dsn = "mysql:dbname={$db};host={$hostname};port={$port};charset=utf8";


    try{
        $conn = new PDO($dsn, $username, $password);
    } catch(PDOException $e){
        die( "Connection failed: " . $e->getMessage());
    }
    return $conn;

}
