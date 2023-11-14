<?php  
include '../sql/connect.php';

if (!empty($_SESSION['user']['nisn'])) {
    $_SESSION['sweetalert'] = '1';
    $_SESSION['alert'] = '0';
    $_SESSION['status'] = 'Anda Tidak memiliki Hak untuk Akses Print Kwitansi!';
    echo '<script>location.reload(); history.back();</script>';
}
$id = $_GET['id'];

$query = mysqli_query($connect, "SELECT *,Date_Format(tgl_bayar, '%d-%M-%Y') as tanggal_byr FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE id_pembayaran='$id' ");
$data = mysqli_fetch_array($query);

$nisn = $data['nisn'];
$spp = $data['id_spp'];

$query_cek = mysqli_query($connect, "SELECT *,SUM(jumlah_bayar) as jumlah FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$nisn' AND pembayaran.id_spp='$spp' ");
$data_cek = mysqli_fetch_array($query_cek);
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
    <title>Pembayaran SPP | Kwitansi</title>
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
        
        <div class="inv-header">
            <div>
                <h2>Data Siswa</h2>
                <table class="ignore">
                    <tr>
                        <th class="a b">NISN </th>
                        <th class="a b"> : </th>
                        <td class="a b"> <?= $data['nisn'] ?></td>
                    </tr>
                    <tr>
                        <th class="a b">NIS </th>
                        <th class="a b"> : </th>
                        <td class="a b"> <?= $data['nis'] ?></td>
                    </tr>
                    <tr>
                        <th class="a b">Nama Siswa </th>
                        <th class="a b"> : </th>
                        <td class="a b"> <?= $data['nama'] ?></td>
                    </tr>
                    <tr>
                        <th class="a b">No. Telp </th>
                        <th class="a b"> : </th>
                        <td class="a b"> <?= $data['no_telp'] ?></td>
                    </tr>
                    <tr>
                        <th class="a b">Kelas </th>
                        <th class="a b"> : </th>
                        <td class="a b"> <?= $data['nama_kelas'] ?> - <?= $data['kompetensi_keahlian'] ?></td>
                    </tr>
                </table>
            </div>
            <div>
                <table class="a">
                    <tr>
                        <td class="a" style="text-align: right;">Petugas Pembayar&nbsp;&nbsp;&nbsp;:</td>
                        <th class="a" style="text-align: right;"><?= $_SESSION['user']['nama_petugas'] ?></th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="inv-body">
            <table>
                <thead>
                    <th>SPP</th>
                    <th>Tanggal Membayar</th>
                    <th>Jumlah Bayar</th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <h4>Tahun SPP : <?= $data['tahun'] ?></h4>
                            <p>Nominal SPP : RP.<?= number_format($data['nominal'], 2, ',', '.') ?></p>
                        </td>
                        <td><?= $data['tanggal_byr'] ?></td>
                        <td>RP.<?= number_format($data['jumlah_bayar'], 2, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="inv-footer">
            <div><!-- required --></div>
            <div>
                <table style="width: 400px;">
                    <tr>
                        <th>Nominal SPP</th>
                        <td>RP.<?= number_format($data['nominal'], 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Bayar</th>
                        <td>RP.<?= number_format($data['jumlah_bayar'], 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Kondisi Akhir</th>
                        <td><?php 
                            if ($data['nominal'] == $data_cek['jumlah']) {
                                echo 'Lunas';
                            }elseif ($data['nominal'] > $data_cek['jumlah']) {
                                $hasil = $data['nominal'] - $data_cek['jumlah'];
                                echo 'Kurang : RP.'.number_format($hasil, 2, ',', '.');
                            }else {
                                echo 'ERROR_INVALID';
                            }
                        ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>