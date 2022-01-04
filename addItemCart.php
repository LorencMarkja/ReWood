<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();
    $usernameLogged=$_SESSION['username'];
    $id_cart=$_SESSION['cart'];
    
    $id_product = $_GET['id'];

    //$main = new Template("dtml/shop-fullwidth.html");

    if (isset($_GET['quantity-value'])){
        $quantity = $_GET['quantity-value'];
        $name =  $_GET['name'];
        $checkProduct = "select * FROM cart_product where product='$id_product' AND cart='$id_cart'";
        $run=mysqli_query($mysqli,$checkProduct);
        $rowCount= mysqli_num_rows($run);

        if($rowCount == 0){
            $addItemCart = "INSERT INTO cart_product (cart, product, quantity) VALUES ('$id_cart', '$id_product', '$quantity')";
            $run2=mysqli_query($mysqli,$addItemCart);
        }else{
            $updateCart = "UPDATE cart_product SET quantity = quantity + $quantity  WHERE product='$id_product' AND cart='$id_cart'";
            $run3=mysqli_query($mysqli,$updateCart);
        }

        header("Location: product-page.php?name=$name");
    }else{
        $checkProduct = "select * FROM cart_product where product='$id_product' AND cart='$id_cart'";
        $run4=mysqli_query($mysqli,$checkProduct);
        $rowCount= mysqli_num_rows($run4);
        
        if($rowCount == 0){
            $addItemCart = "INSERT INTO cart_product (cart, product, quantity) VALUES ('$id_cart', '$id_product', '1')";
            $run5=mysqli_query($mysqli,$addItemCart);
        }else{
            $updateCart = "UPDATE cart_product SET quantity = quantity +1 WHERE product='$id_product' AND cart='$id_cart'";
            $run6=mysqli_query($mysqli,$updateCart);
        }

        header("Location: shop-fullwidth.php");
    }


   
  
//     $main->close();

?>