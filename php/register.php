<?php
include 'connectdb.php';

$email = filter_input(INPUT_POST, "email");
$password = filter_input(INPUT_POST, "password");
$confirmedPassword = filter_input(INPUT_POST, "confirm");

/// Checks if user exists in database.
function doesUserExists($email) {
    $connection = getConnection();
    $query = $connection->prepare("SELECT Id FROM login where Email ='$email'");
    $query->execute();

    if ($query->rowCount() == 0) {
        return false;
    }

    return true;
}

/// Create new user from the given email and password.
function createNewUser($email, $password) {
    $connection = getConnection();

    $query = $connection->prepare("INSERT INTO login (Email, Password) VALUES ('$email', '$password');");
    $query->execute();

    if ($query->errorInfo().count() == 0) {
        header("Location: ../login.html.php");
    }
}

/// Generate safe password.
function generateSavePassword($plainPassword) {
    return password_hash($plainPassword, PASSWORD_BCRYPT);
}

if ($password == $confirmedPassword) {
    if (!doesUserExists($email)) {
        $hashedPassword = generateSavePassword($password);
        createNewUser($email, $hashedPassword);
    }else{
        header("Location: ../pages/register_page.php?error_message=Account bestaat al!");
    }
}
else {
    header("Location: ../pages/register_page.php?error_message=Wachtwoorden komen niet over met elkaar");
}

