<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    $main = new Template("dtml/catalog-admin.html");
    require "include/isLogged.inc.php";
   
    $catalog_info = $mysqli->query("SELECT * FROM rewood.catalog ORDER BY id_catalog DESC");

    while ($data = $catalog_info->fetch_assoc()) {
        $id=$data['id_catalog'];
        $main->setContent("id", $id);
        $main->setContent("name", $data['name']);
        $main->setContent("date", $data['creation_date']);
        $main->setContent("desc", $data['description']);
        $main->setContent("btn_form", 
            "<form style='width: 100%;' method='POST'>
                <input id='open_edit' type='submit' class='edit-btn' name='action' value='EDIT' />
                <input type='submit' class='delete-btn' name='action' value='DELETE'/>
                <input type='hidden' name='id_catalog' value='$id'/>
            </form>");
    };

    $main->close();
?>