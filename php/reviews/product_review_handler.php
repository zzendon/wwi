<?php
include "../connectdb.php";

$review_text = filter_input(INPUT_POST, "review", FILTER_SANITIZE_STRING);
$stockitem_id = filter_input(INPUT_GET, "stock_item_id", FILTER_SANITIZE_STRING);
$review_stars = filter_input(INPUT_POST, "cijfer", FILTER_SANITIZE_STRING);

if (isset($_POST['versturen'])) {
    $connection = getConnection();
    $rev = $connection->prepare("INSERT INTO review (StockItemID, Tekst, Stars) VALUES ('$stockitem_id', '$review_text', '$review_stars')");
    $rev->execute();
}

header("Location: ../../index.html.php?stock_item_id=$stockitem_id");