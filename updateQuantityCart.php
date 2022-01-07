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

    $checkQuantity = "select * from cart_product WHERE product=$id_product and cart=$id_cart and quantity='0' ";
    $run4=mysqli_query($mysqli, $checkQuantity);
    $numRows = mysqli_num_rows($run4);

    if($numRows != 0){
        $deleteProduct = "DELETE FROM cart_product WHERE product=$id_product and cart=$id_cart";
        $run5=mysqli_query($mysqli, $deleteProduct);
    }

    header("Location: cart.php#main-section");

?>
