<?php
include '../php/connectdb.php';
include '../php/utils.php';


/// Get basic stock item information.
function getCategoriesStockItemInfo($categorie_id) {
    $connection = getConnection();

    $pro = $connection->prepare(
        "SELECT s.StockItem" . "Id, s.StockItemName, s.RecommendedRetailPrice FROM stockitems s 
           JOIN stockitemstockgroups sg ON s.StockItemId = sg.StockItemId
           WHERE sg.StockGroupID=". $categorie_id);

    $pro->execute();

    $stockItemsInfo = array();
    while ($row = $pro->fetch()) {
        $id = $row["StockItemId"];
        $product_name = $row["StockItemName"];
        $product_price = $row["RecommendedRetailPrice"];

        $product_name = remove_color_from_stockitem($product_name);

        $item = [
            "StockItemId" => $id,
            "StockItemName" => $product_name,
            "RecommendedRetailPrice" => $product_price,
        ];

        $stockItemsInfo[$id] = $item;
    }

    // filter only unique products because we filtered (COLOR) from stock item name there are now some duplicates.
    $result = unique_multidim_array($stockItemsInfo, "StockItemName" );

    $connection = null;

    return $result;
}
?>
<div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <img class="d-block img-fluid" src="./images/moc_actie.png" alt="Second slide">
        </div>
        <div class="carousel-item">
            <img class="d-block img-fluid" src="./images/banaan_usb.png" alt="Second slide">
        </div>
        <div class="carousel-item">
            <img class="d-block img-fluid" src="./images/usb_actie.png" alt="Third slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="row">
    <?php
    $categorie_id = filter_input(INPUT_GET, 'categorie_id', FILTER_SANITIZE_SPECIAL_CHARS);

    $items = getCategoriesStockItemInfo($categorie_id);

    foreach ($items as $key => $value) {
        ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <a href="index.html.php?stock_item_id=<?php echo $value['StockItemId'] ?>"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="index.html.php?stock_item_id=<?php echo $value['StockItemId'] ?>"><?php echo $value['StockItemName'] ?></a>
                    </h4>
                    <h5>€ <?php echo $value['RecommendedRetailPrice'] ?></h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Amet numquam aspernatur!</p>
                </div>
                <div class="card-foo ter">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<!-- /.row -->