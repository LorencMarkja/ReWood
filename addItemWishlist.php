<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();
    $usernameLogged=$_SESSION['username'];
    
    $id_product = $_GET['id'];
    $id_wishlist = $_GET['idW'];
    $name_prod = $_GET['name_prod'];
    
    $check_wishlist= $mysqli->query("SELECT * FROM product_wishlist where product='$id_product' AND wishlist='$id_wishlist'");
    $rowCount= mysqli_num_rows($check_wishlist);
    if($rowCount == 0){
        $addItem = "INSERT INTO product_wishlist (wishlist, product) VALUES ('$id_wishlist', '$id_product')";
        $run=mysqli_query($mysqli,$addItem);
        $_SESSION['error_wishlist']=0;
    }else{
        $_SESSION['error_wishlist']=1;
    }

   
    if(isset($_GET['name_prod'])){
            header("Location: product-page.php?name=$name_prod");
    }else{
            header("Location: shop-fullwidth.php");
    }
    

?>