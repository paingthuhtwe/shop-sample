<?php

include "../../vendor/autoload.php";
use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();

$table = new UsersTable(new MySQL());
$data = [
   ':name' => $_POST['name'],
   ':email' => $_POST['email'],
   ':phone' => $_POST['phone'],
   ':address' => $_POST['address'],
   ':id' => $_GET['id'],
];
$table->updateUser($data);
HTTP::redirect("/views/users/table.view.php");
