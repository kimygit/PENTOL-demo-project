<?php
include '../inc/koneksi.php';

$id_p = $_GET['id'];
$id_buku = $_GET['id_buku'];

// 1. Update status di tabel peminjaman
$update_master = mysqli_query($koneksi, "UPDATE peminjaman SET status_pinjam = 'dipinjam' WHERE id_pinjam = '$id_p'");

// 2. Update status di tabel detail_peminjaman
$update_detail = mysqli_query($koneksi, "UPDATE detail_peminjaman SET status_item = 'dipinjam' WHERE id_pinjam = '$id_p'");

// 3. Kurangi stok tersedia di tabel buku
$update_stok = mysqli_query($koneksi, "UPDATE buku SET stok_tersedia = stok_tersedia - 1 WHERE id_buku = '$id_buku'");

if ($update_master && $update_detail && $update_stok) {
    echo "<script>alert('Peminjaman disetujui! Stok buku telah dikurangi.'); window.location='index.php?link=peminjaman';</script>";
} else {
    echo "<script>alert('Gagal memproses data.'); window.history.back();</script>";
}
?>