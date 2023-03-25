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
    <link rel="stylesheet" href="../../css/bootstrap.min.css" media="print">
    <link rel="stylesheet" href="../../css/custom.css">
</head>

<body>
    <div class="container mt-3">
        <div class="alert alert-success border shadow-sm" id="nav">
            <a href="../home.view.php" class="btn btn-sm btn-outline-primary">&laquo;&laquo; Home Page</a>
        </div>
        <div class="row">
            <!-- Start Cart Section  -->
            <div class="col-12 col-lg-7" id="cart">
                <div class="row">
                    <?php foreach ($carts as $cart) :?>
                    <?php if($cart->cart) :?>
                    <div class="col-12 col-lg-6">
                        <div
                            class="alert alert-info p-2 d-flex justify-content-start align-items-center position-relative shadow-sm border">
                            <div class="btn btn-sm btn-success position-absolute top-0 start-0 shadow"
                                style="min-width: 30px; min-height: 30px">
                                <?= $cart->cart ?>
                            </div>
                            <div class="position-absolute top-0 end-0">
                                <a href="../../actions/carts/add.php?product_id=<?= htmlspecialchars($cart->productId) ?>&cart=true"
                                    class="btn btn-sm btn-secondary px-2 py-0 shadow"
                                    style="min-width: 30px; min-height: 30px">
                                    <h5 class="p-0 m-0">+</h5>
                                </a>
                                <a href="../../actions/carts/reduce.php?product_id=<?= htmlspecialchars($cart->productId) ?>&cart=true"
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
                    <h1 class="h5 text-center border-bottom border-2 border-warning py-3">Your Received <span
                            id="preview">( Preview )</span></h1>
                    <h1 class="h6 d-flex justify-content-between py-2 flex-column flex-md-row">
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
            </div>
            <!-- End Received Section  -->
        </div>
    </div>
    <script>
        function printForm() {
            // Get the selected area
            var selectedArea = document.getElementById("printArea");
            var nav = document.getElementById("nav");
            var cart = document.getElementById("cart");
            var printBtn = document.getElementById("printBtn");
            var preview = document.getElementById("preview");
            // Hide Unselected Area 
            nav.classList.add("d-none");
            cart.classList.add("d-none");
            printBtn.classList.add("d-none");
            preview.classList.add("d-none");
            // Print Received 
            window.print();
            // Show Unselected Area 
            nav.classList.remove("d-none");
            cart.classList.remove("d-none");
            printBtn.classList.remove("d-none");
            preview.classList.remove("d-none");
        }
    </script>
</body>

</html>