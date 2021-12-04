<?php

    require "product-admin.php";

    $product_info2 = $mysqli->query("
    SELECT *
    FROM product_info
    WHERE id=$id");

    while ($data = $product_info2->fetch_assoc()) {
        $id = $data['id_product'];
        $name = $data['name'];
        $desc = $data['description'];
        $price = $data['price'];
        $pieces = $data['pieces'];
    };

    $main->setContent("form_edit", 
        "<div class='left-content'>
            <input type='text' name='id' hidden/>
            <input type='text' name='name' placeholder='Name'/>
            <textarea name='desc' placeholder='Description'>aa</textarea>
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
                <input type='number' name='pieces' placeholder='Pieces' required>
                <input type='text' name='price' placeholder='Price' required>
            </div>
            
        </div>
        <div class='right-content'>
            <input type='text' name='dim' placeholder='Dimension'/>
            <input type='text' name='weight' placeholder='Weight'/>
            <input type='text' name='material' placeholder='Material'/>

            <select id='categories' name='category' form='insert-form' multiple>
                <option value='' selected disabled hidden>Choose category</option>
                <[category::select table='category' key='id_category' value='name' library='widget']>
            </select>

            <select id='catalogs' name='catalog' form='insert-form' multiple>
                <option value='' selected disabled hidden>Choose catalog</option>
                <[catalog::select table='catalog' key='id_catalog' value='name' library='widget']>
            </select>
        </div>"
    );

    
?>