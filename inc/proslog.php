<?php 
session_start();
include 'koneksi.php';

$username = mysqli_real_escape_string($koneksi, $_POST['Username']);
$password = $_POST['password'];
$password_md5 = md5($password);

// TAHAP 1: Cek Username & Password saja
$sql_cek_akun = mysqli_query($koneksi, "SELECT * FROM users WHERE username ='$username' AND password ='$password_md5'");
$data = mysqli_fetch_array($sql_cek_akun);
$cek_akun = mysqli_num_rows($sql_cek_akun);

if ($cek_akun > 0) {
    // TAHAP 2: Jika akun ada, cek status_aktif nya
    if ($data['status_aktif'] == '0') {
        // NOTIFIKASI 1: Akun ada tapi tidak aktif
        echo "<script>
            alert('Login Gagal! Akun Anda telah dinonaktifkan. Silakan hubungi admin.');
            window.location.href = '../index.php?pesan=nonaktif';
        </script>";
        exit;
    }

    // JIKA LOLOS CEK STATUS (Berarti Aktif), LANJUT LOGIN
    if ($data['role'] == "admin") {
        $_SESSION['username'] = $username;
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['role'] = $data['role'];

        echo "<script>
            alert('Login Berhasil! Selamat Datang Admin.');
            window.location.href = '../admin/index.php';
        </script>";
        exit;

    } elseif ($data['role'] == "user") {
        $id_u = $data['id_user'];
        $sql_agt = mysqli_query($koneksi, "SELECT id_anggota FROM anggota WHERE id_user = '$id_u'");
        $data_agt = mysqli_fetch_assoc($sql_agt);
        
        $_SESSION['role'] = $data['role'];
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
    // NOTIFIKASI 2: Username atau Password salah (Akun tidak ditemukan)
    echo "<script>
        alert('Login Gagal! Username atau Password salah.');
        window.location.href = '../index.php?pesan=gagal';
    </script>";
    exit;
}
?>