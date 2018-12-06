<?php
include "../connectdb.php";

$review_text = filter_input(INPUT_POST, "review", FILTER_SANITIZE_STRING);
$review_stars = filter_input(INPUT_POST, "cijfer", FILTER_SANITIZE_STRING);

if (isset($_POST['versturen'])) {
    $connection = getConnection();
    $bed = $connection->prepare("INSERT INTO review_bedrijf (BedrijfID, Tekst, Stars) VALUES ( 1 , '$review_text', '$review_stars')");
    $bed->execute();
}

header("Location: ../../pages/overons_page.html.php");