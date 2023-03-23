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
$id = $_GET['id'];

$auth = Auth::check();
$table = new UsersTable(new MySQL());
$user = $table->findById($id);

if ($error) {
    HTTP::redirect("/views/users/profile.view.php", "id=$id&error=1");
}
if ($type === "image/jpeg" or $type === "image/png") {
    $table->updatePhoto($name, $id);
    move_uploaded_file($tmp, "../photos/users/$name");
    if ($auth->id === $user->id) {
        $auth->photo = $name;
    }
    $user->photo = $name;
    HTTP::redirect("/views/users/edit.view.php", "id=$id");
} else {
    HTTP::redirect("/views/users/edit.view.php", "id=$id&error=file");
}
