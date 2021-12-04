<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";

    session_start();

    $main = new Template("dtml/my-account.html");
    $usernameLogged=$_SESSION['username'];
  
    

    
    $check_user="select * from user WHERE username='$usernameLogged' ";
    $run=mysqli_query($mysqli,$check_user);

    while ($data = $run->fetch_assoc()){
      $usernameDisplay = $data['username'];
      $passwordDisplay = $data['password'];
      $id_user = $data['id_user'];
      $nameDisplay = $data['name'];
      $surnameDisplay = $data['surname'];
      $emailDisplay = $data['email'];
      $telephoneDisplay = $data['telephone'];
      
    }
    
    if(isset($_POST['updateData'])) {  
        $newAddress=addslashes($_POST['address']);
        $newCity=addslashes($_POST['city']);
        $newPostcode=$_POST['postcode'];
        $newCountry=$_POST['country']; 
        $newPassword=($_POST['password']);
        $repeatPassword=($_POST['repeatPassword']);
        $newPassword=md5($newPassword); 
      
        if(!empty($_POST["address"]))
        {  
            $updateAddress="update address set address = '$newAddress' WHERE user ='$id_user'";
            $run=mysqli_query($mysqli,$updateAddress);
        }   
        if(!empty($_POST["city"]))
        {  
            $updateCity="update address set city = '$newCity' WHERE user ='$id_user'";
            $run2=mysqli_query($mysqli,$updateCity);
        }   
        if(!empty($_POST["postcode"]))
        {  
            $updatePostcode="update address set postcode = '$newPostcode' WHERE user ='$id_user'";
            $run3=mysqli_query($mysqli,$updatePostcode);
        }   
        if(!empty($_POST["country"]))
        {  
            $updateCountry="update address set country = '$newCountry' WHERE user ='$id_user'";
            $run4=mysqli_query($mysqli,$updateCountry);
        }   

        if(!empty($_POST["password"])  && !empty($_POST["repeatPassword"]) && ($_POST["password"]==$_POST["repeatPassword"]) )
        {  
            $updatePassword="update user set password = '$newPassword' WHERE id_user ='$id_user'";
            $run5=mysqli_query($mysqli,$updatePassword);
        }   
        else if($_POST["password"]!=$_POST["repeatPassword"]){
            $main->setContent("errorMessage", "Attenzione, le password non coincidono!");
        }
          
      }

    $check_address="select * from address WHERE user='$id_user'";
    $run6=mysqli_query($mysqli,$check_address);
    while ($data1 = $run6->fetch_assoc()){
        $postcodeDisplay = $data1['postcode'];
        $cityDisplay = $data1['city'];
        $countryDisplay = $data1['country'];
        $addressDisplay = $data1['address'];
        
      }

      $check_orders="select * FROM rewood.order AS orders LEFT JOIN cart ON orders.cart=id_cart WHERE orders.user='$id_user' and cart.user='$id_user' ORDER BY date DESC LIMIT 5";
    $run7=mysqli_query($mysqli,$check_orders);
    while ($data1 = $run7->fetch_assoc()){
        $main->setContent("orderNumber", $data1['order_number']);
        $main->setContent("date", $data1['date']);
        $main->setContent("total", $data1['total_price']);  
      };


    $main->setContent("name", $nameDisplay);
    $main->setContent("surname", $surnameDisplay);
    $main->setContent("email", $emailDisplay);
    $main->setContent("telephone", $telephoneDisplay);
    $main->setContent("username", $usernameDisplay);
   

    $main->setContent("postcode", $postcodeDisplay);
    $main->setContent("city", $cityDisplay);
    $main->setContent("country", $countryDisplay);
    $main->setContent("address", $addressDisplay);

    
    $main->close();

?>

