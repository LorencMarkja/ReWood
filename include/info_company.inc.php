<?php

    $company_email = $mysqli->query("SELECT * FROM company_info WHERE info_name='email'");
    
    while ($data = $company_email->fetch_assoc()) {
        $main->setContent("company_email", $data['content']);
    };

    $company_phone = $mysqli->query("SELECT * FROM company_info WHERE info_name='phone'");
    
    while ($data = $company_phone->fetch_assoc()) {
        $main->setContent("company_phone", $data['content']);
    };

    $company_address = $mysqli->query("SELECT * FROM company_info WHERE info_name='address'");
    
    while ($data = $company_address->fetch_assoc()) {
        $main->setContent("company_address", $data['content']);
    };

    $company_logo = $mysqli->query("SELECT * FROM company_info WHERE info_name='logo'");
    
    while ($data = $company_logo->fetch_assoc()) {
        $main->setContent("company_logo", $data['content']);
    };
?>