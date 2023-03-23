<?php

session_start();
include "../../vendor/autoload.php";
use Helpers\HTTP;
use Helpers\Auth;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$email = $_POST['email'];
$password = md5($_POST['password']);

$table = new UsersTable(new MySQL());
$user = $table->findByEmailAndPassword($email, $password);
if ($user) {
    if ($user->suspended) {
        HTTP::redirect("/index.php", "suspended=1");
    }
    $_SESSION['user'] = $user;
    HTTP::redirect("/views/home.view.php");
} else {
    HTTP::redirect("/index.php", "incorrect=1");
}
