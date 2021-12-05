<?php
require "include/connection_db.inc.php";
require "include/template2.inc.php";

$main = new Template("dtml/shop-fullwidth.html");


$product = $mysqli->query("SELECT * FROM product_info ORDER BY id_product;");

while ($data = $product->fetch_assoc()) {
    $id=$data['id_product'];
    $main->setContent("name", $data['name']);            
    $main->setContent("price", $data['price']);
    $price=$data['price'];
    $front=$data['front'];
    $main->setContent("front", "<img src='products/$front'  style='width:100%; height:272px; object-fit: cover;' alt='product image'>");
    $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
}



$main->close();
?>