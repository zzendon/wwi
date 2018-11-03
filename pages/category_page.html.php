<h1 class="my-4">Categorie&euml;n</h1>
<div class="list-group">
    <?php
    include '../php/connectdb.php';
    $conn = getConnection();
    $categories = array("Nieuwe items", "Kleding", "Mokken", "T-shirts", "Nieuwe luchtmaatschappijen", "Nieuwe gegevensverwerking", "Niewe USB's", "Schoenen", "Speelgoed", "Verpakkings materiaal");
    $query = "SELECT StockGroupID, StockGroupName FROM stockgroups ORDER BY StockGroupID";
    $result = $conn->query($query);

    $pro = $conn->prepare($query);
    $pro->execute();
    while ($row = $pro->fetch())
    {
        $group_name = $row["StockGroupName"];
        $group_id = $row["StockGroupID"];
        $categorie_id = $group_id - 1;

        $url = "index.html.php?categorie_id=".$group_id;
        echo " <a href=$url class=\"list-group-item\">$categories[$categorie_id]</a>";
    }
    ?>
</div>