<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;

$table = new UsersTable(new MySQL());

$data = [
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'address' => $_POST['address'],
    'password' => md5($_POST['password']),
    'role_id' => 1,
];

if ($table) {
    $table->insert($data);
    HTTP::redirect("/index.php", "register=true");
} else {
    HTTP::reidrect("/views/users/register.view.php", "register=false");
}
