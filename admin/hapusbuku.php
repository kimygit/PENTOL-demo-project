<?php
include '../inc/koneksi.php';

// Pastikan ada ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Ambil nama file foto dari database sebelum datanya dihapus
    $ambil = mysqli_query($koneksi, "SELECT foto FROM buku WHERE id_buku = '$id'");
    $data = mysqli_fetch_assoc($ambil);
    $foto_lama = $data['foto'];

    // 2. Hapus file foto di folder fisik jika filenya ada
    if ($foto_lama != "" && file_exists("../asset/img/buku/" . $foto_lama)) {
        unlink("../asset/img/buku/" . $foto_lama);
    }

    // 3. Hapus data dari tabel buku
    $hapus = mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku = '$id'");

    if ($hapus) {
        echo "<script>
                alert('Buku berhasil dihapus!');
                window.location = 'index.php?link=buku';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus buku: " . mysqli_error($koneksi) . "');
                window.location = 'index.php?link=buku';
              </script>";
    }
} else {
    header("location:index.php?link=buku");
}
?>