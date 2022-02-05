<?php

    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/subcategory-admin.html");
    require "include/auth.inc.php";

    $subcat_info = $mysqli->query("SELECT * FROM rewood.subcategory ORDER BY id_subcategory");

    while ($data = $subcat_info->fetch_assoc()) {
            $id=$data['id_subcategory'];
            $main->setContent("id", $id);
            $main->setContent("name", $data["name"]);
            $main->setContent("btn_form", 
                "<form style='width: 100%; display:flex; align-items: center;' method='POST'>
                    <input type='submit' class='delete-btn' style='height: 30px; width:100%' name='delete' value='DELETE'/>
                    <input type='hidden' name='id_category' value='$id'/>
                </form>");
    };

    
    if(isset($_POST['insert'])){
        $name =  $_POST['name'];
        $subcategory_ins = "INSERT INTO subcategory  VALUES (
            0,
            '$name')";

        
        $flag = mysqli_query($mysqli, $subcategory_ins);

        if(!$flag){
            $main->setContent("message", "Name already used!");
        }

        $main->setContent("script", "<script type='text/javascript'> 
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            window.location.reload();
        }
        </script>");
    }

    if(isset($_POST['delete'])){
        $id=$_POST["id_category"];

        $delete = "DELETE FROM subcategory WHERE id_subcategory = $id";
        mysqli_query($mysqli, $delete);
        $main->setContent("script", "<script type='text/javascript'> 
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            window.location.reload();
        }
        </script>");
    }
    $main->close();
?>