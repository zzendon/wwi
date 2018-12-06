<?php
include '../php/connectdb.php';
include "../php/utils.php";

if (isset($_GET['customer_id']) && !empty($_GET['customer_id'])) {
    $customer_id = urldecode(filter_input(INPUT_GET, 'customer_id', FILTER_SANITIZE_STRING));
}

function insertOrder() {
    global $customer_id;

    $connection = getConnection();

    // get highest order number
    $insertOrder = "SELECT (MAX(OrderID) + 1) as NewOrderId FROM orders";
    $query = $connection->prepare($insertOrder);
    $query->execute();

    $newOrderId = 0;
    while ($row = $query->fetch()) {
        $newOrderId = $row["NewOrderId"];
    }

    // create order
    $deliveryDate = $NewDate=Date('y:m:d', strtotime("+3 days"));
    $currentDate = date('y:m:d');

   $insertOrder = "INSERT INTO `orders` (`OrderId`, `CustomerID`, `SalespersonPersonID`, `ContactPersonID`, `OrderDate`, `ExpectedDeliveryDate`, `IsUndersupplyBackordered`, `PickingCompletedWhen`, `LastEditedBy`, `LastEditedWhen`) 
            VALUES ('$newOrderId', '$customer_id', '0', '0', '$currentDate', '$deliveryDate', '', 0, '0', '2018-12-05 00:00:00')";

    $query = $connection->prepare($insertOrder);
    $query->execute();

    insertOrderLines($newOrderId);
}

function insertOrderLines($orderId) {

    $connection = getConnection();
    $stockItems = getStockItemInfoFromSession();

    foreach ($stockItems as $key => $value) {
        $stockItemId = $value["StockItemID"];
        $stockItemName = $value["StockItemName"];
        $packageId = $value["UnitPackageID"];
        $quantity = $value["Quantity"];
        $tax = $value["Tax"];
        $costs = $value["Cost"];

        // get highest order number
        $selectNewOrderLineID = "SELECT (MAX(OrderLineID) + 1) as NewOrderLineID FROM orderlines";
        $query = $connection->prepare($selectNewOrderLineID);
        $query->execute();

        $newOrderLineId = 0;
        while ($row = $query->fetch()) {
            $newOrderLineId = $row["NewOrderLineID"];
        }

        $insertOrderLine = "INSERT INTO `orderlines` (`OrderLineID`, `OrderID`, `StockItemID`, `Description`, `PackageTypeID`, `Quantity`, `UnitPrice`, `TaxRate`, `PickedQuantity`, `LastEditedBy`, `LastEditedWhen`) 
            VALUES ('$newOrderLineId', '$orderId', '$stockItemId', '$stockItemName', '$packageId', '$quantity', '$costs', '$tax', '1', '1', '2018-12-05 00:00:00')";

        $query = $connection->prepare($insertOrderLine);
        $query->execute();
    }
}

insertOrder();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Wide World Importers</title>

    <link rel="import" href="../includes/imports.html">

    <style>
        .footer {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div w3-include-html="../includes/nav_bar.html.php?current=confirmation"></div>
        </div>
    </div>

    <div class="row" style="margin-top: 120px; text-align: center">
        <div class="col-md-12">
        <h1 style=""> U heeft succesvol betaald!</h1>
        </div>
        <div class="col-md-2"></div>
            <div class="col-4 text-right">
                <form method="POST" action="../php/download_invoice.php?<?php  if(!empty($customer_id)) { echo ("customer_id=".$customer_id); }?>">
                    <button name="submit"  type="submit" class="btn btn-success" >Download Factuur</button>
                </form>
            </div>
            <div class="col-4 text-left">
                <form method="POST" action="../php/shopping_cart/confirm_handler.php">
                    <button name="submit"  type="submit" class="btn btn-success" >Terug naar webshop</button>
                </form>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row footer" >
        <div class="col-md-12">
            <div w3-include-html="../includes/footer.html"></div>
        </div>
    </div>
<script>
    includeHTML();
</script>
</body>

<!DOCTYPE html>

<html>