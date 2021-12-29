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
$postcodeForm=($_POST['zip']);
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

//conta output della query che restituisce nome, cognome, email, telefono dal db
//se non ho risultati effettuo la insert
$rowCount = mysqli_num_rows($run);
    if ($rowCount == 0) {

    //insert
    } 

//conta output della query che restituisce city, country, postcode, address dal db
//se non ho risultati effettuo la insert
$rowCount1 = mysqli_num_rows($run1);
    if ($rowCount1 != 0) {

    //insert
    } 

        if($name != $nameForm ){
            $updateNameForm="update user set name = '$nameForm' WHERE id_user ='$id_user'";
            $run=mysqli_query($mysqli,$updateNameForm);
        }

        if($surname != $surnameForm ){
            $updateSurnameForm="update user set surname = '$surnameForm' WHERE id_user ='$id_user'";
            $run=mysqli_query($mysqli,$updateSurnameForm);
        }

        if($email != $emailForm ){
            $updateEmailForm="update user set email = '$emailForm' WHERE id_user ='$id_user'";
            $run=mysqli_query($mysqli,$updateEmailForm);
        }

        if($telephone != $telephoneForm ){
            $updateTelephoneForm="update user set telephone = '$telephoneForm' WHERE id_user ='$id_user'";
            $run=mysqli_query($mysqli,$updateTelephoneForm);
        }

        //confontare campi del form con quelli del db e fare update se sono diversi (city, country, address e postcode)


    header("Location: checkout.php"); 

}


$main->close();
