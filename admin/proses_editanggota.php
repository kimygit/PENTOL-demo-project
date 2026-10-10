<?php
include '../inc/koneksi.php';

if (isset($_POST['update'])) {
    $id     = $_POST['id_anggota']; 
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas  = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $no_hp  = $_POST['no_hp'];
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $status = $_POST['status']; 

    // 1. Ambil id_user dari tabel anggota
    $get_user = mysqli_query($koneksi, "SELECT id_user FROM anggota WHERE id_anggota = '$id'");
    $data_user = mysqli_fetch_assoc($get_user);
    $id_u = $data_user['id_user'];

$status_cek = strtolower($status); 
$status_aktif = ($status_cek == 'aktif') ? 1 : 0;

// 3. Update Tabel Anggota
$query_anggota = "UPDATE anggota SET 
                    nama = '$nama', 
                    kelas = '$kelas', 
                    no_hp = '$no_hp', 
                    alamat = '$alamat', 
                    status = '$status' 
                  WHERE id_anggota = '$id'";

$update = mysqli_query($koneksi, $query_anggota);

if ($update) {
    // 4. Update tabel users (Gunakan $status_aktif hasil pengecekan di atas)
    $query_user = "UPDATE users SET 
                     nama = '$nama', 
                     status_aktif = '$status_aktif' 
                   WHERE id_user = '$id_u'";
    
    mysqli_query($koneksi, $query_user);

        echo "<script>
                alert('Data anggota dan akses login berhasil diperbarui!');
                window.location.href='index.php?link=anggota';
              </script>";
    } else {
        echo "<script>
                alert('Gagal update: " . mysqli_error($koneksi) . "');
                window.history.back();
              </script>";
    }
}
?>