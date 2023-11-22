<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
  $base_url = "http://localhost/kantinterput2/";
} else {
  $base_url = "https://your-production-domain.com/";
}
?>
<!-- <nav class="navbar navbar-expand-lg bg-body-success"> -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">Kantin Kita</a>
    <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="sidebar offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header text-light border-bottom">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-center fs-5 flex-grow-1 pe-3">
          <li class="nav-item mx-2">
            <a class="nav-link active " aria-current="page" href="<?php echo $base_url; ?>">Home</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link active " aria-current="page" href="<?php echo $base_url; ?>cart.php">Keranjang</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link active " aria-current="page" href="<?php echo $base_url; ?>contact.php">Contact</a>
          </li>
        </ul>
        <!-- login/logout -->
        <div class="d-flex justify-content-center align-items-center gap-3">
          <a href="<?php echo $base_url; ?>admin/login.php" class="text-white px-3 py-1 rounded-3 btn"  style="background-color:#008000" >Login</a>
        </div>
       
      </div>
    </div>
  </div>
</nav>
