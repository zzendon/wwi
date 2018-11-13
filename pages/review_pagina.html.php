<!doctype html> 

<?php
    include './php/connectdb.php';
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">   
    <link rel=¨stylesheet¨ type="css" href="css.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Review pagina</title>
  </head>
   
    <body>
        <div class="container">
            <div class="row" style="margin-top:40px;">
                <div class="col-md-6">
                    <div class="well well-sm">
<!--Review box--> 
                            <h1>Review</h1>                      
                        <div class="row" id="review-box">
                            <div class="col-md-12">
                                <form action="review_pagina.html.php" method="get" onsubmit="alert('Bedankt voor uw review!')">
                                <label for="review">Schrijf een korte review over ....</table>
                                <textarea class="form-control animated" cols="65" id="Review" name="Review" placeholder="Type hier u review..." rows="4"></textarea>
<!-- Cijfer-->              
                                    <div class="form-group" id="cijfer">
                                        <label for="Cijfer">Geeft een cijfer aan het product</label>
                                        <select class="form-control" id="Cijfer" name="Cijfer" required>
                                            <option value="">Cijfer...</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                        <div class="invalid-feedback">Example invalid custom select feedback</div>
                                    </div>
<!--Submit knop-->  
                                        <button class="btn btn-success mb-2" type="submit" name="Versturen">Versturen</button>
                                        <?php
                                            $review_tekst = filter_input(INPUT_GET, "Review");
                                            $review_cijfer = filter_input(INPUT_GET, "Cijfer");
                                            $connection = getConnection();
                                            print($review_tekst);
                                            print ($review_tekst);
                                            $rev = $connection->prepare("INSERT INTO Review (StockItemID, tekst, cijfer) VALUES (22, '$review_tekst', '$review_cijfer')");
                                            $rev->execute(); 
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>          
                </div>
            </div>
        </div>

    </body>
</html>