<?php

$user = "root";
$password = "";
$database = "bonmedecin";
try {
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';
    $bdd = new PDO('mysql:host=localhost;dbname=bonmedecin', 'root', '', $pdo_options);
} catch (PDOException $e) {
    echo $bdd . "<br>" . $e->getMessage();
}
?>