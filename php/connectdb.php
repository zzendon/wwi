<?php
$db ="mysql:host=localhost;dbname=wideworldimporters;port=3306";
$user = "test";
$pass = "123";

function getConnection() {
    global $db, $user, $pass;

    try {
        $pdo = new PDO("$db", $user, $pass);
        return $pdo;
    }
    catch(PDOException $e){
        echo "Error!:". $e->getMessage() . "<br/>";
        die();
    }
}
?>