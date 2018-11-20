<?php
include "connectdb.php";
$review_t = filter_input(INPUT_POST, "review");
$review_c = filter_input(INPUT_POST, "cijfer");
if (isset($_POST['versturen'])) {
    $connection = getConnection();
    $bed = $connection->prepare("INSERT INTO review_bedrijf (BedrijfID, Tekst, Stars) VALUES ( 1 , '$review_t', '$review_c')");
    $bed->execute();
}

header("Location: ../pages/overons_page.html.php");