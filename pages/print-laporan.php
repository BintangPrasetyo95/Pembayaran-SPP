<?php  
include '../sql/connect.php';

if (!empty($_SESSION['user']['nisn'])) {
    $_SESSION['sweetalert'] = '1';
    $_SESSION['alert'] = '0';
    $_SESSION['status'] = 'Anda Tidak memiliki Hak untuk Akses Print Kwitansi!';
    echo '<script>location.reload(); history.back();</script>';
}


if (isset($_GET['cari'])) {
    $cari = $_GET['cari'];
    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn LIKE '%" . $cari . "%' OR nis LIKE '%" . $cari . "%' OR nama LIKE '%" . $cari . "%' OR nama_kelas LIKE '%" . $cari . "%' OR kompetensi_keahlian LIKE '%" . $cari . "%' OR alamat LIKE '%" . $cari . "%' OR no_telp LIKE '%" . $cari . "%' OR nama_petugas LIKE '%" . $cari . "%' OR username LIKE '%" . $cari . "%' OR level LIKE '%" . $cari . "%' OR tahun LIKE '%" . $cari . "%' OR nominal LIKE '%" . $cari . "%' OR tgl_bayar LIKE '%" . $cari . "%' OR bulan_bayar LIKE '%" . $cari . "%' OR tahun_dibayar LIKE '%" . $cari . "%' OR jumlah_bayar LIKE '%" . $cari . "%' ORDER BY id_pembayaran DESC ");

} elseif (isset($_GET['button']) && $_GET['button'] == 'kiri') {
    if (!empty($_GET['kiri-kelas']) && empty($_GET['kiri-spp'])) {
    $filter_kelas = $_GET['kiri-kelas'];
    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE kelas.id_kelas='$filter_kelas' ORDER BY id_pembayaran DESC ");

    }elseif (empty($_GET['kiri-kelas']) && !empty($_GET['kiri-spp'])) {
    $filter_spp = $_GET['kiri-spp'];
    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE spp.id_spp='$filter_spp' ORDER BY id_pembayaran DESC ");

    }elseif (!empty($_GET['kiri-kelas']) && !empty($_GET['kiri-spp'])) {
    $filter_kelas = $_GET['kiri-kelas'];
    $filter_spp = $_GET['kiri-spp'];
    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE kelas.id_kelas='$filter_kelas' AND spp.id_spp='$filter_spp' ORDER BY id_pembayaran DESC ");

    }else {
    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp ORDER BY id_pembayaran DESC ");

    }
}elseif (isset($_GET['button']) && $_GET['button'] == 'kanan') {
    if (!empty($_GET['kanan-tawal']) && empty($_GET['kanan-siswa'])) {
    $tanggal_awal = $_GET['kanan-tawal'];
    $tanggal_akhir = $_GET['kanan-takhir'];
    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE tgl_bayar BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY id_pembayaran DESC ");
    
    if (empty($tanggal_akhir)) {
        $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE tgl_bayar>='$tanggal_awal' ORDER BY id_pembayaran DESC ");
    }

    }elseif (empty($_GET['kanan-tawal']) && !empty($_GET['kanan-siswa'])) {
    $filter_siswa = $_GET['kanan-siswa'];
    $query = mysqli_query($connect, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE siswa.nisn='$filter_siswa' ORDER BY id_pembayaran DESC ");

    }elseif (!empty($_GET['kanan-tawal']) && !empty($_GET['kanan-siswa'])) {
    $tanggal_awal = $_GET['kanan-tawal'];
    $tanggal_akhir = $_GET['kanan-takhir'];
    $filter_siswa = $_GET['kanan-siswa'];
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
?>

<!DOCTYPE html>
<html lang="en">
<script>
    window.print();
</script>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Pembayaran SPP | Print Laporan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        @media print {
            @page {
                size: A3;
            }
        }

        ul {
            padding: 0;
            margin: 0 0 1rem 0;
            list-style: none;
        }

        body {
            font-family: "Inter", sans-serif;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        table th,
        table td {
            border: 1px solid silver;
        }

        th{
            text-align: center;
        }

        table .a,
        table th .a,
        table td .a {
            border: 0px;
            text-align: left;
        }

        table th,
        table td {
            text-align: right;
            padding: 8px;
        }

        h1,
        h4,
        p {
            margin: 0;
        }

        .b {
            font-size: 18px;
        }

        .container {
            padding: 20px 0;
            width: 1000px;
            max-width: 90%;
            margin: 0 auto;
        }

        .inv-title {
            padding: 10px;
            border: 1px solid silver;
            text-align: center;
            margin-bottom: 30px;
        }

        .inv-logo {
            width: 150px;
            display: block;
            margin: 0 auto;
            margin-bottom: 40px;
        }

        /* header */
        .inv-header {
            display: flex;
            margin-bottom: 20px;
        }

        .inv-header> :nth-child(1) {
            flex: 2;
        }

        .inv-header> :nth-child(2) {
            flex: 1;
        }

        .inv-header h2 {
            font-size: 20px;
            margin: 0 0 0.3rem 0;
        }

        .inv-header ul li {
            font-size: 15px;
            padding: 3px 0;
        }

        /* body */
        .inv-body table th,
        .inv-body table td {
            text-align: left;
        }

        .inv-body {
            margin-bottom: 30px;
        }

        .ignore {
            all: unset;
        }

        /* footer */
        .inv-footer {
            display: flex;
            flex-direction: row;
        }

        .inv-footer> :nth-child(1) {
            flex: 2;
        }

        .inv-footer> :nth-child(2) {
            flex: 1;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="inv-title">
            <h1>
                <div style="display: flex; align-items: center; justify-content: center;">
                    <img src="../assets/img/logo-ct-dark.png" alt="main_logo" width="40px" height="40px">
                    <span style="margin-left: 10px;">Pembayaran SPP</span>
                </div>
            </h1>
        </div>
        <div class="inv-body">
            <table>
                <thead>
                    <tr>
                        <th rowspan="2" style="text-align: center;">No</th>
                        <th rowspan="2" style="text-align: center;">Tanggal Bayar</th>
                        <th rowspan="2" style="text-align: center;">NIS</th>
                        <th rowspan="2" style="text-align: center;">Nama Siswa</th>
                        <th colspan="3" style="text-align: center;">SPP Terbayar</th>
                        <th rowspan="2" style="text-align: center;">Petugas Pembayar</th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">Tahun</th>
                        <th style="text-align: center;">Nominal</th>
                        <th style="text-align: center;">Jumlah Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                    $i = 1;
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <th><?= $i ?></th>
                        <td><?= $data['tgl_bayar'] ?></td>
                        <td><?= $data['nis'] ?></td>
                        <td><?= $data['nama'] ?></td>
                        <td><?= $data['tahun'] ?></td>
                        <td>RP.<?= number_format($data['nominal'], 2, ',', '.') ?></td>
                        <td>RP.<?= number_format($data['jumlah_bayar'], 2, ',', '.') ?></td>
                        <td><?= $data['nama_petugas'] ?></td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>