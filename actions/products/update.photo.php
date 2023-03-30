<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\ProductsTable;
use Helpers\Auth;
use Helpers\HTTP;

$id = $_GET['id'];
$name = $_FILES['photo']['name'];
$error = $_FILES['photo']['error'];
$tmp = $_FILES['photo']['tmp_name'];
$type = $_FILES['photo']['type'];

$auth = Auth::check();
$productsTable = new ProductsTable(new MySQL());

if ($error) {
    HTTP::redirect("/views/products/edit.view.php", "id=$id&error=1");
}

if ($type === "image/jpeg" or $type === "image/png" or $type === "image/webp" or $type === "image/avif") {
    $productsTable->updatePhoto($name, $id);
    move_uploaded_file($tmp, "../photos/products/$name");
    HTTP::redirect("/views/products/edit.view.php", "id=$id");
} else {
    HTTP::redirect("/views/products/edit.view.php", "id=$id&error=file");
}
