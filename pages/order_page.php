<?php

include "../php/connectdb.php";
session_start();

$costs = 0;
$customerId = 0;

if (isset($_GET['cost']) && !empty($_GET['cost'])) {
    $costs = urldecode(filter_input(INPUT_GET, 'cost', FILTER_SANITIZE_STRING));
}

function SafeCustomerData()
{
    global $customerId;

    $connection = getConnection();

    $customerName = "";
    $customerPhoneNumber = 0;
    $customerWebsiteURL = "";
    $customerDeliveryAddressLine1 = "";
    $customerDeliveryAddressLine2 = "";
    $deliveryPostalCode = "";
    $customerEmail = "";

    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $customerName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

    }
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $customerEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['nummber']) && !empty($_POST['nummber'])) {
        $customerPhoneNumber = filter_input(INPUT_POST, 'nummber', FILTER_SANITIZE_STRING);

    }
    if (isset($_POST['website']) && !empty($_POST['website'])) {
        $customerWebsiteURL = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_STRING);

    }
    if (isset($_POST['address1']) && !empty($_POST['address1'])) {
        $customerDeliveryAddressLine1 = filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_STRING);

    }
    if (isset($_POST['address2']) && !empty($_POST['address2'])) {
        $customerDeliveryAddressLine2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_STRING);
    }
    if (isset($_POST['postcode']) && !empty($_POST['postcode'])) {
        $deliveryPostalCode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING);
    }

    $sql = "SELECT (MAX(CustomerId) + 1) as NewCustomerId FROM customers";
    $query = $connection->prepare($sql);
    $query->execute();

    while ($row = $query->fetch()) {
        $customerId = $row["NewCustomerId"];
    }

    if ($customerId != 0) {
        $sql = "INSERT INTO `customers` (CustomerID,
          `CustomerName`, `BillToCustomerID`, `CustomerCategoryID`, `BuyingGroupID`, `PrimaryContactPersonID`, 
          `AlternateContactPersonID`, `DeliveryMethodID`, `DeliveryCityID`, `PostalCityID`, `CreditLimit`, 
          `AccountOpenedDate`, `StandardDiscountPercentage`, `IsStatementSent`, `IsOnCreditHold`, `PaymentDays`, 
          `PhoneNumber`, `FaxNumber`, `DeliveryRun`, `RunPosition`, `WebsiteURL`, 
          `DeliveryAddressLine1`, `DeliveryAddressLine2`, `DeliveryPostalCode`, `DeliveryLocation`, `PostalAddressLine1`, 
          `PostalAddressLine2`, `PostalPostalCode`, `LastEditedBy`, `ValidFrom`, `ValidTo`) 
        VALUES ('$customerId',
           '$customerName', '1', '1', NULL, '1', 
            NULL, '1', '1', '1', NULL, 
            '2018-12-05', '0', '0', '0', '0', 
            '$customerPhoneNumber', '', NULL, NULL, '$customerWebsiteURL', 
            '$customerDeliveryAddressLine1', '$customerDeliveryAddressLine2', '$deliveryPostalCode', NULL, '',
             NULL, '0', '0', '2018-12-05 00:00:00', '2018-12-29 00:00:00')";

        $query = $connection->prepare($sql);

        $query->execute();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // check if post is form form.
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        SafeCustomerData();
        header("Location: ../libraries/mollie-api-php/examples/payments/create-payment.php?cost=$costs&customer_id=$customerId");
        exit;
    }
}
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
</head>

<body>
<div w3-include-html="../includes/nav_bar.html.php?current=order"></div>
<div class="row" style="margin-top: 120px">
    <div class="container">
        <div class="col-md-12" style="margin-bottom: 10%">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Uw gegevens</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="./order_page.php?customer_id=<?php echo $customerId ?>&cost=<?php echo $costs ?>"
                                  method="post">
                                <div class="form-group row">
                                    <label for="name" class="col-4 col-form-label">Voornaam</label>
                                    <div class="col-8">
                                        <input id="name" name="name" placeholder="First Name" class="form-control here"
                                               type="text" required="required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-4 col-form-label">Email*</label>
                                    <div class="col-8">
                                        <input id="email" name="email" placeholder="Email" class="form-control here"
                                               required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="number" class="col-4 col-form-label">Nummer*</label>
                                    <div class="col-8">
                                        <input id="text" name="nummber" placeholder="Nummer" class="form-control here"
                                              pattern="^[0-9]*$" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="website" class="col-4 col-form-label">Website</label>
                                    <div class="col-8">
                                        <input id="website" name="website" placeholder="website"
                                               class="form-control here" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address1" class="col-4 col-form-label">Address 1</label>
                                    <div class="col-8">
                                        <input id="address1" name="address1" placeholder="Address 1"
                                               class="form-control here" type="text" required="required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address2" class="col-4 col-form-label">Address 2</label>
                                    <div class="col-8">
                                        <input id="address2" name="address2" placeholder="Address 2"
                                               class="form-control here" type="text" required="required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address2" class="col-4 col-form-label">Post Code</label>
                                    <div class="col-8">
                                        <input id="postcode" name="postcode" placeholder="Postcode"
                                               class="form-control here" type="text" required="required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-0 col-8">
                                        <button name="submit" type="submit" class="btn btn-primary">Sla veranderingen
                                            op
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-top: 15Ø%" w3-include-html="../includes/footer.html"></div>
<script>
    includeHTML();
</script>
</body>
</html>