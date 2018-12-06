<?php
require "../libs/pdf-invoice/src/InvoicePrinter.php";

use Konekt\PdfInvoice\InvoicePrinter;

class WWIInvoice {
    private $invoice;
    private $total;
    private $totalVat;
    private $sendCosts;

    public function __construct()
    {
        $invoice = new InvoicePrinter();
        /* Header settings */
        $invoice->setLogo("../images/Kim_Helmink.png");   //logo image path
        $invoice->setColor("#007fff");      // pdf color scheme
        $invoice->setType("WWI Factuur");    // Invoice Type
        $invoice->setReference("INV-55033645");   // Reference
        $invoice->setDate(date('M dS ,Y',time()));   //Billing Date
        $invoice->setTime(date('h:i:s A',time()));   //Billing Time
        $invoice->setDue(date('M dS ,Y',strtotime('+3 months')));    // Due Date
        $invoice->setFrom(array("Wide World Importers","WWI","Campus 2, 8017 CA Zwolle","+852 129 209 291"));
        $invoice->addBadge("Payment Paid");
        $invoice->addTitle("Important Notice");
        $invoice->addParagraph("Zonder factuur kunt u niet retouneren of uw geld terug krijgen.");
        $invoice->setFooternote("Wide World Importers");
        $this->invoice = $invoice;
    }

    public function setToAddressInformation($toAddressInformation) {
        $this->invoice->setTo($toAddressInformation);
    }

    public function addItem($item, $description = "", $quantity, $vat, $price, $discount = 0) {
        $this->invoice->addItem($item,$description, $quantity, $vat, $price, $discount, ($price * $quantity) + $vat);
        $this->total += $price * $quantity;
        $this->totalVat += $vat;
    }

    public function render($invoiceName) {
        $this->sendCosts = 3.50;

        if ($this->total >= 20.00) {
            $this->sendCosts = 0.00;
        }

        $this->invoice->addTotal("Total",$this->total);
        $this->invoice->addTotal("BTW 21%", $this->totalVat);
        $this->invoice->addTotal("Verzend kosten", $this->sendCosts);
        $this->invoice->addTotal("Total due", $this->total + $this->sendCosts + $this->totalVat ,true);

        $this->invoice->render($invoiceName,'D');
    }
}