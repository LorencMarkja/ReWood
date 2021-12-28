<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();

    $main = new Template("dtml/index.html");
    require "include/isLogged.inc.php";
    
    $usernameLogged=$_SESSION['username'];
    $id_cart=$_SESSION['cart'];

    $product_info = $mysqli->query("SELECT * FROM product_info ORDER BY id_product DESC LIMIT 8");

    while ($data = $product_info->fetch_assoc()) {
        $main->setContent("id", $data['id_product']);
        $name_prod= $data['name'];
        $main->setContent("name", "<a href='product-page.php?name=$name_prod'>$name_prod</a>");
        $main->setContent("desc", $data['description']);
        $main->setContent("price", $data['price']);
        $main->setContent("pieces", $data['pieces']);
        $img_name =  $data['front'];
        $main->setContent("img", "<img src='dtml/images/product-images/$img_name' style='width:100%; height:85%; object-fit: contain;' alt='product image'>");
    };

    $last_product = $mysqli->query("SELECT * FROM product_info WHERE id_product=(SELECT max(id_product) FROM product);");
    while ($data = $last_product->fetch_assoc()) {
        $main->setContent("id_last", $data['id_product']);
        $id_last=$data['id_product'];
        $name_last= $data['name'];
        $main->setContent("name_last", "<a href='product-page.php?name=$name_last'>$name_last</a>");
        $main->setContent("desc_last", $data['description']);
        $main->setContent("price_last", $data['price']);
        $img_name = $data['front'];
        $main->setContent("img_last", "<img src='dtml/images/product-images/$img_name' alt='product image'>");
    };

    $main->close();
?>