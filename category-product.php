<?php

require "include/connection_db.inc.php";
require "include/template2.inc.php";

$main = new Template("dtml/shop-fullwidth.html");
require "include/isLogged.inc.php";


session_start();
$id_category = $_GET['id'];

$category_product="select * from product_info LEFT JOIN product_category ON product_info.id_product = product_category.product WHERE category='$id_category'";
    $run=mysqli_query($mysqli,$category_product);

    while ($data = $run->fetch_assoc()){
    $main->setContent("name", $data['name']);
    $main->setContent("price", $data['price']);
    $price=$data['price'];
    $front=$data['front'];
    $main->setContent("front", "<img src='products/$front'  style='width:100%; height:272px; object-fit: cover;' alt='product image'>");
    $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
    }



$main->close();