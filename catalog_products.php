<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    session_start();

    $main = new Template("dtml/shop-fullwidth.html");
    require "include/isLogged.inc.php";

    $usernameLogged=$_SESSION['username'];

    $id_catalog = $_GET['id'];
    $count = 0;
    $product = $mysqli->query("SELECT * FROM product_info LEFT JOIN product_catalog ON product_info.id_product = product_catalog.product WHERE catalog='$id_catalog' ORDER BY id_product;");

    while ($data = $product->fetch_assoc()) {
        $count++;
        $id=$data['id_product'];
        $name=$data['name'];
        $main->setContent("name", "<a href='product-page.php?name=$name'>$name</a>");                 
        $main->setContent("price", $data['price']);
        $price=$data['price'];
        $front=$data['front'];
        $main->setContent("front", "<img src='dtml/images/product-images/$front' alt='product image'>");
        $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
    }
    
    $main->setContent("count", $count);
    $main->close();
?>