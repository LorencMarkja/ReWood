<?php

    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/shop-fullwidth.html");
    require "include/isLogged.inc.php";


    $product = $mysqli->query("SELECT * FROM product_info ORDER BY id_product;");
    $count = 0;

    while ($data = $product->fetch_assoc()) {
        $count++;
        $id=$data['id_product'];
        $main->setContent("name", $data['name']);            
        $main->setContent("price", $data['price']);
        $price=$data['price'];
        $front=$data['front'];
        $main->setContent("front", "<img src='dtml/images/product-images/$front' alt='product image'>");
        $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
    }

    $main->setContent("count", $count);

    $main->close();
?>