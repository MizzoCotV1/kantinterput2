<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                        <h1 class="mt-4">Tables</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data User</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                            <button type="button" class="btn btn-success" onclick="activateAllProducts()">Activate All</button>
                            <button type="button" class="btn btn-danger" onclick="deactivateAllProducts()">Deactivate All</button>
                            <br><br>
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Id Jual</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Gambar</th>
                                            <th>Harga</th>
                                            <th>Aktifasi</th>
                                            <th>Tanggal Update</th>
                                            <th>User Update</th>
                                            <th>Change</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id Jual</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori</th>
                                            <th>Gambar</th>
                                            <th>Harga</th>
                                            <th>Aktifasi</th>
                                            <th>Tanggal Update</th>
                                            <th>User Update</th>
                                            <th>Change</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                             require_once("conn.php");

                                             if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                // Handle the POST request to update "aktifasi"
                                                if (isset($_POST['id_jual']) && isset($_POST['action'])) {
                                                    $productId = $_POST['id_jual'];
                                                    $action = $_POST['action'];
                                                    $response = array();
                                            
                                                    // Update the aktifasi value for the specified product based on the action
                                                    if ($action === 'activate') {
                                                        $query = "UPDATE jual SET aktifasi = 1 WHERE id_jual = :id_jual";
                                                    } elseif ($action === 'deactivate') {
                                                        $query = "UPDATE jual SET aktifasi = 0 WHERE id_jual = :id_jual";
                                                    }
                                            
                                                    $stmt = $conn->prepare($query);
                                                    $stmt->bindParam(':id_jual', $productId, PDO::PARAM_INT);
                                            
                                                    if ($stmt->execute()) {
                                                        $response['success'] = true;
                                                        $response['aktifasi'] = $stmt->fetch(PDO::FETCH_COLUMN);
                                                    } else {
                                                        $response['success'] = false;
                                                    }
                                            
                                                    // Send a JSON response
                                                    header('Content-Type: application/json');
                                                    echo json_encode($response);
                                                    exit;
                                                }
                                            }
                                            
                                            $no = 1;
                                            $query = "SELECT j.*, u.nama_produk, u.kategori, t.gambarPath 
                                            FROM jual AS j
                                            INNER JOIN produk AS u ON j.id_produk = u.id_produk
                                            INNER JOIN gambar AS t ON j.id_gambar = t.id_gambar";

                                            $stmt3 = $conn->query($query);

                                            while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        
                                        <tr>
                                            <td><?= $row['id_jual']; ?></td>
                                            <td><?= $row['nama_produk']; ?></td>
                                            <td><?= $row['kategori']; ?></td>
                                            <td class="w-25">
                                                <img src="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $row['gambarPath']); ?>" alt="Image Description" class="img-fluid custom-img ">
                                            </td>
                                            <td><?= $row['harga']; ?></td>
                                            <td><?= $row['aktifasi'] == 0 ? 'Tidak Aktif' : 'Aktif'; ?></td>
                                            <td><?= $row['tgl_update'] ? $row['tgl_update'] : 'N/A'; ?></td>
                                            <td><?= $row['user_update'] ? $row['user_update'] : 'N/A';  ?></td>
                                            <td>
                                                <div class="d-grid gap-2" role="group" aria-label="First group">
                                                    <a type="button" class="btn btn-update btn-sm btn-success" onclick="openUpdateModal(<?= $row['id_jual']; ?>);">
                                                        <i class="fa-solid fa-pencil" style="color: #ffffff;"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="toggleAktifasi(<?= $row['id_jual']; ?>, 'activate'); refreshPage();">
                                                        Activate
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="toggleAktifasi(<?= $row['id_jual']; ?>, 'deactivate'); refreshPage();">
                                                        Deactivate
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                    
                                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateModalLabel">Update Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Your update form content goes here -->
                                                    <form id="updateForm">
                                                        <input type="hidden" id="id_jual" name="id">
                                                        <div class="form-group row">
                                                            <label for="nama_produk" class="col-md-12 col-form-label col-form-label-sm">Nama Produk</label>
                                                            <div class="col-md-12 ">
                                                                <input type="text" id="nama_produk" name="nama_produk" class="form-control form-control-md" readonly disabled >
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="harga" class="col-md-12 col-form-label col-form-label-sm">Harga</label>
                                                            <div class="col-md-12">
                                                                <input type="text" id="harga" name="harga" class="form-control form-control-md">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <!-- Add other form fields as needed -->
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </table>
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

        <script>
        function toggleAktifasi(productId, action) {
            // Send an AJAX request to update the "aktifasi" value
            $.ajax({
                type: 'POST',
                url: 'penjualan.php',
                data: {
                    id_jual: productId,
                    action: action
                },
                success: function (response) {
                    if (response.success) {
                        // Reload the page or update the DataTable as needed
                        refreshPage();
                    } else {
                        console.error('Failed to update aktifasi');
                    }
                },
                error: function () {
                    console.error('AJAX request failed');
                }
            });
        }

        function refreshPage() {
            // Set the time interval in milliseconds (e.g., 5000 milliseconds = 5 seconds)
            const reloadInterval = 100;

            // Use setTimeout to reload the page after the specified interval
            setTimeout(function () {
                window.location.reload();
            }, reloadInterval);
        }

        function activateAllProducts() {
            updateAllProductsAktifasi(1);
        }

        function deactivateAllProducts() {
            updateAllProductsAktifasi(0);
        }

        function updateAllProductsAktifasi(aktifasiValue) {
            // Send an AJAX request to update the "aktifasi" value for all products
            $.ajax({
                type: 'POST',
                url: 'update-all-produk.php',
                data: {
                    aktifasi: aktifasiValue
                },
                success: function (response) {
                    if (response.success) {
                        // Reload the page or update the DataTable as needed
                        window.location.reload();
                    } else {
                        console.error('Failed to update all products aktifasi');
                    }
                },
                error: function () {
                    console.error('AJAX request failed');
                }
            });
        }
    </script>


        <script>
            function openUpdateModal(id_jual) {
                console.log('Opening modal for id_jual:', id_jual);

                // Fetch current data from the server
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'fetch-data.php?id_jual=' + id_jual, true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        console.log('Data fetched successfully:', xhr.responseText);
                        var data = JSON.parse(xhr.responseText);

                        // Log the data to check if it's correct
                        console.log('Fetched data:', data);

                        // Set values in the modal form
                        document.getElementById('id_jual').value = data.id_jual;
                        document.getElementById('harga').value = data.harga;
                        document.getElementById('nama_produk').value = data.nama_produk; // Update with the actual field name
                        // Set other form fields as needed

                        // Show the modal
                        var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
                        updateModal.show();

                        // Add a submit event listener to the form
                        document.getElementById('updateForm').addEventListener('submit', function (e) {
                            e.preventDefault();
                            updateData();
                        });
                    } else {
                        console.error('Failed to fetch data. Status:', xhr.status);
                    }
                };

                // Log an error if the request fails
                xhr.onerror = function () {
                    console.error('An error occurred while fetching data.');
                };

                // Send the request to fetch data
                xhr.send();
            }
            function updateData() {
                // Get form data
                var id_jual = document.getElementById('id_jual').value;
                var harga = document.getElementById('harga').value; // Update with the actual field name
                // Get other form fields as needed

                // Create FormData object to send data
                var formData = new FormData();
                formData.append('id_jual', id_jual);
                formData.append('harga', harga);
                // Append other form fields as needed

                // Send an AJAX request to update the data
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'update-penjualan.php', true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            console.log('Data updated successfully:', response);
                            // Optionally, you can close the modal or update the table based on your requirement
                            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
                            updateModal.hide();
                            window.location.reload(); // Reload the page or update the table
                        } else {
                            console.error('Failed to update data. Response:', response);
                        }
                    } else {
                        console.error('Failed to update data. Status:', xhr.status);
                    }
                };

                // Send the FormData
                xhr.send(formData);
            }
        </script>
    </body>
</html>