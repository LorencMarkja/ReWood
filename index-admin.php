<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/index-admin.html");

    $result = $mysqli->query("SELECT * FROM rewood.order");

    while ($data = $result->fetch_assoc()) {

		$main->setContent("order_number", $data['order_number']);

	};

    $main->close();
?>