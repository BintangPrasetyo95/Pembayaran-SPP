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
              Table Petugas <a title="Tambah Data Petugas" style="margin-left: 10px;" class="btn btn-sm badge badge-sm text-xxs bg-gradient-success" data-bs-toggle="modal" data-bs-target="#tambahpetugas">+ Tambah Data</a>
              <a class="btn btn-danger me-4" title="Reset Filter pada table" href="" style="float: right;">
                <i class="fa fa-repeat" aria-hidden="true"></i>
              </a>
              <button type="submit" title="Cari data apapun pada table" class="btn btn-info me-2" style="float: right;">
                <i class="fas fa-search" aria-hidden="true"></i>
              </button>
              <div class="input-group w-15 me-4 mh-50 form-inline" title="Cari data apapun pada table" style="float: right;">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="caridata" pattern="[A-Za-z0-9& .]*" oninvalid="alert('Tolong isi Tab Pencarian dengan Benar')" placeholder="Cari...">
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Petugas</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Level</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if (isset($_POST['caridata'])) {
                  $cari = $_POST['caridata'];
                  $query = mysqli_query($connect, "SELECT * FROM petugas WHERE nama_petugas LIKE '%".$cari."%' OR username LIKE '%".$cari."%' OR level LIKE '%".$cari."%' ");
                }else{
                  $query = mysqli_query($connect, "SELECT * FROM petugas ");
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
                        <div id="myAvatar" title="Lihat Foto Profile dari Petugas <?= $data['nama_petugas'] ?>">
                          <img src="../assets/img/avatars/<?= $data['foto_petugas'] ?>" class="avatar avatar-sm me-3" alt="user1" <?= ($data['foto_petugas'] == '' ? 'hidden' : '') ?> onclick="document.getElementById('fullimage<?= $data['id_petugas'] ?>').style.display = 'block' ">
                          <i class="ni ni-circle-08 me-sm-1" <?= ($data['foto_petugas'] == '' ? '' : 'hidden') ?>></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center <?= ($data['foto_petugas'] == '' ? 'ms-4' : '') ?>">
                          <h6 class="mb-0 text-sm text-dark"><?= $data['nama_petugas'] ?></h6>
                          <p class="text-xs text-dark mb-0">Username: <?= $data['username'] ?><?= ($_SESSION['user']['nama_petugas'] == $data['nama_petugas'] ? '<span class="text-info"> (Sedang Digunakan)</span>' : '' ) ?></p>
                        </div>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="badge badge-sm bg-gradient-<?= ($data['level'] == 'admin' ? 'info' : 'success' ) ?>"><?= ucwords($data['level']) ?></span>
                    </td>
                    <td class="align-middle text-center">
                      <a title="Edit data Petugas ini" data-bs-toggle="modal" data-bs-target="#editpetugas<?= $data['id_petugas'] ?>" class="btn btn-info btn-sm text-xs" data-original-title="Edit Kelas" <?= ($_SESSION['user']['id_petugas'] == $data['id_petugas'] ? 'hidden' : '' ) ?>>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
                        Edit
                      </a>
                      <a title="Hapus data Petugas ini" data-bs-toggle="modal" data-bs-target="#hapuspetugas<?= $data['id_petugas'] ?>" style="margin-left: 10px;" class="btn btn-danger btn-sm text-xs" data-original-title="Hapus Kelas" <?= ($_SESSION['user']['id_petugas'] == $data['id_petugas'] ? 'hidden' : '' ) ?>>
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Hapus
                      </a>
                      <a title="Edit Data petugas anda" data-bs-toggle="modal" data-bs-target="#editpetugas<?= $data['id_petugas'] ?>" style="margin-left: 10px;" class="btn btn-primary btn-sm text-xs" data-original-title="Hapus Kelas" <?= ($_SESSION['user']['id_petugas'] == $data['id_petugas'] ? '' : 'hidden' ) ?>>
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Edit Data anda
                      </a>
                    </td>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editpetugas<?= $data['id_petugas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Petugas</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-petugas.php">
                            <input type="hidden" name="id" value="<?= $data['id_petugas'] ?>">
                            <div class="modal-body">
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Nama Petugas</label>
                                  <input type="text" name="nama" title="Masukkan nama petugas" class="form-control" placeholder="Masukkan Nama Petugas" value="<?= $data['nama_petugas'] ?>" maxlength="35" required>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Username</label>
                                  <input type="text" name="name" title="Masukkan username petugas" class="form-control" placeholder="Masukkan Username Petugas" value="<?= $data['username'] ?>" maxlength="25" onkeypress="return event.which != 32" required>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Level</label>
                                  <select class="form-select" title="Ubah hak akses petugas" name="level" required>
                                    <option value="admin" <?= ($data['level'] == 'admin' ? 'selected' : '' ) ?>>Admin</option>
                                    <option value="petugas" <?= ($data['level'] == 'petugas' ? 'selected' : '' ) ?>>Petugas</option>
                                  </select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Password Baru</label>
                                  <input type="password" title="Perbarui password baru Petugas" name="pw" class="form-control" id="pw<?= $data['id_petugas'] ?>" maxlength="32" placeholder="Masukkan Password Siswa" onkeypress="return event.which != 32">
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Konfirmasi Password Baru</label>
                                  <input type="password" title="Konfirmasi Password Baru Petugas" name="kon_pw" class="form-control" id="kon_pw<?= $data['id_petugas'] ?>" maxlength="32" placeholder="Konfirmasi Password Siswa" onkeypress="return event.which != 32">
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Konfirmasi edit data Petugas" class="btn btn-success" name="edit-petugas<?= ($_SESSION['user']['id_petugas'] == $data['id_petugas'] ? '-sendiri' : '' ) ?>">Konfirmasi</button>
                                  <button type="reset" title="Reset Form Edit data Petugas" class="btn btn-danger"><i class="fa fa-repeat"></i></button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <script>
                      var pw<?= $data['id_petugas'] ?> = document.getElementById('pw<?= $data['id_petugas'] ?>');
                      var k_pw<?= $data['id_petugas'] ?> = document.getElementById('kon_pw<?= $data['id_petugas'] ?>');

                      function validasi() {
                        if (pw<?= $data['id_petugas'] ?>.value != k_pw<?= $data['id_petugas'] ?>.value) {
                          k_pw<?= $data['id_petugas'] ?>.setCustomValidity("Input Password Tidak Sama");
                        }else{
                          k_pw<?= $data['id_petugas'] ?>.setCustomValidity("");
                        }
                      }

                      pw<?= $data['id_petugas'] ?>.onchange = validasi;
                      k_pw<?= $data['id_petugas'] ?>.onchange = validasi;
                    </script>

                    <!--Akhir Modal Edit-->

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="hapuspetugas<?= $data['id_petugas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Petugas</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-petugas.php">
                            <input type="hidden" name="id" value="<?= $data['id_petugas'] ?>">
                            <div class="modal-body">
                              <h5 cl class="text-center">Apakah Yakin ingin Menghapus Data Siswa ini? <br>
                                <span class="text-danger"><strong><?= $data['nama_petugas'] ?></strong> - <?= $data['username'] ?> - <?= ucwords($data['level']) ?></span>
                              </h5>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Hapus data Petugas" class="btn btn-success" name="hapus-petugas">Konfirmasi</button>
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

                  <div title="Tekan pada apapun utuk Kembali" id="fullimage<?= $data['id_petugas'] ?>" class="fullimage-petugas" style="background-image: url('../assets/img/avatars/<?= $data['foto_petugas'] ?>')" onclick="this.style.display='none';"></div>

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
<div class="modal fade" id="tambahpetugas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12">
          <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
          <div class="text-center">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Petugas</h1>
          </div>
        </div>
      </div>
      <form method="post" action="../CRUD/CRUD-petugas.php">
        <div class="modal-body">
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Nama Petugas</label>
              <input type="text" title="Masukkan nama petugas" name="nama" class="form-control" placeholder="Masukkan Nama Petugas" maxlength="35" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Username</label>
              <input type="text" title="Masukkan username petugas" name="name" class="form-control" placeholder="Masukkan Username Petugas" maxlength="25" onkeypress="return event.which != 32" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Level</label>
              <select title="Masukkan tingkat petugas dengan hak akses berbeda" class="form-select" name="level" required>
                <option value="" hidden>-- Pilih Level Petugas --</option>
                <option value="admin">Admin</option>
                <option value="petugas">Petugas</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Password</label>
              <input type="password" title="Masukkan Password Petugas" name="pw" class="form-control" id="pw" maxlength="32" placeholder="Masukkan Password Petugas" onkeypress="return event.which != 32" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Konfirmasi Password</label>
              <input type="password" title="Konfirmasi Password Petugas" name="kon_pw" class="form-control" id="kon_pw" maxlength="32" placeholder="Konfirmasi Password Petugas" onkeypress="return event.which != 32" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="col-12">
            <div class="text-center">
              <button type="submit" title="Konfirmasi Tambah Data petugas" class="btn btn-success" name="tambah-petugas">Konfirmasi</button>
              <button type="reset" title="Reset Form tambah petugas" class="btn btn-danger"><i class="fa fa-repeat"></i></button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!--Akhir Modal Tambah-->

<script type="text/javascript" src="../assets/js/js-pages/pw.js"></script>