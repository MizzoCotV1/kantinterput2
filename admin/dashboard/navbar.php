
<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $base_url = "http://localhost/kantinterput2/";
} else {
    $base_url = "https://your-production-domain.com/";
}
session_start();
if (!isset($_SESSION['login'])) {
require_once("conn.php");
?>
    <script>
        alert("SILAHKAN LOGIN!");
        window.open("<?php echo $base_url; ?>admin/login.php', '_self");
    </script>
<?php
} else {
    $statuses = $_SESSION['hak_akses'];
    $usernames = $_SESSION['username'];
    $names = $_SESSION['nama'];
    $id_user = $_SESSION['id_user'];
}

?>
<?php
    if ($_SESSION['hak_akses'] !== 'admin') {
        echo "<script>
            document.location.href='" . $base_url . "admin/dashboard/';
        </script>";
    }
?>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="<?php echo $base_url; ?>admin/dashboard/">Start Bootstrap</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">General</div>
                            <a class="nav-link" href="<?php echo $base_url; ?>admin/dashboard/">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link" href="<?php echo $base_url; ?>admin/dashboard/penjualan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Penjualan
                            </a>
                            <a class="nav-link" href="<?php echo $base_url; ?>admin/dashboard/data-produk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    Data Produk
                            </a>
                            <a class="nav-link" href="<?php echo $base_url; ?>admin/dashboard/pendaftaran-produk.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-id-card"></i></div>
                                    Daftar Produk
                            </a>

                            <?php if ($_SESSION['hak_akses'] == 'admin') : ?>
                                <div class="sb-sidenav-menu-heading">Register</div>
                                <a class="nav-link" href="<?php echo $base_url; ?>admin/dashboard/user/register.php">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-id-card"></i></div>
                                    Register user
                                </a>
                                <a class="nav-link" href="<?php echo $base_url; ?>admin/dashboard/user/data-user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    Data User
                                </a>
                                </div>
                            <?php endif; ?>
                    </div>
                </nav>
            </div>