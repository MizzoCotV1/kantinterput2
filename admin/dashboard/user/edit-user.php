<?php
session_start();

// Check if the user is logged in and has admin privileges
    if ($_SESSION['hak_akses'] !== 'admin') {
    // Redirect to a login page or display an error message
    header("Location: /kantinterput2/admin/dashboard/");
    exit();
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
        <?php include ("../../../admin/dashboard/header.php"); ?>
    </head>
    <body class="sb-nav-fixed">
        <!-- Navbar -->
        <?php include ("../../../admin/dashboard/navbar.php"); ?>
            <div id="layoutSidenav_content">
                <!-- Start Body Content -->
                <main id="admin" class="admin">
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Form Registrasi User</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="http://localhost/kantinterput2/admin/dashboard/">Dashboard</a></li>
                            <li class="breadcrumb-item active">Data User</li>
                        </ol>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Form Edit User
                                </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body px-5 my-2">
                                        <div class="container px-5 admin">
                                        <?php
                                            require_once("../../../admin/dashboard/conn.php");


                                            if (isset($_POST['simpan'])) {

                                                $nama = filter_input(INPUT_POST, 'nama');
                                                $username = filter_input(INPUT_POST, 'username');
                                                $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                                                $password2 = password_hash($_POST["password2"], PASSWORD_DEFAULT);
                                                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                                                $id_user = $_POST['id_user'];

                                                // Gunakan prepared statement untuk mencegah SQL injection

                                                if(isset($_POST['hak_akses'])) {
                                                    $akses = $_POST['hak_akses'];
                                                } 
                                                if (empty($nama) || empty($username) || empty($email) || empty($_POST["hak_akses"])) {
                                                    $error = "Form kosong";
                                                }
                                                if ($_POST["password"] !== $_POST["password2"]) {
                                                    echo "<script>cpassworderror();</script>";
                                                    $error = "Password tidak sama";
                                                }
                                                if(!isset($error)){
                                                    //no error
                                                                //Securly insert into database
                                                    $sql = 'UPDATE user SET id_user=:id_user, username=:username, password=:password, nama=:nama, email=:email, hak_akses=:akses WHERE id_user=:id_user';
                                                    $stmt = $conn->prepare($sql);

                                                    $stmt->bindParam(':id_user', $id_user);
                                                    $stmt->bindParam(':username', $username);
                                                    $stmt->bindParam(':password', $password);
                                                    $stmt->bindParam(':nama', $nama);
                                                    $stmt->bindParam(':email', $email);
                                                    $stmt->bindParam(':akses', $akses);
                                                        
                                                    $stmt->execute();
                                                    echo "<script>document.location.href='http://localhost/kantinterput2/admin/dashboard/data-user.php';</script>";
                                                } else {
                                                    $sql = 'UPDATE user SET id_user=:id_user, username=:username, nama=:nama, email=:email, hak_akses=:akses WHERE id_user=:id_user';
                                                    $stmt = $conn->prepare($sql);

                                                    $stmt->bindParam(':id_user', $id_user);
                                                    $stmt->bindParam(':username', $username);
                                                    $stmt->bindParam(':nama', $nama);
                                                    $stmt->bindParam(':email', $email);
                                                    $stmt->bindParam(':akses', $akses);
                                                        
                                                    $stmt->execute();
                                                    echo "<script>document.location.href='http://localhost/kantinterput2/admin/dashboard/data-user.php';</script>";
                                                }
                                            }

                                            // Gunakan prepared statement untuk mencegah SQL injection
                                            $id_user = $_GET['id_user'];
                                            $stmt = $conn->prepare("SELECT * FROM user WHERE id_user = :id_user");
                                            $stmt->bindParam(':id_user', $id_user);
                                            $stmt->execute();
                                            $edit = $stmt->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                            <form action="" method="POST">
                                                <input type="hidden" name="id_user" id="id_user" value="<?= $edit['id_user']; ?>">
                                                <div class="row">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="username" class="form-control" id="username" value="<?= $edit['username'] ?>">
                                                        <label class="mx-2" for="username">Username</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="nama" class="form-control" id="nm" value="<?= $edit['nama'] ?>">
                                                        <label class="mx-2" for="nm">Nama</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                    <input class="form-control" type="password" id="password1" name="password"/>
                                                        <label class="mx-2" for="floatingPassword">Password</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="password" name="password2" class="form-control" id="rfloatingPassword">
                                                        <label class="mx-2" for="rfloatingPassword">Repeat Password</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="email" name="email" class="form-control" id="floatingInput" value="<?= $edit['email'] ?>">
                                                        <label class="mx-2" for="floatingInput">Email address</label>
                                                    </div>
                                                    <div>
                                                    <select name="hak_akses" class="form-select form-select mb-3" aria-label=".form-select-lg example">
                                                        <option selected hidden disabled>-- Pilih Hak Akses --</option>
                                                        <option value="admin" <?= ($edit['hak_akses'] == 'admin') ? 'selected' : '' ?>>admin</option>
                                                        <option value="operator" <?= ($edit['hak_akses'] == 'operator') ? 'selected' : '' ?>>operator</option>
                                                    </select>

                                                    </div>
                                                    <div class="col-6">
                                                        <input class="btn btn-success btn-block w-100" type="submit" name="simpan" value="Simpan">
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
                    </div>
                </main>
                <!-- End Body Content -->
                <?php include ("../../../admin/dashboard/footer.php"); ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../../admin/dashboard/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../../../admin/dashboard/js/datatables-simple-demo.js"></script>
    </body>
</html>