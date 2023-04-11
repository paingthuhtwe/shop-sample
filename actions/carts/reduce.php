<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\CartsTable;
use Libs\Database\ProductsTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$product_id = $_GET['product_id'];
$user_id = $auth->id;
$cartsTable = new CartsTable(new MySQL());
$check = $_GET['cart'];

$productsTable = new ProductsTable(new MySQL());
$product = $productsTable->findById($product_id);

$cart = $cartsTable->findByUserIdAndProductId($user_id, $product_id);

if ($cart->product_id == $product_id & $cart->user_id == $user_id) {
    $product->stock += 1;
    $productsTable->updateStock($product_id, $product->stock);
    if ($cart->cart > 0) {
        $cart->cart -= 1;
    }
    $data = [
            ':cart' => $cart->cart,
            ':product_id' => $product_id,
            ':user_id' => $user_id,
    ];
    $cartsTable->updateCart($data);
    // $reduceCart = $cart->cart;
    if ($check) {
        HTTP::redirect("/views/carts/cart.view.php");
        // echo json_encode($reduceCart);
        // exit;
    }
    HTTP::redirect("/views/home.view.php");
}
