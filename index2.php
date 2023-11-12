<!DOCTYPE html>
<html lang="en">
<head>
    <script>
    // Function to store scroll position
    function storeScrollPosition() {
        sessionStorage.setItem('scrollPosition', window.scrollY);
    }

    // Store the scroll position when the page unloads (e.g., when refreshing)
    window.addEventListener('beforeunload', function (event) {
        const performance = window.performance || window.mozPerformance || window.msPerformance || window.webkitPerformance || {};
        const navigation = performance.navigation || {};

        // Check if the page is being manually refreshed
        if (navigation.type === 1) {
            storeScrollPosition();
        }
    });

    // Check if the current URL matches the expected pattern and scroll to the saved position
    document.addEventListener('DOMContentLoaded', function () {
        const currentPageUrl = window.location.pathname;
        const scrollPosition = sessionStorage.getItem('scrollPosition');

        // Define the pattern for matching URLs
        const expectedPattern = /^\/produk\/\d+\/\w+/; // Modify this pattern as needed

        if (expectedPattern.test(currentPageUrl) && scrollPosition) {
            // The current URL matches the expected pattern
            // Scroll to the saved position
            window.scrollTo(0, scrollPosition);
        }
    });
    </script>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>
    <?php include 'bs-cdn.php';?>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    <!-- Css Styles -->
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
       
        .feedback {
        background-color : #cad531;
        color: white;
        padding: 10px 20px;
        border-color: #FFFF00;
        height: 80px;
        line-height: 80px;  
        width: 80px;  
        font-size: 2em;
        font-weight: bold;
        border-radius: 50%;
        text-align: center;
        cursor: pointer;
    
  }
        /* Styles for the pop-up message */
        .popup .popuptext {
        text-align: center;
        }

        img {
        z-index: 1; /* Lower z-index value for the image */
        /* Other image styles */
        }

        #mybutton {
        z-index: 999;
        position: fixed;
        bottom: -4px;
        right: 10px;
        margin-bottom: 50px;
        margin-right: 10px;
  }
        .pagination .page-item.active .page-link {
            background-color: transparent; /* Change this to your desired background color */
            border-color: #007bff; /* Change this to your desired border color */
            color: #0d6efd; /* Change this to your desired text color */
        }
    </style>
    <script>
        function formatPrice(price) {
        // Convert the price to a string and split it into integer and decimal parts
        var parts = price.toFixed(2).toString().split(".");
        
        // Add commas to the integer part
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        
        // Join the integer and decimal parts and return the formatted price
        return parts.join(".");
        }
    </script>
</head>

