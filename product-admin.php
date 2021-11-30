<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/product.html");

    $product_info = $mysqli->query("
        SELECT *
        FROM product
        INNER JOIN images ON product.id_product=images.product
        INNER JOIN feature ON product.id_product=feature.product
        ORDER BY id_product");

    while ($data = $product_info->fetch_assoc()) {

        $main->setContent("id", $data['id_product']);
        $main->setContent("name", $data['name']);
        $main->setContent("desc", $data['description']);
        $main->setContent("price", $data['price']);
        $main->setContent("pieces", $data['pieces']);
        
    };

    if(isset($_POST['insert'])){

            $name =  $_REQUEST['name'];
            $desc = $_REQUEST['desc'];
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

                $main->setContent("message", "Product created!");

            } else{
                $main->setContent("message", "ERROR! product not created!");
            }
         
        $main->setContent("buttonClick",  "<script type='text/javascript'>document.getElementById('openForm').click()</script>");
           
    }

    if(isset($_POST['select'])){
        echo "The select function is called.";
    }

    $main->close();
?>
