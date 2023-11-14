<?php
if ($role != 'admin') {
  $_SESSION['sweetalert'] = '1';
  $_SESSION['alert'] = '0';
  $_SESSION['status'] = 'Anda Tidak memiliki Hak untuk mengakses Halaman ini!';
  echo '<script>location.reload(); history.back();</script>';
}
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <form method="post">
            <h6>
              Table Siswa
              <a style="margin-left: 10px;" title="Tambah data Siswa baru" class="btn btn-sm badge badge-sm text-xxs bg-gradient-success" data-bs-toggle="modal" data-bs-target="#tambahsiswa">+ Tambah Data</a>
              <a class="btn btn-danger me-4" title="Reset filter pada table" href="" style="float: right;">
                <i class="fa fa-repeat" aria-hidden="true"></i>
              </a>
              <button type="submit" title="Cari data apapun pada table" class="btn btn-info me-2" style="float: right;">
                <i class="fas fa-search" aria-hidden="true"></i>
              </button>
              <div class="input-group w-15 me-4 mh-50 form-inline" title="Cari data apapun pada table" style="float: right;">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="caridata" pattern="[A-Za-z0-9& .]*" oninvalid="alert('Tolong isi Tab Pencarian dengan Benar')" placeholder="Cari..." required>
              </div>
            </h6>
          </form>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">NIS</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Siswa</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kelas</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No. Telp</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Detail Siswa</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($_POST['caridata'])) {
                  $cari = $_POST['caridata'];
                  $query = mysqli_query($connect, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas WHERE nisn LIKE '%" . $cari . "%' OR nis LIKE '%" . $cari . "%' OR nama LIKE '%" . $cari . "%' OR nama_kelas LIKE '%" . $cari . "%' OR kompetensi_keahlian LIKE '%" . $cari . "%' OR alamat LIKE '%" . $cari . "%' OR no_telp LIKE '%" . $cari . "%' ORDER BY nis ");
                } else {
                  $query = mysqli_query($connect, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas ORDER BY nis ");
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
                          <p class="text-xs font-weight-bold mb-0"><?= $data['nis'] ?></p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div id="myAvatar" title="Lihat Foto profile dari Siswa <?= $data['nama'] ?>">
                          <img src="../assets/img/avatars/<?= $data['foto'] ?>" class="avatar avatar-sm me-3" alt="user1" <?= ($data['foto'] == '' ? 'hidden' : '') ?> onclick="document.getElementById('fullimage<?= $data['nisn'] ?>').style.display = 'block' ">
                          <i class="fa fa-user me-sm-1" <?= ($data['foto'] == '' ? '' : 'hidden') ?>></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center <?= ($data['foto'] == '' ? 'ms-4' : '') ?>">
                          <h6 class="mb-0 text-sm"><?= $data['nama'] ?></h6>
                          <p class="text-xs text-secondary mb-0">NISN: <?= $data['nisn'] ?></p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0"><?= $data['nama_kelas'] ?></p>
                      <p class="text-xs text-secondary mb-0"><?= $data['kompetensi_keahlian'] ?></p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0"><?= $data['no_telp'] ?></p>
                    </td>
                    <td class="align-middle text-center">
                      <a data-bs-toggle="modal" title="Cek Detail Data Siswa" data-bs-target="#detailsiswa<?= $data['nisn'] ?>" class="btn btn-sm badge badge-sm bg-gradient-secondary">Detail</a>
                      <a data-bs-toggle="modal" title="Cek Detail Pembayaran SPP Siswa" data-bs-target="#detailsiswaspp<?= $data['nisn'] ?>" class="btn btn-sm badge badge-sm bg-gradient-success">Riwayat</a>
                    </td>
                    <td class="align-middle text-center">
                      <a data-bs-toggle="modal" title="Edit data siswa" data-bs-target="#editsiswa<?= $data['nisn'] ?>" class="btn btn-info btn-sm text-xs" data-original-title="Edit Kelas">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Edit
                      </a>
                      <a data-bs-toggle="modal" title="Hapus data siswa" data-bs-target="#hapussiswa<?= $data['nisn'] ?>" style="margin-left: 10px;" class="btn btn-danger btn-sm text-xs" data-original-title="Hapus Kelas">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Hapus
                      </a>
                    </td>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailsiswa<?= $data['nisn'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Data Siswa</h1>
                              </div>
                            </div>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">NISN</label>
                                <input type="number" name="nisn" class="form-control" placeholder="Masukkan NISN Siswa" min="1" onKeyPress="if(this.value.length==10) return false" onkeypress="return event.which != 32" value="<?= $data['nisn'] ?>" readonly>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">NIS</label>
                                <input type="number" name="nis" class="form-control" placeholder="Masukkan NIS Siswa" min="1" onKeyPress="if(this.value.length==4) return false" onkeypress="return event.which != 32" value="<?= $data['nis'] ?>" readonly>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">Nama Siswa</label>
                                <input type="text" name="nama" class="form-control" maxlength="30" placeholder="Masukkan Nama Siswa" value="<?= $data['nama'] ?>" readonly>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">Kelas</label>
                                <input type="text" name="nama" class="form-control" maxlength="30" placeholder="Masukkan Nama Siswa" value="<?= $data['nama_kelas'] ?> - <?= $data['kompetensi_keahlian'] ?>" readonly>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">No Telp</label>
                                <input type="number" name="telp" class="form-control" value="<?= $data['no_telp'] ?>" readonly>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">Alamat</label>
                                <textarea type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat Siswa" style="height: 100px;" readonly><?= $data['alamat'] ?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal Detail-->

                    <!-- Modal Detail spp -->
                    <div class="modal fade" id="detailsiswaspp<?= $data['nisn'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Data Pembayaran SPP Siswa</h1>
                              </div>
                            </div>
                          </div>
                          <div class="modal-body">
                            <?php
                            $query_progress_spp = mysqli_query($connect, "SELECT * FROM spp ORDER BY tahun DESC ");
                            $progress_siswa = $data['nisn'];
                            $urut_total = mysqli_num_rows($query_progress_spp);
                            $urut = 1;
                            while ($progress_spp = mysqli_fetch_array($query_progress_spp)) {

                              $id_spp = $progress_spp['id_spp'];
                              $progress_query = mysqli_query($connect, "SELECT *,SUM(jumlah_bayar) as jumlah_byr FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn='$progress_siswa' AND spp.id_spp='$id_spp' ");
                              $progress_data = mysqli_fetch_array($progress_query);
          
                              $progress = ($progress_data['jumlah_byr'] / $progress_spp['nominal']) * 100;
                              $progress_kurang = $progress_spp['nominal'] - $progress_data['jumlah_byr'];
                            ?>
                            <div class="row">
                              <div class="mb-<?= ($urut < $urut_total ? '6' : '4') ?>">
                              <label class="form-label text-xs font-weight-bold mb-0">Tahun : <big class="font-weight-bolder"><?= $progress_spp['tahun'] ?></big></label><br>
                              <center><?= floor($progress) ?>%</center>
                                <div>
                                  <div>
                                    <div class="progress">
                                      <div class="progress-bar bg-gradient-<?php if ($progress >= 0 && $progress < 20) {echo 'danger';} elseif ($progress >= 20 && $progress < 50) {echo 'warning';} elseif ($progress >= 50 && $progress < 100) {echo 'info';} elseif ($progress == 100) {echo 'success';} else {echo 'dark';} ?>" role="progressbar" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="<?= $progress ?>" style="width: <?= $progress ?>%;"></div>
                                    </div>
                                    <?php 
                                    if ($progress == 100) {
                                      echo 'Lunas';
                                    }elseif ($progress != 100 && $progress != 0) {
                                      echo 'Kurang : RP.'.number_format($progress_kurang, 2, ',', '.');
                                    }else{
                                      echo 'Belum Terbayar';
                                    }
                                    ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php
                            $urut++;
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal Detail spp-->

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editsiswa<?= $data['nisn'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Siswa</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-siswa.php">
                            <input type="hidden" name="idn" value="<?= $data['nisn'] ?>">
                            <input type="hidden" name="id" value="<?= $data['nis'] ?>">
                            <div class="modal-body">
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">NISN</label>
                                  <input type="number" title="Masukkan NISN Siswa" name="nisn" class="form-control" placeholder="Masukkan NISN Siswa" min="1" onKeyPress="if(this.value.length==10) return false" onkeypress="return event.which != 32" value="<?= $data['nisn'] ?>" required>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">NIS</label>
                                  <input type="number" title="Masukkan NIS Siswa" name="nis" class="form-control" placeholder="Masukkan NIS Siswa" min="1" onKeyPress="if(this.value.length==4) return false" onkeypress="return event.which != 32" value="<?= $data['nis'] ?>" required>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Nama Siswa</label>
                                  <input type="text" title="Masukkan Nama Siswa" name="nama" class="form-control" maxlength="30" placeholder="Masukkan Nama Siswa" value="<?= $data['nama'] ?>" required>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Kelas</label>
                                  <select class="form-select" name="kelas" title="Pilih Kelas Siswa" required>
                                    <?php
                                    $query_kelas = mysqli_query($connect, "SELECT * FROM kelas ORDER BY nama_kelas ");
                                    while ($kelas = mysqli_fetch_array($query_kelas)) {
                                    ?>
                                      <option value="<?= $kelas['id_kelas'] ?>" <?= ($data['id_kelas'] == $kelas['id_kelas'] ? 'selected' : '') ?>><?= $kelas['nama_kelas'] ?> - <?= $kelas['kompetensi_keahlian'] ?></option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Alamat</label>
                                  <textarea type="text" name="alamat" title="Masukkan Alamat Siswa" class="form-control" placeholder="Masukkan Alamat Siswa" style="height: 100px;" required><?= $data['alamat'] ?></textarea>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">No Telp</label>
                                  <input type="number" name="telp" title="Masukkan Nomor Telepon Siswa" class="form-control" onKeyPress="if(this.value.length==13) return false" placeholder="Masukkan Nomor Telepon Siswa" onkeypress="return event.which != 32" value="<?= $data['no_telp'] ?>" required>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Password Baru</label>
                                  <input type="password" name="pw" title="Perbarui Password Baru Siswa" class="form-control" id="pw<?= $data['nisn'] ?>" maxlength="32" placeholder="Masukkan Password Siswa" onkeypress="return event.which != 32">
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Konfirmasi Password Baru</label>
                                  <input type="password" name="kon_pw" title="Konfirmasi Password Baru Siswa" class="form-control" id="kon_pw<?= $data['nisn'] ?>" maxlength="32" placeholder="Konfirmasi Password Siswa" onkeypress="return event.which != 32">
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Konfirmasi Edit data Siswa" class="btn btn-success" name="edit-siswa">Konfirmasi</button>
                                  <button type="reset" title="Reset Form edit data siswa" class="btn btn-danger"><i class="fa fa-repeat"></i></button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <script>
                      var pw<?= $data['nisn'] ?> = document.getElementById('pw<?= $data['nisn'] ?>');
                      var k_pw<?= $data['nisn'] ?> = document.getElementById('kon_pw<?= $data['nisn'] ?>');

                      function validasi() {
                        if (pw<?= $data['nisn'] ?>.value != k_pw<?= $data['nisn'] ?>.value) {
                          k_pw<?= $data['nisn'] ?>.setCustomValidity("Input Password Tidak Sama");
                        } else {
                          k_pw<?= $data['nisn'] ?>.setCustomValidity("");
                        }
                      }

                      pw<?= $data['nisn'] ?>.onchange = validasi;
                      k_pw<?= $data['nisn'] ?>.onchange = validasi;
                    </script>

                    <!--Akhir Modal Edit-->

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="hapussiswa<?= $data['nisn'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Siswa</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-siswa.php">
                            <input type="hidden" name="nisn" value="<?= $data['nisn'] ?>">
                            <input type="hidden" name="nis" value="<?= $data['nis'] ?>">
                            <div class="modal-body">
                              <h5 cl class="text-center">Apakah Yakin ingin Menghapus Data Siswa ini? <br>
                                <span class="text-danger"><strong><?= $data['nama'] ?></strong></span>
                              </h5>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Konfirmasi Hapus data siswa" class="btn btn-danger" name="hapus-siswa">Konfirmasi</button>
                                  <a data-bs-dismiss="modal" title="Kembali" class="btn btn-secondary">Kembali</i></a>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal Hapus-->

                  </tr>

                  <div title="Tekan pada apapun untuk Kembali" id="fullimage<?= $data['nisn'] ?>" class="fullimage-siswa" style="background-image: url('../assets/img/avatars/<?= $data['foto'] ?>')" onclick="this.style.display='none';"></div>

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
  </div>
</div>

<!-- Modal tambah -->
<div class="modal fade" id="tambahsiswa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12">
          <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
          <div class="text-center">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Siswa</h1>
          </div>
        </div>
      </div>
      <form method="post" action="../CRUD/CRUD-siswa.php">
        <div class="modal-body">
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">NISN</label>
              <input type="number" name="nisn" title="Masukkan NISN Siswa" class="form-control" placeholder="Masukkan NISN Siswa" min="1" onKeyPress="if(this.value.length==10) return false" onkeypress="return event.which != 10" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">NIS</label>
              <input type="number" name="nis" title="Masukkan NIS Siswa" class="form-control" placeholder="Masukkan NIS Siswa" min="1" onKeyPress="if(this.value.length==4) return false" onkeypress="return event.which != 8" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Nama Siswa</label>
              <input type="text" name="nama" title="Masukkan Nama Siswa" class="form-control" maxlength="30" placeholder="Masukkan Nama Siswa" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Kelas</label>
              <select class="form-select" title="Pilih Kelas Siswa" name="kelas" required>
                <option value="" hidden>-- Pilih Data Kelas --</option>
                <?php
                $query_kelas = mysqli_query($connect, "SELECT * FROM kelas ORDER BY nama_kelas ");
                while ($kelas = mysqli_fetch_array($query_kelas)) {
                ?>
                  <option value="<?= $kelas['id_kelas'] ?>"><?= $kelas['nama_kelas'] ?> - <?= $kelas['kompetensi_keahlian'] ?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Alamat</label>
              <textarea type="text" name="alamat" title="Masukkan Alamat Siswa" class="form-control" placeholder="Masukkan Alamat Siswa" maxlength="255" style="height: 100px;" required></textarea>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">No Telp</label>
              <input type="number" name="telp" title="Masukkan Nomor Telepon Siswa" class="form-control" onKeyPress="if(this.value.length==13) return false" placeholder="Masukkan Nomor Telepon Siswa" onkeypress="return event.which != 32" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Password</label>
              <input type="password" name="pw" title="Masukkan Password Siswa" class="form-control" id="pw" maxlength="32" placeholder="Masukkan Password Siswa" onkeypress="return event.which != 32" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Konfirmasi Password</label>
              <input type="password" name="kon_pw" title="Konfirmasi Password Siswa" class="form-control" id="kon_pw" maxlength="32" placeholder="Konfirmasi Password Siswa" onkeypress="return event.which != 32" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="col-12">
            <div class="text-center">
              <button type="submit" class="btn btn-success" title="Konfirmasi tambah data Siswa" name="tambah-siswa">Konfirmasi</button>
              <button type="reset" title="Reset form tambah data siswa" class="btn btn-danger"><i class="fa fa-repeat"></i></button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!--Akhir Modal Tambah-->

<script type="text/javascript" src="../assets/js/js-pages/siswa.js"></script>