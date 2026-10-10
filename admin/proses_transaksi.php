<?php
include '../inc/koneksi.php';

$aksi = $_GET['aksi'];
$id_p = $_GET['id'];
$id_b = $_GET['buku'];

if ($aksi == 'setujui') {
    // 1. Ubah status jadi 'dipinjam'
    mysqli_query($koneksi, "UPDATE peminjaman SET status_pinjam = 'dipinjam' WHERE id_pinjam = '$id_p'");
    // 2. STOK BERKURANG (karena buku dibawa siswa)
    mysqli_query($koneksi, "UPDATE buku SET stok_tersedia = stok_tersedia - 1 WHERE id_buku = '$id_b'");
    $pesan = "Buku telah diberikan ke siswa!";

} elseif ($aksi == 'kembalikan') {
    // 1. Ubah status jadi 'kembali'
    mysqli_query($koneksi, "UPDATE peminjaman SET status_pinjam = 'kembali' WHERE id_pinjam = '$id_p'");
    // 2. STOK BERTAMBAH (karena buku masuk rak lagi)
    mysqli_query($koneksi, "UPDATE buku SET stok_tersedia = stok_tersedia + 1 WHERE id_buku = '$id_b'");
    $pesan = "Buku telah diterima kembali!";
}

echo "<script>alert('$pesan'); window.location='index.php?link=transaksi';</script>";
?>