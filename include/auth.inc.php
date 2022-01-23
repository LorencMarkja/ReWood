<?php

    session_start();

    $result = $mysqli->query("
        SELECT service.name_script AS script
        from user
        left join group_user
        on group_user.user = user.id_user
        left join service_group 
        ON service_group.group = group_user.group_type
        left JOIN service
        ON service.id_services = service_group.service
        where user.username = '{$_SESSION['username']}'
    ");

    if (!$result) {
        echo "Error!";
        exit;
    } 

    $script = array();

    while ($data = $result->fetch_assoc()) {

        $script[$data['script']] = true;

    }

    $_SESSION['auth'] = $script;

    $script = basename($_SERVER['SCRIPT_NAME']);

    if (!isset($_SESSION['auth'][$script])) {
        $main = new Template("dtml/404.html");
        require "include/isLogged.inc.php";
        $main->close();
        exit;
    }


?>