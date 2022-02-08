<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    $main = new Template("dtml/slider-editor.html");

    
    $slider = $mysqli->query("SELECT * FROM slider ORDER BY id_slider DESC");

    while ($data = $slider->fetch_assoc()) {
        $id=$data['id_slider'];
        $main->setContent("slider_image", $data['slider_image']);
        $decodedString = strip_tags($data['slider_content']);
        $main->setContent("slider_content", $decodedString);
        $main->setContent("btn_form", 
            "<form style='width: 100%;' method='POST'>
                <input id='open_edit' type='submit' class='edit-btn' name='action' value='EDIT' />
                <input type='submit' class='delete-btn' name='action' value='DELETE'/>
                <input type='hidden' name='id_slider' value='$id'/>
            </form>");
    };

    
    if($_POST['action'] && $_POST['id_slider']) {
        $slider= $_POST['id_slider'];

        if ($_POST['action'] == 'EDIT') {
            $main->setContent("script",  "<script type='text/javascript'>document.getElementById('edit').style.display='block';</script>");
            $slider2 = $mysqli->query("SELECT * FROM slider WHERE id_slider = '$slider'");

            while ($data = $slider2->fetch_assoc()) {
                $id = $data['id_slider'];
                $name = $data['slider_image'];
                $content = $data['slider_content'];
                $main->setContent("slider_content_edit", $data['slider_content']);
                $main->setContent("input_id","<input type='hidden' name='id_slider' value='$id'/>");
                
            };
        }

        if($_POST['action'] == 'DELETE'){
            $delete = "DELETE FROM slider WHERE id_slider = $slider";
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

        $id = $_POST['id_slider'];
        $content = $_POST['slider_content'];
        
        if(!($_FILES['img']['size'] == 0)){
            $img = $_FILES["img"]["name"];
            $update_slider="UPDATE slider SET slider_image = '$img', slider_content = '$content' WHERE id_slider = '$id'"; 
        }else{
            $update_slider="UPDATE slider SET slider_content = '$content' WHERE id_slider = '$id'"; 
        }

        if(!mysqli_query($mysqli, $update_slider)){
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

    
    if(isset($_POST['insert'])){

        $img = $_FILES["img"]["name"];
        $slider_content = $_REQUEST['slider_content'];
        
        $slider_ins = "INSERT INTO slider VALUES (
            0,
            '$img', 
            '$slider_content')";
        
        if(mysqli_query($mysqli, $slider_ins)){
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



    $main->close();

?>