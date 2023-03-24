<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\CartsTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$product_id = $_GET['product_id'];
$user_id = $auth->id;
$cartsTable = new CartsTable(new MySQL());
$check = $_GET['cart'];

$cart = $cartsTable->findByUserIdAndProductId($user_id, $product_id);

if ($cart->product_id == $product_id & $cart->user_id == $user_id) {
    $cart->cart += 1;
    $data = [
            ':cart' => $cart->cart,
            ':product_id' => $product_id,
            ':user_id' => $user_id,
    ];
    $cartsTable->updateCart($data);
    if ($check) {
        HTTP::redirect("/views/carts/cart.view.php");
    }
    HTTP::redirect("/views/home.view.php");
} else {
    $data = [
        ':product_id' => $product_id,
        ':user_id' => $user_id,
        ':cart' => 1,
    ];
    $cartsTable->insert($data);
    HTTP::redirect("/views/home.view.php");
}
