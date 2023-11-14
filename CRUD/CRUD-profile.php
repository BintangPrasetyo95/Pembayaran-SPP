<?php
include '../sql/connect.php';

if (isset($_POST['edit-profile-siswa'])) {
    $alamat = trim($_POST['alamat']);
    $no_telp = $_POST['no_telp'];
    $id = $_SESSION['user']['nisn'];

    $queryfoto = mysqli_query($connect, "SELECT * FROM siswa WHERE nisn='$id' ");
    $datafoto = mysqli_fetch_array($queryfoto);

    if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];

        $fotobaru = rand() . '_' . $foto;

        $path = "../assets/img/avatars/" . $fotobaru;

        $check = getimagesize($_FILES['foto']['tmp_name']);

        if ($check !== false) {
            if (move_uploaded_file($foto_tmp, $path)) {
                if (is_file("../assets/img/avatars/" . $datafoto['foto']))
                    unlink("../assets/img/avatars/" . $datafoto['foto']);

                if (!empty($_POST['pw_konf'])) {
                    if (empty($_POST['pw_lama']) || md5($_POST['pw_lama']) != $_SESSION['user']['password']) {
                        $_SESSION['sweetalert'] = '1';
                        $_SESSION['alert'] = '0';
                        $_SESSION['status'] = 'Password Lama Salah';
                        header('location: ../pages/index.php?page=profile');
                    } else {
                        $password = md5($_POST['pw_konf']);

                        $query = mysqli_query($connect, "UPDATE siswa SET alamat='$alamat', no_telp='$no_telp', foto='$fotobaru', password='$password' WHERE nisn='$id' ");
                        $session = mysqli_query($connect, "SELECT * FROM siswa WHERE nisn='$id' ");

                        if ($query) {
                            $_SESSION['user'] = mysqli_fetch_array($session);
                            $_SESSION['sweetalert'] = '1';
                            $_SESSION['alert'] = '1';
                            $_SESSION['status'] = 'Berhasil Mengedit Data Profile';
                            header('location: ../pages/index.php?page=profile');
                        }else{
                            $_SESSION['sweetalert'] = '1';
                            $_SESSION['alert'] = '0';
                            $_SESSION['status'] = 'Gagal Mengedit Data Profile';
                            header('location: ../pages/index.php?page=profile');
                        }
                    }
                }else{
                    $query = mysqli_query($connect, "UPDATE siswa SET alamat='$alamat', no_telp='$no_telp', foto='$fotobaru' WHERE nisn='$id' ");
                    $session = mysqli_query($connect, "SELECT * FROM siswa WHERE nisn='$id' ");

                    if ($query) {
                        $_SESSION['user'] = mysqli_fetch_array($session);
                        $_SESSION['sweetalert'] = '1';
                        $_SESSION['alert'] = '1';
                        $_SESSION['status'] = 'Berhasil Mengedit Data Profile';
                        header('location: ../pages/index.php?page=profile');
                    }else{
                        $_SESSION['sweetalert'] = '1';
                        $_SESSION['alert'] = '0';
                        $_SESSION['status'] = 'Gagal Mengedit Data Profile';
                        header('location: ../pages/index.php?page=profile');
                    }
                }
            }
        } else {
            echo "<script>alert('File Bukan Foto'); location.href='../pages/index.php?page=profile#section_profile'</script>";
        }
    }

    if (!empty($_POST['pw_konf'])) {
        if (empty($_POST['pw_lama']) || md5($_POST['pw_lama']) != $_SESSION['user']['password']) {
            $_SESSION['sweetalert'] = '1';
            $_SESSION['alert'] = '0';
            $_SESSION['status'] = 'Password Lama Salah';
            header('location: ../pages/index.php?page=profile');
        } else {
            $password = md5($_POST['pw_konf']);

            $query = mysqli_query($connect, "UPDATE siswa SET alamat='$alamat', no_telp='$no_telp', password='$password' WHERE nisn='$id' ");
            $session = mysqli_query($connect, "SELECT * FROM siswa WHERE nisn='$id' ");

            if ($query) {
                $_SESSION['user'] = mysqli_fetch_array($session);
                $_SESSION['sweetalert'] = '1';
                $_SESSION['alert'] = '1';
                $_SESSION['status'] = 'Berhasil Mengedit Data Profile';
                header('location: ../pages/index.php?page=profile');
            }else{
                $_SESSION['sweetalert'] = '1';
                $_SESSION['alert'] = '0';
                $_SESSION['status'] = 'Gagal Mengedit Data Profile';
                header('location: ../pages/index.php?page=profile');
            }
        }
    }else{
        $query = mysqli_query($connect, "UPDATE siswa SET alamat='$alamat', no_telp='$no_telp' WHERE nisn='$id' ");
        $session = mysqli_query($connect, "SELECT * FROM siswa WHERE nisn='$id' ");

        if ($query) {
            $_SESSION['user'] = mysqli_fetch_array($session);
            $_SESSION['sweetalert'] = '1';
            $_SESSION['alert'] = '1';
            $_SESSION['status'] = 'Berhasil Mengedit Data Profile';
            header('location: ../pages/index.php?page=profile');
        }else{
            $_SESSION['sweetalert'] = '1';
            $_SESSION['alert'] = '0';
            $_SESSION['status'] = 'Gagal Mengedit Data Profile';
            header('location: ../pages/index.php?page=profile');
        }
    }
}


