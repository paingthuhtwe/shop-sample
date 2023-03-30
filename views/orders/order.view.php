<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\ProductsTable;
use Libs\Database\CartsTable;
use Libs\Database\OrdersTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$product_id = $_GET['product_id'];

$productsTable = new ProductsTable(new MySQL());
$product = $productsTable->findById($product_id);

$ordersTable = new OrdersTable(new MySQL());
$orders = $ordersTable->findByUserId($auth->id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre Order Form</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/custom.css">
    <link rel="stylesheet" href="../../fontawesome-free/css/all.min.css">
    <style>
        #preOrder {
            top: -7%;
            left: -5%;
            transform: rotate(-25deg);
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 col-lg-6">
                <?php if($orders) :?>
                <?php foreach ($orders as $order) :?>
                <div class="alert alert-info p-2 shadow-sm">
                    <div class="d-flex justify-content-start align-items-center position-relative">
                        <div class="badge bg-warning position-absolute shadow py-2" id="preOrder">
                            Pre Order
                        </div>
                        <div class="position-absolute bottom-0 end-0">
                            <a href="../../actions/carts/add.php?product_id=1&cart=true"
                                class="btn btn-sm btn-secondary px-2 py-0 shadow"
                                style="min-width: 30px; min-height: 30px">
                                <h5 class="p-0 m-0">+</h5>
                            </a>
                            <a href="../../actions/carts/reduce.php?product_id=1&cart=true"
                                class="btn btn-sm btn-secondary px-2 py-0 shadow"
                                style="min-width: 30px; min-height: 30px">
                                <h5 class="p-0 m-0">-</h5>
                            </a>
                        </div>
                        <div class="btn btn-sm btn-danger px-2 py-0 shadow position-absolute top-0 end-0"
                            style="min-width: 30px; min-height: 30px">
                            <h5 class="p-0 m-0">
                                <?= htmlspecialchars($order->preorder) ?>
                            </h5>
                        </div>
                        <img src="../../actions/photos/products/<?= htmlspecialchars($order->photo) ?>"
                            alt="Product Img" class="img-thumbnail me-3" style="max-width: 100px">
                        <div>
                            <b><?= $order->title ?></b>
                            <br>
                            <small>
                                <b>
                                    (
                                    <?= htmlspecialchars($order->price * $order->preorder)?>
                                    ) Ks
                                </b>
                            </small>
                            <br>
                            <b class="text-danger">Total :
                                <?= htmlspecialchars($order->price*$order->preorder) ?>
                                Ks</b>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
                <?php else :?>
                <div class="alert alert-info p-2 shadow-sm">
                    <div class="d-flex justify-content-start align-items-center position-relative">
                        <div class="badge bg-warning position-absolute shadow py-2" id="preOrder">
                            Pre Order
                        </div>
                        <div class="position-absolute bottom-0 end-0">
                            <a href="../../actions/carts/add.php?product_id=1&cart=true"
                                class="btn btn-sm btn-secondary px-2 py-0 shadow"
                                style="min-width: 30px; min-height: 30px">
                                <h5 class="p-0 m-0">+</h5>
                            </a>
                            <a href="../../actions/carts/reduce.php?product_id=1&cart=true"
                                class="btn btn-sm btn-secondary px-2 py-0 shadow"
                                style="min-width: 30px; min-height: 30px">
                                <h5 class="p-0 m-0">-</h5>
                            </a>
                        </div>
                        <div class="btn btn-sm btn-danger px-2 py-0 shadow position-absolute top-0 end-0"
                            style="min-width: 30px; min-height: 30px">
                            <h5 class="p-0 m-0">
                                0
                            </h5>
                        </div>
                        <img src="../../actions/photos/products/<?= $product->photo ?>"
                            alt="Product Img" class="img-thumbnail me-3" style="max-width: 100px">
                        <div>
                            <b><?= htmlspecialchars($product->title) ?></b>
                            <br>
                            <small>
                                <b>
                                    (
                                    <?= $product->price ?> * 0
                                    ) Ks
                                </b>
                            </small>
                            <br>
                            <b class="text-danger">Total :
                                <?= $product->price*0 ?>
                                Ks</b>
                        </div>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <?php require("../nav.view.php"); ?>
</body>

</html>