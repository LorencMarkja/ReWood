<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    $main = new Template("dtml/index.html");
    require "include/isLogged.inc.php";

    $product_info = $mysqli->query("SELECT * FROM product_info ORDER BY id_product DESC LIMIT 8");

    while ($data = $product_info->fetch_assoc()) {
        $main->setContent("id", $data['id_product']);
        $main->setContent("name", $data['name']);
        $main->setContent("desc", $data['description']);
        $main->setContent("price", $data['price']);
        $main->setContent("pieces", $data['pieces']);
        $img_name =  $data['front'];
        $main->setContent("img", "<img src='products/$img_name' style='width:100%; height:85%; object-fit: contain;' alt='product image'>");
    };

    $last_product = $mysqli->query("SELECT * FROM product_info WHERE id_product=(SELECT max(id_product) FROM product);");
    while ($data = $last_product->fetch_assoc()) {
        $main->setContent("id_last", $data['id_product']);
        $id_last=$data['id_product'];
        $main->setContent("name_last", $data['name']);
        $main->setContent("desc_last", $data['description']);
        $main->setContent("price_last", $data['price']);
        $img_name = $data['front'];
        $main->setContent("img_last", "<img src='products/$img_name'  style='width:100%; height:272px; object-fit: cover;' alt='product image'>");
    };

    $main->close();
?>