<?php  
  
  require "include/connection_db.inc.php";
  require "include/template2.inc.php";
  
  session_start();

 /* if(empty($_POST["username"]) && empty($_POST["password"]))                           DA IMPLEMENTARE
      {  
           echo '<script>alert("Both Fields are required")</script>';  
           header("Location: login-register.php");
      }  
else{ */

  if(isset($_POST['login_user'])) {  
    $username=$_POST['username'];  
    $password=($_POST['password']);
    $password=md5($password); 
  
    $check_user="select * from user WHERE username='$username'AND password='$password' ";  

    $run=mysqli_query($mysqli,$check_user);  
  }
    while ($data = $run->fetch_assoc()) {
      $id_user = $data['id_user'];
      $username = $data['username'];
      $password = $data['password'];

    }
    
    $check_group="select group_type from group_user where user='$id_user'";
    $run1=mysqli_query($mysqli,$check_group);

    while ($data = $run1->fetch_assoc()){
      $group_type = $data['group_type'];
      
    }

    $sql = "SELECT MAX(id_cart) AS id_cart FROM cart WHERE user = '$id_user'";
    $result = $mysqli -> query($sql);

    // Associative array
    $row = $result -> fetch_assoc();
    $id_cart=$row['id_cart'];

    if(mysqli_num_rows($run)) {  

        if($group_type == 1){
          
          header("Location: index-admin.php");
        }else{

               header("Location: index.php");
        }
    }else{  

      $main = new Template("dtml/login.html");
      require "include/isLogged.inc.php";
      $main->setContent("message", "Username or password are incorrect!");
    }  

    
$_SESSION['username']= $username;
$_SESSION['id_user']= $id_user;
$_SESSION['cart']= $id_cart;







?>  
