<?php

require "include/connection_db.inc.php";
require "include/template2.inc.php";

session_start();
$id_user=$_SESSION['id_user'];
$error_wishlist=$_SESSION['error_wishlist'];

$main = new Template("dtml/shop-fullwidth.html");
require "include/isLogged.inc.php";
require "include/info_company.inc.php";

$main->setContent("disabled", "hidden");

if($error_wishlist == 1){
    $main->setContent("script", "<script type='text/javascript'>setTimeout(function () {alert('Product already in wishlist!');}, 500);</script>");
    $_SESSION['error_wishlist']=0;
}

// Current Page Number
if (isset($_GET['page-number']) && $_GET['page-number'] != "") {
    $page_no = $_GET['page-number'];
} else {
    $page_no = 1;
}

$total_records_per_page = 12;

//OFFSET Value and SET other Variables
$offset = ($page_no - 1) * $total_records_per_page;
$previous_page = $page_no - 1;
$next_page = $page_no + 1;
$adjacents = "2";

//Total Number of Pages for Pagination
$records = mysqli_query($mysqli, "SELECT COUNT(*) AS total_records FROM `product_info` WHERE pieces > 0");
$total_records = mysqli_fetch_array($records);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$check_idWishlist="SELECT id_wishlist FROM wishlist where user='$id_user'";
    $run1=mysqli_query($mysqli,$check_idWishlist);
    while ($data = $run1->fetch_assoc()){
        $id_wishlist = $data['id_wishlist'];     
    }

    $product = $mysqli->query("SELECT * FROM product_info WHERE pieces > 0 ORDER BY id_product LIMIT $offset, $total_records_per_page;");

    if(isset($_SESSION['username'])){
        while ($data = $product->fetch_assoc()) {
            $id=$data['id_product'];
            $name=$data['name'];
            $main->setContent("name", "<a href='product-page.php?name=$name'>$name</a>");            
            $main->setContent("price", $data['price']);
            $price=$data['price'];
            $front=$data['front'];
            $main->setContent("front", "<img src='dtml/images/product-images/$front' alt='product image'>");
            $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
            $main->setContent("euro", "???");
            $main->setContent("figcaption"," <figcaption class='uk-overlay-panel uk-overlay-background uk-flex uk-flex-right uk-flex-bottom'>
                <a href='addItemCart.php?id=$id'><button class='uk-button uk-icon-shopping-cart'></button></a>
                <a href='addItemWishlist.php?id=$id&idW=$id_wishlist'><button class='uk-button uk-icon-heart-o'></button></a>
                </figcaption>");
        }

    } else {
        while ($data = $product->fetch_assoc()) {
            $id=$data['id_product'];
            $name=$data['name'];
            $main->setContent("name", "<a href='product-page.php?name=$name'>$name</a>");            
            $main->setContent("price", $data['price']);
            $price=$data['price'];
            $front=$data['front'];
            $main->setContent("front", "<img src='dtml/images/product-images/$front' alt='product image'>");
            $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
            $main->setContent("euro", "???");
            $main->setContent("figcaption","<figcaption class='uk-overlay-panel uk-overlay-background uk-flex uk-flex-right uk-flex-bottom'>
                <a href='login-register.php'><button class='uk-button uk-icon-shopping-cart'></button></a>
                <a href='login-register.php'><button class='uk-button uk-icon-heart-o'></button></a>
                </figcaption>");
            }
    
        }  
        $main->setContent("page_1", "<li id='page1'><a href='?page-number=1'>1</a></li>");

$contatore = $total_no_of_pages;
$contatore_pagine = 2;
while ($contatore > 1) {
    $main->setContent("page_number", "<li id='page$contatore_pagine'><a href='shop-fullwidth.php?page-number=$contatore_pagine'> $contatore_pagine </a><li>");  
    $contatore_pagine = $contatore_pagine + 1;
    $contatore = $contatore - 1;
}

//Showing section
$moltiplicatore1 = 1;
$moltiplicatore2 = 2;

$contatore_pagina = 0;

if ($page_no == 1) {

    $main->setContent("first_result", "<p>Showing 1 ??? $total_records_per_page of $total_records results</p>");
}


while (($contatore_pagina <= $total_no_of_pages) && $page_no >= 2) {

    $first_result = ($total_records_per_page * $moltiplicatore1) + 1;
    $second_result = ($total_records_per_page * $moltiplicatore2);

    if ($second_result >= $total_records) {

        $second_result = $total_records;
    }
    $main->setContent("first_result", "<p>Showing $first_result ??? $second_result of $total_records results</p> ");

    $moltiplicatore1 = $moltiplicatore1 + 1;
    $moltiplicatore2 = $moltiplicatore2 + 1;
    $contatore_pagina = $contatore_pagina + 1;
}

$main->close();
