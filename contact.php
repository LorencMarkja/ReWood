<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    $main = new Template("dtml/contact.html");
    require "include/isLogged.inc.php";
    require "include/info_company.inc.php";


    $main->close();

?>