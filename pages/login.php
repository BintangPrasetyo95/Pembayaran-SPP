<?php 
include '../sql/connect.php';

if (isset($_POST['name'])) {
  $nm = $_POST['name'];
  $pw = md5($_POST['pw']);

  $petugas = mysqli_query($connect, "SELECT * FROM petugas WHERE username='$nm' AND password='$pw' ");
  $siswa = mysqli_query($connect, "SELECT * FROM siswa WHERE nis='$nm' AND password='$pw' ");

  if (mysqli_num_rows($siswa) >= 1) {
    $_SESSION['user'] = mysqli_fetch_array($siswa);
    $_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '1';
		$_SESSION['status'] = 'Selamat Datang '.$_SESSION['user']['nama'];
  } elseif (mysqli_num_rows($petugas) >= 1) {
    $_SESSION['user'] = mysqli_fetch_array($petugas);
    $_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '1';
		$_SESSION['status'] = 'Selamat Datang '.$_SESSION['user']['nama_petugas'];
		header('location: ../pages/index.php?page=laporan');
  }  else {
    echo '<script>alert("Username atau Password Salah!"); location.href="login.php";</script>';
  }

  if (!empty($_SESSION['user'])) {
    header('location: index.php');
  }
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
    Pembayaran SPP | Login
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent mt-4">
    <div class="container">
      <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon mt-2">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
      </button>
    </div>
  </nav>
  <!-- End Navbar -->
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../assets/img/47TAMAN.jpg'); background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Pembayaran SPP</h1>
            <p class="text-lead text-white">Masukkan Username / NISN dan Password untuk masuk</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Login</h5>
            </div>
            <div class="row px-xl-5 px-sm-4 px-3">
            <div class="card-body">
              <form method="POST">
                <div class="mb-3">
                  <input type="text" title="Masukkan Username / NIS untuk Login" class="form-control" placeholder="Username / NIS" aria-label="Email" name="name" autocomplete="off" required>
                </div>
                <div class="mb-3">
                  <input type="password" title="Masukkan Password untuk Login" class="form-control" placeholder="Password" aria-label="Password" name="pw" required>
                </div>
                <div class="text-center">
                  <button title="Login" class="btn bg-primary w-100 my-4 mb-2 text-white">Masuk</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> Soft by Bintang Prasetyo.
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>