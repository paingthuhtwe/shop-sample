<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\ProductsTable;
use Helpers\Auth;
use Helpers\HTTP;

$id = $_GET['id'];
$auth = Auth::check();
$productsTable = new ProductsTable(new MySQL());
$productsTable->delete($id);
HTTP::redirect("/views/products/table.view.php");
