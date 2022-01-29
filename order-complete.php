<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    
    
    session_start();
    $id_user=$_SESSION['id_user'];
    
    
    $main = new Template("dtml/order-complete.html");
    require "include/isLogged.inc.php";
    require "include/info_company.inc.php";


    $sql = "SELECT MAX(cart) AS id_cart FROM rewood.order WHERE user = '$id_user'";
    $result = $mysqli -> query($sql);

    $row = $result -> fetch_assoc();
    $id_cart=$row['id_cart'];
   
    $check_address="select * from address WHERE user='$id_user'";
    $run7=mysqli_query($mysqli,$check_address);
    while ($data1 = $run7->fetch_assoc()){
        $postcode = $data1['postcode'];
        $city = $data1['city'];
        $country = $data1['country'];
        $address = $data1['address'];
        
      }

      $main->setContent("city", "$city");
      $main->setContent("country", "$country");
      $main->setContent("postcode", "$postcode");
      $main->setContent("address", "$address");


      $check_user="select * from user WHERE id_user='$id_user' ";
    $run8=mysqli_query($mysqli,$check_user);

    while ($data = $run8->fetch_assoc()){
      $username = $data['username'];
      $password = $data['password'];
      $id_user = $data['id_user'];
      $name = $data['name'];
      $surname = $data['surname'];
      $email = $data['email'];
      $telephone = $data['telephone'];
      
    }

    $main->setContent("nameUser", "$name");
    $main->setContent("surname", "$surname");
    $main->setContent("email", "$email");
    $main->setContent("telephone", "$telephone");

    $check_address="select * from rewood.order WHERE user='$id_user' AND cart='$id_cart'";
    $run7=mysqli_query($mysqli,$check_address);
    while ($data1 = $run7->fetch_assoc()){
        $orderNumber = $data1['order_number'];
        $date = $data1['date'];
        $total = $data1['total'];
        
        
      }

      $main->setContent("numberOrder", "$orderNumber");
      $main->setContent("date", "$date");
      $main->setContent("total", "$total" . "€");

      $check_idChart = "SELECT * FROM cart_info where id_cart='$id_cart'";
        $run1 = mysqli_query($mysqli, $check_idChart);
        $total_price = 0;




    while ($data = $run1->fetch_assoc()) {
    $id_product = $data['id_product'];
    $main->setContent("nameProduct", $data['name']);
    $quantity = $data['quantity'];
    $price = $data['price'];
    $total_product_price = $price * $quantity;
    $main->setContent("totalProduct", "$total_product_price" . "€");
    
}
    


     


    $main->close();

    ?>