<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();
    $usernameLogged=$_SESSION['username'];
    $id_cart=$_SESSION['cart'];
    
    $main = new Template("dtml/shop-fullwidth.html");
    $id_product = $_GET['id'];
    
    $checkProduct = "select * FROM cart_product where product='$id_product' AND cart='$id_cart'";
    $run2=mysqli_query($mysqli,$checkProduct);
    $rowCount= mysqli_num_rows($run2);
    if($rowCount == 0){

   $addItemCart = "INSERT INTO cart_product (cart, product, quantity) VALUES ('$id_cart', '$id_product', '1')";
   $run=mysqli_query($mysqli,$addItemCart);
} else{
    $updateCart = "UPDATE cart_product SET quantity = quantity +1 WHERE product='$id_product' AND cart='$id_cart'";
    $run3=mysqli_query($mysqli,$updateCart);
}

   header("Location: shop-fullwidth.php");

    $main->close();

    ?>