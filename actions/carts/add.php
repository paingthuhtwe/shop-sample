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

if ($product->stock > 0) {
    $product->stock -= 1;
    $productsTable->updateStock($product_id, $product->stock);

    if ($cart->product_id == $product_id & $cart->user_id == $user_id) {
        $cart->cart += 1;
        $data = [
                ':cart' => $cart->cart,
                ':product_id' => $product_id,
                ':user_id' => $user_id,
        ];
        $cartsTable->updateCart($data);
        // $addCart = $cart->cart;
        if ($check) {
            HTTP::redirect("/views/carts/cart.view.php");
            // echo json_encode($addCart);
            // exit;
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
} else {
    HTTP::redirect("/views/carts/cart.view.php", "stock=none");
}
