<?php  
include '../sql/connect.php';

date_default_timezone_set('Asia/Jakarta');

if (empty($_SESSION['user']) || empty($_SESSION['user']['nama']) && empty($_SESSION['user']['nama_petugas'])) {
  header('location: logout.php');
}

if (empty($_SESSION['user']['level'])) {
  $role = 'siswa';
}elseif ($_SESSION['user']['level'] == 'petugas') {
  $role = 'petugas';
}elseif ($_SESSION['user']['level'] == 'admin') {
  $role = 'admin';
}else{
  $role = 'siswa';
}

if ($role == 'siswa') {
  $nama = $_SESSION['user']['nama'];
}else{
  $nama = $_SESSION['user']['nama_petugas'];
}

if ($role != 'siswa') {
  $userfoto = $_SESSION['user']['foto_petugas'];
}else{
  $userfoto = $_SESSION['user']['foto'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Pembayaran SPP | <?php  
      $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
      $cek = preg_replace("/-/", " ", $page);
      $title = ucwords($cek);
      echo $title;
    ?>
  </title>
  <link rel="stylesheet" href="../assets/css/fade.css">
  <link rel="stylesheet" href="../assets/css/avatar-show.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100" <?php if (isset($_SESSION['sweetalert'])) {echo 'onload="sweetalert()"'; unset($_SESSION['sweetalert']);} ?>>
  <div class="min-height-300 bg-primary position-absolute w-100" <?php if ($page == 'profile') {echo "hidden";} ?>></div>
  <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('../assets/img/smk-coe.jpg'); background-position-y: 50%;" <?php if ($page != 'profile') {echo "hidden";} ?>>
    <span class="mask bg-primary opacity-6"></span>
  </div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <!-- <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank"> -->
      <a class="navbar-brand m-0" href="index.php">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Pembayaran SPP</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0" style="height: 2px;">

    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main" style="height: 800px;">
      <ul class="navbar-nav">
        <?php  
        if ($role != 'siswa') {
        ?>
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'pembayaran' ? 'active' : '' ) ?>" href="?page=pembayaran">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Bayar SPP</span>
          </a>
          <br>
        <hr class="horizontal dark mt-0" style="height: 2px;">
        </li>
        <?php
        }
        ?>
        
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'dashboard' ? 'active' : '' ) ?>" href="?page=dashboard">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'history' ? 'active' : '' ) ?>" href="?page=history">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">History</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'profile' ? 'active' : '' ) ?>" href="?page=profile">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <?php 
        if ($role == 'petugas') {
        ?>
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'list-siswa' ? 'active' : '' ) ?>" href="?page=list-siswa">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-users text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">List Siswa</span>
          </a>
        </li>
        <?php
        }
        ?>
      </ul>

      <?php 
      if ($role == 'admin') {
      ?>
      <ul class="navbar-nav">
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Laporan</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'laporan' ? 'active' : '' ) ?>" href="?page=laporan">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-archive-2 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Laporan Pembayaran</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Administrator</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'spp' ? 'active' : '' ) ?>" href="?page=spp">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-money-coins text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">SPP</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'petugas' ? 'active' : '' ) ?>" href="?page=petugas">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-circle-08 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Petugas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'siswa' ? 'active' : '' ) ?>" href="?page=siswa">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-users text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Siswa</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page == 'kelas' ? 'active' : '' ) ?>" href="?page=kelas">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tag text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Kelas</span>
          </a>
        </li>
      </ul>
      <?php
      }
      ?>
    </div>
  </aside>

