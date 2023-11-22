<?php
session_start();
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $base_url = "http://localhost/kantinterput2/";
} else {
    $base_url = "https://your-production-domain.com/";
}
if (isset($_SESSION['cart'])) {
    // Unset the cart session variable to clear the cart
    unset($_SESSION['cart']);
}

// Redirect back to the cart display page (cart.php)
header("Location: " . $base_url . "cart.php");
?>