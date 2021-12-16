<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    session_start();

    $main = new Template("dtml/shop-fullwidth.html");
    require "include/isLogged.inc.php";

    $usernameLogged=$_SESSION['username'];
    $id_user=$_SESSION['id_user'];

    $check_idWishlist="SELECT id_wishlist FROM wishlist where user='$id_user'";
    $run1=mysqli_query($mysqli,$check_idWishlist);
    while ($data = $run1->fetch_assoc()){
        $id_wishlist = $data['id_wishlist'];     
    }

    $id_catalog = $_GET['id'];
    $count = 0;
    $product = $mysqli->query("SELECT * FROM product_info LEFT JOIN product_catalog ON product_info.id_product = product_catalog.product WHERE catalog='$id_catalog' ORDER BY id_product;");

    if(isset($_SESSION['username'])){
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
            $main->setContent("wishlist", "<a href='addItemWishlist.php?id=$id&idW=$id_wishlist'><button class='uk-button uk-icon-heart-o'></button></a>");
        }
    } else {
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
            $main->setContent("wishlist", "<a href='login-register.php'><button class='uk-button uk-icon-heart-o'></button></a>");
    }
}
    $main->setContent("count", $count);
    $main->close();
?>