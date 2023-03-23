<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$role = $_GET['role'];
$id = $_GET['id'];
$table = new UsersTable(new MySQL());
$table->changeRole($id, $role);
HTTP::redirect("/views/users/table.view.php");
