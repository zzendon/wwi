<div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-list"></i> Categories</div><ul class="list-group category_block">
    <?php
    include '../php/connectdb.php';
    $conn = getConnection();
    $categories = array("Nieuwe items", "Kleding", "Mokken", "T-shirts", "Nieuwe luchtmaatschappijen", "Nieuwe gegevensverwerking", "Niewe USB's", "Schoenen", "Speelgoed", "Verpakkings materiaal");
    $query = "SELECT StockGroupID, StockGroupName FROM stockgroups ORDER BY StockGroupID";
    $result = $conn->query($query);

    $pro = $conn->prepare($query);
    $pro->execute();
    while ($row = $pro->fetch()) {
        $group_name = $row["StockGroupName"];
        $group_id = $row["StockGroupID"];
        $categorie_id = $group_id - 1;

        $url = "index.html.php?categorie_id=" . $group_id;
        echo "<li class=\"list-group-item\"><a href=\"$url\">$categories[$categorie_id]</a></li>";
    }
    ?>
</ul>