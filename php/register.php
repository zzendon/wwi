<?php
include 'connectdb.php';
include 'utils.php';

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$confirmedPassword = filter_input(INPUT_POST, "confirm", FILTER_SANITIZE_STRING);

/// Create new user from the given email and password.
function createNewUser($email, $password) {
    $connection = getConnection();

    $query = $connection->prepare("INSERT INTO login (Email, Password) VALUES ('$email', '$password');");
    $query->execute();

    if ($query->errorInfo().count() == 0) {
        header("Location: ../pages/login_page.php");
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

