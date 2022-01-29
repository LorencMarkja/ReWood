<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    $main = new Template("dtml/contacts-editor.html");
    require "include/info_company.inc.php";


    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $company_email_update = $mysqli->query("UPDATE company_info SET content ='$email' WHERE info_name='email'");
        $company_phone_update = $mysqli->query("UPDATE company_info SET content ='$phone' WHERE info_name='phone'");
        $company_address_update = $mysqli->query("UPDATE company_info SET content ='$address' WHERE info_name='address'");
        
        if(isset( $_POST['logo'])){
            $logo = $_POST['logo'];
            $company_logo_update = $mysqli->query("UPDATE company_info SET content ='$logo' WHERE info_name='logo'");
        }
        
        header("Refresh:0");
    }

    $main->close();

?>