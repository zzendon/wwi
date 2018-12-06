<?php
include '../connectdb.php';
include '../utils.php';

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$confirmedPassword = filter_input(INPUT_POST, "confirm", FILTER_SANITIZE_STRING);

/// Create new user from the given email and password
function createNewUser($email, $password)
{
    $connection = getConnection();
    $query = $connection->prepare("
          INSERT INTO people(`FullName`, `PreferredName`, `SearchName`, `IsPermittedToLogon`, `LogonName`, `IsExternalLogonProvider`, `HashedPassword`, `IsSystemUser`, `IsEmployee`, `IsSalesperson`, `PhoneNumber`, `EmailAddress`, `LastEditedBy`, `ValidFrom`, `ValidTo`) 
          VALUES (' ', ' ', ' ', 1, '$email', 0, '$password' , 0, 0, 0, 0, '$email', '2016-05-31 23:14:00', '2016-05-31 23:14:00', '9999-12-31 23:59:59')");
    $query->execute();

    header("Location: ../../pages/login_page.php");
}

/// Generate safe password
function generateSavePassword($plainPassword)
{
    return password_hash($plainPassword, PASSWORD_BCRYPT);
}

/// Register logic
if ($password == $confirmedPassword) {
    if (!doesUserExists($email)) {
        $hashedPassword = generateSavePassword($password);
        createNewUser($email, $hashedPassword);
    } else {
        header("Location: ../../pages/register_page.php?error_message=Account bestaat al!");
    }
} else {
    header("Location: ../../pages/register_page.php?error_message=Wachtwoorden komen niet over met elkaar");
}

