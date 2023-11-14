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
              Table SPP <a title="Tambah Data pada Table SPP" style="margin-left: 10px;" class="btn btn-sm badge badge-sm text-xxs bg-gradient-success" data-bs-toggle="modal" data-bs-target="#tambahspp">+ Tambah Data</a>
                <a class="btn btn-danger me-4" href="" title="Reset Filter pada Table" style="float: right;">
                  <i class="fa fa-repeat" aria-hidden="true"></i>
                </a>
                <button type="submit" title="Cari Nominal atau Tahun pada Table SPP" class="btn btn-info me-2" style="float: right;">
                  <i class="fas fa-search" aria-hidden="true"></i>
                </button>
                <div class="input-group w-15 me-4 mh-50 form-inline" style="float: right;">
                  <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" title="Cari Nominal atau Tahun pada Table SPP" name="caridata" pattern="[A-Za-z0-9& .]*" oninvalid="alert('Tolong isi Tab Pencarian dengan Benar')" placeholder="Cari...">
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Tahun</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nominal</th>
                  <th class="text-secondary opacity-7"></th>
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
                      <a title="Edit Data SPP" data-bs-toggle="modal" data-bs-target="#editspp<?= $data['id_spp'] ?>" class="btn btn-info btn-sm text-xs" data-original-title="Edit SPP">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 
                        Edit
                      </a>
                      <a title="Hapus Data SPP Beserta Pembayaran di dalamnya" data-bs-toggle="modal" data-bs-target="#hapusspp<?= $data['id_spp'] ?>" style="margin-left: 10px;" class="btn btn-danger btn-sm text-xs" data-original-title="Hapus SPP">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                        Hapus
                      </a>
                    </td>

                    <!-- Modal ubah -->
                    <div class="modal fade" id="editspp<?= $data['id_spp'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit SPP</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-spp.php">
                            <input type="hidden" name="id" value="<?= $data['id_spp'] ?>">
                            <div class="modal-body">
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Tahun</label>
                                  <input type="number" name="tahun" min="1" title="Masukkan Input Tahun" onKeyPress="if(this.value.length==4) return false" class="form-control" maxlength="4" value="<?= $data['tahun'] ?>" placeholder="Masukkan Tahun Pembayaran SPP" required>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Nominal</label>
                                  <div class="input-group me-4 mh-50 form-inline">
                                    <span class="input-group-text text-body">RP.</span>
                                    <input type="number" name="nominal" id="numericInput" title="Masukkan Input Nominal" class="form-control" onKeyPress="if(this.value.length==9) return false" value="<?= $data['nominal'] ?>" placeholder="Masukkan Nominal Membayar SPP" required>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Konfirmasi Edit data SPP" class="btn btn-success" name="edit-spp">Konfirmasi</button>
                                  <button type="reset" title="Reset Form Edit SPP" class="btn btn-danger"><i class="fa fa-repeat"></i></button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal ubah-->

                    <!-- Modal hapus -->
                    <div class="modal fade" id="hapusspp<?= $data['id_spp'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus SPP</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-spp.php">
                            <input type="hidden" name="id" value="<?= $data['id_spp'] ?>">
                            <div class="modal-body">
                              <h5 cl class="text-center">Apakah Yakin ingin Menghapus Data SPP ini beserta data-data Pembayaran yang Terkait? <br>
                                <span class="text-danger"><strong><?= $data['tahun'] ?></strong> - RP.<?= number_format($data['nominal'] , 2, ',', '.') ?> </span>
                              </h5>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Konfirmasi Hapus data pada table SPP" class="btn btn-danger" name="hapus-spp">Konfirmasi</button>
                                  <a data-bs-dismiss="modal" title="Kembali" class="btn btn-secondary">Kembali</i></a>
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
<div class="modal fade" id="tambahspp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12">
          <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
          <div class="text-center">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah SPP</h1>
          </div>
        </div>
      </div>
      <form method="post" action="../CRUD/CRUD-spp.php">
        <div class="modal-body">
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Tahun</label>
              <input type="number" title="Masukkan Input Tahun" name="tahun" min="1" onKeyPress="if(this.value.length==4) return false" class="form-control" placeholder="Masukkan Tahun Pembayaran SPP" maxlength="4" onkeypress="return event.which != 32" required>
            </div>
          </div>
          <div class="row">
            <div class="mb-3">
              <label class="form-label text-xs font-weight-bold mb-0">Nominal</label>
              <div class="input-group me-4 mh-50 form-inline" title="Masukkan Input Nominal">
                <span class="input-group-text text-body">RP.</span>
                <input type="number" name="nominal" class="form-control" onKeyPress="if(this.value.length==9) return false" placeholder="Masukkan Nominal Membayar SPP" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="col-12">
            <div class="text-center">
              <button type="submit" class="btn btn-success" title="Konfirmasi Tambah data SPP" name="tambah-spp">Konfirmasi</button>
              <button type="reset" title="Reset Form tambah SPP" class="btn btn-danger"><i class="fa fa-repeat"></i></button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!--Akhir Modal Tambah-->