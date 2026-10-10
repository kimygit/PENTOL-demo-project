<?php
include '../inc/koneksi.php';

// Ambil ID Kembali dari URL
$id_k = $_GET['id_kembali'];

if (isset($id_k) && !empty($id_k)) {
    // Proses hapus hanya berdasarkan id_kembali
    $query_hapus = mysqli_query($koneksi, "DELETE FROM pengembalian WHERE id_kembali = '$id_k'");

    if ($query_hapus) {
        echo "<script>
                alert('Pengajuan pengembalian telah dihapus.'); 
                window.location='index.php?link=konfirmasi_kembali';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "'); 
                window.history.back();
              </script>";
    }
} else {

   /echo "<script>window.location='index.php?link=pengembalian';</script>";
}
?>