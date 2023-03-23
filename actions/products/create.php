<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\ProductsTable;
use Helpers\HTTP;

$table = new ProductsTable(new MySQL());

$name = $_FILES['photo']['name'];
$error = $_FILES['photo']['error'];
$tmp = $_FILES['photo']['tmp_name'];
$type = $_FILES['photo']['type'];
$data = [
    'title' => $_POST['title'],
    'description' => $_POST['description'],
    'price' => $_POST['price'],
    'photo' => $_FILES['photo']['name'],
    'stock' => $_POST['stock'],
];
if ($error) {
    HTTP::redirect("/views/products/add.view.php", "error=1");
}
if ($type === "image/jpeg" or $type === "image/png") {
    move_uploaded_file($tmp, "../photos/products/$name");
    if ($table) {
        $table->insert($data);
        HTTP::redirect("/views/home.view.php", "addItem=true");
    } else {
        HTTP::reidrect("/views/products/add.view.php", "addItem=false");
    }
} else {
    HTTP::redirect("/views/products/add.view.php", "error=file");
}
