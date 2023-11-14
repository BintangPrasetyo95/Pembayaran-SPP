<!-- Navbar -->
<main class="main-content position-relative border-radius-lg ">
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm opacity-5 text-white">Pages</li>
        <li class="breadcrumb-item text-sm opacity-5 text-white" <?php if ($page != 'petugas' && $page != 'siswa' && $page != 'kelas' && $page != 'spp') {echo "hidden";} ?>>Administrator</li>
        <li class="breadcrumb-item text-sm opacity-5 text-white" <?php if ($page != 'laporan') {echo "hidden";} ?>>Laporan</li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?= ($title == 'Pembayaran' ? 'Pembayaran SPP' : $title ) . ($page == 'laporan' ? ' Pembayaran' : '' ) ?></li>
      </ol>
      <h6 class="font-weight-bolder text-white mb-0"><?= $title . ($page == 'laporan' ? ' Pembayaran' : '' ) ?></h6>
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center" style="margin-right: 40px;">
      </div>
      <ul class="navbar-nav  justify-content-end">
        <span class="text-white font-weight-bold me-7 mt-1"><?= date("l, d - F - Y") ?></span>
        <li class="nav-item d-flex align-items-center">
          <a href="?page=profile" class="nav-link text-white font-weight-bold px-0" title="Pergi ke Halaman Profile">
            <i class="ni ni-circle-08 me-sm-1" <?= (!empty($_SESSION['user']['level']) ? '' : 'hidden' ) ?>></i>
            <i class="fa fa-user me-sm-1" <?= (!empty($_SESSION['user']['nisn']) ? '' : 'hidden' ) ?>></i>
            <span class="d-sm-inline d-none"><?= $nama ?></span>
          </a>
        </li>
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center" title="Buka Menu Halaman">
          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </li>
        <li style="margin-left: 10px;" class="nav-item px-3 d-flex align-items-center" title="Pengaturan Profile">
          <a href="?page=profile#section_profile" class="nav-link text-white p-0">
            <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
          </a>
        </li>
        <li style="margin-left: 10px;" class="nav-item px-3 d-flex align-items-center" title="Logout">
          <a href="logout.php" class="nav-link text-white p-0" title="Logout">
            <i class="fa fa-sign-out fixed-plugin-button-nav cursor-pointer"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script>
  function sweetalert() {
    Swal.fire(
    '<?= ($_SESSION['alert'] == "1" ? "Berhasil!" : "Gagal!" ) ?>',
    '<?= $_SESSION['status'] ?>',
    '<?= ($_SESSION['alert'] == "1" ? "success" : "error" ) ?>'
    )
  }
</script>
<!-- End Navbar -->
<div class="container-fluid py-4">
