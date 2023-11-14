<?php
if ($role == 'siswa') {
  $_SESSION['sweetalert'] = '1';
  $_SESSION['alert'] = '0';
  $_SESSION['status'] = 'Anda Tidak memiliki Hak untuk mengakses Halaman ini!';
  echo '<script>location.reload(); history.back();</script>';
}
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-md-12 mb-lg-0 mb-4">
          <div class="card mt-5">
            <div class="card-header pb-0 p-3">
              <div class="row">
                <div class="col-6 d-flex align-items-center">
                  <h6 class="mb-0 ms-3">Pembayaran SPP<strong class="position-absolute end-4" style="float: right;">Petugas Pembayar : <span class="text-success"><?= $_SESSION['user']['nama_petugas'] ?></span></strong></h6>
                </div>
              </div>
            </div>
            <div class="card-body p-4">

              <!-- KELAS !!!!!!!!!!!!!!!!!!!!!!!! -->

              <form method="post" <?= (isset($_POST['kelas_cari']) || isset($_POST['siswa_cari']) || isset($_POST['spp_cari']) ? 'hidden' : '') ?>>
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Pilih Kelas Siswa</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <select class="form-select shadow-none border-0" style="font-size: 18px;" name="kelas_cari" title="Cari data siswa yang akan membayar SPP di kelas ini" required>
                        <option value="" hidden>-- Pilih Data Kelas Siswa --</option>
                        <?php
                        $query = mysqli_query($connect, "SELECT * FROM kelas ORDER BY nama_kelas ");
                        while ($kelas = mysqli_fetch_array($query)) {
                        ?>
                          <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['nama_kelas'] ?> - <?= $kelas['kompetensi_keahlian'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <a class="btn btn-danger me-4" href="" style="float: right;">
                  <i class="fa fa-repeat" title="Reset Pembayaran" aria-hidden="true"></i>
                </a>
                <button style="float: right;" class="btn bg-gradient-info mb-0 me-2 mb-4" title="Cari data siswa yang akan membayar SPP" href=""><i class="fas fa-user-plus"></i>&nbsp;&nbsp;Cari Data Siswa</button>
              </form>

              <!-- END KELAS !!!!!!!!!!!!!!!!!!!! -->

              <!-- SISWA !!!!!!!!!!!!!!!!!!!!!!! -->

              <form method="post" <?= (isset($_POST['kelas_cari']) ? '' : 'hidden') ?>>
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Kelas Siswa</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <?php
                      $kelas_id = $_POST['kelas_cari'];
                      $query_kelas = mysqli_query($connect, "SELECT * FROM kelas WHERE id_kelas='$kelas_id' ");
                      $kelas_temp = mysqli_fetch_array($query_kelas);
                      ?>
                      <input type="text" value="<?= $kelas_temp['nama_kelas'] ?> - <?= $kelas_temp['kompetensi_keahlian'] ?>" style="font-size: 18px;" class="form-control shadow-none border-0" disabled>
                      <input type="hidden" name="kelas" value="<?= $kelas_temp['nama_kelas'] ?> - <?= $kelas_temp['kompetensi_keahlian'] ?>">
                    </div>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Pilih Data Siswa</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <select class="form-select shadow-none border-0" style="font-size: 18px;" title="Pilih Data Siswa yang akan membayar SPP" name="siswa_cari" required>
                        <option value="" hidden>NIS - Nama Siswa</option>
                        <?php
                        $kelas = $_POST['kelas_cari'];
                        $query = mysqli_query($connect, "SELECT * FROM siswa WHERE id_kelas='$kelas_id' ORDER BY nis ");
                        while ($siswa = mysqli_fetch_array($query)) {
                        ?>
                          <option value="<?= $siswa['nisn'] ?>"><?= $siswa['nis'] ?> - <?= $siswa['nama'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <a class="btn btn-danger me-4" href="" title="Title Pembayaran" style="float: right;">
                  <i class="fa fa-repeat" aria-hidden="true"></i>
                </a>
                <button style="float: right;" class="btn bg-gradient-info mb-0 me-2 mb-4" title="Cari data SPP yang ingin Siswa bayar" href=""><i class="fas fa-address-card"></i>&nbsp;&nbsp;Cari Data SPP</button>
              </form>

              <!-- END SISWA !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

              <!-- SPP !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

              <form method="post" <?= (isset($_POST['siswa_cari']) ? '' : 'hidden') ?>>
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Kelas Siswa</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <?php
                      if (isset($_POST['siswa_cari'])) {
                        $kelas_holder = $_POST['kelas'];
                        $query_kelas = mysqli_query($connect, "SELECT * FROM kelas WHERE id_kelas='$kelas' ");
                        $kelas = mysqli_fetch_array($query_kelas);
                      }
                      ?>
                      <input type="text" value="<?= $kelas_holder ?>" style="font-size: 18px;" class="form-control shadow-none border-0" disabled>
                      <input type="hidden" name="kelas" value="<?= $kelas_holder ?>">
                    </div>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Data Siswa</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <?php
                      if (isset($_POST['siswa_cari'])) {
                        $siswa_id = $_POST['siswa_cari'];
                        $query_siswa = mysqli_query($connect, "SELECT * FROM siswa WHERE nisn='$siswa_id' ");
                        $siswa = mysqli_fetch_array($query_siswa);
                      }
                      ?>
                      <input type="text" value="<?= $siswa['nis'] ?> - <?= $siswa['nama'] ?>" style="font-size: 18px;" class="form-control shadow-none border-0" disabled>
                      <input type="hidden" name="siswa" value="<?= $siswa['nisn'] ?>">
                    </div>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Pilih Data SPP</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <select class="form-select shadow-none border-0" style="font-size: 18px;" name="spp_cari" title="Pilih Data SPP yang akan dibayar oleh Siswa <?= $siswa['nama'] ?>" required>
                        <option value="" hidden>Tahun - Nominal</option>
                        <?php
                        $query = mysqli_query($connect, "SELECT * FROM spp ORDER BY tahun DESC ");

                        while ($spp = mysqli_fetch_array($query)) {

                          $id_spp_temp = $spp['id_spp'];
                          $cek_spp_query = mysqli_query($connect, "SELECT *,SUM(jumlah_bayar) as bayaran FROM pembayaran INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$siswa_id' AND pembayaran.id_spp='$id_spp_temp' ");
                          $cek_spp_row = mysqli_num_rows($cek_spp_query);

                          if ($cek_spp_row >= 1) {
                            $spp_total = $spp['nominal'];

                            $cek_spp = mysqli_fetch_array($cek_spp_query);
                            $total = intval($cek_spp['nominal']);
                            $bayaran_awal = intval($cek_spp['bayaran']);

                            $bayaran_akhir = intval($total - $bayaran_awal);
                            $bayaran = number_format($bayaran_akhir, 2, ',', '.');
                          }

                        ?>
                          <option value="<?= $spp['id_spp'] ?>" <?= ($spp_total == $bayaran_awal ? 'disabled' : '' ) ?>>
                            <?= $spp['tahun'] ?> - RP.<?= number_format($spp['nominal'], 2, ',', '.') ?><?php
                            if ($bayaran_akhir != 0) {
                              echo ' (Kurang: RP.' . $bayaran . ')';
                            }elseif ($spp_total == $bayaran_awal ) {
                              echo ' (Lunas)';
                            }
                            ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <a class="btn btn-danger me-4" href="" title="Reset Pembayaran" style="float: right;">
                  <i class="fa fa-repeat" aria-hidden="true"></i>
                </a>
                <button style="float: right;" class="btn bg-gradient-info mb-0 me-2 mb-4" title="Buka Halaman Pembayaran SPP" href=""><i class="fa fa-credit-card-alt"></i>&nbsp;&nbsp;Buka Laman Pembayaran SPP </button>
              </form>

              <!-- END SPP !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

              <!-- LAST FORM !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

              <form method="post" action="../CRUD/CRUD-pembayaran.php" <?= (isset($_POST['spp_cari']) ? '' : 'hidden') ?>>
                <input type="hidden" name="petugas" value="<?= $_SESSION['user']['nama_petugas'] ?>">
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Kelas Siswa</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <?php
                      if (isset($_POST['spp_cari'])) {
                        $kelas_holder = $_POST['kelas'];
                      }
                      ?>
                      <input type="text" value="<?= $kelas_holder ?>" style="font-size: 18px;" class="form-control shadow-none border-0" disabled>
                    </div>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Data Siswa</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <?php
                      if (isset($_POST['spp_cari'])) {
                        $siswa_id = $_POST['siswa'];
                        $query_siswa = mysqli_query($connect, "SELECT * FROM siswa WHERE nisn='$siswa_id' ");
                        $siswa = mysqli_fetch_array($query_siswa);
                      }
                      ?>
                      <input type="text" value="<?= $siswa['nisn'] ?> - <?= $siswa['nama'] ?>" style="font-size: 18px;" class="form-control shadow-none border-0" disabled>
                    </div>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Data SPP</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <?php
                      if (isset($_POST['spp_cari'])) {
                        $spp_id = $_POST['spp_cari'];
                        $query_spp = mysqli_query($connect, "SELECT * FROM spp WHERE id_spp='$spp_id' ");
                        $spp = mysqli_fetch_array($query_spp);
                      }
                      ?>
                      <input type="text" value="<?= $spp['tahun'] ?> - RP.<?= number_format($spp['nominal'], 2, ',', '.') ?>" style="font-size: 18px;" class="form-control shadow-none border-0" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label class="form-label" style="font-size: 18px;">Nominal Yang dibutuhkan</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <?php
                      $spp_nominal = $spp['nominal'];
                      
                      $bayar_cek = mysqli_query($connect, "SELECT SUM(jumlah_bayar) as jumlah FROM pembayaran INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn='$siswa_id' AND spp.id_spp='$spp_id' ");
                      $bayar_rows = mysqli_num_rows($bayar_cek);

                      // if bayar pernah exist
                      if ($bayar_rows >= 1) {
                        $bayar = mysqli_fetch_array($bayar_cek);
                        $total = $spp_nominal - $bayar['jumlah'];
                      }

                      ?>
                      <input type="text" style="font-size: 25px;" value="RP.<?= ( $bayar_rows >= 1 ? number_format($total, 2, ',', '.') : number_format($spp_nominal, 2, ',', '.') ) ?>" class="form-control shadow-none border-0" disabled>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <label class="form-label" style="font-size: 18px;">Nominal yang akan Dibayar</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <div class="input-group me-4 mh-50 form-inline border-0">
                        <span class="input-group-text text-body border-0" style="font-size: 25px;">RP.</i></span>
                        <input type="number" name="nominal" id="numericInput" style="font-size: 25px;" title="Input Nominal yang akan Dibayar oleh siswa (Maksimal: RP.<?= ( $bayar_rows >= 1 ? number_format($total, 2, ',', '.') : number_format($spp_nominal, 2, ',', '.') ) ?>)" onKeyPress="if(this.value.length==9) return false" max="<?= ( $bayar_rows >= 1 ? $total : $spp_nominal ) ?>" min="1" class="form-control shadow-none border-0" placeholder="..." required>
                      </div>
                    </div>
                  </div>

                  <input type="hidden" name="petugas" value="<?= $_SESSION['user']['id_petugas'] ?>">
                  <input type="hidden" name="siswa" value="<?= $siswa['nisn'] ?>">
                  <input type="hidden" name="spp" value="<?= $spp['id_spp'] ?>">
                  <input type="hidden" name="date" value="<?= date('Y/m/d') ?>">
                  <input type="hidden" name="tahun" value="<?= date('Y') ?>">
                  <input type="hidden" name="bulan" value="<?= date('F') ?>">

                </div>
                <a class="btn btn-danger btn-lg me-4" href="" title="Reset Pembayaran" style="float: right;">
                  <i class="fa fa-repeat" aria-hidden="true"></i>
                </a>
                <button type="submit" style="float: right;" name="bayar" title="Bayar SPP Dengan Data-Data yang telah Dipilih" class="btn bg-gradient-success btn-lg mb-0 me-2 mb-4" href=""><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;BAYAR</button>
              </form>

              <!-- END LAST FORM !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>