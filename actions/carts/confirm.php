<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\CartsTable;
use Libs\Database\ProductsTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$user_id = $auth->id;
$cartsTable = new CartsTable(new MySQL());
$data = [
    ':confirm' => 1,
    ':user_id' => $user_id,
];

$cartsTable->confirm($data);

HTTP::redirect("/views/carts/cart.view.php");
