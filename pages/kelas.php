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
            Table Kelas
            <a title="Tambah data Kelas" style="margin-left: 10px;" class="btn btn-sm badge badge-sm text-xxs bg-gradient-success" data-bs-toggle="modal" data-bs-target="#tambahkelas">+ Tambah Data</a>
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Kelas</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kompetensi Keahlian</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                <?php  
                $i = 1;

                if (isset($_POST['caridata'])) {
                  $cari = $_POST['caridata'];
                  $query = mysqli_query($connect, "SELECT * FROM kelas WHERE nama_kelas LIKE '%".$cari."%' OR kompetensi_keahlian LIKE '%".$cari."%' ORDER BY nama_kelas ");
                }else{
                  $query = mysqli_query($connect, "SELECT * FROM kelas ORDER BY nama_kelas ");
                }

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
                          <h6 class="mb-0 text-sm"><?= $data['nama_kelas'] ?></h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0"><?= $data['kompetensi_keahlian'] ?></p>
                    </td>
                    <td class="align-middle text-center">
                      <a title="Edit data Kelas" data-bs-toggle="modal" data-bs-target="#editkelas<?= $data['id_kelas'] ?>" class="btn btn-info btn-sm text-xs" data-original-title="Edit Kelas">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
                        Edit
                      </a>
                      <a title="Hapus Data Kelas" data-bs-toggle="modal" data-bs-target="#hapuskelas<?= $data['id_kelas'] ?>" style="margin-left: 10px;" class="btn btn-danger btn-sm text-xs" data-original-title="Hapus Kelas">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Hapus
                      </a>
                    </td>

                    <!-- Modal ubah -->
                    <div class="modal fade" id="editkelas<?= $data['id_kelas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Kelas</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-kelas.php">
                            <input type="hidden" name="id" value="<?= $data['id_kelas'] ?>">
                            <div class="modal-body">
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Nama Kelas</label>
                                  <select name="nama_kelas" title="Ubah Tingkat kelas" class="form-select" required>
                                    <option value="X" <?= ($data['nama_kelas'] == 'X' ? 'selected' : '' ) ?>>X</option>
                                    <option value="XI" <?= ($data['nama_kelas'] == 'XI' ? 'selected' : '' ) ?>>XI</option>
                                    <option value="XII" <?= ($data['nama_kelas'] == 'XII' ? 'selected' : '' ) ?>>XII</option>
                                  </select>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Kompetensi Keahlian</label>
                                  <input type="text" name="komp_ahli" title="Ubah Kompetesi Keahlian pada Kelas" class="form-control" maxlength="50" value="<?= $data['kompetensi_keahlian'] ?>" placeholder="Masukkan Kompetensi Keahlian">
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Konfirmasi Ubah data Kelas" class="btn btn-success" name="edit-kelas">Konfirmasi</button>
                                  <button type="reset" title="Reset Form ubah data Kelas" class="btn btn-danger"><i class="fa fa-repeat"></i></button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal ubah-->

                    <!-- Modal hapus -->
                    <div class="modal fade" id="hapuskelas<?= $data['id_kelas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Kelas</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-kelas.php">
                            <input type="hidden" name="id" value="<?= $data['id_kelas'] ?>">
                            <div class="modal-body">
                              <h5 cl class="text-center">Apakah Yakin ingin Menghapus Data Kelas ini beserta Data Siswa didalamnya? <br>
                                <span class="text-danger"><strong><?= $data['nama_kelas'] ?></strong> - <?= $data['kompetensi_keahlian'] ?> </span>
                              </h5>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Hapus data Kelas" class="btn btn-success" name="hapus-kelas">Konfirmasi</button>
                                  <a data-bs-dismiss="modal" title="Kembali" class="btn btn-secondary">Kembali</a>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal hapus-->

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
  </div>
</div>

<!-- Modal tambah -->
<div class="modal fade" id="tambahkelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12">
          <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
          <div class="text-center">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kelas</h1>
          </div>
        </div>
      </div>
      <form method="post" action="../CRUD/CRUD-kelas.php">
        <div class="modal-body">
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Nama Kelas</label>
              <select name="nama_kelas" title="Pilih tingkat pada Kelas" class="form-select" required>
                <option value="" hidden>-- Pilih Tingkat Kelas --</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Kompetensi Keahlian</label>
              <input type="text" title="Masukkan Kompetensi Keahlian Pada Kelas" name="komp_ahli" class="form-control" maxlength="50" placeholder="Masukkan Kompetensi Keahlian" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="col-12">
            <div class="text-center">
              <button type="submit" title="Konfirmasi Tambah data Kelas" class="btn btn-success" name="tambah-kelas">Konfirmasi</button>
              <button type="reset" title="Reset Form Tambah data Kelas" class="btn btn-danger"><i class="fa fa-repeat"></i></button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!--Akhir Modal Tambah-->

