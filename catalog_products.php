<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    $main = new Template("dtml/shop-fullwidth.html");
    require "include/isLogged.inc.php";

    $main->close();
?>