<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();
    $usernameLogged=$_SESSION['username'];
    
    $main = new Template("dtml/shopping-cart.html");
    $id_product = $_GET['idProduct'];
    $id_cart = $_GET['idCart'];

   $deleteItem = "DELETE FROM cart_product WHERE product='$id_product' AND cart='$id_cart' ";
   $run=mysqli_query($mysqli,$deleteItem);
   header("Location: cart.php");

    $main->close();

    ?>