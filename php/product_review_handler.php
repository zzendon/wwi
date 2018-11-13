<?php
include "connectdb.php";
$review_t = filter_input(INPUT_POST, "review");
$stockitemid = filter_input(INPUT_GET, "stock_item_id");
$review_c = filter_input(INPUT_POST, "cijfer");
if (isset($_POST['versturen'])) {
    $connection = getConnection();
    $rev = $connection->prepare("INSERT INTO review (StockItemID, Tekst, Stars) VALUES ('$stockitemid', '$review_t', '$review_c')");
    $rev->execute();
}

header("Location: ../index.html.php?stock_item_id=$stockitemid");