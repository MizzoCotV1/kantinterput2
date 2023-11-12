<?php  
 //login_success.php  
    session_start();  
    if(isset($_SESSION["username"])) {  
        echo "<script>prosesLogin();</script>";  
    } else {  
        header("location:../login.php");  
    }    
    ?>  
<!DOCTYPE html>
<html lang="en">
<head>
        <style>
        /* Custom CSS to limit the pixel size */
        .custom-img {
            max-width: 300px; /* Set the maximum width you want */
            max-height: 200px; /* Set the maximum height you want */
            margin: auto;    
            display: block;
        }
        </style>
    <?php include 'header.php' ?>
    </head>
    <body class="sb-nav-fixed">
        <?php include 'navbar.php' ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="container mb-3">
                        
                            <div class="row text-center">
                            <?php
                                require_once("conn.php");

                                $query = "
                                    SELECT
                                        kategori,
                                        COUNT(id_produk) AS jumlah_produk
                                    FROM
                                        produk
                                    GROUP BY
                                        kategori;
                                ";

                                $stmt = $conn->query($query);

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $kategori = $row['kategori'];
                                    $jumlahProduk = $row['jumlah_produk'];

                                    // Output or use the values as needed
                                    echo '<div class="col border-start">';
                                    echo '<p class=""><i class="fa-solid fa-user"></i> ' . $kategori . '<br><strong class="h3">' . $jumlahProduk . '</strong></p>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include 'footer.php' ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
