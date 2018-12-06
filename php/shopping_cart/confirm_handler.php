<?php
include "../connectdb.php";

session_start();


function deleteSessionShoppingCartItems()
{
    $connection = getConnection();

    foreach ($_SESSION["shopping_cart"] as $id => $aantal) {
        // Haalt de gekochte items uit de voorrraad
        $query = "UPDATE stockitemholdings SET QuantityonHand = QuantityonHand -$aantal WHERE StockItemID = $id";
        $pro = $connection->prepare($query);
        $pro->execute();

        // Verwijderd het gekochte item uit de winkelmand
        unset($_SESSION["shopping_cart"][$id]);
    }

    header("Location: ../../index.html.php");
}

deleteSessionShoppingCartItems();