<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\CartsTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$cartsTable = new CartsTable(new MySQL());
$carts = $cartsTable->getAllByUserId($auth->id);
$no = null;
$grandTotal = null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart List</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../fontawesome-free/css/all.min.css">
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <!-- Start Cart Section  -->
            <div class="col-12 col-lg-7" id="cart">
                <?php if(isset($_GET['stock'])) :?>
                <div class="alert alert-danger"><i class="fas fa-warning fa-lg pe-2"></i>Product is out of
                    stock. Pre
                    Order For
                    More!</div>
                <?php endif ?>
                <div class="row">
                    <?php foreach ($carts as $cart) :?>
                    <?php if($cart->cart) :?>
                    <div class="col-12 col-lg-6">
                        <div
                            class="alert alert-info p-2 d-flex justify-content-start align-items-center position-relative shadow-sm border">
                            <div class="position-absolute top-0 start-0 shadow">
                                <div class="btn btn-sm btn-success" id="totalCart"
                                    style="min-width: 30px; min-height: 30px">
                                    <?= $cart->cart ?>
                                </div>
                                <?php if($cart->stock <= 0) :?>
                                <div class="btn btn-sm btn-warning">
                                    Out of Stock!
                                </div>
                                <?php endif ?>
                            </div>
                            <div class="position-absolute top-0 end-0">
                                <a href="../../actions/carts/add.php?product_id=<?= $cart->productId ?>&cart=true"
                                    class="btn btn-sm btn-secondary px-2 py-0 shadow <?php if($cart->stock <= 0) :?>
                                        disabled
                                    <?php endif ?>"
                                    style="min-width: 30px; min-height: 30px">
                                    <h5 class="p-0 m-0">+</h5>
                                </a>
                                <a href="../../actions/carts/reduce.php?product_id=<?= $cart->productId ?>&cart=true"
                                    class="btn btn-sm btn-secondary px-2 py-0 shadow"
                                    style="min-width: 30px; min-height: 30px">
                                    <h5 class="p-0 m-0">-</h5>
                                </a>
                            </div>
                            <img src="../../actions/photos/products/<?= htmlspecialchars($cart->photo) ?>"
                                alt="Product Img" class="img-thumbnail me-3" style="max-width: 100px">
                            <div>
                                <b><?= htmlspecialchars($cart->title) ?></b>
                                <br>
                                <small>
                                    <b>
                                        (
                                        <?= htmlspecialchars($cart->price) ?>
                                        *
                                        <?= htmlspecialchars($cart->cart) ?>
                                        ) Ks
                                    </b>
                                </small>
                                <br>
                                <b class="text-danger">Total :
                                    <?= htmlspecialchars($cart->price*$cart->cart) ?>
                                    Ks</b>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
            <!-- End Cart Section  -->
            <!-- Start Received Section  -->
            <div class="col-12 col-lg-5">
                <div class="alert alert-warning shadow-sm position-relative border" id="printArea">
                    <div class="position-absolute top-0 end-0">
                        <div class="btn btn-secondary shadow" onClick="printForm()" id="printBtn">Print</div>
                    </div>
                    <h1 class="h5 text-center border-bottom border-2 border-warning py-3">Your Receipt <span
                            id="preview">( Preview )</span></h1>
                    <h1 class="h6 d-flex justify-content-between py-2">
                        <span class="py-1">
                            Customer Name :
                            <span
                                class="border-bottom border-dark border-2"><?= htmlspecialchars($auth->name) ?></span>
                        </span>
                        <span class="py-1">
                            Date :
                            <?php
                            $day = date("D-M-Y");
echo "$day";
?>
                        </span>
                    </h1>
                    <table class="table table-striped table-bordered border-warning m-0">
                        <tr class="text-center">
                            <th>Sr.</th>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                        <?php foreach($carts as $cart) :?>
                        <?php if($cart->cart) :?>
                        <tr>
                            <td class="text-center"><?= $no+=1 ?>
                            </td>
                            <td class="text-center">
                                <?= $cart->title ?>
                            </td>
                            <td class="text-center">
                                <?= $cart->cart ?>
                            </td>
                            <td class="text-end">
                                <?= htmlspecialchars($cart->price) ?>
                            </td>
                            <td class="text-end">
                                <?php $total = $cart->cart * $cart->price;
                            $grandTotal += $total;
                            echo htmlspecialchars($total);
                            ?>
                            </td>
                        </tr>
                        <?php endif ?>
                        <?php endforeach ?>
                        <tr>
                            <th colspan="4" class="text-center">Grand Total ( Kyats )</th>
                            <th class="text-end">
                                <?= $grandTotal ?>
                            </th>
                        </tr>
                    </table>
                    <small p-0 m-0>
                        For Support : Call ( 09 - 780 909 574 )
                    </small>
                    <h1 class="h5 text-center pt-2 pb-0">Thanks For Your Choice!</h1>
                </div>
                <!-- End Received Section  -->
                <div class="alert alert-info shadow-sm border" id="payment">
                    <h1 class="h4 text-dark my-3 text-center">Payment Information</h1>
                    <form action="">
                        <label for="name">Name</label>
                        <input type="text" class="form-control w-100 mb-3" name="name"
                            value="<?= $auth->name ?>">
                        <label for="email">Email</label>
                        <input type="text" class="form-control w-100 mb-3" name="email"
                            value="<?= $auth->email ?>">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control w-100 mb-3" name="phone"
                            value="<?= $auth->phone ?>">
                        <label for="address">Address</label>
                        <input type="text" class="form-control w-100 mb-3" name="address"
                            value="<?= $auth->address ?>">
                        <input type="submit" class="btn btn-danger w-100" value="Confirm">
                    </form>
                </div>
            </div>

        </div>
    </div>
    <?php require("../nav.view.php"); ?>
    <script>
        function printForm() {
            // Get the selected area
            var selectedArea = document.getElementById("printArea");
            var cart = document.getElementById("cart");
            var printBtn = document.getElementById("printBtn");
            var preview = document.getElementById("preview");
            var bNavbar = document.getElementById("bNavbar");
            var payment = document.getElementById("payment");
            // Hide Unselected Area 
            cart.classList.add("d-none");
            printBtn.classList.add("d-none");
            preview.classList.add("d-none");
            bNavbar.classList.add("d-none");
            payment.classList.add("d-none");
            // Print Receipt 
            window.print();
            // Show Unselected Area 
            cart.classList.remove("d-none");
            printBtn.classList.remove("d-none");
            preview.classList.remove("d-none");
            bNavbar.classList.remove("d-none");
            payment.classList.remove("d-none");
        }
    </script>
    <!-- <script>
        const totalCart = document.getElementById("totalCart");

        function btnAddCart(id) {
            var url = "http://localhost/practice/actions/carts/add.php?product_id=";
            url += id;
            url += "&cart=true"
            fetch(url)
                .then(function(res) {
                    return res.json();
                })
                .then(function(addCart) {
                    totalCart.innerHTML = addCart.cart;
                });
        }

        function btnReduceCart(id) {
            var url = "http://localhost/practice/actions/carts/reduce.php?product_id=";
            url += id;
            url += "&cart=true"
            fetch(url)
                .then(function(res) {
                    return res.json();
                })
                .then(function(reduceCart) {
                    totalCart.innerHTML = reduceCart.cart;
                });
        }
    </script> -->
</body>

</html>