if (isset($_POST['edit-profile-petugas'])) {
    $username = trim($_POST['username']);
    $id = $_SESSION['user']['id_petugas'];

    $queryfoto = mysqli_query($connect, "SELECT * FROM petugas WHERE id_petugas='$id' ");
    $datafoto = mysqli_fetch_array($queryfoto);

	$cek_query = mysqli_query($connect, "SELECT * FROM petugas WHERE username='$username' AND NOT id_petugas='$id' ");
	$cek = mysqli_num_rows($cek_query);

    if ($cek >= 1) {
		$_SESSION['sweetalert'] = '1';
		$_SESSION['alert'] = '0';
		$_SESSION['status'] = 'Data Petugas dengan Username yang sama telah ada!';
		header('location: ../pages/index.php?page=profile');
	} elseif (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];

        $fotobaru = rand() . '_' . $foto;

        $path = "../assets/img/avatars/" . $fotobaru;

        $check = getimagesize($_FILES['foto']['tmp_name']);
       
        if ($check !== false) {
            if (move_uploaded_file($foto_tmp, $path)) {
                if (is_file("../assets/img/avatars/" . $datafoto['foto_petugas']))
                    unlink("../assets/img/avatars/" . $datafoto['foto_petugas']);

                if (!empty($_POST['pw_konf'])) {
                    if (empty($_POST['pw_lama']) || md5($_POST['pw_lama']) != $_SESSION['user']['password']) {
                        $_SESSION['sweetalert'] = '1';
                        $_SESSION['alert'] = '0';
                        $_SESSION['status'] = 'Password Lama Salah';
                        header('location: ../pages/index.php?page=profile');
                    } else {
                        $password = md5($_POST['pw_konf']);

                        $query = mysqli_query($connect, "UPDATE petugas SET username='$username', foto_petugas='$fotobaru', password='$password' WHERE id_petugas='$id' ");
                        $session = mysqli_query($connect, "SELECT * FROM petugas WHERE id_petugas='$id' ");

                        if ($query) {
                            $_SESSION['user'] = mysqli_fetch_array($session);
                            $_SESSION['sweetalert'] = '1';
                            $_SESSION['alert'] = '1';
                            $_SESSION['status'] = 'Berhasil Mengedit Data Profile';
                            header('location: ../pages/index.php?page=profile');
                        }else{
                            $_SESSION['sweetalert'] = '1';
                            $_SESSION['alert'] = '0';
                            $_SESSION['status'] = 'Gagal Mengedit Data Profile';
                            header('location: ../pages/index.php?page=profile');
                        }
                    }
                } else {
                    $query = mysqli_query($connect, "UPDATE petugas SET username='$username', foto_petugas='$fotobaru' WHERE id_petugas='$id' ");
                    $session = mysqli_query($connect, "SELECT * FROM petugas WHERE id_petugas='$id' ");

                    if ($query) {
                        $_SESSION['user'] = mysqli_fetch_array($session);
                        $_SESSION['sweetalert'] = '1';
                        $_SESSION['alert'] = '1';
                        $_SESSION['status'] = 'Berhasil Mengedit Data Profile';
                        header('location: ../pages/index.php?page=profile');
                    }else{
                        $_SESSION['sweetalert'] = '1';
                        $_SESSION['alert'] = '0';
                        $_SESSION['status'] = 'Gagal Mengedit Data Profile';
                        header('location: ../pages/index.php?page=profile');
                    }
                }
            }
        } else {
            echo "<script>alert('File Bukan Foto'); location.href='../pages/index.php?page=profile#section_profile'</script>";
        }
    }else{
        if (!empty($_POST['pw_konf'])) {
            if ($_POST['pw_lama'] = '' || md5($_POST['pw_lama']) != $_SESSION['user']['password']) {
                $_SESSION['sweetalert'] = '1';
                $_SESSION['alert'] = '0';
                $_SESSION['status'] = 'Password Lama Salah';
                header('location: ../pages/index.php?page=profile');
            } else {
                $password = md5($_POST['pw_konf']);

                $query = mysqli_query($connect, "UPDATE petugas SET username='$username', password='$password' WHERE id_petugas='$id' ");
                $session = mysqli_query($connect, "SELECT * FROM petugas WHERE id_petugas='$id' ");

                if ($query) {
                    $_SESSION['user'] = mysqli_fetch_array($session);
                    $_SESSION['sweetalert'] = '1';
                    $_SESSION['alert'] = '1';
                    $_SESSION['status'] = 'Berhasil Mengedit Data Profile';
                    header('location: ../pages/index.php?page=profile');
                }else{
                    $_SESSION['sweetalert'] = '1';
                    $_SESSION['alert'] = '0';
                    $_SESSION['status'] = 'Gagal Mengedit Data Profile';
                    header('location: ../pages/index.php?page=profile');
                }
            }
        } else {
            $query = mysqli_query($connect, "UPDATE petugas SET username='$username' WHERE id_petugas='$id' ");
            $session = mysqli_query($connect, "SELECT * FROM petugas WHERE id_petugas='$id' ");

            if ($query) {
                $_SESSION['user'] = mysqli_fetch_array($session);
                $_SESSION['sweetalert'] = '1';
                $_SESSION['alert'] = '1';
                $_SESSION['status'] = 'Berhasil Mengedit Data Profile';
                header('location: ../pages/index.php?page=profile');
            }else{
                $_SESSION['sweetalert'] = '1';
                $_SESSION['alert'] = '0';
                $_SESSION['status'] = 'Gagal Mengedit Data Profile';
                header('location: ../pages/index.php?page=profile');
            }
        }
    }
}

?>