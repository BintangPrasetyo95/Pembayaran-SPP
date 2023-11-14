<?php
include '../sql/connect.php';

if (isset($_POST['tambah-siswa'])) {
	$nisn = $_POST['nisn'];
	$nis = $_POST['nis'];
	$nama = trim($_POST['nama']);
	$kelas = $_POST['kelas'];
	$alamat = trim($_POST['alamat']);
	$telp = $_POST['telp'];
	$pw = md5($_POST['pw']);
	$k_pw = md5($_POST['kon_pw']);

	$cek_query = mysqli_query($connect, "SELECT * FROM siswa WHERE nisn='$nisn' OR nis='$nis' OR nama='$nama' ");
	$cek = mysqli_num_rows($cek_query);

	if ($nisn == '' || $nis == '' || $nama == '' || $kelas == '' || $alamat == '' || $telp == '' || $_POST['pw'] == '' || $_POST['kon_pw'] == '') {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Tolong isi dengan Benar!';
		header('location: ../pages/index.php?page=siswa');
	}elseif ($pw != $k_pw) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Password dan Konfirmasi Password tidak sama!';
		header('location: ../pages/index.php?page=siswa');
	}elseif ($cek >= 1) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Data Siswa dengan NISN / NIS / Nama yang sama telah ada!';
		header('location: ../pages/index.php?page=siswa');
	}else{
		$query = mysqli_query($connect, "INSERT INTO siswa (nisn,nis,nama,id_kelas,alamat,no_telp,password) VALUES ('$nisn','$nis','$nama','$kelas','$alamat','$telp','$k_pw') ");

		if ($query) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '1';
			$_SESSION['status'] = 'Berhasil Menambahkan Data Siswa';
			header('location: ../pages/index.php?page=siswa');
		}else{
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Gagal Menambahkan Data Siswa';
			header('location: ../pages/index.php?page=siswa');
		}
	}
}



if (isset($_POST['edit-siswa'])) {
	$idn = $_POST['idn'];
	$id = $_POST['id'];

	$nisn = $_POST['nisn'];
	$nis = $_POST['nis'];
	$nama = trim($_POST['nama']);
	$kelas = $_POST['kelas'];
	$alamat = trim($_POST['alamat']);
	$telp = $_POST['telp'];
	$pw = md5($_POST['pw']);
	$k_pw = md5($_POST['kon_pw']);

	$cek_query = mysqli_query($connect, "SELECT * FROM siswa WHERE (nisn='$nisn' OR nis='$nis' OR nama='$nama') AND nisn!='$idn' AND nis!='$id' ");
	$cek = mysqli_num_rows($cek_query);

	if ($nisn == '' || $nis == '' || $nama == '' || $kelas == '' || $alamat == '' || $telp == '' ) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Tolong isi dengan Benar!';
		header('location: ../pages/index.php?page=siswa');
	}elseif ($cek >= 1) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Data Siswa dengan NISN / NIS / Nama yang sama telah ada!';
		header('location: ../pages/index.php?page=siswa');
	}elseif (!empty($_POST['pw']) && !empty($_POST['kon_pw'])) {
		if ($pw != $k_pw) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Password dan Konfirmasi Password tidak sama!';
			header('location: ../pages/index.php?page=siswa');
		}else{
			$query = mysqli_query($connect, "UPDATE siswa SET nisn='$nisn', nis='$nis', nama='$nama', id_kelas='$kelas', alamat='$alamat', no_telp='$telp', password='$k_pw' WHERE nisn='$idn' && nis='$id' ");

			if ($query) {
				$_SESSION['sweetalert'] = '1';
				$_SESSION['alert'] = '1';
				$_SESSION['status'] = 'Berhasil Mengedit Data Siswa';
				header('location: ../pages/index.php?page=siswa');
			}else{
				$_SESSION['sweetalert'] = '1';
				$_SESSION['alert'] = '0';
				$_SESSION['status'] = 'Gagal Mengedit Data Siswa';
				header('location: ../pages/index.php?page=siswa');
			}
		}
	}else{
		$query = mysqli_query($connect, "UPDATE siswa SET nisn='$nisn', nis='$nis', nama='$nama', id_kelas='$kelas', alamat='$alamat', no_telp='$telp' WHERE nisn='$idn' && nis='$id' ");

		if ($query) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '1';
			$_SESSION['status'] = 'Berhasil Mengedit Data Siswa';
			header('location: ../pages/index.php?page=siswa');
		}else{
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Gagal Mengedit Data Siswa';
			header('location: ../pages/index.php?page=siswa');
		}
	}
}



if (isset($_POST['hapus-siswa'])) {
	$nisn = $_POST['nisn'];
	$nis = $_POST['nis'];

	$query = mysqli_query($connect, "DELETE FROM siswa WHERE nisn='$nisn' AND nis='$nis' ");

	if ($query) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '1';
		$_SESSION['status'] = 'Berhasil Menghapus Data Siswa';
		header('location: ../pages/index.php?page=siswa');
	}else{
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Gagal Menghapus Data Siswa';
		header('location: ../pages/index.php?page=siswa');
	}
}

?>