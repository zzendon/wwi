<?php
include 'connectdb.php';
include 'utils.php';

function authenticate($email, $password) {
    $connection = getConnection();
    $query = $connection->prepare("SELECT Id, Password FROM login where Email ='$email'");
    $query->execute();

    if ($query->rowCount()) {
        while ($row = $query->fetch()) {
            session_start();
            $_SESSION['gebuikers_id'] = $row['Id'];
            $hashed_password = $row["Password"];

            if (password_verify($password, $hashed_password)) {
                header("Location: ../index.html.php");
            }
        }
    }

    header("Location: ../pages/login_page.php?error_message=Wachtwoord of gebruikersnaam is verkeerd!");
}

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

authenticate($email, $password);