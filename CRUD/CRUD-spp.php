<?php
include '../sql/connect.php';

if (isset($_POST['tambah-spp'])) {
	$tahun = $_POST['tahun'];
	$nominal = $_POST['nominal'];

	$cek_query = mysqli_query($connect, "SELECT * FROM spp WHERE tahun='$tahun' ");
	$cek = mysqli_num_rows($cek_query);

	if ($tahun == '' || $nominal == '') {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Tolong isi dengan Benar!';
		header('location: ../pages/index.php?page=spp');
	}elseif ($cek >= 1) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Data SPP dengan Tahun yang sama telah ada!';
		header('location: ../pages/index.php?page=spp');
	}else{
		$query = mysqli_query($connect, "INSERT INTO spp (tahun, nominal) VALUES ('$tahun', '$nominal') ");

		if ($query) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '1';
			$_SESSION['status'] = 'Berhasil Menambahkan Data SPP';
			header('location: ../pages/index.php?page=spp');
		}else{
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Gagal Menambahkan Data SPP';
			header('location: ../pages/index.php?page=spp');
		}
	}
}



if (isset($_POST['edit-spp'])) {
	$id = $_POST['id'];

	$tahun = $_POST['tahun'];
	$nominal = $_POST['nominal'];

	$cek_query = mysqli_query($connect, "SELECT * FROM spp WHERE tahun='$tahun' AND id_spp!='$id' ");
	$cek = mysqli_num_rows($cek_query);

	if ($tahun == '' || $nominal == '') {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Tolong isi dengan Benar!';
		header('location: ../pages/index.php?page=spp');
	}elseif ($cek >= 1) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Data SPP dengan Tahun yang sama telah ada!';
		header('location: ../pages/index.php?page=spp');
	}else{
		$query = mysqli_query($connect, "UPDATE spp SET tahun='$tahun', nominal='$nominal' WHERE id_spp='$id' ");

		if ($query) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '1';
			$_SESSION['status'] = 'Berhasil Mengubah Data SPP';
			header('location: ../pages/index.php?page=spp');
		}else{
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Gagal Mengubah Data SPP';
			header('location: ../pages/index.php?page=spp');
		}
	}
}



if (isset($_POST['hapus-spp'])) {
	$id = $_POST['id'];

	$query = mysqli_query($connect, "DELETE FROM spp WHERE id_spp='$id' ");

	if ($query) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '1';
		$_SESSION['status'] = 'Berhasil Menghapus Data SPP';
		header('location: ../pages/index.php?page=spp');
	}else{
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Gagal Menghapus Data SPP';
		header('location: ../pages/index.php?page=spp');
	}
}
?>