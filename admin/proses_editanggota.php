<?php
include '../inc/koneksi.php';

if (isset($_POST['update'])) {
    $id     = $_POST['id_anggota'];
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas  = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $no_hp  = $_POST['no_hp'];
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $status = $_POST['status'];

    // Query Update
    $query = "UPDATE anggota SET 
                nama = '$nama', 
                kelas = '$kelas', 
                no_hp = '$no_hp', 
                alamat = '$alamat', 
                status = '$status' 
              WHERE id_anggota = '$id'";

    $update = mysqli_query($koneksi, $query);

    if ($update) {
        echo "<script>
                alert('Data anggota berhasil diperbarui!');
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