<?php
session_start();

if (isset($_SESSION['gebruikers_id']) && !empty($_SESSION['gebruikers_id'])) {
    unset($_SESSION['gebruikers_id']);
}

header("Location: ../../index.html.php");