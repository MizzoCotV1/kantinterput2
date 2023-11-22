<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $base_url = "http://localhost/kantinterput2/";
} else {
    $base_url = "https://your-production-domain.com/";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
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
        <main id="admin" class="admin">
            <div class="container-fluid px-4">
                <h1 class="mt-4">Form Pendaftaran</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="http://localhost/terput2/admin/dashboard/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pendaftaran</li>
                </ol>
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne">
                                Form Pendaftaran
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                            aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body px-5 my-2">
                                <?php
                                    require_once("conn.php");
                                    if (isset($_POST['daftar'])) {

                                        $nama_produk = filter_input(INPUT_POST, 'nama_produk');
                                        $kategori = $_POST["kategori"];
                                        $id_produk = $_POST["id_produk"];
                                        $tgl_update = date("Y-m-d");
                                        $user_update = $_SESSION['nama'];

                                        // Gunakan prepared statement untuk mencegah SQL injection
                                        if (empty($_POST["kategori"])) {
                                            $error = "Form kosong";
                                        }
                                        if(!isset($error)){
                                            //no error
                                                        //Securly insert into database
                                            $sql = 'UPDATE produk SET id_produk=:id_produk, nama_produk=:nama_produk, kategori=:kategori, tgl_update=:tgl_update, user_update=:user_update WHERE id_produk=:id_produk';
                                            $stmt = $conn->prepare($sql);

                                            $stmt->bindParam(':nama_produk', $nama_produk);
                                            $stmt->bindParam(':id_produk', $id_produk);
                                            $stmt->bindParam(':kategori', $kategori);
                                            $stmt->bindParam(':tgl_update', $tgl_update);
                                            $stmt->bindParam(':user_update', $user_update);
                                                
                                            $stmt->execute();
                                            echo "<script>document.location.href='" . $base_url . "admin/dashboard/data-produk.php';</script>";
                                        }
                                    }

                                    // Gunakan prepared statement untuk mencegah SQL injection
                                    $id_produk = $_GET['id_produk'];
                                    $stmt = $conn->prepare("SELECT * FROM produk WHERE id_produk = :id_produk");
                                    $stmt->bindParam(':id_produk', $id_produk);
                                    $stmt->execute();
                                    $edit = $stmt->fetch(PDO::FETCH_ASSOC);

                                    $currentCategory = $edit['kategori'];
                                ?>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id_produk" value="<?= $edit['id_produk'] ?>">
                                    <div class="row">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="nama_produk" class="form-control" id="nama_produk" value="<?= $edit['nama_produk'] ?>"
                                                placeholder="Nama Produk">
                                            <label class="mx-2" for="nama_produk">Nama Produk</label>
                                        </div>
                                        <div class="">
                                            <select name="kategori" class="form-select mb-3" aria-label=".form-select-lg example">
                                                <option selected hidden disabled value="">Pilih Kategori Produk</option>
                                                <option value="Gorengan" <?= ($currentCategory == 'Gorengan') ? 'selected' : ''; ?>>Gorengan</option>
                                                <option value="Minuman" <?= ($currentCategory == 'Minuman') ? 'selected' : ''; ?>>Minuman</option>
                                                <option value="Mie" <?= ($currentCategory == 'Mie') ? 'selected' : ''; ?>>Mie</option>
                                                <option value="Snack" <?= ($currentCategory == 'Snack') ? 'selected' : ''; ?>>Snack</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <input class="btn btn-primary btn-block w-100" type="submit" name="daftar"
                                                value="daftar">
                                        </div>
                                        <div class="col-6">
                                            <input class="btn btn-danger btn-block w-100" type="reset">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <?php include 'footer.php' ?>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
    $('.panel-collapse').on('show.bs.collapse', function() {
        $(this).siblings('.panel-heading').addClass('active');
    });

    $('.panel-collapse').on('hide.bs.collapse', function() {
        $(this).siblings('.panel-heading').removeClass('active');
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd', // Use the appropriate format for your database (e.g., 'yyyy-mm-dd')
            autoclose: true
        });
    });
    </script>
</body>

</html>