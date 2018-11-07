﻿<?php
include '../php/connectdb.php';
include '../php/utils.php';

//kijkt naar het StockItemID wat je hebt meegegeven aan het product
if(isset($_GET['stock_item_id'])){
   $id = preg_replace('#[^0-9]#i', '',$_GET['stock_item_id']);
}
else {
    echo "no such product exist";
    exit();
}

// initialize product information.
$productInfo = getProductInformation();
$productId = $productInfo["StockItemID"];
$productNameTrimmed = $productInfo["StockItemNameTrimmed"];
$fullProductName = $productInfo["StockItemName"];
$productPrice = $productInfo["RecommendedRetailPrice"];

$itemsAvailible = getStockItemCountInArchive($id);

/// Get basic information from stockitem by stockitem id.
function getProductInformation() {
    global $id;

    $connection = getConnection();
    $pdo = $connection->prepare("SELECT StockItemID, StockItemName, RecommendedRetailPrice FROM stockitems s WHERE StockItemID ='$id'");
    $pdo->execute();

    $stockItemsInfo = array();

    while ($row = $pdo->fetch()) {
        $product_name = remove_color_from_stockitem($row["StockItemName"]);

        $stockItemsInfo["StockItemID"] = $row["StockItemID"];
        //foto row is blob file werkt nog niet, we gebruiken nu een test foto
        //$photo = $row["Photo"];
        $stockItemsInfo["StockItemNameTrimmed"] = $product_name;
        $stockItemsInfo["StockItemName"] = $row["StockItemName"];
        $stockItemsInfo["RecommendedRetailPrice"] = $row["RecommendedRetailPrice"];

    }


    return $stockItemsInfo;
}

/// Get available colors by product name.
function getAvailableColors() {
    global $productNameTrimmed;

    $connection = getConnection();


    $col = $connection->prepare("SELECT c.ColorName , c.ColorID FROM colors c LEFT JOIN stockitems s ON s.ColorID = c.ColorID WHERE StockItemName LIKE '$productNameTrimmed%'");
    $col->execute();

    $colors = array();

    while ($row = $col->fetch()) {
        $color_name = $row["ColorName"];
        $color_id = $row["ColorID"];

        $color_item = [
            "ColorID" => $color_id,
            "ColorName" => $color_name
        ];
        $colors[$color_id] = $color_item;
    }

    return $colors;
}

/// Get specific count of stock items in archive.
function getStockItemCountInArchive($id)
{
    $connection = getConnection();
    $tal = $connection->prepare("SELECT count(*) as aantal, StockItemID FROM stockitems_archive WHERE StockItemID ='$id'");
    $tal->execute();

    while ($row = $tal->fetch()) {
        $itemsAvailible = $row["aantal"];

        return $itemsAvailible;
    }
}


?>
<div class="row" style="margin-top: 100px">
    <div class="col-md-7">
        <div class="product col-md-3 service-image-left">
                <img id="item-display" src="http://placehold.it/400x300" alt=""></img>
        </div>
    </div>

    <div class="col-md-4">
        <div class="product-title"> <?php echo $productNameTrimmed ?></div>
        <div class="product-desc"> <?php echo $fullProductName ?></div>
        <div class="product-rating"><i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star-o"></i> </div>
        <hr>
        <div class="product-price">&euro; <?php echo $productPrice ?></div>
        <h6 class="title-attr" style="margin-top:15px;" ><small>Kleur</small></h6>

        <?php
        $colorOptions = getAvailableColors();

        if(empty($colorOptions)){

        } else {
            // print all color options.
            foreach ($colorOptions as $key => $value) {
                $color = str_replace(' ', '', strtolower($value["ColorName"]));
                print ("<div class=\"attr\" style=\"width:25px;background:$color;float:left;\"></div>");
            }
        }
        ?>

        <div class="product-stock">Beschikbaar: <?php echo $itemsAvailible ?> </div>
        <hr>
        <div class="btn-group cart">
            <button type="button" class="btn btn-success">
                Toevoegen aan winkelwagen
            </button>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-12 product-info">
            <ul id="myTab" class="nav nav-tabs nav_tabs">
                <li><a href="#service-three" data-toggle="tab">REVIEWS</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="service-one">

                    <section class="container product-info">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at.
                    </section>

                </div>
                <div class="tab-pane fade" id="service-two">

                    <section class="container">

                    </section>

                </div>
                <div class="tab-pane fade" id="service-three">

                </div>
            </div>
            <hr>
        </div>
    </div>
</div>

