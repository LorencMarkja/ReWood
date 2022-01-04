<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();
    $usernameLogged=$_SESSION['username'];
    
    $main = new Template("dtml/wishlist.html");
    $id_product = $_GET['id'];
    $id_wishlist = $_GET['idW'];
    $name_prod = $_GET['name_prod'];

    $deleteItem = "DELETE FROM product_wishlist WHERE wishlist='$id_wishlist' AND product='$id_product'";
    $run=mysqli_query($mysqli,$deleteItem);

    if(isset($_GET['name_prod'])){
        header("Location: product-page.php?name=$name_prod");
    }else{
        header("Location: wishlist.php");
    }
    $main->close();

    ?>