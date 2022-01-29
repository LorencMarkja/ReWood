<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    if(isset($_GET['title'])){
        $main = new Template("dtml/page.html");
        require "include/isLogged.inc.php";
        require "include/info_company.inc.php";


        $title = $_GET['title'];
        $page = $mysqli->query("SELECT * FROM page WHERE title = '$title'");
        $rowcount = mysqli_num_rows($page);
        if ($rowcount == 0) {
            $main = new Template("dtml/404.html");
            require "include/isLogged.inc.php";
        }
        while ($data = $page->fetch_assoc()) {
            $id_page=$data['id_page'];
            $main->setContent("title", $data['title']);
            $main->setContent("content", $data['content']);
        };
        
    }
    $main->close();

?>