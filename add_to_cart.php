<?php
session_start();

if (isset($_POST['id_product']) && isset($_POST['product_name']) && isset($_POST['price']) && isset($_POST['image']) && isset($_POST['quantity'])) {
    $id_product = $_POST['id_product'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $quantity = (int)$_POST['quantity']; // Ensure quantity is an integer

    // Create or retrieve the cart array from the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Check if the product with the same 'id_product' and 'product_name' is already in the cart
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id_product'] == $id_product && $item['product_name'] == $product_name) {
            $item['quantity'] += $quantity; // Increment quantity if product exists
            $product_exists = true;
            break;
        }
    }

    // If the product doesn't exist in the cart, add it
    if (!$product_exists) {
        $_SESSION['cart'][] = array(
            'id_product' => $id_product,
            'product_name' => $product_name,
            'price' => $price,
            'image' => $image,
            'quantity' => $quantity
        );
    }

    // Return a JSON response with the cart size
    $cartSize = count($_SESSION['cart']);
    echo json_encode(['cartSize' => $cartSize]);
}
?>
