<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";  
    $db = "rewood";

    // Create connection 
    $mysqli = new mysqli($servername, $username, $password, $db); 
    // Check connection 

    if ($mysqli->connect_error) {   
        die("Connection failed: " . $mysqli->connect_error); 
    }; 

?>