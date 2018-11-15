<?php
include "../php/connectdb.php";
function getReviews(){

    $connection = getConnection();
    $rev = $connection->prepare("SELECT Tekst, Stars, ReviewBedrijfID FROM review_bedrijf where BedrijfID =1");
    $rev->execute();

    $reviews = array();

    while ($row = $rev->fetch()) {
        $reviewsTekst = $row["Tekst"];
        $reviewsStars = $row["Stars"];
        $reviewsID = $row["ReviewBedrijfID"];

        $reviews_item = [
            "ReviewTekst" => $reviewsTekst,
            "ReviewStars" => $reviewsStars
        ];
        $reviews[$reviewsID] = $reviews_item;
    }
    return $reviews;
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
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.html.php">Wide World Importers > Over ons </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.html.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Account</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../pages/overons_page.html.php">Over ons</a>
                    <span class="sr-only">(current)</span>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="about-section paddingTB60">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-6">
                <div class="about-title clearfix">
                    <h1>Over<span> Ons</span></h1>
                    <h3>Wide World Importers</h3>
                    <p class="about-paddingB">Wij zijn WWI. We zijn trots op onze producten en geloven in kwaliteit. In ieder huis vindt een
                    product van WWI zijn thuis. Ondanks onze grootte zien klanten ons als kleinschalig en
                    betrokken. Persoonlijk klantcontact staat bij ons hoog in het vaandel</p>
                    <img class="d-block img-fluid rounded mx-auto" src="../images/pand.png"/><br>    
                </div>      
            </div>
            <div class="col-sm">
                <br><b>Contactgegevens:</b><br/>
                Wide World Importers, <br/>
                Campus 2, 8017 CA Zwolle<br/>
                Telefoon: +852 129 209 291<br/>
                Mail: <a href="mailto:info@wwi.com">info@wwi.com</a><br/><br/>

                <div class="about-icons"> 
                    <a href="https://www.facebook.com/"><i id="social-fb" class="fa fa-facebook-square fa-3x social"></i></a>
                    <a href="https://twitter.com/"><i id="social-tw" class="fa fa-twitter-square fa-3x social"></i></a>
                    <a href="https://instagram.com"><i id="social-in" class="fa fa-instagram fa-3x social"></i></a>
                    <a href="mailto:info@wwi.com"><i id="social-em" class="fa fa-envelope-square fa-3x social"></i></a>   
                </div>
            </div>
        </div>

<hr>
    <div class="container-fluid">
        <div class="col-md-7 product-info">
            <ul id="myTab" class="nav nav-tabs nav_tabs">
                <li><a href="#service-three" data-toggle="tab">REVIEWS OVER WWI</a></li>
            </ul>
            <form method="POST" action="../php/bedrijf_review_handler.php" onsubmit="alert('Bedankt voor uw review!')">
                <label for="review">Schrijf een korte review over Wide World Importers</label>
                <textarea class="form-control animated" cols="65" id="review" name="review" placeholder="Type hier u review..." rows="4"></textarea>
                <!-- Cijfer-->
                <div class="form-group" id="cijfer">
                    <label for="Cijfer">Geeft een cijfer aan het product</label>
                    <select class="form-control" id="cijfer" name="cijfer" required>
                        <option value="">Geef een cijfer</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <div class="invalid-feedback">Example invalid custom select feedback</div>
                </div>
                <!--Submit knop-->
                <button class="btn btn-success mb-2" type="submit" name="versturen" id="versturen">Versturen</button>
            </form>
        </div>
        <div class="col-md-7">
        <?php
        $getReview = getReviews();

        if (empty($getReview)) {
            print("Geen reviews over Wide World Importers");
        } else {
            foreach ($getReview as $key => $value) {
                $stars = $value['ReviewStars'];
                for ($i = 0; $i < 5; $i++) {
                    if ($i < $stars) {
                        echo "<i class=\"fa fa-star gold\"></i>";
                    } else {
                        echo "<i class=\"fa fa-star-o\"></i>";
                    }


                }
                print ("<br>" . $value['ReviewTekst'] . "<br><hr>");
            }

        }
        ?>
        </div>
    </div>
</div>




<!-- Footer -->
<footer class="py-5 bg-dark">
<div class="container">
        <div class="row">
        <div class="col-sm text-white">
                <br><b>Contactgegevens:</b><br/>
                Wide World Importers, <br/>
                Campus 2, 8017 CA Zwolle<br/>
                Telefoon: +852 129 209 291<br/>
                Mail: <a href="mailto:info@wwi.com">info@wwi.com</a><br />
        </div>
            <div class="col-sm text-white">
                <br><b>Social Media:</b><br/>
                <a href="https://www.facebook.com/"><i id="social-fb" class="fa fa-facebook-square fa-3x social"></i></a>
                <a href="https://twitter.com/"><i id="social-tw" class="fa fa-twitter-square fa-3x social"></i></a>
                <a href="https://instagram.com"><i id="social-in" class="fa fa-instagram fa-3x social" ></i></a>                    
                <a href="mailto:info@wwi.com"><i id="social-em" class="fa fa-envelope-square fa-3x social"></i></a>
           </div>
        </div>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="./vendor/jquery/jquery.min.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>