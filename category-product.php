<?php

require "include/connection_db.inc.php";
require "include/template2.inc.php";

$main = new Template("dtml/shop-fullwidth.html");
require "include/isLogged.inc.php";


session_start();
$usernameLogged=$_SESSION['username'];
$id_user=$_SESSION['id_user'];


$id_category = $_GET['id'];

$check_idWishlist="SELECT id_wishlist FROM wishlist where user='$id_user'";
    $run1=mysqli_query($mysqli,$check_idWishlist);
    while ($data = $run1->fetch_assoc()){
        $id_wishlist = $data['id_wishlist'];     
    }

$category_product="select * from product_info LEFT JOIN product_category ON product_info.id_product = product_category.product WHERE category='$id_category'";
    $run=mysqli_query($mysqli,$category_product);
    $count = 0;

if(isset($_SESSION['username'])){
    while ($data = $run->fetch_assoc()){
        $count++;
        $name_prod=$data['name'];
        $main->setContent("name", "<a href='product-page.php?name=$name_prod'>$name_prod</a>");
        $main->setContent("price", $data['price']);
        $price=$data['price'];
        $front=$data['front'];
        $main->setContent("front", "<img src='dtml/images/product-images/$front' alt='product image'>");
        $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
        $id=$data['id_product'];
        $main->setContent("wishlist", "<a href='addItemWishlist.php?id=$id&idW=$id_wishlist'><button class='uk-button uk-icon-heart-o'></button></a>");
    }
} else {
    while ($data = $run->fetch_assoc()){
        $count++;
        $name_prod=$data['name'];
        $main->setContent("name", "<a href='product-page.php?name=$name_prod'>$name_prod</a>");
        $main->setContent("price", $data['price']);
        $price=$data['price'];
        $front=$data['front'];
        $main->setContent("front", "<img src='dtml/images/product-images/$front' alt='product image'>");
        $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
        $id=$data['id_product'];
        $main->setContent("wishlist", "<a href='login-register.php'><button class='uk-button uk-icon-heart-o'></button></a>");
    }
}
    $main->setContent("count", $count);

$main->close();