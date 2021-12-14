<?php

    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();
    $id_user=$_SESSION['id_user'];

    $main = new Template("dtml/shop-fullwidth.html");
    require "include/isLogged.inc.php";



// Current Page Number
    if (isset($_GET['page-number']) && $_GET['page-number']!="") {
        $page_no = $_GET['page-number'];
        } else {
            $page_no = 1;
            }

    $total_records_per_page = 12;

//OFFSET Value and SET other Variables
    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";

//Total Number of Pages for Pagination
    $records = mysqli_query($mysqli, "SELECT COUNT(*) AS total_records FROM `product_info`");
        $total_records = mysqli_fetch_array($records);
        $total_records = $total_records['total_records'];
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;


    $check_idWishlist="SELECT id_wishlist FROM wishlist where user='$id_user'";
    $run1=mysqli_query($mysqli,$check_idWishlist);
    while ($data = $run1->fetch_assoc()){
        $id_wishlist = $data['id_wishlist'];     
    }

    $product = $mysqli->query("SELECT * FROM product_info ORDER BY id_product LIMIT $offset, $total_records_per_page;");
    while ($data = $product->fetch_assoc()) {
        $id=$data['id_product'];
        $main->setContent("name", $data['name']);            
        $main->setContent("price", $data['price']);
        $price=$data['price'];
        $front=$data['front'];
        $main->setContent("front", "<img src='dtml/images/product-images/$front' alt='product image'>");
        $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
        $main->setContent("idRef", $id);
        $main->setContent("idWref", $id_wishlist);
        
    }

    $contatore = $total_no_of_pages; 
    $contatore_pagine = 2;
    while($contatore > 1 ){
        $main->setContent("page_number", "<a href='shop-fullwidth.php?page-number=$contatore_pagine'> $contatore_pagine </a>");
        $contatore_pagine = $contatore_pagine + 1;
        $contatore = $contatore -1;

    }
 
    
    //sezione showing results
    //nella prima pagina deve mostrare                         1          -    $total_records_per_page of 18 $recordsTotal                          1 - 12    of 18
    //nella seconda pagina deve mostrare ($total_records_per_page)+1      -    ($total_records_per_page * 2)                                        13 - 24
    //nella terza pagina deve mostrare   ($total_records_per_page * 2)+1  -    ($total_records_per_page * 3)                                        25 - 36 
    //nella quarta pagina deve mostrare  ($total_records_per_page * 3)+1  -    ($total_records_per_page * 4)                                        37 - 49   


    $main->setContent("recordsTotal", $total_records);
    $main->close();
?>
