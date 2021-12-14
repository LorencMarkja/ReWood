<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
    

    session_start();

    $main = new Template("dtml/my-account.html");
    require "include/isLogged.inc.php";
    $usernameLogged=$_SESSION['username'];
  
    

    
    $check_user="select * from user WHERE username='$usernameLogged' ";
    $run8=mysqli_query($mysqli,$check_user);

    while ($data = $run8->fetch_assoc()){
      $usernameDisplay = $data['username'];
      $passwordDisplay = $data['password'];
      $id_user = $data['id_user'];
      $nameDisplay = $data['name'];
      $surnameDisplay = $data['surname'];
      $emailDisplay = $data['email'];
      $telephoneDisplay = $data['telephone'];
      
    }
    
    $check_address="select * from address WHERE user='$id_user'";
    $run7=mysqli_query($mysqli,$check_address);
    while ($data1 = $run7->fetch_assoc()){
        $postcodeDisplay = $data1['postcode'];
        $cityDisplay = $data1['city'];
        $countryDisplay = $data1['country'];
        $addressDisplay = $data1['address'];
        
      }
      
    $numRows = mysqli_num_rows($run7);

    $check_orders="select * FROM rewood.order AS orders LEFT JOIN cart ON orders.cart=id_cart WHERE orders.user='$id_user' and cart.user='$id_user' ORDER BY date DESC LIMIT 5";
    $run6=mysqli_query($mysqli,$check_orders);
    while ($data1 = $run6->fetch_assoc()){
        $main->setContent("orderNumber", $data1['order_number']);
        $main->setContent("date", $data1['date']);
        $main->setContent("total", $data1['total_price']);  
        $main->setContent("view", "<a class='uk-button uk-button-small idz-button-grey uk-width-1-1'>View</a>");      
    };


    if($numRows !=0) {
        $main->setContent("infoAddress", "Edit your address");
        $main->setContent("valueButt", "Edit your data");
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
        header("Location: my-account.php");
      }
    }
    if($numRows == 0){
        $main->setContent("infoAddress", "Insert your address");
        $main->setContent("valueButt", "Insert your data");
        if (isset($_POST['updateData'])){
        echo("ECCO LA PROVA ADATTA");
        $newAddress=addslashes($_POST['address']);
        $newCity=addslashes($_POST['city']);
        $newPostcode=$_POST['postcode'];
        $newCountry=$_POST['country'];

        
            $insertAddress="INSERT INTO address  VALUES (
                0,
                '$newPostcode', 
                '$newCity',
                '$newCountry',
                '$newAddress',
                '$id_user')";
            $run9=mysqli_query($mysqli,$insertAddress);
           
            header("Location: my-account.php");
      }
      
    }


    $main->setContent("name", $nameDisplay);
    $main->setContent("surname", $surnameDisplay);
    $main->setContent("email", $emailDisplay);
    $main->setContent("telephone", $telephoneDisplay);
    $main->setContent("username", $usernameDisplay);
   

    $main->setContent("postcode", $postcodeDisplay);
    $main->setContent("city", $cityDisplay);
    $main->setContent("country", $countryDisplay);
    $main->setContent("address", $addressDisplay);

    $_SESSION['id_user']= $id_user;
    
    $main->close();

?>

