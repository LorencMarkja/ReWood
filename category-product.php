<?php

require "include/connection_db.inc.php";
require "include/template2.inc.php";

$main = new Template("dtml/shop-fullwidth.html");
require "include/isLogged.inc.php";


session_start();
$usernameLogged=$_SESSION['username'];


$id_category = $_GET['id'];

$category_product="select * from product_info LEFT JOIN product_category ON product_info.id_product = product_category.product WHERE category='$id_category'";
    $run=mysqli_query($mysqli,$category_product);
    $count = 0;

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
        $main->setContent("idRef", $id);
    }

    $main->setContent("count", $count);

$main->close();