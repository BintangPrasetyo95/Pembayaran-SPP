<?php
include '../sql/connect.php';

if (isset($_POST['tambah-kelas'])) {
	$nama = trim($_POST['nama_kelas']);
	$ahli = trim($_POST['komp_ahli']);

	$cek_query = mysqli_query($connect, "SELECT * FROM kelas WHERE nama_kelas='$nama' AND kompetensi_keahlian='$ahli' ");
	$cek = mysqli_num_rows($cek_query);

	if ($nama == '' || $ahli == '') {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Tolong isi dengan Benar!';
		header('location: ../pages/index.php?page=kelas');
	}elseif ($cek >= 1) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Data Kelas dengan Data yang sama telah ada!';
		header('location: ../pages/index.php?page=kelas');
	} else{
		$query = mysqli_query($connect, "INSERT INTO kelas (nama_kelas, kompetensi_keahlian) VALUES ('$nama', '$ahli') ");

		if ($query) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '1';
			$_SESSION['status'] = 'Berhasil Menambahkan Data Kelas';
			header('location: ../pages/index.php?page=kelas');
		}else{
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Gagal Menambahkan Data Kelas';
			header('location: ../pages/index.php?page=kelas');
		}
	}
}




if (isset($_POST['edit-kelas'])) {
	$id = $_POST['id'];

	$nama = trim($_POST['nama_kelas']);
	$ahli = trim($_POST['komp_ahli']);

	$cek_query = mysqli_query($connect, "SELECT * FROM kelas WHERE nama_kelas='$nama' AND kompetensi_keahlian='$ahli' ");
	$cek = mysqli_num_rows($cek_query);

	if ($nama == '' || $ahli == '') {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Tolong isi dengan Benar!';
		header('location: ../pages/index.php?page=kelas');
	}elseif ($cek >= 1) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Data Kelas dengan Data yang sama telah ada!';
		header('location: ../pages/index.php?page=kelas');
	}else{
		$query = mysqli_query($connect, "UPDATE kelas SET nama_kelas='$nama', kompetensi_keahlian='$ahli' WHERE id_kelas='$id' ");

		if ($query) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '1';
			$_SESSION['status'] = 'Berhasil Mengubah Data Kelas';
			header('location: ../pages/index.php?page=kelas');
		}else{
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Gagal Mengubah Data Kelas';
			header('location: ../pages/index.php?page=kelas');
		}
	}
}



if (isset($_POST['hapus-kelas'])) {
	$id = $_POST['id'];

	$query = mysqli_query($connect, "DELETE FROM kelas WHERE id_kelas='$id' ");

	if ($query) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '1';
		$_SESSION['status'] = 'Berhasil Menghapus Data Kelas';
		header('location: ../pages/index.php?page=kelas');
	}else{
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Gagal Menghapus Data Kelas';
		header('location: ../pages/index.php?page=kelas');
	}
}
?>