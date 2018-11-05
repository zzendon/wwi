<?php
include '../php/connectdb.php';


//kijkt naar het StockItemID wat je hebt meegegeven aan het product
//                    if(isset($_GET['id'])){
//                       $id = preg_replace('#[^0-9]#i', '',$_GET['StockItemID']);
//                    }
//                   else{
//                       echo "no such product exist";
//                      exit();
//                    $pdo = null;
//               }

//moet het product ophalen doormiddel van een quary
$connection = getConnection();
$pro = $connection->prepare("SELECT StockItemID, StockItemName, RecommendedRetailPrice FROM stockitems s WHERE StockItemID = 2");
$pro->execute();
    while ($row = $pro->fetch()) {
        $product_id = $row["StockItemID"];
        //foto row is blob file werkt nog niet
        //$photo = $row["Photo"];
        $product_name = $row["StockItemName"];
        $product_price = $row["RecommendedRetailPrice"];
    }

$col = $connection->prepare("select ColorName , c.ColorID from colors c left join stockitems s on s.ColorID = C.ColorID where StockItemName LIKE 'USB%'");
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
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Wide World Importers</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/shop-homepage.css" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../index.html.php">Wide World Importers</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.html.php">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Over ons</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <div class="list-group">
                    <h1 class="my-4">Categorie&euml;n</h1>
                    <a href="#" class="list-group-item">Category 1</a>
                    <a href="#" class="list-group-item">Category 2</a>
                    <a href="#" class="list-group-item">Category 3</a>
                </div>

            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="row">
                    <div class="col-sm-7"
                    <!-- alle informatie van het product -->
                    <?php
                        print("<br> <br><h3>" . $product_name . "</h3><br>");
                    ?>
                    <div class="col-sm-8">
                        <?php
                            print("<img src=\"../images/noavatar.png\" class=\"img-fluid\" alt='Test image'/>");
                            print("Product id: " . $product_id. "<br>");
                            print("Prijs €" . $product_price . "<br>");
                            if($color_name == ""){
                                print("Geen Kleur beschikbaar <br><br>");
                            } else {
                                print ("<b>Kleur(en): </b><br>");
                                foreach ($colors as $key => $value) {
                                    print ($value['ColorName'] .  "<br>");
                                }

                            }
                            ?>
                        <p>
                            <br><b>Omschrijving:</b><br>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at.
                        </p>
                    </div>
                    </div>

                <div class="row">
                    <div class="col-sm-12">
                        <br>
                        <!-- form voor het toevoegen aan winkelwagen -->
                        <form method="post">
                            <input type="image" src="../images/Winkel.png" border="0" alt="Submit" style="width: 75px; height: 75px;"/>
                            Toevoegen aan winkelwagen
                        </form>
                        <!-- php code voor hoeveel er nog beschikbaar is -->
                        <?php
                        print("Nog maar: 4 beschikbaar")
                        ?>

                    </div>
                </div>

                </div>

                </div>
                <!-- /.row -->

            </div>
            <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Wide World Importers</p>
        </div>
        <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>