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
        <?php include ("../../../admin/dashboard/navbar.php"); ?>
            <div id="layoutSidenav_content">
            <main id="admin" class="admin">
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Form Registrasi User</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="http://localhost/kantinterput2/admin/dashboard/">Dashboard</a></li>
                            <li class="breadcrumb-item active">Register</li>
                        </ol>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Form Registrasi User
                                </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body px-5 my-2">
                                        <div class="container px-5 admin">
                                        <?php
                                            require_once("../../../admin/dashboard/conn.php");
                                            if(isset($_POST['register'])){

                                                // filter data yang diinputkan
                                                $nama = filter_input(INPUT_POST, 'nama');
                                                $username = filter_input(INPUT_POST, 'username');
                                                // enkripsi password
                                                $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                                                $cpassword = password_hash($_POST["cpassword"], PASSWORD_DEFAULT);
                                                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

                                                if(isset($_POST['hak_akses'])) {
                                                    $hakAkses = $_POST['hak_akses'];
                                                } 
                                                if (empty($nama) || empty($username) || empty($_POST["password"]) || empty($email) || empty($_POST["hak_akses"])) {
                                                    $error = "Form kosong";
                                                    echo "<script>formkosong();</script>";
                                                    
                                                }
                                                if ($_POST["password"] !== $_POST["cpassword"]) {
                                                    echo "<script>cpassworderror();</script>";
                                                    $error = "Password tidak sama";
                                                }
                                                if(!isset($error)){
                                                    //no error
                                                        $sthandler = $conn->prepare("SELECT username FROM user WHERE username = :username");
                                                        $sthandler->bindParam(':username', $username);
                                                        $sthandler->execute();
                                                        
                                                        if($sthandler->rowCount() > 0){
                                                            echo "<script>usernameexist();</script>";
                                                        } else {
                                                                //Securly insert into database
                                                                $sql = 'INSERT INTO user (nama ,username, email, password, hak_akses) VALUES (:nama,:username,:email,:password,:hak_akses)';    
                                                                $query = $conn->prepare($sql);

                                                                $query->execute(array(
                                                            
                                                                    ":nama" => $nama,
                                                                    ":username" => $username,
                                                                    ":password" => $password,
                                                                    ":email" => $email,
                                                                    ":hak_akses" => $hakAkses
                                                            
                                                                ));
                                                        }
                                                        
                                                    }
                                            }

                                            ?>
                                            <form action="" method="POST">
                                                <div class="row">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                                                        <label class="mx-2" for="username">Username</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="nama" class="form-control" id="nm" placeholder="Nama">
                                                        <label class="mx-2" for="nm">Nama</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                                                        <label class="mx-2" for="floatingPassword">Password</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="password" name="cpassword" class="form-control" id="cfloatingPassword" placeholder="Repeat Password">
                                                        <label class="mx-2" for="rfloatingPassword">Repeat Password</label>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                                        <label class="mx-2" for="floatingInput">Email address</label>
                                                    </div>
                                                    <div>
                                                        <select name="hak_akses" class="form-select form-select mb-3" aria-label=".form-select-lg example">
                                                            <option selected hidden disabled>Hak Akses</option>
                                                            <option value="admin">Admin</option>
                                                            <option value="operator">Operator</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <input class="btn btn-primary btn-block w-100" type="submit" name="register" value="Daftar">
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
        <script>
             $('.panel-collapse').on('show.bs.collapse', function () {
                $(this).siblings('.panel-heading').addClass('active');
            });

            $('.panel-collapse').on('hide.bs.collapse', function () {
                $(this).siblings('.panel-heading').removeClass('active');
            });
        </script>
    </body>
</html>
