<?php
   session_start();
   $username=$_SESSION['username'];

   if(isset($_SESSION['username'])){
       $main->setContent("logged","
           <ul class='uk-list uk-align-right'>
               <li class='idz-mini-info'>
                   <div class='uk-button-dropdown' data-uk-dropdown>
                       <a href=''><span class='uk-icon-button uk-icon-shopping-cart'></span><div class='uk-badge uk-badge-notification uk-badge-danger'>2</div>$ 12,685.00</a>
                       <div class='uk-dropdown uk-dropdown-center'>
                           <ul class='uk-nav uk-nav-dropdown idz-product-widget'>
                               <li class='uk-text-truncate'>
                                   <a href='product-page.html'>
                                       <img src='images/product-images/product_thumb1a.jpg' alt=''>
                                       <p>Graham Sofa in Blue</p>
                                   </a>
                                   <span>1 x $ 1,440.00</span>
                               </li>
                               <li class='uk-text-truncate'>
                                   <a href='product-page.html'>
                                       <img src='images/product-images/product_thumb2.jpg' alt=''>
                                       <p>Zahra Armchair</p>
                                   </a>
                                   <span>1 x $ 1,440.00</span>
                               </li>
                               <li class='subtotal-price'>
                                   <h6>Subtotal : $ 12,685.00</h6>
                               </li>
                               <li>
                                   <a href='shopping-cart.html' class='uk-button uk-button-mini idz-button-white uk-width-1-2'>View cart</a>
                                   <a href='checkout.html' class='uk-button uk-button-mini idz-button-white uk-width-1-2'>Checkout</a>
                               </li>
                           </ul>
                       </div>
                   </div>
               </li>
               <li>
                   <a href='my-account.php'>My Account</a>
               </li>
               <li>
                   <a href='wishlist.php'>Wishlist</a>
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