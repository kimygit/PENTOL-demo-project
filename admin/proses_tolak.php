<?php
include '../inc/koneksi.php';

// Cek apakah ID dikirim melalui URL
if (isset($_GET['id'])) {
    $id_p = mysqli_real_escape_string($koneksi, $_GET['id']);

    // 1. Hapus data di tabel DETAIL_PEMINJAMAN (Hapus "anak" dulu)
    $query_hapus_detail = "DELETE FROM detail_peminjaman WHERE id_pinjam = '$id_p'";
    $hapus_detail = mysqli_query($koneksi, $query_hapus_detail);

    if ($hapus_detail) {
        // 2. Baru hapus data di tabel PEMINJAMAN (Hapus "induk")
        $query_hapus_master = "DELETE FROM peminjaman WHERE id_pinjam = '$id_p'";
        $hapus_master = mysqli_query($koneksi, $query_hapus_master);

        if ($hapus_master) {
            echo "<script>alert('Pengajuan peminjaman telah ditolak dan data dihapus dari sistem.'); window.location='index.php?link=transaksi';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data utama: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal menghapus detail data: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
    }
} else {
    // Jika tidak ada ID, balikkan ke halaman transaksi
    header("location:index.php?link=transaksi");
}
?>