<?php  
if (isset($_GET['section']) == 'profile' ) {
  echo "<script>location.href='index.php?page=profile#section_profile'</script>";
}
?>

<div class="card shadow-lg mx-4 card-profile-bottom mt-8">
  <div class="card-body p-3">
    <div class="row gx-4">
      <div class="col-auto">
        <div title="Lihat Foto Profile" class="avatar avatar-xl position-relative" onload="getPics()" onclick="document.getElementById('fullimage').style.display = 'block' " id="myAvatar2">
          <img src="../assets/img/avatars/<?= $userfoto ?>" alt="<?= $userfoto ?>" class="w-100 border-radius-lg shadow-sm" width="74px" height="74px">
        </div>
      </div>
      <div class="col-auto my-auto">
        <div class="h-100">
          <h5 class="mb-1">
            <?= $nama ?>
          </h5>
          <p class="mb-0 font-weight-bold text-sm">
            <?= ($role == 'siswa' ? $_SESSION['user']['nis'] : $_SESSION['user']['username'] ) ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid py-4" id="section_profile">
  <div class="row">
    <div class="col-md-4 mb-5">
      <div class="card card-profile">
        <img src="../assets/img/smkn3metro.jpg" alt="Image placeholder" class="card-img-top">
        <div class="row justify-content-center">
          <div class="col-4 col-lg-4 order-lg-2">
            <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0" title="Lihat Foto Profile" onload="getPics()" onclick="document.getElementById('fullimage').style.display = 'block' " id="myAvatar">
              <img src="../assets/img/avatars/<?= $userfoto ?>" alt="<?= $userfoto ?>" class="rounded-circle img-fluid border border-2 border-white">
            </div>
          </div>
        </div>
        <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
          <hr class="horizontal dark pb-1">
        </div>
        <div class="card-body pt-0">
          <div class="text-center m2-4">
            <h5 class="mb-2">
              <?= $nama ?>
            </h5>
            <?php
            if ($role == 'siswa') {
              $nisn = $_SESSION['user']['nisn'];
              $query_kelas = mysqli_query($connect, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas WHERE nisn='$nisn' ");
              $kelas = mysqli_fetch_array($query_kelas);
            }
            ?>
            <div class="h6 font-weight-300" <?= ($role != 'siswa' ? 'hidden' : '') ?>>
              <i class="fa fa-tag me-2"></i><?= $kelas['nama_kelas'] ?> - <?= $kelas['kompetensi_keahlian'] ?>
            </div>
            <div class="h6 font-weight-300" <?= ($role != 'siswa' ? '' : 'hidden') ?>>
              <i class="ni ni-circle-08 me-2"></i><?= $_SESSION['user']['username'] ?>
            </div>
            <div class="h6 mt-4">
              <i class="ni ni-badge me-2"></i><?= ucwords($role) ?>
            </div>
            <div <?= ($role != 'siswa' ? 'hidden' : '') ?>>
              <i class="ni ni-square-pin me-2"></i><?= $_SESSION['user']['alamat'] ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0">Edit Profile</p>
          </div>
        </div>
        <div class="card-body">
          <form method="post" action="../CRUD/CRUD-profile.php" enctype="multipart/form-data">
            <p class="text-uppercase text-sm">Informasi User</p>
            <div class="row">
              <label for="example-text-input" class="form-control-label">Foto Profile <span class="text-secondary">&nbsp;&nbsp;(Disarankan untuk memakai foto berbentuk Persegi)</span></label>
              <div class="col-md-8 col-lg-9">
                <input type="file" name="foto" id="upload-button" oninput="showPreview()" accept="image/*" hidden>
                <figure id="myPreview" style="display: none;">
                  <img id="chosen-image" width="200px" height="200px">
                  <figcaption id="file-name"></figcaption>
                </figure>
                <div class="pt-2">
                  <label for="upload-button" style="color: white;" class="btn btn-primary btn-sm" title="Upload Foto Profile Baru"><i class="bi bi-upload"></i></label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-<?= ($role == 'siswa' ? '12' : '6') ?>">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Nama</label>
                  <input class="form-control" type="text" value="<?= $nama ?>" disabled>
                </div>
              </div>
              <div class="col-md-6" <?= ($role == 'siswa' ? 'hidden' : '') ?>>
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Username</label>
                  <input class="form-control" type="text" title="Ubah Data Username" maxlength="25" name="username" value="<?= $_SESSION['user']['username'] ?>">
                </div>
              </div>
              <div class="col-md-6" <?= ($role == 'siswa' ? '' : 'hidden') ?>>
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">NISN</label>
                  <input class="form-control" type="text" value="<?= $_SESSION['user']['nisn'] ?>" disabled>
                </div>
              </div>
              <div class="col-md-6" <?= ($role == 'siswa' ? '' : 'hidden') ?>>
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">NIS</label>
                  <input class="form-control" type="text" value="<?= $_SESSION['user']['nis'] ?>" disabled>
                </div>
              </div>
            </div>
            <hr class="horizontal dark" <?= ($role == 'siswa' ? '' : 'hidden') ?>>
            <p class="text-uppercase text-sm" <?= ($role == 'siswa' ? '' : 'hidden') ?>>Informasi Kontak</p>
            <div class="row" <?= ($role == 'siswa' ? '' : 'hidden') ?>>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">alamat</label>
                  <input class="form-control" type="text" title="Ubah Data Alamat" name="alamat" value="<?= $_SESSION['user']['alamat'] ?>">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">No. Telp</label>
                  <input class="form-control" type="number" title="Ubah Data Nomor Telepon" name="no_telp" value="<?= $_SESSION['user']['no_telp'] ?>">
                </div>
              </div>
            </div>
            <hr class="horizontal dark">
            <p class="text-uppercase text-sm">Edit Password</p>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Password Lama</label>
                  <input class="form-control" title="Masukkan Data Password Lama" name="pw_lama" type="password" maxlength="32" onkeypress="return event.which != 32">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Password Baru</label>
                  <input class="form-control" title="Masukkan Data Password Baru" name="pw_baru" id="pw_baru" type="password" maxlength="32" onkeypress="return event.which != 32">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Konfirmasi Password Baru</label>
                  <input class="form-control" title="Konfirmasi Password Baru" name="pw_konf" id="pw_konf" type="password" maxlength="32" onkeypress="return event.which != 32">
                </div>
              </div>
            </div>
            <a class="btn btn-danger me-2 mt-2" href="?page=profile&section=edit" title="Reset Edit Profile" style="float: right;">
              <i class="fa fa-repeat" aria-hidden="true"></i>
            </a>
            <button name="edit-profile-<?= ($role == 'siswa' ? 'siswa' : 'petugas' ) ?>" title="Ubah Data Profile" style="float: right;" class="btn bg-gradient-info mb-0 me-2 mb-4 mt-2 w-25" href=""><i class="fas fa-paper-plane"></i>&nbsp;&nbsp;Simpan</button>
          </form>
        </div>
        <div id="fullimage" title="Tekan pada apapun untuk Kembali" style="background-image: url('../assets/img/avatars/<?= $userfoto ?>')" onclick="this.style.display='none';"></div>
      </div>
    </div>
  </div>
</div>

<script src="../assets/js/js-pages/profile.js"></script>
<link rel="stylesheet" href="../assets/css/profile-page.css">