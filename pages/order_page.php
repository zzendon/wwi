<?php
include "../php/connectdb.php";
require "../libs/pdf-invoice/src/InvoicePrinter.php";

use Konekt\PdfInvoice\InvoicePrinter;

function getStockItemInformation

$invoice = new InvoicePrinter();

/// Get basic stock item information.
function getCategoriesStockItemInfo($category_id)
{
    global $search;

    print "search: " . $search;
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
}
//Wide World Importers,
//Campus 2, 8017 CA Zwolle
//Telefoon: +852 129 209 291
//Mail: info@wwi.com

/* Header settings */
$invoice->setLogo("../images/Kim_Helmink.png");   //logo image path
$invoice->setColor("#007fff");      // pdf color scheme
$invoice->setType("WWI Factuur");    // Invoice Type
$invoice->setReference("INV-55033645");   // Reference
$invoice->setDate(date('M dS ,Y',time()));   //Billing Date
$invoice->setTime(date('h:i:s A',time()));   //Billing Time
$invoice->setDue(date('M dS ,Y',strtotime('+3 months')));    // Due Date
$invoice->setFrom(array("Wide World Importers","WWI","Campus 2, 8017 CA Zwolle","Zwolle , 8017 CA"));
$invoice->setTo(array("Purchaser Name","Sample Company Name","128 AA Juanita Ave","Glendora , CA 91740"));

$invoice->addItem("AMD Athlon X2DC-7450","2.4GHz/1GB/160GB/SMP-DVD/VB",6,0,580,0,3480);
$invoice->addItem("PDC-E5300","2.6GHz/1GB/320GB/SMP-DVD/FDD/VB",4,0,645,0,2580);
$invoice->addItem('LG 18.5" WLCD',"",10,0,230,0,2300);
$invoice->addItem("HP LaserJet 5200","",1,0,1100,0,1100);

$invoice->addTotal("Total",9460);
$invoice->addTotal("VAT 21%",1986.6);
$invoice->addTotal("Total due",11446.6,true);

$invoice->addBadge("Payment Paid");

$invoice->addTitle("Important Notice");

$invoice->addParagraph("No item will be replaced or refunded if you don't have the invoice with you.");

$invoice->setFooternote("My Company Name Here");

$invoice->render('example1.pdf','I');
/* I => Display on browser, D => Force Download, F => local path save, S => return document as string */

//session_start();
//
//if(isset($_SESSION['gebruikers_id']) && !empty($_SESSION['gebruikers_id'])) {
//    $gebruiker_id = $_SESSION["gebruikers_id"];
//    $connection = getConnection();
//    $query = $connection->prepare("SELECT l.Email, c. FROM login l where id ='$gebruiker_id' LEFT JOIN customers c ON l.CustomerId = c.CustomerId");
//    $query->execute();
//
//    if ($query->rowCount() != 0) {
//
//        while ($row = $query->fetch()) {
//
//        }
//    }
////    "SELECT * from customers where "
//}