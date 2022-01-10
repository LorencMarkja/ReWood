<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();
    $usernameLogged=$_SESSION['username'];
    $id_user=$_SESSION['id_user'];
    $id_cart=$_SESSION['cart'];
    $total = $_GET['total'];
    
    $main = new Template("dtml/checkout.html");
    
    $numberOrder = rand(50000,99999);
    $date = new DateTime();
    $timestamp = $date->getTimestamp();
    $newDate = date('Y-m-d', $timestamp);
    
    $insertOrder = "INSERT INTO rewood.order (order_number, date, total, user, cart) VALUES ('$numberOrder', '$newDate', '$total', '$id_user', '$id_cart')";
    $run1=mysqli_query($mysqli,$insertOrder);

    $getQuantity = "SELECT product, quantity FROM cart_product WHERE cart = $id_cart";
    $run3=mysqli_query($mysqli,$getQuantity);
    while ($data = $run3->fetch_assoc()) {
        $id_product = $data['product'];
        $quantity = $data['quantity'];

        $updateQuantity = "UPDATE product SET pieces = pieces - $quantity  WHERE id_product='$id_product'";
        $run4=mysqli_query($mysqli, $updateQuantity);

    }
    
    
    $newCart = "INSERT cart (user) VALUES ('$id_user')";
    $run2=mysqli_query($mysqli,$newCart);

    $sql = "SELECT MAX(id_cart) AS id_cart FROM cart WHERE user = '$id_user'";
    $result = $mysqli -> query($sql);

   
    $row = $result -> fetch_assoc();
    $id_cart=$row['id_cart'];
    $_SESSION['cart']= $id_cart;

    header("Location: order-complete.php");

    $main->close();

    ?>