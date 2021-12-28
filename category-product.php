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
        $main->setContent("euro", "€");
        $main->setContent("figcaption"," <figcaption class='uk-overlay-panel uk-overlay-background uk-flex uk-flex-right uk-flex-bottom'>
            <a href='addItemCart.php?id=$id'><button class='uk-button uk-icon-shopping-cart'></button></a>
            <a href='addItemWishlist.php?id=$id&idW=$id_wishlist'><button class='uk-button uk-icon-heart-o'></button></a>
            </figcaption>");
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
        $main->setContent("euro", "€");
        $main->setContent("figcaption","<figcaption class='uk-overlay-panel uk-overlay-background uk-flex uk-flex-right uk-flex-bottom'>
            <a href='login-register.php'><button class='uk-button uk-icon-shopping-cart'></button></a>
            <a href='login-register.php'><button class='uk-button uk-icon-heart-o'></button></a>
            </figcaption>");
    }
}
    $main->setContent("count", $count);

    $category_name="select name from category WHERE id_category='$id_category'";
    $run=mysqli_query($mysqli,$category_name);
    while ($data = $run->fetch_assoc()){
        $name_category = $data['name'];
    }

    $main->setContent("page_1", "<li id='page1'><a href='?page-number=1'>1</a></li>");
    $main->setContent("first_result", "<p>Showing $name_category products</p>");

$main->close();