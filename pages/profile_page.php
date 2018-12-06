<?php

include "../php/connectdb.php";
session_start();

$fullName = "";
$email = "";
$logonName = "";

if (isset($_SESSION['gebruikers_id']) && !empty($_SESSION['gebruikers_id'])) {
    $gebruikers_id = $_SESSION["gebruikers_id"];

    $selectInformation = "SELECT * FROM people WHERE PersonID = '$gebruikers_id'";

    $connection = getConnection();

    $pro = $connection->prepare($selectInformation);

    $pro->execute();

    while ($row = $pro->fetch()) {
        $fullName = $row["FullName"];
        $email = $row["EmailAddress"];
        $logonName = $row["LogonName"];
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
                            <form action="./order_page.php?customer_i"
                                  method="post">
                                <div class="form-group row">
                                    <label for="name" class="col-4 col-form-label">Voornaam</label>
                                    <div class="col-8">
                                        <input id="name" name="name" placeholder="First Name" class="form-control here"
                                               type="text" required="required" value="<?php echo $fullName ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-4 col-form-label">Email*</label>
                                    <div class="col-8">
                                        <input id="email" name="email" placeholder="Email" class="form-control here"
                                               required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" type="text" value="<?php echo $email ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-4 col-form-label">LoginNaam</label>
                                    <div class="col-8">
                                        <input id="name" name="name" placeholder="Login Naam" class="form-control here"
                                               type="text" required="required" value="<?php echo $logonName ?>" readonly>
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