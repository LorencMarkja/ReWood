<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    $main = new Template("dtml/category-admin.html");
    require "include/auth.inc.php";

    $category_info = $mysqli->query("SELECT * FROM rewood.category ORDER BY id_category DESC");

    while ($data = $category_info->fetch_assoc()) {
        $id=$data['id_category'];
        $main->setContent("id", $id);
        $img = $data['image'];
        $main->setContent("image", "<img src='dtml/images/category-images/$img' style='width: 45px; height: 45px;' alt='category image'>");
        $main->setContent("name", $data['name']);
        $main->setContent("date", $data['creation_date']);
        $main->setContent("desc", $data['description']);
        $main->setContent("btn_form", 
            "<form style='width: 100%;' method='POST'>
                <input id='open_edit' type='submit' class='edit-btn' name='action' value='EDIT' />
                <input type='submit' class='delete-btn' name='action' value='DELETE'/>
                <input type='hidden' name='id_category' value='$id'/>
            </form>");
    };

    if(isset($_POST['insert'])){

        $name =  $_REQUEST['name'];
        $desc = $_REQUEST['desc'];
        $desc = mysqli_real_escape_string($mysqli, $desc);
    
        $img = $_FILES["img"]["name"];
        $subcategories = $_REQUEST['subcategory'];

        $category_ins = "INSERT INTO rewood.category  VALUES (
            0,
            '$name', 
            '$desc',
            '$img')";

        
        if(mysqli_query($mysqli, $category_ins)){
         

            $last_id = $mysqli->insert_id;

            foreach($subcategories as $subcategory){
                $cat_subcat = "INSERT INTO category_subcategory VALUES (
                    0,
                    '$last_id',
                    '$subcategory')";
                
                $flag = mysqli_query($mysqli, $cat_subcat);
                
                if(!$flag){
                    $main->setContent("message", "ERROR! subcategory relation not added!");
                }
            }

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

    if($_POST['action'] && $_POST['id_category']) {
        $id_category = $_POST['id_category'];

        if ($_POST['action'] == 'EDIT') {
            $main->setContent("script",  "<script type='text/javascript'>document.getElementById('edit').style.display='block';</script>");
            $category_info2 = $mysqli->query("SELECT * FROM category WHERE id_category = '$id_category'");

            while ($data = $category_info2->fetch_assoc()) {
                $id = $data['id_category'];
                $main->setContent("edit_id", $data['id_category']);
                $main->setContent("edit_name", $data['name']);
                $main->setContent("edit_desc", $data['description']);
            };
        }

        if($_POST['action'] == 'DELETE'){
            $delete = "DELETE FROM rewood.category WHERE id_category = $id_category";
            mysqli_query($mysqli, $delete);
            $main->setContent("script", "<script type='text/javascript'> 
                    if ( window.history.replaceState ) {
                        window.history.replaceState( null, null, window.location.href );
                        window.location.reload();
                    }
                </script>");

        } 
    }


    if(isset($_POST['edit'])){

        $id = $_POST['id'];
        $name =  $_POST['name'];
        $desc = $_POST['desc'];
        $desc = mysqli_real_escape_string($mysqli, $desc);
        $subcategories = $_POST['subcategory'];
        
        if(!($_FILES['img']['size'] == 0)){
            $img = $_FILES["img"]["name"];
            $update_category="UPDATE rewood.category SET name = '$name', description = '$desc', image = '$img' WHERE id_category = '$id'"; 
        }else{
            $update_category="UPDATE rewood.category SET name = '$name', description = '$desc' WHERE id_category = '$id'"; 
        }

        if(!mysqli_query($mysqli, $update_category)){
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

        if(isset($_POST["subcategory"])){
            $delete = $mysqli->query("DELETE FROM category_subcategory WHERE category='$id'");
            
            foreach($subcategories as $subcategory){
                $update_cat = "INSERT INTO category_subcategory  VALUES (
                    0,
                    '$id',
                    '$subcategory')";
                
                $flag = mysqli_query($mysqli, $update_cat);
                
                if(!$flag){
                    $main->setContent("script",  "<script type='text/javascript'>document.getElementById('open_edit').click()</script>");
                    $main->setContent("message", "ERROR! product not updated!");
                }
            }
        }
    }

    $main->close();

?>