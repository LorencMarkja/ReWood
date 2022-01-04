<?php

    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    
    session_start();
    $id_user=$_SESSION['id_user'];
    $id_cart=$_SESSION['cart'];


    $id_product = $_GET['id_prod'];
    $quantity= $_GET['quantity'];

    $updateQuantity = "UPDATE cart_product SET quantity =  $quantity  WHERE product='$id_product' AND cart='$id_cart'";
    $run3=mysqli_query($mysqli, $updateQuantity);

    header("Location: cart.php#main-section");

?>
