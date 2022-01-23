<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
	require "include/auth.inc.php";
    
    $main = new Template("dtml/editor-form.html");

    if(isset($_GET['title'])){
        $title = $_GET['title'];
        $main->setContent("h1", "<h1>Editing \"<span style='text-transform: uppercase;'>$title</span>\" page ...</h1>");
        $main->setContent("input_title", "<input type='text' name='new_title' value='$title' style='width: 70%; margin: 30px 0;' required/>");
        $page = $mysqli->query("SELECT * FROM page WHERE title = '$title'");
        while ($data = $page->fetch_assoc()) {
            $id_page=$data['id_page'];
            $main->setContent("content", $data['content']);
        };
        $main->setContent("delete-btn",  "<input type='submit' name='delete' value='DELETE' class='delete-btn'>");

    }else{
        $main->setContent("h1", "<h1>Adding new page...</h1>");
        $main->setContent("input_title", "<input type='text' name='new_title' placeholder='Title' style='width: 70%; margin: 30px 0;' required/>");
    }

    if(isset($_POST['submit'])){
        $new_title =  $_REQUEST['new_title'];
        $new_content = $_REQUEST['new_content'];
        
        if(isset($_GET['title'])){
            $update_page = $mysqli->query("UPDATE rewood.page SET title = '$new_title', content = '$new_content' WHERE id_page='$id_page'");
            header("Refresh:0");
        }else{
            $insert_page = $mysqli->query("INSERT INTO rewood.page  VALUES (0, '$new_title', '$new_content')"); 
            header('location: page-editor.php');
        }
    }
    if(isset($_POST['delete'])){
        $update_page = $mysqli->query("DELETE FROM rewood.page WHERE id_page='$id_page'");
        header('location: page-editor.php');
    }
    $main->close();

?>