<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <form method="post">
            <h6>
              Table History Pembayaran Anda
              <a class="btn btn-danger me-4" href="" title="Reset Filter Table" style="float: right;">
                <i class="fa fa-repeat" aria-hidden="true"></i>
              </a>
              <button type="submit" class="btn btn-info me-2" title="Cari Data apapun dari Table ini" style="float: right;">
                <i class="fas fa-search" aria-hidden="true"></i>
              </button>
              <div class="input-group w-15 me-4 mh-50 form-inline" style="float: right;" title="Cari Data apapun dari Table ini">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="caridata" pattern="[A-Za-z0-9& .]*" oninvalid="alert('Tolong isi Tab Pencarian dengan Benar')" placeholder="Cari..." value="<?= (isset($_POST['caridata']) ? $_POST['caridata'] : '') ?>">
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3" <?= ($role == 'siswa' ? 'hidden' : '') ?>>NIS</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" <?= ($role == 'siswa' ? 'hidden' : '') ?>>Nama Siswa</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" <?= ($role != 'siswa' ? 'hidden' : '') ?>>Petugas Pembayar</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1">Tahun SPP</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Bayar</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Tanggal Bayar</th>
                  <th class="text-secondary opacity-7" <?= ($role == 'siswa' ? 'hidden' : '') ?>></th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($role == 'siswa') {
                  $id_user = $_SESSION['user']['nisn'];

                  if (isset($_POST['caridata'])) {
                    $cari = $_POST['caridata'];
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn = '$id_user' AND nama_petugas LIKE '%" . $cari . "%' OR tahun LIKE '%" . $cari . "%' OR nominal LIKE '%" . $cari . "%' OR tgl_bayar LIKE '%" . $cari . "%' OR bulan_bayar LIKE '%" . $cari . "%' OR tahun_dibayar LIKE '%" . $cari . "%' OR jumlah_bayar LIKE '%" . $cari . "%' ORDER BY id_pembayaran DESC ");
                  } else {
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn = '$id_user' ORDER BY id_pembayaran DESC ");
                  }
                } else {
                  $id_user = $_SESSION['user']['id_petugas'];

                  if (isset($_POST['caridata'])) {
                    $cari = $_POST['caridata'];
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE petugas.id_petugas = '$id_user' AND siswa.nisn LIKE '%" . $cari . "%' OR nis LIKE '%" . $cari . "%' OR nama LIKE '%" . $cari . "%' OR nama_kelas LIKE '%" . $cari . "%' OR kompetensi_keahlian LIKE '%" . $cari . "%' OR alamat LIKE '%" . $cari . "%' OR no_telp LIKE '%" . $cari . "%' OR tahun LIKE '%" . $cari . "%' OR nominal LIKE '%" . $cari . "%' OR tgl_bayar LIKE '%" . $cari . "%' OR bulan_bayar LIKE '%" . $cari . "%' OR tahun_dibayar LIKE '%" . $cari . "%' OR jumlah_bayar LIKE '%" . $cari . "%' ORDER BY id_pembayaran DESC ");
                  } else {
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE petugas.id_petugas = '$id_user' ORDER BY id_pembayaran DESC ");
                  }
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
                    <td <?= ($role == 'siswa' ? 'hidden' : '') ?>>
                      <p class="font-weight-bold mb-0"><?= $data['nis'] ?></p>
                    </td>
                    <td <?= ($role == 'siswa' ? 'hidden' : '') ?>>
                      <div class="d-flex px-2 py-1">
                        <div id="myAvatar" title="Lihat Foto Profile dari Siswa <?= $data['nama'] ?>">
                          <img src="../assets/img/avatars/<?= $data['foto'] ?>" class="avatar avatar-sm me-3" alt="user1" <?= ($data['foto'] == '' ? 'hidden' : '') ?> onclick="document.getElementById('fullimage<?= $data['id_pembayaran'] . $data['nisn'] ?>').style.display = 'block' ">
                          <i class="fa fa-user me-sm-1" <?= ($data['foto'] == '' ? '' : 'hidden') ?>></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center <?= ($data['foto'] == '' ? 'ms-4' : '') ?>">
                          <h6 class="text-sm mb-0"><strong><?= $data['nama'] ?></strong></h6>
                          <span title="Cek Detail dari Siswa ini" data-bs-toggle="modal" data-bs-target="#detail-siswa<?= $data['id_pembayaran'] ?>" class="btn btn-sm badge badge-sm text-xxs btn-secondary ms-2" style="width: 75px;">Details</span>
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
                          <h6 class="mb-0 text-sm text-dark"><?= $data['nama_petugas'] ?></h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bolder text-dark ps-1 mb-0"><?= $data['tahun'] ?></p>
                      <p class="text-xs text-secondary mb-0">RP.<?= number_format($data['nominal'], 2, ',', '.') ?></p>
                    </td>
                    <td>
                      <p class="font-weight-bold mb-0"><strong>RP.<?= number_format($data['jumlah_bayar'], 2, ',', '.') ?></strong></p>
                    </td>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-secondary"><?= $data['tgl_bayar'] ?></h6>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle text-center" <?= ($role == 'siswa' ? 'hidden' : '') ?>>
                      <a class="btn btn-info btn-sm text-xs" title="Print Kwitansi pada data ini" target="_blank" href="print.php?id=<?= $data['id_pembayaran'] ?>">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;
                        Kwitansi
                      </a>
                      <a data-bs-toggle="modal" title="Pilih Opsi yang akan dioperasikan pada data ini" data-bs-target="#opsibayar<?= $data['id_pembayaran'] ?>" style="margin-left: 10px;" class="btn btn-danger btn-sm text-xs" data-original-title="Hapus SPP" <?= ($role != 'admin' ? 'hidden' : '') ?>>
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        Opsi
                      </a>
                    </td>

                    <!-- Modal detail siswa -->
                    <div class="modal fade" id="detail-siswa<?= $data['id_pembayaran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                <input type="text" class="form-control" value="<?= $data['nisn'] ?>" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">NIS</label>
                                <input type="text" class="form-control" value="<?= $data['nis'] ?>" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">Nama Siswa</label>
                                <input type="text" class="form-control" value="<?= $data['nama'] ?>" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">Kelas</label>
                                <input type="text" class="form-control" value="<?= $data['nama_kelas'] ?> - <?= $data['kompetensi_keahlian'] ?>" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">No.Telp</label>
                                <input type="text" class="form-control" value="<?= $data['no_telp'] ?>" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">Alamat</label>
                                <textarea type="text" name="alamat" class="form-control" placeholder="Masukkan Alamat Siswa" style="height: 100px;" disabled><?= $data['alamat'] ?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal detail siswa -->

                    <!-- Modal opsi -->
                    <div class="modal fade" id="opsibayar<?= $data['id_pembayaran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Opsi Pembayaran</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-spp.php">
                            <input type="hidden" name="id" value="<?= $data['id_spp'] ?>">
                            <div class="modal-body">
                              <h5 cl class="text-center">Pilih Opsi pada Data ini <br>
                                <span class="text-danger"><strong><?= $data['nama'] ?></strong><br> Telah Membayar: <?= $data['tahun'] ?> - RP.<?= number_format($data['jumlah_bayar'], 2, ',', '.') ?> </span>
                              </h5>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <a data-bs-toggle="modal" title="Edit Data Pembayaran ini" data-bs-target="#opsiedit<?= $data['id_pembayaran'] ?>" class="btn btn-success" name="edit-bayar"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                  <a data-bs-toggle="modal" title="Hapus Data Pembayaran ini" data-bs-target="#opsihapus<?= $data['id_pembayaran'] ?>" class="btn btn-danger" name="hapus-bayar"><i class="fa fa-trash"></i> Hapus</a>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal opsi-->

                    <!-- Modal Edit -->
                    <div class="modal fade" id="opsiedit<?= $data['id_pembayaran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Pembayaran</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-laporan.php">
                            <input type="hidden" name="id" value="<?= $data['id_pembayaran'] ?>">
                            <div class="modal-body">
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Nama Siswa</label>
                                  <input type="text" class="form-control" value="<?= $data['nama'] ?>" disabled>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Petugas Pembayar</label>
                                  <input type="text" class="form-control" value="<?= $data['nama_petugas'] ?>" disabled>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Tanggal Pembayaran</label>
                                  <input type="date" class="form-control" value="<?= $data['tgl_bayar'] ?>" disabled>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Data SPP</label>
                                  <input type="text" class="form-control" value="<?= $data['tahun'] ?> - RP.<?= number_format($data['nominal'], 2, ',', '.') ?>" disabled>
                                </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                  <label class="form-label text-xs font-weight-bold mb-0">Data SPP</label>
                                  <div class="input-group me-4 mh-50 form-inline">
                                    <span class="input-group-text text-body">RP.</span>
                                    <input type="number" name="nominal" title="Edit Data Nominal yang telah dibayar" id="numericInput" class="form-control" onKeyPress="if(this.value.length==9) return false" value="<?= $data['jumlah_bayar'] ?>" placeholder="Masukkan Nominal Membayar SPP" min="1" required>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Konfirmasi Edit pada Data ini" class="btn btn-success" name="edit-bayar">Konfirmasi</button>
                                  <button type="reset" title="Reset Form Edit Data Pembayaran" class="btn btn-danger"><i class="fa fa-repeat"></i></button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <!--Akhir Modal Edit-->

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="opsihapus<?= $data['id_pembayaran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Data Pembayaran</h1>
                              </div>
                            </div>
                          </div>
                          <div class="modal-body">
                            <h5 cl class="text-center">Apakah Yakin ingin Menghapus Data Pembayaran ini? <br>
                              <span class="text-danger"><strong><?= $data['nama'] ?></strong><br> Telah Membayar: <?= $data['tahun'] ?> - RP.<?= number_format($data['jumlah_bayar'], 2, ',', '.') ?> </span>
                            </h5>
                          </div>
                          <div class="modal-footer">
                            <div class="col-12">
                              <div class="text-center">
                                <a data-bs-toggle="modal" title="Hapus Data Pembayaran" data-bs-target="#opsihapuskonf<?= $data['id_pembayaran'] ?>" class="btn btn-danger" name="hapus-bayar">Hapus</a>
                                <a data-bs-dismiss="modal" title="Kembali" class="btn btn-secondary">Kembali</i></a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal Hapus-->

                    <!-- Modal Hapus Konfirmasi -->
                    <div class="modal fade" id="opsihapuskonf<?= $data['id_pembayaran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Data Pembayaran</h1>
                              </div>
                            </div>
                          </div>
                          <form method="post" action="../CRUD/CRUD-laporan.php">
                            <input type="hidden" name="id" value="<?= $data['id_pembayaran'] ?>">
                            <div class="modal-body">
                              <h5 cl class="text-center">Apakah Anda Yakin? <br>
                                <span class="text-danger"><strong><?= $data['nama'] ?></strong><br> Telah Membayar: <?= $data['tahun'] ?> - RP.<?= number_format($data['jumlah_bayar'], 2, ',', '.') ?> </span>
                              </h5>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Konfirmasi Hapus data Pembayaran" class="btn btn-danger" name="hapus-bayar">Konfirmasi</button>
                                  <a data-bs-dismiss="modal" title="Kembali" class="btn btn-secondary">Kembali</i></a>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal Hapus Konfirmasi-->

                  </tr>

                  <div title="Tekan pada apapun untuk Kembali" id="fullimage<?= $data['id_pembayaran'] . $data['nisn'] ?>" class="fullimage-siswa" style="background-image: url('../assets/img/avatars/<?= $data['foto'] ?>')" onclick="this.style.display='none';"></div>
                  <div title="Tekan pada apapun untuk Kembali" id="fullimage<?= $data['id_pembayaran'] . $data['id_petugas'] ?>" class="fullimage-petugas" style="background-image: url('../assets/img/avatars/<?= $data['foto_petugas'] ?>')" onclick="this.style.display='none';"></div>

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