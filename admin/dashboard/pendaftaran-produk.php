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
                    <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>admin/dashboard/">Dashboard</a></li>
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
                                    $id_gambar = uniqid() . mt_rand();
                                            if(isset($_POST['daftar'])){
                                                $nama_produk = filter_input(INPUT_POST, 'nama_produk');
                                                $kategori = filter_input(INPUT_POST, 'kategori');
                                                $tgl_input = date("Y-m-d");
                                                $user_input = $_SESSION['nama'];
                                                $id_user = $_SESSION['id_user'];

                                                if (empty($kategori) || $kategori === "") {
                                                    $error = "Please select a category.";
                                                } 
                                                if (empty($nama_produk))  {
                                                    echo "<script>formkosong();</script>";
                                                    $error ="Error";
                                                }

                                                if(!isset($error)){
                                                    $uploadedFile = $_FILES["gambar"];

                                                    if ($uploadedFile["error"] === UPLOAD_ERR_OK) {
                                                        $gambarNama = $uploadedFile["name"];
                                                        $gambarPath = $_SERVER['DOCUMENT_ROOT'] . "/kantinterput2/image/" . $gambarNama;

                                                        if (move_uploaded_file($uploadedFile["tmp_name"], $gambarPath)) {
                                                            try {
                                                                $sql1 = 'INSERT INTO Gambar (id_gambar, GambarNama, GambarPath) VALUES (?, ?, ?)';
                                                                $stmt1 = $conn->prepare($sql1);
                                                                $stmt1->execute([$id_gambar, $gambarNama, $gambarPath]);

                                                                echo "Gambar berhasil diunggah dan disimpan di basis data.";
                                                            } catch (PDOException $e) {
                                                                echo "Koneksi atau operasi basis data gagal: " . $e->getMessage();
                                                            }
                                                        } else {
                                                            echo "Gagal mengunggah gambar ke server.";
                                                        }
                                                    } else {
                                                        echo "Terjadi kesalahan saat mengunggah gambar.";
                                                    }
                                                    $sql = 'INSERT INTO produk (nama_produk, kategori, id_gambar, tgl_input, user_input, id_user) 
                                                    VALUES (:nama_produk, :kategori, :id_gambar, :tgl_input, :user_input, :id_user)';
                                                                $query1 = $conn->prepare($sql);

                                                                $query1->bindParam(':nama_produk', $nama_produk);
                                                                $query1->bindParam(':kategori', $kategori);
                                                                $query1->bindParam(':id_gambar', $id_gambar);
                                                                $query1->bindParam(':tgl_input', $tgl_input);
                                                                $query1->bindParam(':user_input', $user_input);
                                                                $query1->bindParam(':id_user', $id_user);

                                                                if ($query1->execute()) {
                                                                    // Step 2: Retrieve the auto-increment value
                                                                    $autoIncrementValue = $conn->lastInsertId();
                                                            
                                                                    // Step 3: Insert a record into table2 using the retrieved auto-increment value
                                                                    $query2 = "INSERT INTO jual (id_produk, id_gambar) VALUES (:auto_increment, :id_gambar)";
                                                                    $stmt2 = $conn->prepare($query2);
                                                            
                                                                    // Bind parameters for the second query
                                                                    $stmt2->bindParam(':auto_increment', $autoIncrementValue);
                                                                    $stmt2->bindParam(':id_gambar', $id_gambar);
                                                            
                                                                    $stmt2->execute();
                                                                }
                                                    }
                                            }

                                            ?>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="nama_produk" class="form-control" id="nama_produk"
                                                placeholder="Nama Produk">
                                            <label class="mx-2" for="nama_produk">Nama Produk</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                        </div>
                                        <div class="">
                                            <select name="kategori" class="form-select mb-3"
                                                aria-label=".form-select-lg example">
                                                <option selected hidden disabled value="">Pilih Kategori Produk</option>
                                                <option value="Gorengan">Makanan</option>
                                                <option value="Minuman">Minuman</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Input Gambar PNG, JPEG, JPG</label>
                                            <input class="form-control" type="file" id="formFile" name="gambar" accept=".png, .jpeg, .jpg">
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