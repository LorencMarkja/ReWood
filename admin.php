<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
	require "include/auth.inc.php";
    
    $main = new Template("dtml/index-admin.html");

    $orders_info = $mysqli->query("
        SELECT *
        FROM rewood.order AS orders
        INNER JOIN rewood.user ON orders.user=user.id_user;");


    $total_income = 0;

    while ($data = $orders_info->fetch_assoc()) {

		$main->setContent("order_number", $data['order_number']);
        $main->setContent("username", $data['username']);
        $main->setContent("date", $data['date']);
        $main->setContent("total_price", $data['total']." €");

        $total_income = $data['total'] + $total_income;
        
	};

    $main->setContent("total_income", $total_income);
    
    $orders = $mysqli->query("
        SELECT COUNT(*) AS number_orders
        FROM rewood.order");

    while ($data = $orders->fetch_assoc()) {
        $main->setContent("orders_numb", $data['number_orders']);
    }

    $clients = $mysqli->query("
        SELECT COUNT(*) AS number_clients
        FROM group_user
        WHERE group_user.group_type = 2;");

    while ($data = $clients->fetch_assoc()) {
        $main->setContent("clients_numb", $data['number_clients']);
    }

    $main->close();
?>