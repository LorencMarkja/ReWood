<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    $main = new Template("dtml/index-editor.html");


    $index_page = $mysqli->query("SELECT * FROM index_page ORDER BY id_index DESC");

    while ($data = $index_page->fetch_assoc()) {
        $id=$data['id_index'];
        $main->setContent("id", $id);
        $main->setContent("section_name", $data['section_name']);
        $decodedString = strip_tags($data['content']);
        $main->setContent("content_prev", $decodedString);
        $main->setContent("btn_form", 
            "<form style='width: 100%; justify-content: space-around;' method='POST'>
                <input id='open_edit' type='submit' class='edit-btn' name='action' value='EDIT' />
                <input type='hidden' name='id_index' value='$id'/>
            </form>");
    };


    if($_POST['action'] && $_POST['id_index']) {
        $index_page = $_POST['id_index'];

        if ($_POST['action'] == 'EDIT') {
            $main->setContent("script",  "<script type='text/javascript'>document.getElementById('edit').style.display='block';</script>");
            $index_page2 = $mysqli->query("SELECT * FROM index_page WHERE id_index = '$index_page'");

            while ($data = $index_page2->fetch_assoc()) {
                $id = $data['id_index'];
                $name = $data['section_name'];
                $content = $data['content'];
                
            };
        }
    }

    $main->setContent("left_content", 
    "<label for='sname'>Section name:</label>
    <input type='text' name='sname' value=$name />
    <label for=content>Content:</label>
   <textarea id='content-editor' name='content' required> $content</textarea>
   <input type='hidden' name='id_index' value='$id'/>" );
        
    if(isset($_POST['edit'])){

        $id1 = $_POST['id_index'];
        $name1 =  $_POST['sname'];
        $content1 = $_POST['content'];

        $update_index="UPDATE index_page SET section_name = '$name1', content = '$content1' WHERE id_index = '$id1'"; 
   
        if(!mysqli_query($mysqli, $update_index)){
            $main->setContent("message_edit", "ERROR! section not updated!");
            $main->setContent("script", "<script type='text/javascript'>document.getElementById('open_edit').click()</script>");
        }else{
            $main->setContent("script", "<script type='text/javascript'> 
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
                window.location.reload();
            }
            </script>");
        }
    }

    $main->close();

?>