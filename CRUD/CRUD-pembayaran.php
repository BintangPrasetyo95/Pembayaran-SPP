<?php
include '../sql/connect.php';

if (isset($_POST['bayar'])) {
	$petugas = $_POST['petugas'];
	$siswa = $_POST['siswa'];
	$spp = $_POST['spp'];
	$date = $_POST['date'];
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bulan'];
	$bayar = $_POST['nominal'];

	$query = mysqli_query($connect, "INSERT INTO pembayaran (id_petugas, nisn, id_spp, tgl_bayar, bulan_bayar, tahun_dibayar, jumlah_bayar) VALUES ('$petugas', '$siswa', '$spp', '$date', '$bulan', '$tahun', '$bayar') ");

	$query_cek = mysqli_query($connect, "SELECT * FROM siswa WHERE nisn='$siswa' ");
	$siswa_data = mysqli_fetch_array($query_cek);

	if ($query) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '1';
		$_SESSION['status'] = 'Berhasil Membayar SPP dengan nama<br>'.$siswa_data["nama"];
		header('location: ../pages/index.php?page=history');
	}else{
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Gagal Membayar SPP dengan nama<br>'.$siswa_data["nama"];
		header('location: ../pages/index.php?page=history');
	}
}

?>