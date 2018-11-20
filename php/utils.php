<?php

/// this filters an multidimensional array by removing duplicates.
function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
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
function doesUserExists($email) {
    $connection = getConnection();
    $query = $connection->prepare("SELECT Id FROM login where Email ='$email'");
    $query->execute();

    if ($query->rowCount() == 0) {
        return false;
    }

    return true;
}