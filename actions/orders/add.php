<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\OrdersTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$product_id = $_GET['product_id'];

$ordersTable = new OrdersTable(new MySQL());
$order = $ordersTable->findByUserIdAndProductId($auth->id, $product_id);

$data = [
    ':order' => 1,
    ':user_id' => $auth->id,
    ':product_id' => $product_id,
];

$ordersTable->insert($data);

if ($order) {
}
