<?php
session_start();

?>


<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
    <?php include 'bs-cdn.php';?>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/css/style.css" type="text/css">
<?php include 'header.php';?>
    
    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <?php
                            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                $messageBody = "Pesanan Anda:\n";
                                $totalQuantity = 0;
                                $totalPrice = 0;

                                foreach ($_SESSION['cart'] as $items) {
                                    $messageBody .= $items['quantity'] . "x " . $items['product_name'] . " - $" . $items['price'] . "\n";
                                    $totalQuantity += $items['quantity'];
                                    $totalPrice += $items['price'] * $items['quantity'];
                                }

                                // Include total quantity, total products, and total price in the message
                                $messageBody .= "\nTotal Quantity: " . $totalQuantity . "\n";
                                $messageBody .= "Total Produk: " . count($_SESSION['cart']) . "\n";
                                $messageBody .= "Total Harga: $" . $totalPrice . "\n";
                                $messageBody .= "Nama:\n";
                                $messageBody .= "Kelas:\n";
                                echo '<table>';
                                echo '<thead>';
                                echo '<tr><th class="shoping__product">Products</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                foreach ($_SESSION['cart'] as $index => $item) {
                                    echo '<tr>';
                                    echo '<td class="shoping__cart__item"><img src="' . str_replace($_SERVER["DOCUMENT_ROOT"], "", $item["image"]) . '"width="60" height="60" class="d-none d-sm-inline"><h5>' . $item['product_name'] . '</h5></td>';
                                    echo '<td class="shoping__cart__price">Rp' . $item['price'] . '</td>';
                                    echo '<td class="shoping__cart__quantity">';
                                    echo '<a href="/kantinterput2/update_cart.php?action=decrease&index=' . $index . '">- </a>';
                                    echo $item['quantity'];
                                    echo '<a href="/kantinterput2/update_cart.php?action=increase&index=' . $index . '"> +</a>';
                                    echo '</td>';
                                    echo '<td class="shoping__cart__total">Rp' . ($item['price'] * $item['quantity']) . '</td>';
                                    echo '<p class="d-none">' . $item['id_product'] . '</p>';
                                    echo '<td class="shoping__cart__item__close"><a href="/kantinterput2/update_cart.php?action=remove&index=' . $index . '"><span class="icon_close"></span></a></td>';
                                    echo '</tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo '<h5>Your cart is empty.</h5>';
                            }
                        ?>
                        <?php
                        $totalPrice = 0; // Initialize the total price to zero

                        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) {
                                $totalPrice += $item['price'] * $item['quantity']; // Add product price to the total
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="/kantinterput2/" class="site-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="/kantinterput2/cart.php" class="site-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Upadate Cart</a>
                        <br>
                        <a href="/kantinterput2/cart_clear.php" class="primary-btn cart-btn cart-btn-right my-2">CLEAR CART</a>
                    </div>
                </div>
                <div class="col-lg-6">
                </div>
                
                <div class="col-lg-6">
                    <form method="post" action="#" id="checkoutForm">
                        <div class="shoping__checkout">
                            <h5>Cart Total</h5>
                            <ul>
                                <li>Total <span>
                                        <?php
                                        if ($totalPrice === 0) {
                                            echo '0';
                                        } else {
                                            echo '<td class="shoping__cart__total">Rp' . $totalPrice . '</td>';
                                        }
                                        ?></span>
                                </li>
                            </ul>
                            <button type="button" onclick="redirectToWhatsApp()" class="site-btn">PROCEED TO CHECKOUT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->

    <!-- Footer Section Begin -->
    
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        function redirectToWhatsApp() {
            // Add your WhatsApp number and message to the URL
            var whatsappURL = 'https://wa.me/6285157171344?text=<?php echo urlencode($messageBody); ?>';

            // Open a new window or tab with the WhatsApp chat link
            var whatsappWindow = window.open(whatsappURL, '_blank');

            // Make an AJAX request to notify the server that the message is sent
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "cart_clear.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send();

            // Destroy the session after a short delay (adjust the delay as needed)
            setTimeout(function() {
                // Close the WhatsApp window if it's still open
                if (whatsappWindow && !whatsappWindow.closed) {
                    whatsappWindow.close();
                }

                // Redirect to the "thank_you.php" page
                window.location.href = 'thank_you.php';
            }, 1000); // 1000 milliseconds (1 second) delay
        }
    </script>

</body>

</html>