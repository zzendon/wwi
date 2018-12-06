<?php

/// this filters an multidimensional array by removing duplicates.
function unique_multidim_array($array, $key)
{
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach ($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

// replace (COLOR) with empty string, colors are show as options for product and not as a product on its own.
function remove_color_from_stockitem($stock_item_name)
{
    return preg_replace('/\((.*?)\)/', '', $stock_item_name);
}

/// Checks if user exists in database.
function doesUserExists($email)
{
    $connection = getConnection();
    $query = $connection->prepare("SELECT Id FROM people where EmailAddress ='$email'");
    $query->execute();

    if ($query->rowCount() == 0) {
        return false;
    }

    return true;
}

// Get basic stock item information from shopping cart session.
function getStockItemInfoFromSession()
{
    session_start();
    $product_ids = array();
    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as $index => $value) {
            array_push($product_ids, $index);
        }
    }

    $connection = getConnection();

    $imploded_ids = implode(',', $product_ids);

    $query = "SELECT StockItemID, StockItemName, RecommendedRetailPrice as Cost, TaxRate as Tax, UnitPackageID FROM stockitems  WHERE StockItemID IN ($imploded_ids)";

    $pro = $connection->prepare($query);
    $pro->execute();

    $stockItemsInfo = array();
    while ($row = $pro->fetch()) {
        $id = $row["StockItemID"];
        $product_name = $row["StockItemName"];
        $costs = $row["Cost"];
        $tax = $row["Tax"];

        $item = [
            "StockItemID" => $id,
            "StockItemName" => $product_name,
            "Cost" => $costs,
            "Tax" => $tax,
            "Quantity" => $_SESSION["shopping_cart"][$id],
            "UnitPackageID" => $row["UnitPackageID"]
        ];

        $stockItemsInfo[$id] = $item;
    }

    return $stockItemsInfo;
}