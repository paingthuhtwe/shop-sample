<?php

session_start();
include "../../vendor/autoload.php";
use Helpers\HTTP;

unset($_SESSION['user']);
HTTP::redirect("/index.php");
