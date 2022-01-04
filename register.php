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

    	$query = "INSERT INTO user VALUES(0, '$name','$surname','$username', '$email', '$password','$telephone')";
    	  

        if(mysqli_query($mysqli, $query)){

          $last_id = $mysqli->insert_id;

          $query2 = "INSERT INTO wishlist VALUES ( 0,'$last_id')";
          $result = mysqli_query($mysqli, $query2);
          $query3 = "INSERT INTO cart VALUES ( 0,'$last_id')";
          $result2 = mysqli_query($mysqli, $query3);
          $query4 = "INSERT INTO group_user VALUES ( 0, '2','$last_id')";
          $result3 = mysqli_query($mysqli, $query4);
          header('location: login-register.php');
        } 
        
     } else {
      $main = new Template("dtml/login.html");
      require "include/isLogged.inc.php";
      $main->setContent("buttonClick",  "<script type='text/javascript'>window.onload = function(){ document.getElementById('reg-tab').click();}</script>");
      $main->setContent("error_message", "Username o email already in use");
     }
}
$main->close();

?>

