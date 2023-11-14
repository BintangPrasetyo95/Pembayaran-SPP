<?php
if ($role != 'admin') {
  $_SESSION['sweetalert'] = '1';
  $_SESSION['alert'] = '0';
  $_SESSION['status'] = 'Anda Tidak memiliki Hak untuk mengakses Halaman ini!';
  echo '<script>location.reload(); history.back();</script>';
}

if (isset($_POST['button-kiri']) || isset($_POST['button-kanan']) || isset($_POST['caridata']) || isset($_GET['section_refresh'])) {
  echo '<script>location.href="?page=laporan#section_table";</script>';
}
?>

<!-- FILTER  -->
<div class="card shadow-lg mx-4 card-profile-bottom mt-1">
  <div class="card-body p-3">
    <div class="row gx-4">
      <span class="text-center text-dark font-weight-bolder">
        <i class="fa fa-angle-double-down text-info"></i>&nbsp;&nbsp;
        Pilih Filter untuk Table Laporan Pembayaran SPP&nbsp;&nbsp;
        <i class="fa fa-angle-double-down text-info"></i>
      </span>
    </div>
  </div>
</div>
<div class="container-fluid py-4">
  <div class="row mb-5">
    <div class="col-lg-12 mb-1">
      <div class="row">
        <div class="col-md-6 mb-lg-0 mb-4">
          <div class="card mt-2">
            <div class="card-body p-4">
              <form method="post">
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Filter Kelas</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <select class="form-select shadow-none border-0" style="font-size: 18px;" title="Cari data pembayaran pada Kelas yang terpilih" name="kelas_filter">
                        <option value="" hidden></option>
                        <?php
                        $query = mysqli_query($connect, "SELECT * FROM kelas ORDER BY nama_kelas ");
                        while ($kelas = mysqli_fetch_array($query)) {
                        ?>
                          <option value="<?= $kelas['id_kelas'] ?>" <?php if (isset($_POST['kelas_filter'])) {if($_POST['kelas_filter'] == $kelas['id_kelas']) {echo 'selected';}} ?>><?= $kelas['nama_kelas'] ?> - <?= $kelas['kompetensi_keahlian'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Filter SPP Siswa</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <select class="form-select shadow-none border-0" style="font-size: 18px;" title="Cari data pembayaran pada SPP yang terpilih" name="spp_filter">
                        <option value="" hidden></option>
                        <?php
                        $query = mysqli_query($connect, "SELECT * FROM spp ORDER BY tahun ");
                        while ($spp = mysqli_fetch_array($query)) {
                        ?>
                          <option value="<?= $spp['id_spp'] ?>" <?php if (isset($_POST['spp_filter'])) {if($_POST['spp_filter'] == $spp['id_spp']) {echo 'selected';}} ?>><?= $spp['tahun'] ?> - RP.<?= number_format($spp['nominal'], 2, ',', '.') ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <a class="btn btn-danger me-4" href="" title="Reset Filter pada Table" style="float: right;">
                  <i class="fa fa-repeat" aria-hidden="true"></i>
                </a>
                <button style="float: right;" title="Cari data pembayaran Dengan Filter Terpilih" name="button-kiri" class="btn bg-gradient-info mb-0 me-2 mb-4" href=""><i class="fa fa-search"></i>&nbsp;&nbsp;Cari Data Siswa</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-lg-0 mb-4">
          <div class="card mt-2">
            <div class="card-body p-4">
              <form method="post">
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Filter Tanggal Bayar</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <input type="date" class="form-control shadow-none border-0" value="<?php if (isset($_POST['tanggal_awal'])) {if(!empty($_POST['tanggal_awal'])) {echo $_POST['tanggal_awal'];}} ?>" name="tanggal_awal" title="Cari data pembayaran dimulai dari tanggal awal">
                    </div>
                  </div>
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">s / d</label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <input type="date" class="form-control shadow-none border-0" value="<?php if (isset($_POST['tanggal_akhir'])) {if(!empty($_POST['tanggal_akhir'])) {echo $_POST['tanggal_akhir'];}}else{echo date("Y-m-d");} ?>" title="Cari data pembayaran diakhiri dengan tanggal akhir" name="tanggal_akhir">
                    </div>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col">
                    <label class="form-label" style="font-size: 18px;">Filter Siswa <span class="text-secondary">(yang sudah membayar)</span></label>
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      <select class="form-select shadow-none border-0" style="font-size: 18px;" name="siswa_filter" title="Cari data pembayaran Pada siswa yang Terpilih">
                        <option value="" hidden></option>
                        <?php
                        $query_filter_siswa = mysqli_query($connect, "SELECT nisn FROM pembayaran ");
                        $filter_dataset_siswa = array();
                        while ($query_siswa = mysqli_fetch_array($query_filter_siswa)) {
                          $filter_dataset_siswa[] = $query_siswa['nisn'];
                        }
                        $filter_siswa = implode(",", $filter_dataset_siswa);

                        $query = mysqli_query($connect, "SELECT * FROM siswa WHERE nisn IN($filter_siswa) ORDER BY nis ");
                        while ($siswa = mysqli_fetch_array($query)) {
                        ?>
                          <option value="<?= $siswa['nisn'] ?>" <?php if (isset($_POST['siswa_filter'])) {if($_POST['siswa_filter'] == $siswa['nisn']) {echo 'selected';}} ?>><?= $siswa['nis'] ?> - <?= $siswa['nama'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <a class="btn btn-danger me-4" href="" title="Reset Filter pada Table" style="float: right;">
                  <i class="fa fa-repeat" aria-hidden="true"></i>
                </a>
                <button id="section_table" style="float: right;" name="button-kanan" title="Cari data pembayaran dengan Filter yang terpilih" class="btn bg-gradient-info mb-0 me-2 mb-4" href=""><i class="fa fa-search"></i>&nbsp;&nbsp;Cari Data Siswa</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END FILTER  -->

  <!-- MAIN TABLE  -->
  <div class="row" >
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <form method="post">
            <h6>
              Table Laporan Pembayaran
              <a class="btn btn-danger me-4" href="?page=laporan&section_refresh" title="Reset Filter pada table" style="float: right;">
                <i class="fa fa-repeat" aria-hidden="true"></i>
              </a>
              <button type="submit" class="btn btn-info me-2" title="Cari data apapun pada table ini" style="float: right;">
                <i class="fas fa-search" aria-hidden="true"></i>
              </button>
              <div class="input-group w-15 me-4 mh-50 form-inline" style="float: right;" title="Cari data apapun pada table ini">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="caridata" pattern="[A-Za-z0-9& .]*" oninvalid="alert('Tolong isi Tab Pencarian dengan Benar')" placeholder="Cari...">
              </div>
              <a href="print-laporan.php<?php  
                if (isset($_POST['caridata'])) {
                  $cari = $_POST['caridata'];
                  echo '?cari='.$cari;

                } elseif (isset($_POST['button-kiri'])) {
                  if (!empty($_POST['kelas_filter']) && empty($_POST['spp_filter'])) {
                    $filter_kelas = $_POST['kelas_filter'];
                    echo '?button=kiri&kiri-kelas='.$filter_kelas;

                  }elseif (empty($_POST['kelas_filter']) && !empty($_POST['spp_filter'])) {
                    $filter_spp = $_POST['spp_filter'];
                    echo '?button=kiri&kiri-spp='.$filter_spp;

                  }elseif (!empty($_POST['kelas_filter']) && !empty($_POST['spp_filter'])) {
                    $filter_kelas = $_POST['kelas_filter'];
                    $filter_spp = $_POST['spp_filter'];
                    echo '?button=kiri&kiri-kelas='.$filter_kelas.'&kiri-spp='.$filter_spp;
                    
                  }else {
                    echo '?filter=default';
                  }
                }elseif (isset($_POST['button-kanan'])) {
                  if (!empty($_POST['tanggal_awal']) && empty($_POST['siswa_filter'])) {
                    $tanggal_awal = $_POST['tanggal_awal'];
                    $tanggal_akhir = $_POST['tanggal_akhir'];
                    echo '?button=kanan&kanan-tawal='.$tanggal_awal.'&kanan-takhir='.$tanggal_akhir;

                  }elseif (empty($_POST['tanggal_awal']) && !empty($_POST['siswa_filter'])) {
                    $filter_siswa = $_POST['siswa_filter'];
                    echo '?button=kanan&kanan-siswa='.$filter_siswa;
                    
                  }elseif (!empty($_POST['tanggal_awal']) && !empty($_POST['siswa_filter'])) {
                    $tanggal_awal = $_POST['tanggal_awal'];
                    $tanggal_akhir = $_POST['tanggal_akhir'];
                    $filter_siswa = $_POST['siswa_filter'];
                    echo '?button=kanan&kanan-tawal='.$tanggal_awal.'&kanan-takhir='.$tanggal_akhir.'&kanan-siswa='.$filter_siswa;

                  }else {
                    echo '?filter=default';
                    
                  }
                } else {
                  echo '?filter=default';

                }
              ?>" target="_blank" class="btn btn-primary me-2" title="Print Laporan yang tersedia pada Table" style="float: right;">
                <i class="fa fa-print" aria-hidden="true"></i>&nbsp;
                Print Table
              </a>
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Siswa</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1">Tahun SPP</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Bayar</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Petugas Pembayar</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Tanggal Bayar</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($_POST['caridata'])) {
                  $cari = $_POST['caridata'];
                  $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn LIKE '%" . $cari . "%' OR nis LIKE '%" . $cari . "%' OR nama LIKE '%" . $cari . "%' OR nama_kelas LIKE '%" . $cari . "%' OR kompetensi_keahlian LIKE '%" . $cari . "%' OR alamat LIKE '%" . $cari . "%' OR no_telp LIKE '%" . $cari . "%' OR nama_petugas LIKE '%" . $cari . "%' OR username LIKE '%" . $cari . "%' OR level LIKE '%" . $cari . "%' OR tahun LIKE '%" . $cari . "%' OR nominal LIKE '%" . $cari . "%' OR tgl_bayar LIKE '%" . $cari . "%' OR bulan_bayar LIKE '%" . $cari . "%' OR tahun_dibayar LIKE '%" . $cari . "%' OR jumlah_bayar LIKE '%" . $cari . "%' ORDER BY id_pembayaran DESC ");

                } elseif (isset($_POST['button-kiri'])) {
                  if (!empty($_POST['kelas_filter']) && empty($_POST['spp_filter'])) {
                    $filter_kelas = $_POST['kelas_filter'];
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE kelas.id_kelas='$filter_kelas' ORDER BY id_pembayaran DESC ");

                  }elseif (empty($_POST['kelas_filter']) && !empty($_POST['spp_filter'])) {
                    $filter_spp = $_POST['spp_filter'];
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE spp.id_spp='$filter_spp' ORDER BY id_pembayaran DESC ");

                  }elseif (!empty($_POST['kelas_filter']) && !empty($_POST['spp_filter'])) {
                    $filter_kelas = $_POST['kelas_filter'];
                    $filter_spp = $_POST['spp_filter'];
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE kelas.id_kelas='$filter_kelas' AND spp.id_spp='$filter_spp' ORDER BY id_pembayaran DESC ");

                  }else {
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp ORDER BY id_pembayaran DESC ");

                  }
                }elseif (isset($_POST['button-kanan'])) {
                  if (!empty($_POST['tanggal_awal']) && empty($_POST['siswa_filter'])) {
                    $tanggal_awal = $_POST['tanggal_awal'];
                    $tanggal_akhir = $_POST['tanggal_akhir'];
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE tgl_bayar BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY id_pembayaran DESC ");
                    
                    if (empty($tanggal_akhir)) {
                      $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE tgl_bayar>='$tanggal_awal' ORDER BY id_pembayaran DESC ");
                    }

                  }elseif (empty($_POST['tanggal_awal']) && !empty($_POST['siswa_filter'])) {
                    $filter_siswa = $_POST['siswa_filter'];
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn='$filter_siswa' ORDER BY id_pembayaran DESC ");

                  }elseif (!empty($_POST['tanggal_awal']) && !empty($_POST['siswa_filter'])) {
                    $tanggal_awal = $_POST['tanggal_awal'];
                    $tanggal_akhir = $_POST['tanggal_akhir'];
                    $filter_siswa = $_POST['siswa_filter'];
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn='$filter_siswa' AND tgl_bayar BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY id_pembayaran DESC ");

                    if (empty($tanggal_akhir)) {
                      $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn='$filter_siswa' AND tgl_bayar>='$tanggal_awal' ORDER BY id_pembayaran DESC ");
                    }

                  }else {
                    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp ORDER BY id_pembayaran DESC ");

                  }
                } else {
                  $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp ORDER BY id_pembayaran DESC ");

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
                      <p class="font-weight-bold mb-0"><?= $data['nis'] ?></p>
                    </td>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div id="myAvatar" title="Lihat Foto Profile dari Siswa <?= $data['nama'] ?>">
                          <img src="../assets/img/avatars/<?= $data['foto'] ?>" class="avatar avatar-sm me-3" alt="user1" <?= ($data['foto'] == '' ? 'hidden' : '') ?> onclick="document.getElementById('fullimage<?= $data['id_pembayaran'] . $data['nisn'] ?>').style.display = 'block' ">
                          <i class="fa fa-user me-sm-1" <?= ($data['foto'] == '' ? '' : 'hidden') ?>></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center <?= ($data['foto'] == '' ? 'ms-4' : '') ?>">
                          <h6 class="text-sm mb-0"><strong><?= $data['nama'] ?></strong></h6>
                          <span title="Cek detail pada siswa ini" data-bs-toggle="modal" data-bs-target="#detail-siswa<?= $data['id_pembayaran'] ?>" class="btn btn-sm badge badge-sm text-xxs btn-secondary ms-2" style="width: 75px;">Details</span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold text-dark ps-1 mb-0"><?= $data['tahun'] ?></p>
                      <p class="text-xs text-secondary mb-0">RP.<?= number_format($data['nominal'], 2, ',', '.') ?></p>
                    </td>
                    <td>
                      <p class="font-weight-bold mb-0"><strong>RP.<?= number_format($data['jumlah_bayar'], 2, ',', '.') ?></strong></p>
                    </td>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div id="myAvatar" title="Lihat Foto Profile dari Siswa <?= $data['nama_petugas'] ?>">
                          <img src="../assets/img/avatars/<?= $data['foto_petugas'] ?>" class="avatar avatar-sm me-3" alt="user1" <?= ($data['foto_petugas'] == '' ? 'hidden' : '') ?> onclick="document.getElementById('fullimage<?= $data['id_pembayaran'] . $data['id_petugas'] ?>').style.display = 'block' ">
                          <i class="ni ni-circle-08 me-sm-1" <?= ($data['foto_petugas'] == '' ? '' : 'hidden') ?>></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center <?= ($data['foto_petugas'] == '' ? 'ms-4' : '') ?>">
                          <h6 class="mb-0 text-sm text-success"><?= $data['nama_petugas'] ?></h6>
                          <span title="Cek detail pada petugas ini" data-bs-toggle="modal" data-bs-target="#detail-petugas<?= $data['id_pembayaran'] ?>" class="btn btn-sm badge badge-sm text-xxs btn-success ms-2" style="width: 75px;">Details</span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-secondary"><?= $data['tgl_bayar'] ?></h6>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle text-center">
                      <a title="Print Kwitansi pada data ini" class="btn btn-info btn-sm text-xs" target="_blank"href="print.php?id=<?= $data['id_pembayaran'] ?>">
                        <i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;
                        Kwitansi
                      </a>
                      <a title="Pilih opsi yang akan dioperasikan pada data ini" data-bs-toggle="modal" data-bs-target="#opsibayar<?= $data['id_pembayaran'] ?>" style="margin-left: 10px;" class="btn btn-danger btn-sm text-xs" data-original-title="Hapus SPP">
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

                    <!-- Modal detail petugas -->
                    <div class="modal fade" id="detail-petugas<?= $data['id_pembayaran'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="col-12">
                              <big><a title="Kembali" href="" data-bs-dismiss="modal"><i class="fa fa-arrow-left" style="float: left; color: black; margin-top: 5px;"></i></a></big>
                              <div class="text-center">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Data Petugas</h1>
                              </div>
                            </div>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">Nama Petugas</label>
                                <input type="text" class="form-control" value="<?= $data['nama_petugas'] ?>" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">Username</label>
                                <input type="text" class="form-control" value="<?= $data['username'] ?>" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold mb-0">Level</label>
                                <input type="text" class="form-control" value="<?= ucwords($data['level']) ?>" disabled>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Akhir Modal detail petugas-->

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
                                    <input type="number" name="nominal" id="numericInput" title="Edit Data Nominal yang telah dibayar" class="form-control" onKeyPress="if(this.value.length==9) return false" value="<?= $data['jumlah_bayar'] ?>" placeholder="Masukkan Nominal Membayar SPP" min="1" required>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <div class="col-12">
                                <div class="text-center">
                                  <button type="submit" title="Konfirmasi edit pada data ini" class="btn btn-success" name="edit-bayar">Konfirmasi</button>
                                  <button type="reset" title="Reset form edit data pembayaran" class="btn btn-danger"><i class="fa fa-repeat"></i></button>
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
                                <a data-bs-toggle="modal" title="Hapus data pembayaran" data-bs-target="#opsihapuskonf<?= $data['id_pembayaran'] ?>" class="btn btn-danger" name="hapus-bayar">Hapus</a>
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
                                  <button type="submit" title="Konfirmasi Hapus data pembayaran" class="btn btn-danger" name="hapus-bayar">Konfirmasi</button>
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
  <!-- END MAIN TABLE  -->