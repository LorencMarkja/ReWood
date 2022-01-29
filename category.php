<?php

require "include/connection_db.inc.php";
require "include/template2.inc.php";

session_start();
$main = new Template("dtml/category-grid.html");
require "include/isLogged.inc.php";
require "include/info_company.inc.php";

$usernameLogged=$_SESSION['username'];

$check_category="select * from category";
    $run=mysqli_query($mysqli,$check_category);

    while ($data = $run->fetch_assoc()){
    
    $main->setContent("name", $data['name']);
    $main->setContent("image", $data['image']);
    $main->setContent("id", $data['id_category']);
    $id_category = $data['id_category'];
    $main->setContent("pageRef", "<a href='category-product.php?id=$id_category'>View Products &raquo;</a>");
    }
    

$main->close();



?>