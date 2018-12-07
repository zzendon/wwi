<?php
include '../php/connectdb.php';
include '../php/utils.php';

const PRODUCTS_PER_PAGE = 9;

$search = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = urldecode(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING));
}

$categorie_id = filter_input(INPUT_GET, 'categorie_id', FILTER_SANITIZE_SPECIAL_CHARS);
$page = intval(filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS));
$stockitems = getCategoriesStockItemInfo($categorie_id);
$pages = getPages($stockitems);

// if page is to low stay at lowest page if page is to high stay at highest page.
if ($page >= count($pages) - 1) {
    $page = count($pages) - 2;
} else if (empty($page) && count($pages) != 0) {
    $page = 0;
} else if ($page <= 0) {
    $page += 1;
}

// Get the number of pages for stockitems.
// This will always get the page count rounded up.
function getPageCount($stockItemCount)
{
    $remainder = $stockItemCount % PRODUCTS_PER_PAGE > 0 ? 1 : 0;
    $pages_count = ($stockItemCount / PRODUCTS_PER_PAGE) + $remainder;

    return ceil($pages_count);
}

// This will divide the given stockitems over the different pages.
// For example you will get the following array back.
// pages [
//  page 1 = [
//      stockitem 1,
//      stockitem 2,
//      stockitem 3,
// ]
//  page 2 = [
//      stockitem 4,
//      stockitem 5,
//      stockitem 6,
// ]
//]
function getPages($stockitems)
{
    $pages = array();

    $stockitem_count = count($stockitems);
    $pages_count = getPageCount($stockitem_count);

    for ($i = 0; $i < $pages_count; $i++) {
        // get start end pos in buffer
        $start_pos = $i * PRODUCTS_PER_PAGE;
        $pages[$i] = array_slice($stockitems, $start_pos, PRODUCTS_PER_PAGE);
    }

    return $pages;
}

/// Get basic stock item information.
function getCategoriesStockItemInfo($category_id)
{
    global $search;

    $connection = getConnection();

    $sql = "SELECT s.StockItemId, s.StockItemName, s.RecommendedRetailPrice, AVG(r.Stars) FROM stockitems s 
           JOIN stockitemstockgroups sg ON s.StockItemID = sg.StockItemId
           LEFT JOIN review r ON r.StockItemID = s.StockItemID
           WHERE sg.StockGroupID='$category_id' AND s.StockItemName LIKE '%$search%'
           GROUP BY s.StockItemID";

    $pro = $connection->prepare($sql);

    $pro->execute();

    $stockItemsInfo = array();
    while ($row = $pro->fetch()) {
        $id = $row["StockItemId"];
        $product_name = $row["StockItemName"];
        $product_price = $row["RecommendedRetailPrice"];
        $stars = $row["AVG(r.Stars)"];

        $product_name = remove_color_from_stockitem($product_name);

        $item = [
            "StockItemId" => $id,
            "StockItemName" => $product_name,
            "RecommendedRetailPrice" => $product_price,
            "Stars" => $stars,
        ];

        $stockItemsInfo[$id] = $item;
    }

    // filter only unique products because we filtered (COLOR) from stock item name there are now some duplicates.
    $result = unique_multidim_array($stockItemsInfo, "StockItemName");

    $connection = null;

    return $result;
}

?>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="./images/usb_actie.png" alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="./images/moc_actie.png" alt="Second slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="./images/banaan_usb.png" alt="Third slide">
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
    <div class="col-md-12">
        <!-- pagination --->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a class="page-link" aria-label="Previous"
                       onclick="previousProductPage(<?php echo $categorie_id ?>, <?php echo $page ?>)">Previous</a>
                </li>
                <?php
                for ($i = 0; $i < count($pages) - 1; $i++) {
                    $pageIndex = $i + 1;

                    if ($page == $i) {

                        echo "  
                    <li class=\"page-item active\">
                        <a class=\"page-link\" href=\"#\">$pageIndex<span class=\"sr-only\">(current)</span></a>
                    </li>";
                    } else {
                        echo " <li class=\"page-item\"><a class=\"page-link\" href=\"index.html.php?categorie_id=$categorie_id&page=$i\">$pageIndex</a></li>";
                    }
                }
                ?>
                <li class="page-item"><a class="page-link" href="#"
                                         onclick="nextProductPage(<?php echo $categorie_id ?>, <?php echo $page ?>)">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- stock items --->
<div class="row">
    <div class="col-md-3" w3-include-html="./pages/category_page.php"></div>
    <div style="margin-top: 10px" class="col-md-9">
        <div class="row">
            <?php
            if (array_key_exists($page, $pages)) {
                $items = $pages[$page];

                foreach ($items as $key => $value) {
                    ?>
                    <!-- stock item --->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-30">
                            <a href="index.html.php?stock_item_id=<?php echo $value['StockItemId'] ?>"><img
                                        class="card-img-top"
                                        <?php
                                        if ($key == 0){
                                            echo "src='images/test1.jpg'";
                                        }
                                        else{
                                            echo "src='http://placehold.it/700x400'";
                                        }
                                        ?>

                                        alt=""></a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="index.html.php?stock_item_id=<?php echo $value['StockItemId'] ?>"><?php echo $value['StockItemName'] ?></a>
                                </h4>
                                <h5>€ <?php echo $value['RecommendedRetailPrice'] ?></h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Amet numquam aspernatur!</p>
                            </div>
                            <div class="card-foo ter">
                                <small class="text-muted">
                                    <?php
                                    $stars = $value["Stars"];
                                    for ($i = 0; $i < 5; $i++) {
                                        if ($i < $stars) {
                                            echo "<i class=\"fa fa-star gold\"></i>";
                                        } else {
                                            echo "<i class=\"fa fa-star-o\"></i>";
                                        }
                                    }
                                    ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>