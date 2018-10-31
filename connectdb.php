<?php
$db ="mysql:host=localhost;dbname=wideworldimporters;port=3306";
$user = "test";
$pass = "123";
    try {
        $pdo = new PDO("$db", $user, $pass);
            //echo een message wanner connected to database
            //echo 'Connected to database! </br>';
        }
        catch(PDOException $e){
            echo "Error!:". $e->getMessage() . "<br/>";
            die();
        }
?>