<body>
<?php include 'header.php';?>
    <!-- Page Preloder -->
    <div class="container m-5 my-5">

    </div>
    <div id="cartStatus">Cart: Loading...</div>
    <script>
        let isSubmitting = false;

        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('add-to-cart') && !isSubmitting) {
                isSubmitting = true;
                const button = event.target;
                const id_product = button.dataset.id;
                const product_name = button.dataset.name;
                const price = button.dataset.price;
                const image = button.dataset.image;

                const data = new FormData();
                data.append('id_product', id_product);
                data.append('product_name', product_name);
                data.append('price', price);
                data.append('image', image);
                data.append('quantity', 1);

                fetch('add_to_cart.php', {
                    method: 'POST',
                    body: data
                })

                .then(response => response.json())
                .then(data => {
                    // Handle the response
                    // Update the cart status in the UI
                    isSubmitting = false;
                    document.getElementById("cartStatus").textContent = 'Cart: ' + data.cartSize;
                })

                .catch(error => {
                    console.error('Error:', error);
                    isSubmitting = false;
                });
            }
        });
    </script>

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                        <div id="mybutton">
                         <a href="cart.php" class="feedback"><i class="fa-solid fa-cart-shopping" style="color: #000000;"></i></a>
                        </div>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <?php
                            // Define the category names and the corresponding URLs
                            $categories = [
                                'All' => 'index.php',
                                'Mie' => 'index.php?kategori=Mie',
                                'Gorengan' => 'index.php?kategori=Gorengan',
                                'Minuman' => 'index.php?kategori=Minuman',
                                'Snack' => 'index.php?kategori=Snack',
                            ];

                            $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'All'; // Define $kategori with a default value

                            // Loop through the categories and create the category links
                            foreach ($categories as $categoryName => $categoryURL) {
                                $isActive = ($kategori === $categoryName || ($kategori === 'All' && $categoryName === 'All')) ? 'class="active"' : ''; // Check if the category is active
                                echo '<li ' . $isActive . ' data-filter="*' . ($categoryName === 'All' ? '' : '.' . $categoryName) . '"><a href="' . $categoryURL . '">' . $categoryName . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <?php
                // Include the database connection file
                require_once("admin/dashboard/conn.php");
                $productsPerPage = 12; // Number of products to display per page

                // Determine the selected kategori (default to "All"
                try {
                    // Count the total number of products for the selected kategori
                    $countSql = "SELECT COUNT(*) FROM jual AS j 
                                INNER JOIN produk AS u ON j.id_produk = u.id_produk
                                INNER JOIN gambar AS t ON j.id_gambar = t.id_gambar
                                WHERE :kategori = 'All' OR u.kategori = :kategori";

                    $countStmt = $conn->prepare($countSql);
                    $countStmt->bindParam(':kategori', $kategori);
                    $countStmt->execute();
                    $totalProducts = $countStmt->fetchColumn();

                    $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                    $startIndex = ($currentPage - 1) * $productsPerPage;

                    // Update your SQL query to filter by kategori
                    $sql = "SELECT * FROM jual AS j 
                        INNER JOIN produk AS u ON j.id_produk = u.id_produk
                        INNER JOIN gambar AS t ON j.id_gambar = t.id_gambar
                        WHERE (:kategori = 'All' OR u.kategori = :kategori) AND j.aktifasi = 1
                        ORDER BY u.nama_produk ASC
                        LIMIT :productsPerPage OFFSET :startIndex";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':kategori', $kategori);
                    $stmt->bindParam(':productsPerPage', $productsPerPage, PDO::PARAM_INT);
                    $stmt->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    function formatPrice($price) {
                        return 'Rp ' . number_format($price, 2, '.', ',');
                    }

                    if (count($result) > 0) {
                        foreach ($result as $row) {
                            $jualId = $row['id_jual'];
                            $productName = $row['nama_produk'];
                            $productName = str_replace(['(', ')'], '', $productName);
                            $productName = str_replace(' ', '-', $productName); // Replace spaces with hyphens
                            $productLink = 'produk/' . $jualId . '/' . $productName;
                            $formattedPrice = formatPrice($row['harga']);
                            echo '<div class="col-lg-3 col-md-4 col-sm-6 mix ' . $row['kategori'] . '">';
                            echo '<div class="featured__item">';
                            echo '<div class="featured__item__pic set-bg d-flex justify-content-center">';
                            echo '<a href="' . $productLink . '"><img src="' . str_replace($_SERVER["DOCUMENT_ROOT"], "", $row["gambarPath"]) . '" alt="" style="max-width: 270px;
                            max-height: 270px;"></a>';
                            echo '<ul class="featured__item__pic__hover">';
                            echo '<li><a href="#"><i class="fa fa-heart"></i></a></li>';
                            echo '<li><a href="#"><i class="fa fa-retweet"></i></a></li>';
                            echo '<li><a class="add-to-cart" onclick="popupwin()"
                                data-id="' . $row['id_jual'] . '" 
                                data-name="' . $row['nama_produk'] . '" 
                                data-price="' . $row['harga'] . '"
                                data-image="' . $row['gambarPath'] . '">
                                <i class="fa fa-solid fa-plus" style="pointer-events: none;"></i></a></li>';
                            echo '</ul>';
                            echo '</div>';
                            echo '<div class="featured__item__text">';
                            echo '<h6><a href="' . $productLink . '">' . $row['nama_produk'] . '</a></h6>';
                            echo '<h5>' . $formattedPrice . '</h5>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            // You can include "Add to Cart" buttons here for each product
                        }

                        // Implement separate pagination for each kategori
                        echo '<div class="container text-center d-flex justify-content-center">';
                        echo '<ul class="pagination">';
                        
                        $totalPages = ceil($totalProducts / $productsPerPage);
                        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
                        
                        $maxPagesToDisplay = 5; // Adjust the number of pages to display as needed
                        
                        // Display "Previous" button if not on the first page
                        if ($currentPage > 1) {
                            echo '<li class="page-item"><a class="page-link" href="index.php?kategori=' . $kategori . '&page=' . ($currentPage - 1) . '">Previous</a></li>';
                        }
                        
                        // Display link to jump to the first page
                        if ($currentPage > ceil($maxPagesToDisplay / 2)) {
                            echo '<li class="page-item"><a class="page-link" href="index.php?kategori=' . $kategori . '&page=1">1</a></li>';
                            if ($currentPage > ceil($maxPagesToDisplay / 2) + 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }
                        
                        // Display the page numbers
                        for ($page = 1; $page <= $totalPages; $page++) {
                            $class = ($page === $currentPage) ? ' active' : '';
                            if ($page >= max(1, $currentPage - floor($maxPagesToDisplay / 2)) && $page <= min($currentPage + floor($maxPagesToDisplay / 2), $totalPages)) {
                                echo '<li class="page-item' . $class . '"><a class="page-link" href="index.php?kategori=' . $kategori . '&page=' . $page . '">' . $page . '</a></li>';
                            }
                        }
                        
                        // Display link to jump to the last page
                        if ($currentPage < $totalPages - floor($maxPagesToDisplay / 2)) {
                            if ($currentPage < $totalPages - floor($maxPagesToDisplay / 2) - 1) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                            echo '<li class="page-item"><a class="page-link" href="index.php?kategori=' . $kategori . '&page=' . $totalPages . '">' . $totalPages . '</a></li>';
                        }
                        
                        // Display "Next" button if not on the last page
                        if ($currentPage < $totalPages) {
                            echo '<li class="page-item"><a class="page-link" href="index.php?kategori=' . $kategori . '&page=' . ($currentPage + 1) . '">Next</a></li>';
                        }
                        
                        echo '</ul>';
                        echo '</div>';
                        
                        

                        
                    } else {
                        echo "No products found.";
                    }

                    // Close the database connection
                    $conn = null;
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <!-- Blog Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="./index.html"><img src="img/logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li>Address: 60-49 Road 11378 New York</li>
                            <li>Phone: +65 11.188.888</li>
                            <li>Email: hello@colorlib.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <h6>Useful Links</h6>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">About Our Shop</a></li>
                            <li><a href="#">Secure Shopping</a></li>
                            <li><a href="#">Delivery infomation</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Our Sitemap</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Who We Are</a></li>
                            <li><a href="#">Our Services</a></li>
                            <li><a href="#">Projects</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Innovation</a></li>
                            <li><a href="#">Testimonials</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__widget">
                        <h6>Join Our Newsletter Now</h6>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="#">
                            <input type="text" placeholder="Enter your mail">
                            <button type="submit" class="site-btn">Subscribe</button>
                        </form>
                        <div class="footer__widget__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>
                        <div class="footer__copyright__payment"><img src="img/payment-item.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
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
        function popupwin() {
        // Show the pop-up
        var popup = document.getElementById("cartPopup");
        var popupMessage = document.getElementById("popupMessage");

        popup.style.display = "block"; // Show the popup
        // Force a reflow to enable the CSS transition to work
        void popup.offsetWidth;

        popup.style.opacity = 1; // Set opacity to 1 for the fade-in effect
        popupMessage.textContent = "Added to Cart";

        // Automatically close the pop-up after 3 seconds (adjust the time as needed)
        setTimeout(function() {
            popup.style.opacity = 0; // Set opacity to 0 for the fade-out effect
            setTimeout(function() {
            popup.style.display = "none"; // Hide the pop-up
            }, 500); // 500 milliseconds for the fade-out transition
        }, 3000); // 3000 milliseconds (3 seconds) for the pop-up to stay visible
        }
    </script>


</body>

</html>