<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();

    $main = new Template("dtml/index.html");
    require "include/isLogged.inc.php";

    $id_user=$_SESSION['id_user'];
    $usernameLogged=$_SESSION['username'];
    $id_cart=$_SESSION['cart'];

    $check_idWishlist="SELECT id_wishlist FROM wishlist where user='$id_user'";
    $run1=mysqli_query($mysqli,$check_idWishlist);
    while ($data = $run1->fetch_assoc()){
        $id_wishlist = $data['id_wishlist'];     
    }
    $product_info = $mysqli->query("SELECT * FROM product_info ORDER BY id_product DESC LIMIT 8");

    while ($data = $product_info->fetch_assoc()) {
        $id= $data['id_product'];
        $name_prod= $data['name'];
        $main->setContent("name_prod", $name_prod);
        $main->setContent("name", "<a href='product-page.php?name=$name_prod'>$name_prod</a>");
        $main->setContent("desc", $data['description']);
        $main->setContent("price", $data['price']);
        $main->setContent("pieces", $data['pieces']);
        $img_name =  $data['front'];
        $main->setContent("img", "<img src='dtml/images/product-images/$img_name' style='width:100%; height:85%; object-fit: contain;' alt='product image'>");

        if(isset($_SESSION['username'])){
            $main->setContent("cart", "<a href='addItemCart.php?id=$id&index=1'><button class='uk-button uk-icon-shopping-cart'></button></a>");
            $main->setContent("wishlist", "<a href='addItemWishlist.php?id=$id&idW=$id_wishlist&index=1'><button class='uk-button uk-icon-heart-o'></button></a>");
        }else{
            $main->setContent("cart", "<a href='login-register.php'><button class='uk-button uk-icon-shopping-cart'></button></a>");
            $main->setContent("wishlist", "<a href='login-register.php'><button class='uk-button uk-icon-heart-o'></button></a>");
        }
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

    // $_SESSION['username']= $username;
    // $_SESSION['id_user']= $id_user;
    // $_SESSION['cart']= $id_cart;    

    $main->close();
?>