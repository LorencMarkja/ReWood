<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();
    $usernameLogged=$_SESSION['username'];
    
    $main = new Template("dtml/catalog.html");
    require "include/isLogged.inc.php";
    require "include/info_company.inc.php";
   
    $catalog_info = $mysqli->query("SELECT * FROM rewood.catalog ORDER BY id_catalog DESC LIMIT 12");
    

    while ($data = $catalog_info->fetch_assoc()) {
        
        $id=$data['id_catalog'];
        $name=$data['name'];
        $description=$data['description'];
        $img_name =  $data['image'];
        $main->setContent("img", "<img src='dtml/images/catalog-images/$img_name' alt='catalog image' class='uk-overlay-spin'/>");
        $main->setContent("a", "<a class='uk-position-cover' href='catalog-products.php?id=$id' title='$name'></a>");
        $main->setContent("name", $name);
    };

    $main->close();
?>