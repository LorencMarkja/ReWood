<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    $main = new Template("dtml/index-editor.html");


    $index_page = $mysqli->query("SELECT * FROM index_page ORDER BY id_index DESC");

    while ($data = $index_page->fetch_assoc()) {
        $id=$data['id_index'];
        $main->setContent("id", $id);
        $main->setContent("section_name", $data['section_name']);
        $main->setContent("content_prev", $data['content']);
        $main->setContent("btn_form", 
            "<form style='width: 100%;' method='POST'>
                <input id='open_edit' type='submit' class='edit-btn' name='action' value='EDIT' />
                <input type='submit' class='delete-btn' name='action' value='DELETE'/>
                <input type='hidden' name='id_index' value='$id'/>
            </form>");
    };


    $main->close();

?>