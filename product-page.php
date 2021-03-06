<?php

    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();
    $id_user=$_SESSION['id_user'];
    
    $main = new Template("dtml/product-page.html");
    require "include/isLogged.inc.php";
    require "include/info_company.inc.php";

    $check_idWishlist="SELECT id_wishlist FROM wishlist where user='$id_user'";
    $run1=mysqli_query($mysqli,$check_idWishlist);
    while ($data = $run1->fetch_assoc()){
        $id_wishlist = $data['id_wishlist'];     
    }

    $name_prod=$_GET["name"];
    $product_info = $mysqli->query("SELECT * FROM product_info WHERE name='$name_prod'");
    while ($data = $product_info->fetch_assoc()) {
        $id_prod=$data["id_product"];
        $main->setContent("id_prod", $data['id_product']);
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
        $main->setContent("category_name", "<a href='category-product.php?id=$id_cat'>$name_categ</a>");
    }

    $product_catalog = $mysqli->query("SELECT catalog.* FROM product_catalog AS p_cat INNER JOIN catalog ON p_cat.catalog = catalog.id_catalog WHERE p_cat.product='$id_prod'");
    while ($data = $product_catalog->fetch_assoc()) {
        $name_catalog = $data["name"];
        $id_cat= $data["id_catalog"];
        $catalog_array[]=$id_cat;
    } 

    $i=0;
    foreach($catalog_array AS $catalog){
        $related= $mysqli->query("SELECT *,product_info.name AS name_prod, catalog.*, catalog.name AS name_cat FROM product_info INNER JOIN product_catalog AS p_cat ON product_info.id_product=p_cat.product INNER JOIN catalog ON p_cat.catalog = catalog.id_catalog WHERE p_cat.catalog='$catalog' AND product_info.id_product<>'$id_prod'");

        while ($data = $related->fetch_assoc()) {
            $id_prod_rel=$data["id_product"];
            $main->setContent("id_rel", "$id_prod_rel");
            $name_prod_rel= $data['name_prod'];
            $main->setContent("name_prod", "$name_prod");
            $main->setContent("name_rel", "<a href='product-page.php?name=$name_prod_rel'>$name_prod_rel</a>");
            $main->setContent("price_rel", $data['price']);
            $img_front_rel =  $data['front'];
            $main->setContent("img_rel", "<img src='dtml/images/product-images/$img_front_rel' style='object-fit: scale-down;margin-top: -25px;' alt='product image'>");
            $main->setContent("name_catag", $data["name_cat"]);
            $main->setContent("id_catag", $catalog);
            $main->setContent("id_wishlist",  $id_wishlist);
        }
       
    }


    $check_wishlist= $mysqli->query("SELECT * FROM product_wishlist where product='$id_prod' AND wishlist='$id_wishlist'");
    $rowCount= mysqli_num_rows($check_wishlist);
    if($rowCount == 0){
        $main->setContent("wishlist", "<a href='addItemWishlist.php?id=$id_prod&idW=$id_wishlist&name_prod=$name_prod'><button class='uk-button'><i class='uk-icon-heart-o'></i>Add to Wishlist</button></a>");
    }else{
        $main->setContent("wishlist", "<a href='deleteItemWishlist.php?id=$id_prod&idW=$id_wishlist&name_prod=$name_prod'><button class='uk-button'><i class='uk-icon-heart-o' style='background: #fff; border: 1px solid black; color: #000'></i>Remove from Wishlist</button></a>");
    }
    

    $main->close();
?>