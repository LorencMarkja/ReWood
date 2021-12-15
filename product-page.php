<?php

    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/product-page.html");
    require "include/isLogged.inc.php";


    $name_prod=$_GET["name"];
    $product_info = $mysqli->query("SELECT * FROM product_info WHERE name='$name_prod'");
    while ($data = $product_info->fetch_assoc()) {
        $id_prod=$data["id_product"];
        $main->setContent("name", $data['name']);
        $main->setContent("desc", $data['description']);
        $main->setContent("price", $data['price']);
        $main->setContent("pieces", $data['pieces']);
        $main->setContent("dim", $data['dimension']);
        $main->setContent("materials", $data['material']);
        $img_front =  $data['front'];
        $img_back =  $data['back'];
        $img_side =  $data['side'];
        $main->setContent("front", "<img src='dtml/images/product-images/$img_front' alt='product image'>");
        $main->setContent("back", "<img src='dtml/images/product-images/$img_back' alt='product image'>");
        $main->setContent("side", "<img src='dtml/images/product-images/$img_side' alt='product image'>");
    };

    
    $product_category = $mysqli->query("SELECT category.* FROM product_category AS p_cat INNER JOIN category ON p_cat.category = category.id_category WHERE p_cat.product='$id_prod'");
    while ($data = $product_category->fetch_assoc()) {
        $name_categ = $data["name"];
        $id_cat= $data["id_category"];
        $category_array[]=$id_cat;
        $main->setContent("category", "<a href='category-product.php?id=$id_cat'>$name_categ</a>");
    }

    $i=0;
    foreach($category_array AS $category){
        $related= $mysqli->query("SELECT *,product_info.name AS name_prod, category.*, category.name AS name_categ FROM product_info INNER JOIN product_category AS p_cat ON product_info.id_product=p_Cat.product INNER JOIN category ON p_cat.category = category.id_category WHERE p_cat.category='$category' AND product_info.id_product<>'$id_prod'");

        while ($data = $related->fetch_assoc()) {
            $id_prod_rel=$data["id_product"];
            $name_prod_rel= $data['name_prod'];
            $main->setContent("name_rel", "<a href='product-page.php?name=$name_prod_rel'>$name_prod_rel</a>");
            $main->setContent("price_rel", $data['price']);
            $img_front_rel =  $data['front'];
            $main->setContent("img_rel", "<img src='dtml/images/product-images/$img_front_rel' style='object-fit: scale-down;margin-top: -25px;' alt='product image'>");
            $main->setContent("name_categ", $data["name_categ"]);
            $main->setContent("id_categ", $category);
        }
        //controllo solo 4 elementi da far vedere.
    }

    $main->close();
?>