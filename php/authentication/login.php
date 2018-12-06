<?php
include '../connectdb.php';
include '../utils.php';

/// Try to authenticate the user with the given email and password.
function authenticate($email, $password)
{
    $connection = getConnection();
    $query = $connection->prepare("SELECT PersonId, cast(HashedPassword as char) as Password FROM people where EmailAddress ='$email'");
    $query->execute();

    if ($query->rowCount()) {
        while ($row = $query->fetch()) {
            session_start();
            $_SESSION['gebruikers_id'] = $row['PersonId'];
            $hashed_password = $row["Password"];

            if (password_verify($password, $hashed_password)) {
                header("Location: ../../index.html.php");
            }
            else {
                header("Location: ../../pages/login_page.php?error_message=Wachtwoord of gebruikersnaam is verkeerd!");
            }
        }
    }
    else {
        header("Location: ../../pages/login_page.php?error_message=Wachtwoord of gebruikersnaam is verkeerd!");
    }
}

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

authenticate($email, $password);