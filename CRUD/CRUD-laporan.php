<?php
include '../sql/connect.php';

if (isset($_POST['edit-bayar'])) {
	$id = $_POST['id'];

	$nominal = $_POST['nominal'];

	$query = mysqli_query($connect, "UPDATE pembayaran SET jumlah_bayar='$nominal' WHERE id_pembayaran='$id' ");

    if ($query) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '1';
		$_SESSION['status'] = 'Berhasil Mengedit Data Pembayaran';
		header('location: ../pages/index.php?page=laporan');
	}else{
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Gagal Mengedit Data Pembayaran';
		header('location: ../pages/index.php?page=laporan');
	}
}



if (isset($_POST['hapus-bayar'])) {
	$id = $_POST['id'];

	$query = mysqli_query($connect, "DELETE FROM pembayaran WHERE id_pembayaran='$id' ");

	if ($query) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '1';
		$_SESSION['status'] = 'Berhasil Menghapus Data Pembayaran';
		header('location: ../pages/index.php?page=laporan');
	}else{
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Gagal Menghapus Data Pembayaran';
		header('location: ../pages/index.php?page=laporan');
	}
}
?>