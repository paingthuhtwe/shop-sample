<?php

namespace Helpers;

session_start();

class Auth
{
    public static $loginUrl = '/index.php';
    public static function check()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        } else {
            HTTP::redirect(static::$loginUrl);
        }
    }
}
