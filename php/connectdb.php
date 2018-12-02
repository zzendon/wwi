<?php
include "config.php";

$config = new Config();
$connection = $config->connection_string();
$user = $config->db_user();
$pass = $config->db_password();

function getConnection()
{
    global $connection, $user, $pass;
    try {
        $pdo = new PDO("$connection", $user, $pass);
        return $pdo;
    } catch (PDOException $e) {
        echo "Error!:" . $e->getMessage() . "<br/>";
    }
    return null;
}
?>