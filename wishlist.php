<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    
    session_start();
    $id_user=$_SESSION['id_user'];
    
    
    $main = new Template("dtml/wishlist.html");
    require "include/isLogged.inc.php";
    require "include/info_company.inc.php";

    $check_idWishlist="SELECT id_wishlist FROM wishlist where user='$id_user'";
    $run1=mysqli_query($mysqli,$check_idWishlist);
    while ($data = $run1->fetch_assoc()){
        $id_wishlist = $data['id_wishlist'];     
    }

    $check_wishlist="select wishlist_info.product, wishlist_info.image, wishlist_info.name_product, wishlist_info.price FROM wishlist_info WHERE wishlist='$id_wishlist'";
    $run=mysqli_query($mysqli,$check_wishlist);
    $numRows = mysqli_num_rows($run);
    if($numRows!=0){
        while ($data = $run->fetch_assoc()){
            $id_product = $data['product'];     
            $main->setContent("image", $data['image']);
            $main->setContent("name", $data['name_product']);
            $main->setContent("price", $data['price']."€");
            $availability = $mysqli->query("SELECT * FROM product WHERE pieces > 0 AND id_product='$id_product'");
            $rowCount= mysqli_num_rows($availability);
            if($rowCount == 0){
                $main->setContent("status", "<span class='uk-text-success' style='color: red !important;'>Out of Stock</span>");
            }else{
                $main->setContent("status", "<span class='uk-text-success'>In Stock</span>");
            }
            $main->setContent("delete", "<a href='deleteItemWishlist.php?id=$id_product&idW=$id_wishlist' class='uk-icon-button uk-icon-times-circle'></a>");
            $main->setContent("cart", "<a class='uk-button uk-button-small idz-button-grey uk-margin-small-top' href='addItemCart.php?id=$id_product''>Add to Cart</a>");
        };

        
    }  else {
        $main->setContent("style", "pointer-events: none; cursor: default;");
        $main->setContent("name", "Your wishlist is empty");
        $main->setContent("status", "<a href='shop-fullwidth.php'>Check our products</a>");
    }
    


    $main->close();

    ?>