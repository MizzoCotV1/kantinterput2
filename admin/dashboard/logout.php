<?php
session_start();
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $base_url = "http://localhost/kantinterput2/";
} else {
    $base_url = "https://your-production-domain.com/";
}
$_SESSION = [];
session_unset();
session_destroy();

setcookie('id', '', time() - 3600);
setcookie('key', '', time() - 3600);

header("Location: " . $base_url . "admin/login.php");