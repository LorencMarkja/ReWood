<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/product.html");

    $product_info = $mysqli->query("
        SELECT *
        FROM product
        INNER JOIN images ON product.id_product=images.product
        INNER JOIN feature ON product.id_product=feature.product
        ORDER BY id_product DESC");

    while ($data = $product_info->fetch_assoc()) {
        $main->setContent("id", $data['id_product']);
        $id=$data['id_product'];
        $main->setContent("name", $data['name']);
        $main->setContent("desc", $data['description']);
        $main->setContent("price", $data['price']);
        $main->setContent("pieces", $data['pieces']);
        $main->setContent("btn_form", 
            "<form style='width: 100%;' method='POST'>
                <input id='open_edit' type='submit' class='edit-btn' name='action' value='EDIT' />
                <input type='submit' class='delete-btn' name='action' value='DELETE'/>
                <input type='hidden' name='id_prod' value='$id'/>
            </form>");
    };

    if(isset($_POST['insert'])){

            $name =  $_REQUEST['name'];
            $desc = $_REQUEST['desc'];
            $desc = mysqli_real_escape_string($mysqli, $desc);
            $price =  $_REQUEST['price'];
            $pieces = $_REQUEST['pieces'];
            $dimension =  $_REQUEST['dim'];
            $weight = $_REQUEST['weight'];
            $material =  $_REQUEST['material'];
            $categories = $_REQUEST['category'];
            $catalogs = $_REQUEST['catalog'];

            $front = $_FILES["front_img"]["name"];
            $back = $_FILES["back_img"]["name"];
            $side = $_FILES["side_img"]["name"];

            $prod_ins = "INSERT INTO product  VALUES (
                0,
                '$name', 
                '$price',
                '$desc',
                '$pieces')";
    
            
            if(mysqli_query($mysqli, $prod_ins)){

                $last_id = $mysqli->insert_id;

                $feature_ins = "INSERT INTO feature  VALUES (
                    0,
                    '$dimension', 
                    '$weight',
                    '$material',
                    '$last_id')";
                
                $images_ins = "INSERT INTO images  VALUES (
                    0,
                    '$front',
                    '$back',
                    '$side',
                    '$last_id')";
                
                foreach($categories as $category){
                    $prod_cat = "INSERT INTO product_category  VALUES (
                        0,
                        '$last_id',
                        '$category')";
                    
                    $flag = mysqli_query($mysqli, $prod_cat);
                    
                    if(!$flag){
                        $main->setContent("message", "ERROR! product not created!");
                    }
                }

                foreach($catalogs as $catalog){
                    $prod_catalog = "INSERT INTO product_catalog  VALUES (
                        0,
                        '$last_id',
                        '$catalog')";

                    $flag = mysqli_query($mysqli, $prod_catalog);
                    
                    if(!$flag){
                        $main->setContent("message", "ERROR! product not created!");
                    }
                }
                                       

                if(!mysqli_query($mysqli, $feature_ins)){
                    $main->setContent("message", "ERROR! product not created!");
                }
                   
                if(!mysqli_query($mysqli, $images_ins)){
                    $main->setContent("message", "ERROR! product not created!");
                }

                $main->setContent("script", "<script type='text/javascript'> 
                    if ( window.history.replaceState ) {
                        window.history.replaceState( null, null, window.location.href );
                        window.location.reload();
                    }
                </script>");

            } else{
                $main->setContent("script",  "<script type='text/javascript'>document.getElementById('openForm').click()</script>");
                $main->setContent("message", "ERROR! product not created!");
            } 
    }

    if($_POST['action'] && $_POST['id_prod']) {
        $id_prod = $_POST['id_prod'];

        if ($_POST['action'] == 'EDIT') {
            $main->setContent("script",  "<script type='text/javascript'>document.getElementById('edit').style.display='block';</script>");
            $product_info2 = $mysqli->query("SELECT * FROM product_info WHERE id_product = '$id_prod'");

            while ($data = $product_info2->fetch_assoc()) {
                $id = $data['id_product'];
                $name = $data['name'];
                $desc = $data['description'];
                $price = $data['price'];
                $pieces = $data['pieces'];
                $dim = $data['dimension'];
                $weight = $data['weight'];
                $material = $data['material'];
            };
        }

        if($_POST['action'] == 'DELETE'){
            $delete = "DELETE FROM product WHERE id_product = $id_prod";
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
            <textarea name='desc' placeholder='Description'>$desc</textarea>
            <div class='images-up-container'>
                <label for='files' class='btn'>Select Front Image: </label>
                <input type='file' class='file' name='front_img' accept='image/png, image/gif, image/jpeg'>
            </div>
            <div class='images-up-container'>
                <label for='files' class='btn'>Select Back Image: </label>
                <input type='file' class='file' name='back_img' accept='image/png, image/gif, image/jpeg'>
            </div>
            <div class='images-up-container'>
                <label for='files' class='btn'>Select Side Image:  </label>
                <input type='file' class='file' name='side_img' accept='image/png, image/gif, image/jpeg'>
            </div>        
            <div class='flex-container'>
                <input type='number' name='pieces' placeholder='Pieces' value='$pieces' required>
                <input type='text' name='price' placeholder='Price' value='$price' required>
            </div>  
        </div>");
        
        $main->setContent("right_content",
        "   <input type='text' name='dim' placeholder='Dimension'  value='$dim'/>
            <input type='text' name='weight' placeholder='Weight' value='$weight'/>
            <input type='text' name='material' placeholder='Material'  value='$material'/>");



    if(isset($_POST['edit'])){

        $id = $_POST['id'];
        $name =  $_POST['name'];
        $desc = $_POST['desc'];
        $desc = mysqli_real_escape_string($mysqli, $desc);
        $price =  $_POST['price'];
        $pieces = $_POST['pieces'];
        $dimension =  $_POST['dim'];
        $weight = $_POST['weight'];
        $material =  $_POST['material'];
        $categories = $_REQUEST['category'];
        $catalogs = $_REQUEST['catalog'];

        $front = $_FILES["front_img"]["name"];
        $back = $_FILES["back_img"]["name"];
        $side = $_FILES["side_img"]["name"];

        $update_prod ="UPDATE product SET name = '$name', description = '$desc', pieces = '$pieces', price = '$price' WHERE id_product = '$id'"; 

        $update_feat = $mysqli->query("UPDATE feature SET dimension = '$dimension', weight = '$weight', material = '$material' WHERE product='$id'"); 

        if(!mysqli_query($mysqli, $update_prod)){
            $main->setContent("message_edit", "ERROR! product not updated!");
            $main->setContent("script", "<script type='text/javascript'>document.getElementById('open_edit').click()</script>");
        } 
        if(!($update_feat)){
            $main->setContent("script", "<script type='text/javascript'>document.getElementById('open_edit').click()</script>");
            $main->setContent("message_edit", "ERROR! product not updated!");
        }

        if (!($_FILES['front_img']['size'] == 0)){
            $update_img = $mysqli->query("UPDATE images SET front = '$front' WHERE product='$id'"); 
            if(!($update_img)){
               $main->setContent("script",  "<script type='text/javascript'>document.getElementById('open_edit').click()</script>");
               $main->setContent("message", "ERROR! product not updated!");
            }
        }
        if (!($_FILES['back_img']['size'] == 0)){
            $update_img = $mysqli->query("UPDATE images SET back = '$back' WHERE product='$id'");
            if(!($update_img)){
                $main->setContent("script",  "<script type='text/javascript'>document.getElementById('open_edit').click()</script>");
                $main->setContent("message", "ERROR! product not updated!");
            } 
        }
        if (!($_FILES['side_img']['size'] == 0)){
            $update_img = $mysqli->query("UPDATE images SET side = '$side' WHERE product='$id'"); 
            if(!($update_img)){
                $main->setContent("script",  "<script type='text/javascript'>document.getElementById('open_edit').click()</script>");
                $main->setContent("message", "ERROR! product not updated!");
            }
        }

        if(isset($_REQUEST["category"])){
            $delete = $mysqli->query("DELETE FROM product_category WHERE product='$id'");
            
            foreach($categories as $category){
                $update_cat = "INSERT INTO product_category  VALUES (
                    0,
                    '$id',
                    '$category')";
                
                $flag = mysqli_query($mysqli, $update_cat);
                
                if(!$flag){
                    $main->setContent("script",  "<script type='text/javascript'>document.getElementById('open_edit').click()</script>");
                    $main->setContent("message", "ERROR! product not updated!");
                }
            }
        }
        if(isset($_REQUEST["catalog"])){
            $delete = $mysqli->query("DELETE FROM product_catalog WHERE product='$id'");
        
            foreach($catalogs as $catalog){
                $update_catalog = "INSERT INTO product_catalog  VALUES (
                    0,
                    '$id',
                    '$catalog')";

                $flag = mysqli_query($mysqli, $update_catalog);
                
                if(!$flag){
                    $main->setContent("script",  "<script type='text/javascript'>document.getElementById('open_edit').click()</script>");
                    $main->setContent("message", "ERROR! product not updated!");
                }
            }
        }

        $main->setContent("script", "<script type='text/javascript'> 
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            window.location.reload();
        }
        </script>");

    }


    $main->close();
?>
