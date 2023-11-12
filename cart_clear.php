<?php
session_start();

if (isset($_SESSION['cart'])) {
    // Unset the cart session variable to clear the cart
    unset($_SESSION['cart']);
}

// Redirect back to the cart display page (cart.php)
header('Location: /kantinterput2/cart.php');
?>