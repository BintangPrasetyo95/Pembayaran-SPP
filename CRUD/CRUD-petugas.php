<?php
include '../sql/connect.php';

if (isset($_POST['tambah-petugas'])) {
	$nama = trim($_POST['nama']);
	$name = trim($_POST['name']);
	$level = $_POST['level'];
	$pw = md5($_POST['pw']);
	$k_pw = md5($_POST['kon_pw']);

	$cek_query = mysqli_query($connect, "SELECT * FROM petugas WHERE nama_petugas='$nama' OR username='$name' ");
	$cek = mysqli_num_rows($cek_query);

	if ($nama == '' || $name == '' || $level == '' || $_POST['pw'] == '' || $_POST['kon_pw'] == '') {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Tolong isi dengan Benar!';
		header('location: ../pages/index.php?page=petugas');
	}elseif ($pw != $k_pw) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Password dan Konfirmasi Password tidak sama!';
		header('location: ../pages/index.php?page=petugas');
	}elseif ($cek >= 1) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Data Petugas dengan Nama / Username yang sama telah ada!';
		header('location: ../pages/index.php?page=petugas');
	}else{
		$query = mysqli_query($connect, "INSERT INTO petugas (nama_petugas, username, level, password) VALUES ('$nama','$name','$level','$k_pw') ");

		if ($query) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '1';
			$_SESSION['status'] = 'Berhasil Menambahkan Data Petugas';
			header('location: ../pages/index.php?page=petugas');
		}else{
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Gagal Menambahkan Data Petugas';
			header('location: ../pages/index.php?page=petugas');
		}
	}
}



if (isset($_POST['edit-petugas'])) {
	$id = $_POST['id'];

	$nama = trim($_POST['nama']);
	$name = trim($_POST['name']);
	$level = $_POST['level'];
	$pw = md5($_POST['pw']);
	$k_pw = md5($_POST['kon_pw']);

	$cek_query = mysqli_query($connect, "SELECT * FROM petugas WHERE (username='$name' OR nama_petugas='$nama') AND id_petugas!='$id' ");
	$cek = mysqli_num_rows($cek_query);

	if ($nama == '' || $name == '' || $level == '' ) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Tolong isi dengan Benar!';
		header('location: ../pages/index.php?page=petugas');
	}elseif ($cek >= 1) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Data Petugas dengan Nama / Username yang sama telah ada!';
		header('location: ../pages/index.php?page=petugas');
	}elseif (!empty($_POST['pw']) && !empty($_POST['kon_pw'])) {
		if ($pw != $k_pw) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Password dan Konfirmasi Password tidak sama!';
			header('location: ../pages/index.php?page=petugas');
		}else{
			$query = mysqli_query($connect, "UPDATE petugas SET nama_petugas='$nama', username='$name', level='$level', password='$k_pw' WHERE id_petugas='$id' ");

			if ($query) {
				$_SESSION['sweetalert'] = '1';
				$_SESSION['alert'] = '1';
				$_SESSION['status'] = 'Berhasil Mengedit Data Petugas';
				header('location: ../pages/index.php?page=petugas');
			}else{
				$_SESSION['sweetalert'] = '1';
				$_SESSION['alert'] = '0';
				$_SESSION['status'] = 'Gagal Mengedit Data Petugas';
				header('location: ../pages/index.php?page=petugas');
			}
		}
	}else{
		$query = mysqli_query($connect, "UPDATE petugas SET nama_petugas='$nama', username='$name', level='$level' WHERE id_petugas='$id' ");

		if ($query) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '1';
			$_SESSION['status'] = 'Berhasil Mengedit Data Petugas';
			header('location: ../pages/index.php?page=petugas');
		}else{
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Gagal Mengedit Data Petugas';
			header('location: ../pages/index.php?page=petugas');
		}
	}
}



if (isset($_POST['hapus-petugas'])) {
	$id = $_POST['id'];

	$query = mysqli_query($connect, "DELETE FROM petugas WHERE id_petugas='$id' ");

	if ($query) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '1';
		$_SESSION['status'] = 'Berhasil Menghapus Data Petugas';
		header('location: ../pages/index.php?page=petugas');
	}else{
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Gagal Menghapus Data Petugas';
		header('location: ../pages/index.php?page=petugas');
	}
}





if (isset($_POST['edit-petugas-sendiri'])) {
	$id = $_POST['id'];

	$nama = trim($_POST['nama']);
	$name = trim($_POST['name']);
	$level = $_POST['level'];
	$pw = md5($_POST['pw']);
	$k_pw = md5($_POST['kon_pw']);

	$cek_query = mysqli_query($connect, "SELECT * FROM petugas WHERE (username='$name' OR nama_petugas='$nama') AND id_petugas!='$id' ");
	$cek = mysqli_num_rows($cek_query);

	if ($nama == '' || $name == '' || $level == '' ) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Tolong isi dengan Benar!';
		header('location: ../pages/index.php?page=petugas');
	}elseif ($cek >= 1) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Data Petugas dengan Nama / Username yang sama telah ada!';
		header('location: ../pages/index.php?page=petugas');
	}elseif (!empty($_POST['pw']) && !empty($_POST['kon_pw'])) {
		if ($pw != $k_pw) {
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Password dan Konfirmasi Password tidak sama!';
			header('location: ../pages/index.php?page=petugas');
		}else{
			$query = mysqli_query($connect, "UPDATE petugas SET nama_petugas='$nama', username='$name', level='$level', password='$k_pw' WHERE id_petugas='$id' ");

			if ($query) {
				$self_id = $_SESSION['user']['id_petugas'];
				$refresh = mysqli_query($connect, "SELECT * FROM petugas WHERE id_petugas='$self_id' ");
				$_SESSION['user'] = mysqli_fetch_array($refresh);
				$_SESSION['sweetalert'] = '1';
				$_SESSION['alert'] = '1';
				$_SESSION['status'] = 'Berhasil Mengedit Data Anda';
				header('location: ../pages/index.php?page=petugas');
			}else{
				$_SESSION['sweetalert'] = '1';
				$_SESSION['alert'] = '0';
				$_SESSION['status'] = 'Gagal Mengedit Data Anda';
				header('location: ../pages/index.php?page=petugas');
			}
		}
	}else{
		$query = mysqli_query($connect, "UPDATE petugas SET nama_petugas='$nama', username='$name', level='$level' WHERE id_petugas='$id' ");

		if ($query) {
			$self_id = $_SESSION['user']['id_petugas'];
			$refresh = mysqli_query($connect, "SELECT * FROM petugas WHERE id_petugas='$self_id' ");
			$_SESSION['user'] = mysqli_fetch_array($refresh);
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '1';
			$_SESSION['status'] = 'Berhasil Mengedit Data Anda';
			header('location: ../pages/index.php?page=petugas');
		}else{
			$_SESSION['sweetalert'] = '1';
			$_SESSION['alert'] = '0';
			$_SESSION['status'] = 'Gagal Mengedit Data Anda';
			header('location: ../pages/index.php?page=petugas');
		}
	}
}