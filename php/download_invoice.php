<?php
include "./connectdb.php";
include "./wwi_invoice.php";
include "./utils.php";

$stockItemsInfo = getStockItemInfoFromSession();

function GetCustomerInformation()
{
    if (isset($_GET['customer_id']) && !empty($_GET['customer_id'])) {

        $customer_id = urldecode(filter_input(INPUT_GET, 'customer_id', FILTER_SANITIZE_STRING));

        $connection = getConnection();
        $sql = "SELECT CustomerName, DeliveryAddressLine1, ci.CityName as CityName FROM customers c JOIN cities ci ON c.DeliveryCityID = ci.CityID WHERE CustomerID = '$customer_id'";
        $query = $connection->prepare($sql);
        $query->execute();

        while ($row = $query->fetch()) {
            $customer = [
                "CustomerName" => $row["CustomerName"],
                "DeliveryAddressLine1" => $row["DeliveryAddressLine1"],
                "CityName" => $row["CityName"]
            ];

            return $customer;
        }
    }
}

function generateInvoice()
{
    global $stockItemsInfo;
    $invoice = new WWIInvoice();

    foreach ($stockItemsInfo as $key => $value) {
        $invoice->addItem($value["StockItemName"], "", $value["Quantity"], $value["Tax"], $value["Cost"], 0);
    }

    $customerInfo = GetCustomerInformation();

    $invoice->setToAddressInformation(array($customerInfo["CustomerName"], "", $customerInfo["DeliveryAddressLine1"], $customerInfo["CityName"]));
    $invoice->render("Invoice #aasdf");
}

generateInvoice();

exit;