<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\ProductsTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$productsTable = new ProductsTable(new MySQL());

$data = [
    ':title' => $_POST['title'],
    ':description' => $_POST['description'],
    ':price' => $_POST['price'],
    ':stock' => $_POST['stock'],
    ':id' => $_GET['id'],
];

$productsTable->updateProduct($data);
HTTP::redirect("/views/products/table.view.php");
