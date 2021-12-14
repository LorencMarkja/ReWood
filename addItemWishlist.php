<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();
    $usernameLogged=$_SESSION['username'];
    
    $main = new Template("dtml/shop-fullwidth.html");
    $id_product = $_GET['id'];
    $id_wishlist = $_GET['idW'];
    

   $addItem = "INSERT INTO product_wishlist (wishlist, product) VALUES ('$id_wishlist', '$id_product')";
   $run=mysqli_query($mysqli,$addItem);
   header("Location: shop-fullwidth.php");

    $main->close();

    ?>