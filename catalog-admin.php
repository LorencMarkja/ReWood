<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    $main = new Template("dtml/catalog-admin.html");
    require "include/auth.inc.php";

    $catalog_info = $mysqli->query("SELECT * FROM rewood.catalog ORDER BY creation_date DESC");

    while ($data = $catalog_info->fetch_assoc()) {
        $id=$data['id_catalog'];
        $main->setContent("id", $id);
        $img = $data['image'];
        $main->setContent("image", "<img src='dtml/images/catalog-images/$img' style='width: 45px; height: 45px;' alt='category image'>");
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

    if(isset($_POST['insert'])){

        $name =  $_REQUEST['name'];
        $desc = $_REQUEST['desc'];
        $desc = mysqli_real_escape_string($mysqli, $desc);
        $date =  $_REQUEST['date'];
    
        $img = $_FILES["img"]["name"];
        
        $catalog_ins = "INSERT INTO rewood.catalog  VALUES (
            0,
            '$name', 
            '$date',
            '$desc',
            '$img')";

        
        if(mysqli_query($mysqli, $catalog_ins)){
            $main->setContent("script", "<script type='text/javascript'> 
                if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href );
                    window.location.reload();
                }
            </script>");

        } else{
            $main->setContent("script",  "<script type='text/javascript'>document.getElementById('openForm').click()</script>");
            $main->setContent("message", "ERROR! catalog not created!");
        } 
    }

    if($_POST['action'] && $_POST['id_catalog']) {
        $id_catalog = $_POST['id_catalog'];

        if ($_POST['action'] == 'EDIT') {
            $main->setContent("script",  "<script type='text/javascript'>document.getElementById('edit').style.display='block';</script>");
            $catalog_info2 = $mysqli->query("SELECT * FROM rewood.catalog WHERE id_catalog = '$id_catalog'");

            while ($data = $catalog_info2->fetch_assoc()) {
                $id = $data['id_catalog'];
                $name = $data['name'];
                $desc = $data['description'];
                $date = $data['creation_date'];
            };
        }

        if($_POST['action'] == 'DELETE'){
            $delete = "DELETE FROM rewood.catalog WHERE id_catalog = $id_catalog";
            mysqli_query($mysqli, $delete);
            $main->setContent("script", "<script type='text/javascript'> 
                    if ( window.history.replaceState ) {
                        window.history.replaceState( null, null, window.location.href );
                        window.location.reload();
                    }
                </script>");

        } 
    }

    $main->setContent("left_content", 
        "<div class='left-content'>
            <input type='text' name='id' value='$id' hidden/>
            <input type='text' name='name' placeholder='Name' value='$name'/>
            <textarea id='edit-editor' name='desc' placeholder='Description'>$desc</textarea> 
        </div>");
        
        $main->setContent("right_content","<input type='date' name='date' value='$date' required>");



    if(isset($_POST['edit'])){

        $id = $_POST['id'];
        $name =  $_POST['name'];
        $desc = $_POST['desc'];
        $desc = mysqli_real_escape_string($mysqli, $desc);
        $date =  $_POST['date'];
        
        if(!($_FILES['img']['size'] == 0)){
            $img = $_FILES["img"]["name"];
            $update_catalog="UPDATE rewood.catalog SET name = '$name', creation_date = '$date', description = '$desc', image = '$img' WHERE id_catalog = '$id'"; 
        }else{
            $update_catalog="UPDATE rewood.catalog SET name = '$name', creation_date = '$date', description = '$desc' WHERE id_catalog = '$id'"; 
        }
   
        if(!mysqli_query($mysqli, $update_catalog)){
            $main->setContent("message_edit", "ERROR! product not updated!");
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