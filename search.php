<?php

require "include/connection_db.inc.php";
require "include/template2.inc.php";

$main = new Template("dtml/shop-fullwidth.html");

//current category and search text

$search_text = $_GET['search_text'];

if (isset($_GET['category_id'])) {

    $category_option = $_GET['category_id'];
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

//case categories 1 to 6 selected
if ($category_option != '7') {
    $search = $mysqli->query("SELECT * FROM product_search WHERE category = $category_option AND name LIKE '%$search_text%' AND description LIKE '%$search_text%' ORDER BY id_product LIMIT $offset, $total_records_per_page ;");

    while ($data = $search->fetch_assoc()) {
        $id = $data['id_product'];
        $main->setContent("name", $data['name']);
        $main->setContent("price", $data['price']);
        $price = $data['price'];
        $front = $data['front'];
        $main->setContent("front", "<img src='dtml/images/product-images/$front' alt='product image'>");
        $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
    }

    $records = mysqli_query($mysqli, "SELECT COUNT(*) AS total_records FROM `product_search` WHERE category = $category_option AND name LIKE '%$search_text%' AND description LIKE '%$search_text%';");
}

// case all categories selected
if ($category_option == '7') {
    $search = $mysqli->query("SELECT * FROM product_search WHERE name LIKE '%$search_text%' AND description LIKE '%$search_text%'  ORDER BY id_product LIMIT $offset, $total_records_per_page;");
    while ($data = $search->fetch_assoc()) {
        $id = $data['id_product'];
        $main->setContent("name", $data['name']);
        $main->setContent("price", $data['price']);
        $price = $data['price'];
        $front = $data['front'];
        $main->setContent("front", "<img src='dtml/images/product-images/$front' alt='product image'>");
        $main->setContent("info_sort", "<li data-id='$id' data-price='$price' class='items'>");
    }
    $records = mysqli_query($mysqli, "SELECT COUNT(*) AS total_records FROM `product_search`");
}


//Total Number of Pages for Pagination
$total_records = mysqli_fetch_array($records);
$total_records = $total_records['total_records'];
$total_no_of_pages = ceil($total_records / $total_records_per_page);
$second_last = $total_no_of_pages - 1;

$contatore = $total_no_of_pages;
$contatore_pagine = 2;
while ($contatore > 1) {
    $main->setContent("page_number", "<a href='shop-fullwidth.php?page-number=$contatore_pagine'> $contatore_pagine </a>");
    $contatore_pagine = $contatore_pagine + 1;
    $contatore = $contatore - 1;
}


//Showing section
$moltiplicatore1 = 1;
$moltiplicatore2 = 2;

$contatore_pagina = 0;

if ($page_no == 1) {

    $main->setContent("first_result", "<p>Showing 1 – $total_records_per_page of $total_records results</p>");
}


while (($contatore_pagina <= $total_no_of_pages) && $page_no >= 2) {

    $first_result = ($total_records_per_page * $moltiplicatore1) + 1;
    $second_result = ($total_records_per_page * $moltiplicatore2);

    if ($second_result >= $total_records) {

        $second_result = $total_records;
    }
    $main->setContent("first_result", "<p>Showing $first_result – $second_result of $total_records results</p> ");

    $moltiplicatore1 = $moltiplicatore1 + 1;
    $moltiplicatore2 = $moltiplicatore2 + 1;
    $contatore_pagina = $contatore_pagina + 1;
}

$main->setContent("recordsTotal", $total_records);
$main->close();
