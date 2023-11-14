<?php  
$month_ago = date("Y-m-d", strtotime('last month'));
?>


<div class="row">
  <div class="col-xl-<?= ($role == 'siswa' ? '6' : '3' ) ?> col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Pembayaran SPP <?= ($role != 'admin' ? 'Anda' : '') ?></p>
              <h5 class="font-weight-bolder">
                <?php  
                if ($role == 'siswa') {
                  $id = $_SESSION['user']['nisn'];

                  $query = mysqli_query($connect, "SELECT count(*) as total FROM pembayaran WHERE nisn='$id' ");
                  $data = mysqli_fetch_array($query);

                  $query_sub = mysqli_query($connect, "SELECT count(*) as total FROM pembayaran WHERE nisn='$id' AND tgl_bayar>='$month_ago' ");
                  $data_sub = mysqli_fetch_array($query_sub);

                  echo $data['total'];
                  ?>
                  </h5>
                  <p class="mb-0">
                    <span class="text-success text-sm font-weight-bolder">+<?= $data_sub['total'] ?></span>
                    Bulan ini
                  </p>
                  <?php
                }elseif ($role == 'admin') {
                  $id = $_SESSION['user']['id_petugas'];

                  $query = mysqli_query($connect, "SELECT count(*) as total FROM pembayaran ");
                  $data = mysqli_fetch_array($query);

                  $query_sub = mysqli_query($connect, "SELECT count(*) as total FROM pembayaran WHERE tgl_bayar>='$month_ago' ");
                  $data_sub = mysqli_fetch_array($query_sub);

                  echo $data['total'];
                  ?>
                  </h5>
                  <p class="mb-0">
                    <span class="text-success text-sm font-weight-bolder">+<?= $data_sub['total'] ?></span>
                    Bulan Ini
                  </p>
                  <?php
                }else {
                  $id = $_SESSION['user']['id_petugas'];

                  $query = mysqli_query($connect, "SELECT count(*) as total FROM pembayaran WHERE id_petugas='$id' ");
                  $data = mysqli_fetch_array($query);

                  $query_sub = mysqli_query($connect, "SELECT count(*) as total FROM pembayaran WHERE id_petugas='$id' AND tgl_bayar>='$month_ago' ");
                  $data_sub = mysqli_fetch_array($query_sub);

                  echo $data['total'];
                  ?>
                  </h5>
                  <p class="mb-0">
                    <span class="text-success text-sm font-weight-bolder">+<?= $data_sub['total'] ?></span>
                    Bulan Ini
                  </p>
                  <?php
                }
                ?>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
              <i class="ni ni-credit-card text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php 
  if ($role != 'siswa') {
  ?>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Siswa</p>
              <h5 class="font-weight-bolder pb-4">
                <?php  
                $query = mysqli_query($connect, "SELECT count(*) as total FROM siswa ");
                $data = mysqli_fetch_array($query);
                echo $data['total'];
                ?>
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
              <i class="fas fa-users text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Petugas</p>
              <h5 class="font-weight-bolder pb-4">
                <?php  
                $query = mysqli_query($connect, "SELECT count(*) as total FROM petugas ");
                $data = mysqli_fetch_array($query);
                echo $data['total'];
                ?>
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
              <i class="ni ni-circle-08 text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  }
  ?>
  
  <div class="col-xl-<?= ($role == 'siswa' ? '6' : '3' ) ?> col-sm-6">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">SPP Tahun Ini</p>
              <h5 class="font-weight-bolder">
                <?= date("Y") ?>
              </h5>
              <p class="mb-0">
                <?php 
                $query = mysqli_query($connect, "SELECT * FROM spp WHERE tahun='".date('Y')."' ");
                $data = mysqli_fetch_array($query);

                if (empty($data['nominal'])) {
                  echo 'Nominal : -';
                }else {
                  echo 'Nominal : RP.'.number_format($data['nominal'] , 2, ',', '.');
                }
                ?>
              </p>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
              <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mt-4">
  <div class="col-lg-7 mb-lg-0 mb-4">
    <div class="card ">
      <div class="card-header pb-0 p-3">
        <div class="d-flex justify-content-between">
          <h6 class="mb-2">Pembayaran Terakhir <?= ($role != 'admin' ? 'Anda' : '') ?></h6>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center ">
          <tbody>
            <?php
            // $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON spp.id_spp=spp.id_spp ORDER BY id_pembayaran DESC LIMIT 6 ");
            if ($role == 'siswa') {
              $id_user = $_SESSION['user']['nisn'];
              $query = mysqli_query($connect, "SELECT *,Date_Format(tgl_bayar, '%d-%M-%Y') as tanggal_bayar FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$id_user' ORDER BY id_pembayaran DESC LIMIT 6 ");
            }else {
              $query = mysqli_query($connect, "SELECT *,Date_Format(tgl_bayar, '%d-%M-%Y') as tanggal_bayar FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp ORDER BY id_pembayaran DESC LIMIT 6 ");
            }
            
            while ($data = mysqli_fetch_array($query)) {
            ?>
            <tr>
              <td <?= ($role == 'siswa' ? 'hidden' : '') ?>>
                <div class="d-flex px-2 py-1">
                  <div id="myAvatar" title="Lihat Foto Profile dari Siswa <?= $data['nama'] ?>">
                    <img src="../assets/img/avatars/<?= $data['foto'] ?>" class="avatar avatar-sm me-3" alt="user1" <?= ($data['foto'] == '' ? 'hidden' : '') ?> onclick="document.getElementById('fullimage<?= $data['id_pembayaran'] . $data['nisn'] ?>').style.display = 'block' ">
                    <i class="fa fa-user me-sm-1" <?= ($data['foto'] == '' ? '' : 'hidden') ?>></i>
                  </div>
                  <div class="d-flex flex-column justify-content-center <?= ($data['foto'] == '' ? 'ms-4' : '') ?>">
                    <h6 class="text-sm mb-0"><strong><?= $data['nama'] ?></strong></h6>
                    <p class="text-xs text-secondary mb-0">NIS: <?= $data['nis'] ?></p>
                  </div>
                </div>
              </td>
              <td <?= ($role == 'siswa' ? '' : 'hidden') ?>>
                <div class="d-flex px-2 py-1">
                  <div id="myAvatar" title="Lihat Foto Profile dari Petugas <?= $data['nama_petugas'] ?>">
                    <img src="../assets/img/avatars/<?= $data['foto_petugas'] ?>" class="avatar avatar-sm me-3" alt="user1" <?= ($data['foto_petugas'] == '' ? 'hidden' : '') ?> onclick="document.getElementById('fullimage<?= $data['id_pembayaran'] . $data['id_petugas'] ?>').style.display = 'block' ">
                    <i class="ni ni-circle-08 me-sm-1" <?= ($data['foto_petugas'] == '' ? '' : 'hidden') ?>></i>
                  </div>
                  <div class="d-flex flex-column justify-content-center <?= ($data['foto_petugas'] == '' ? 'ms-4' : '') ?>">
                  <p class="text-xs font-weight-bold mb-0">Petugas:</p>
                  <h6 class="text-sm mb-0"><?= $data['nama_petugas'] ?></h6>
                  </div>
                </div>
              </td>
              <td>
                <div class="text-center">
                  <p class="text-xs font-weight-bold mb-0">SPP:</p>
                  <h6 class="text-sm mb-0"><?= $data['tahun'] ?></h6>
                </div>
              </td>
              <td>
                <div class="text-center">
                  <p class="text-xs font-weight-bold mb-0">Jumlah Bayar:</p>
                  <h6 class="text-sm mb-0">RP.<?= number_format($data['jumlah_bayar'] , 2, ',', '.') ?></h6>
                </div>
              </td>
              <td class="align-middle text-sm">
                <div class="col text-center">
                  <p class="text-xs font-weight-bold mb-0">Tanggal:</p>
                  <h6 class="text-sm mb-0"><?= $data['tanggal_bayar'] ?></h6>
                </div>
              </td>
            </tr>

            <div title="Tekan pada apapun untuk kembali" id="fullimage<?= $data['id_pembayaran'] . $data['nisn'] ?>" class="fullimage-siswa" style="background-image: url('../assets/img/avatars/<?= $data['foto'] ?>')" onclick="this.style.display='none';"></div>
            <div title="Tekan pada apapun untuk kembali" id="fullimage<?= $data['id_pembayaran'] . $data['id_petugas'] ?>" class="fullimage-petugas" style="background-image: url('../assets/img/avatars/<?= $data['foto_petugas'] ?>')" onclick="this.style.display='none';"></div>

            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card card-carousel overflow-hidden h-100 p-0">
      <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
        <div class="carousel-inner border-radius-lg h-100">
          <div class="carousel-item h-100 active" style="background-image: url('../assets/img/IMG_20231027_111640.jpg');background-size: cover;">
            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
              <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                <i class="ni ni-camera-compact text-dark opacity-10"></i>
              </div>
            </div>
          </div>
          <div class="carousel-item h-100" style="background-image: url('../assets/img/IMG_5331-scaled.jpg');background-size: cover;">
            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
              <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                <i class="ni ni-bulb-61 text-dark opacity-10"></i>
              </div>
            </div>
          </div>
          <div class="carousel-item h-100" style="background-image: url('../assets/img/1490717184.jpg');background-size: cover;">
            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
              <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                <i class="ni ni-trophy text-dark opacity-10"></i>
              </div>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>
</div>
<?php 
if ($role == 'siswa') {
?>
<div class="row mt-4">
  <div class="col-lg-12 mb-lg-0 mb-4">
    <div class="card ">
      <div class="card-header pb-0 p-3">
        <div class="d-flex justify-content-between">
          <h6 class="mb-2">List Data SPP</h6>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Tahun</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-5">Nominal</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Proses Bayar SPP</th>
            </tr>
          </thead>
          <tbody>
            <?php  
            if (isset($_POST['caridata'])) {
              $cari = $_POST['caridata'];
              $query = mysqli_query($connect, "SELECT * FROM spp WHERE tahun LIKE '%".$cari."%' OR nominal LIKE '%".$cari."%' ORDER BY tahun DESC ");
            }else{
              $query = mysqli_query($connect, "SELECT * FROM spp ORDER BY tahun DESC ");
            }

            $i = 1;
            while ($data = mysqli_fetch_array($query)) {
              ?>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <p class="text-xs font-weight-bold mb-0"><?= $i ?></p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0"><?= $data['tahun'] ?></h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="font-weight-bold mb-0">RP.<?= number_format($data['nominal'] , 2, ',', '.') ?></p>
                </td>
                <td class="align-middle text-center">
                <?php  
                $data_bayar = $_SESSION['user']['nisn'];
                $data_spp = $data['id_spp'];
                $progress_query = mysqli_query($connect, "SELECT *,SUM(jumlah_bayar) as jumlah_byr FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn='$data_bayar' AND spp.id_spp='$data_spp' ");
                $progress_data = mysqli_fetch_array($progress_query);

                $progress = ($progress_data['jumlah_byr'] / $data['nominal']) * 100;
                ?>
                  <div class="d-flex align-items-center justify-content-center">
                    <span class="me-2 text-xs font-weight-bold"><?= floor($progress) ?>%</span>
                    <div>
                      <div class="progress">
                        <div class="progress-bar bg-gradient-<?php if ($progress >= 0 && $progress < 20) {echo 'danger';} elseif ($progress >= 20 && $progress < 50) {echo 'warning';} elseif ($progress >= 50 && $progress < 100) {echo 'info';} elseif ($progress == 100) {echo 'success';} else {echo 'dark';} ?>" role="progressbar" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="<?= $progress ?>" style="width: <?= $progress ?>%;"></div>
                      </div>
                    </div>
                  </div>
                </td>

              </tr>
              <?php
            $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php
}
?>