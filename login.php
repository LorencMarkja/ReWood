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

    if(mysqli_num_rows($run)) {  

        if($group_type == 1){
          header("Location: index-admin.php");
        }else{
          header("Location: my-account.php");
        }
    }else{  

      $main = new Template("dtml/login.html");
      $main->setContent("message", "Username or password are incorrect!");
    }  
  
$_SESSION['username']= $username;




$main->close();

?>  
