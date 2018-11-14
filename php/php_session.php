<?php
    session_name("ShoppingCart"); // De sessie krijgt een naam 
    session_start("ShoppingCart"); // Starten van de session 
    $_SESSION["product_id"] = array();
?>