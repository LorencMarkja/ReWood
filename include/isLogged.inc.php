<?php
   session_start();
   $username=$_SESSION['username'];
   $id_user=$_SESSION['id_user'];
   $id_cart=$_SESSION['cart'];

   if(isset($_SESSION['username'])){
    $count = "SELECT quantity FROM cart_info WHERE id_user = $id_user AND id_cart = (SELECT MAX(id_cart) FROM cart WHERE user = $id_user) ";
    $run=mysqli_query($mysqli,$count);
    $cont=0;
    while ($data1 = $run->fetch_assoc()){
        $cont=$cont+$data1['quantity'];
    };

    $subtot = "SELECT price, quantity FROM cart_info WHERE id_user = $id_user AND id_cart = (SELECT MAX(id_cart) FROM cart WHERE user = $id_user) ";
    $run2=mysqli_query($mysqli,$subtot);
    $numRows = mysqli_num_rows($run2);
    if($numRows!=0){
        $euro = "€";
      while ($data2 = $run2->fetch_assoc()){
            $price = $data2['price'];
            $quantity = $data2['quantity'];
            $subtotal = $price * $quantity;
            $total_price = $total_price + $subtotal;
        };
    }else{
        $euro= " ";
    }

       $main->setContent("logged","
           <ul class='uk-list uk-align-right'>
               <li class='idz-mini-info'>
                   <div class='uk-button-dropdown' data-uk-dropdown>
                       <a href='cart.php'><span class='uk-icon-button uk-icon-shopping-cart'></span><div class='uk-badge uk-badge-notification uk-badge-danger'>$cont</div> $total_price $euro</a>
                       
                   </div>
               </li>
               <li>
                   <a href='my-account.php'>My Account</a>
               </li>
               <li>
                   <a href='wishlist.php'>Wishlist</a>
               </li>
               <li>
                   <a href='logout.php'>Logout</a>
               </li>
           </ul>");
   }else{
       $main->setContent("logged", " 
           <ul class='uk-list uk-align-right'>
               <li>
                   <a href='index.php'>Home</a>
               </li>
               <li>
                   <a href='login-register.php'>Register</a>
               </li>
               <li>
                   <a href='login-register.php'>Login</a> 
               </li>
           </ul>");
   }
   
?>