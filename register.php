<?php
    require "include/connection_db.inc.php";
    require "include/template2.inc.php";
   
    $errors = array();
    $username = "";
    $email    = "";

    if (isset($_POST['reg_user'])) {

        $name = mysqli_real_escape_string($mysqli, $_POST['name']);
        $surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
        $username = mysqli_real_escape_string($mysqli, $_POST['username']);
        $telephone = mysqli_real_escape_string($mysqli, $_POST['telephone']);
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $password = mysqli_real_escape_string($mysqli, $_POST['password']);

        
        $user_check_query = "SELECT * FROM user WHERE username='$username' OR email='$email' LIMIT 1";
        $result =  mysqli_query($mysqli,$user_check_query);
        $user = mysqli_fetch_assoc($result);


         if ($user) { // if user exists
         if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
         if ($user['email'] === $email) {
        array_push($errors, "email already exists");
    
      }
      }

        if (count($errors) == 0) {
    	$password = md5($password);

    	$query = "INSERT INTO user (name, surname, username, telephone, email, password) 
  			      VALUES('$name','$surname','$username','$telephone', '$email', '$password')";
    	  mysqli_query($mysqli, $query);
  	    header('location: login-register.php');
     }else {

      //$main = new Template("dtml/login.html");
      header("Location: login-register.php");
      $main->setContent("buttonClick",  "<script type='text/javascript'>document.getElementById('registration123').click()</script>");
      $main->setContent("error_message", "Username o email already in use");
    
     }
}


?>

