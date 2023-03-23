<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$id = $_GET['id'];
$table = new UsersTable(new MySQL());
$table->unsuspend($id);
HTTP::redirect("/views/users/table.view.php");
