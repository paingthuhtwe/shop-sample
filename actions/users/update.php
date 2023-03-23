<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;
use Helpers\HTTP;

$name = $_FILES['photo']['name'];
$error = $_FILES['photo']['error'];
$tmp = $_FILES['photo']['tmp_name'];
$type = $_FILES['photo']['type'];

$auth = Auth::check();
$table = new UsersTable(new MySQL());

if ($error) {
    HTTP::redirect("/views/users/auth.view.php", "error=1");
}
if ($type === "image/jpeg" or $type === "image/png") {
    $table->updatePhoto($name, $auth->id);
    move_uploaded_file($tmp, "../photos/users/$name");
    $auth->photo = $name;
    HTTP::redirect("/views/users/auth.view.php");
} else {
    HTTP::redirect("/views/users/auth.view.php", "error=file");
}
