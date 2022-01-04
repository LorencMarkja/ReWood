<?php
require "include/connection_db.inc.php";
require "include/template2.inc.php";

session_start();
$id_user = $_SESSION['id_user'];
$id_cart = $SESSION['cart'];

$main = new Template("dtml/shopping-cart.html");
require "include/isLogged.inc.php";

$check_idChart = "SELECT * FROM cart_info where id_cart='$id_cart'";
$run1 = mysqli_query($mysqli, $check_idChart);
$total_price = 0;
$rowCount = mysqli_num_rows($run1);

if($rowCount != 0){
    while ($data = $run1->fetch_assoc()) {
        $id_product = $data['id_product'];
        $main->setContent("id_prod", $data['id_product']);
        $main->setContent("image", $data['image']);
        $main->setContent("name", $data['name']);
        $quantity = $data['quantity'];
        $main->setContent("price", $data['price'] . "€");
        $price = $data['price'];
        $pieces = $data['pieces'];
        $main->setContent("quantityInput", "<input type='number' name='quantity' min='0' max='$pieces' value='$quantity'/><input type='submit' class='uk-button uk-button-small idz-button-grey uk-margin-small-top' style='width: 62px; height: 38px; font-size: 0.9rem; padding: 5px;'value='update'/> ");
        $total_product_price = $price * $quantity;
        $main->setContent("productPrice", "$total_product_price" . "€");
        $main->setContent("delete", "<a href='deleteItemCart.php?idProduct=$id_product&idCart=$id_cart' class='uk-icon-button uk-icon-times-circle'></a>");
        $total_price = $total_price + $total_product_price;
    }

    $main->setContent("checkout", "<a href='checkout.php' class='uk-button uk-button-small idz-button-white uk-width-1-1'>Proceed to Checkout</a>");

} else {
    $main->setContent("name", "There isn't any product in your cart");
}


$main->setContent("totalPrice", "$total_price" . "€");



$main->close();
