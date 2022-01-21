<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/page-editor.html");

    $pages = $mysqli->query("SELECT * FROM page");
    
    while ($data = $pages->fetch_assoc()) {
        $main->setContent("id", $data['id_page']);
        $main->setContent("title", $data['title']);
    };

    $main->close();

?>