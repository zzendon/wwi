<?php 
    // include sql connect en php session file
    include '../php/connectdb.php';
    //include '../php/php_session.php';
    $conn = getConnection();

    // Shopping vars
    $total_cost = 0;
    $total_cost_btw = 0;
    $send_cost = 0.00;
    $product_id = array();
    $product_id[1] = 2;
    $product_id[3] = 1;
?>
<h1 class="my-4">Winkelmand</h1>
<div class="list-group">
    <?php  
        foreach($product_id as $index => $value)
        {
            $query = "SELECT StockItemID, StockItemName, RecommendedRetailPrice * $value as Cost, TaxRate * $value as Tax FROM stockitems  WHERE StockItemID = $index";
            $result = $conn->query($query);

            $pro = $conn->prepare($query);
            $pro->execute();
                    
            while ($row = $pro->fetch())
            {
                $item_name = $row["StockItemName"];
                $item_id = $row["StockItemID"];
                $cost = $row["Cost"];
                $tax = $row["Tax"];
                
                echo '<div class="row">
                        <div class="col-12 col-sm-12 col-md-2 text-center">
                                <img class="img-responsive" src="http://placehold.it/120x80" alt="prewiew" width="120" height="80">
                        </div>
                        <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
                            <h4 class="product-name"><strong> '. $item_name .'  </strong></h4>
                            <h4>
                                <small>Product beschrijving</small>
                            </h4>
                        </div>
                        <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
                            <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                                <h6><strong> &#8364; '. $cost .' <span class="text-muted"></span></strong></h6>
                            </div>
                            <div class="col-4 col-sm-4 col-md-4">
                                <div class="quantity">
                                    <button type="button" onClick="" class="btn btn-success pull-right">+</button>
                                    <input type="number" step="1" max="99" min="1" value="'. $value .'" title="Qty" class="qty"
                                           size="4">
                                    <input type="button" value="-" class="btn btn-success pull-right" style="width:35px">
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 text-right">
                                <button type="button" class="btn btn-outline-danger btn-xs">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- END PRODUCT -->';
                    $total_cost += $cost;
                    $total_cost_btw += $tax;
            }
        }
        $total_product = $total_cost - $total_cost_btw;
    ?>
</div>
<!-- The price and checkout -->
<div class="btn btn-success pull-right" style="margin: 10px">
    <div class="pull-right" style="margin: 5px">
        Totaal: <b> &#8364; <?php echo number_format($total_cost, 2); ?></b>
        <a href="" class="card-header bg-dark text-light">Betalen</a>
        <br> <br> details kosten: <br>
        Totale product kosten: <b> &#8364; <?php echo number_format($total_product, 2); ?></b> <br>
        Totale btw kosten: <b> &#8364; <?php echo number_format($total_cost_btw, 2); ?></b> <br>
        Verzendkosten: <b> &#8364; <?php echo number_format($send_cost, 2); ?></b> <br>
    </div>
</div>