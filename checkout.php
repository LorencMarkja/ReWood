<?php
require "include/connection_db.inc.php";
require "include/template2.inc.php";

session_start();
$id_user = $_SESSION['id_user'];
$id_cart = $SESSION['cart'];

$main = new Template("dtml/checkout.html");
require "include/isLogged.inc.php";

//recupero dal form i dati inseriti
$nameForm=($_POST['name']);
$surnameForm=($_POST['surname']);
$emailForm=($_POST['email']);
$telephoneForm=($_POST['telephone']);

$countryForm=($_POST['country']);
$cityForm=($_POST['city']);
$postcodeForm=($_POST['postcode']);
$addressForm=($_POST['address']);

//recupero i dati utente dal db
$check_user = "select * from user WHERE id_user='$id_user' ";
$run = mysqli_query($mysqli, $check_user);

while ($data = $run->fetch_assoc()) {
    $name = $data['name'];
    $surname = $data['surname'];
    $email = $data['email'];
    $telephone = $data['telephone'];
}

//setto all'interno del form i dati dell'utente presenti nel db
$main->setContent("name", "$name");
$main->setContent("surname", "$surname");
$main->setContent("email", "$email");
$main->setContent("telephone", "$telephone");

//recupero dati indirizzo utente dal db
$check_address = "select * from address WHERE user='$id_user'";
$run1 = mysqli_query($mysqli, $check_address);
while ($data1 = $run1->fetch_assoc()) {
    $postcode = $data1['postcode'];
    $city = $data1['city'];
    $country = $data1['country'];
    $address = $data1['address'];
}

//setto all'interno del form i dati dell'indirizzo utente presenti nel db
$main->setContent("city", "$city");
$main->setContent("country", "$country");
$main->setContent("zip", "$postcode");
$main->setContent("address", "$address");


//se il bottone è cliccato allora faccio l'update se i campi sono stati modificati, se non erano presenti campi faccio la insert
if(isset($_POST['update_data'])) { 

//conta output della query che restituisce city, country, postcode, address dal db
//se non ho risultati effettuo la insert

$rowCount = mysqli_num_rows($run1);
    if ($rowCount == 0) {

        $insertAddress="INSERT INTO address  (postcode, city, country, address, user) VALUES (
            '$postcodeForm', 
            '$cityForm',
            '$countryForm',
            '$addressForm',
            '$id_user')";
        $run2=mysqli_query($mysqli,$insertAddress);
    } 
        else {

            //confontare campi del form con quelli del db e fare update se sono diversi (city, country, address e postcode)
            if($postcode != $postcodeForm ){
                $updatePostcodeForm="update address set postcode = '$postcodeForm' WHERE id_user ='$id_user'";
                $run3=mysqli_query($mysqli,$updatePostcodeForm);
            }
    
            if($city != $cityForm ){
                $updateCityForm="update address set city = '$cityForm' WHERE id_user ='$id_user'";
                $run4=mysqli_query($mysqli,$updateCityForm);
            }
    
            if($country != $countryForm ){
                $updateCountryForm="update address set country = '$countryForm' WHERE id_user ='$id_user'";
                $run5=mysqli_query($mysqli,$updateCountryForm);
            }
    
            if($address != $addressForm ){
                $updateAddressForm="update address set addres = '$addressForm' WHERE id_user ='$id_user'";
                $run6=mysqli_query($mysqli,$updateAddressForm);
            }
        }


        if($name != $nameForm ){
            $updateNameForm="update user set name = '$nameForm' WHERE id_user ='$id_user'";
            $run7=mysqli_query($mysqli,$updateNameForm);
        }

        if($surname != $surnameForm ){
            $updateSurnameForm="update user set surname = '$surnameForm' WHERE id_user ='$id_user'";
            $run8=mysqli_query($mysqli,$updateSurnameForm);
        }

        if($email != $emailForm ){
            $updateEmailForm="update user set email = '$emailForm' WHERE id_user ='$id_user'";
            $run9=mysqli_query($mysqli,$updateEmailForm);
        }

        if($telephone != $telephoneForm ){
            $updateTelephoneForm="update user set telephone = '$telephoneForm' WHERE id_user ='$id_user'";
            $run10=mysqli_query($mysqli,$updateTelephoneForm);
        }

        


    header("Location: checkout.php"); 

    }
    
     $check_idChart = "SELECT * FROM cart_info where id_cart='$id_cart'";
    $run11 = mysqli_query($mysqli, $check_idChart);
    $total_price = 0;

while ($data = $run11->fetch_assoc()) {
    $id_product = $data['id_product'];
    $main->setContent("nameProduct", $data['name']);
    $quantity = $data['quantity'];
    $price = $data['price'];
    $total_product_price = $price * $quantity;
    $main->setContent("totalProduct", $total_product_price . "€" );
    $total_price = $total_price + $total_product_price;
}

$main->setContent("total", "$total_price" . "€"); 

$main->close();
