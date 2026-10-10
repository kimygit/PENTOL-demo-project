<?php 
session_start();
include 'koneksi.php';

$username = $_POST['Username'];
$password = $_POST['password'];
$password_md5 = md5($password);

// Ambil data user
$sql2 = mysqli_query($koneksi, "SELECT * FROM users WHERE username ='$username' AND password ='$password_md5'");
$data2 = mysqli_fetch_array($sql2);
$cek2 = mysqli_num_rows($sql2);

if ($cek2 > 0) {
    // JIKA LOGIN BERHASIL
    if ($data2['role'] == "admin") {
        $_SESSION['username'] = $username;
        $_SESSION['id_user'] = $data2['id_user'];
        $_SESSION['role'] = $data2['role'];

        echo "<script>
            alert('Login Berhasil! Selamat Datang Admin.');
            window.location.href = '../admin/index.php';
        </script>";
        exit;

    } elseif ($data2['role'] == "user") {
        $id_u = $data2['id_user'];
        $sql_agt = mysqli_query($koneksi, "SELECT id_anggota FROM anggota WHERE id_user = '$id_u'");
        $data_agt = mysqli_fetch_assoc($sql_agt);
        
        $_SESSION['role'] = $data2['role'];
        $_SESSION['username'] = $username;
        $_SESSION['id_user'] = $id_u;
        $_SESSION['id_anggota'] = $data_agt['id_anggota'];
        
        echo "<script>
            alert('Login Berhasil! Selamat Datang Siswa.');
            window.location.href = '../siswa/index.php';
        </script>";
        exit;
    }
} else {
    // JIKA LOGIN GAGAL
    echo "<script>
        alert('Login Gagal! Username atau Password Salah.');
        window.location.href = '../index.php?pesan=gagal';
    </script>";
    exit;
}
?>