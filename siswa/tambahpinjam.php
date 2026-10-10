<?php
session_start();
include '../inc/koneksi.php';

if (isset($_POST['submit_pinjam'])) {
    // 1. Ambil Data & Lindungi dari SQL Injection
    $id_buku = mysqli_real_escape_string($koneksi, $_POST['id_buku']);
    $durasi  = mysqli_real_escape_string($koneksi, $_POST['durasi']);
    
    if (!isset($_SESSION['id_anggota']) || !isset($_SESSION['id_user'])) {
        echo "<script>alert('Error: Sesi Login Hilang. Silakan Login Ulang.'); window.location='../index.php';</script>";
        exit;
    }

    $id_agt  = $_SESSION['id_anggota'];
    $id_user = $_SESSION['id_user'];
    
    $tgl_pinjam  = date('Y-m-d');
    $tgl_kembali = date('Y-m-d', strtotime("+$durasi days"));

    // 2. Cek Stok (Walaupun pending, kita tetap cek apakah stok fisik masih ada)
    $cek_stok = mysqli_query($koneksi, "SELECT stok_tersedia FROM buku WHERE id_buku = '$id_buku'");
    $s = mysqli_fetch_array($cek_stok);

    if ($s['stok_tersedia'] > 0) {
        
        // A. Insert ke tabel PEMINJAMAN dengan status 'pending'
        // Perhatikan: status_pinjam sekarang diisi 'pending'
        $query_pinjam = "INSERT INTO peminjaman (id_anggota, id_user, tanggal_pinjam, tanggal_jatuh_tempo, status_pinjam) 
                         VALUES ('$id_agt', '$id_user', '$tgl_pinjam', '$tgl_kembali', 'pending')";
        
        $simpan_pinjam = mysqli_query($koneksi, $query_pinjam);

        if ($simpan_pinjam) {
            $id_p = mysqli_insert_id($koneksi);

            // B. Insert ke tabel DETAIL_PEMINJAMAN dengan status_item 'pending'
            $query_detail = "INSERT INTO detail_peminjaman (id_pinjam, id_buku, qty, status_item) 
                             VALUES ('$id_p', '$id_buku', 1, 'pending')";
            $simpan_detail = mysqli_query($koneksi, $query_detail);

            if ($simpan_detail) {
                // --- BAGIAN UPDATE STOK DIHAPUS DARI SINI ---
                // Kenapa? Karena ini baru pengajuan (pending). 
                // Stok baru berkurang kalau Admin sudah verifikasi buku fisiknya ada.

                echo "<script>alert('Pengajuan peminjaman berhasil! Silakan tunggu verifikasi petugas/admin.'); window.location='index.php?link=dashboard';</script>";
            } else {
                echo "<script>alert('Gagal Simpan Detail: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Gagal Simpan Peminjaman: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
        }

    } else {
        echo "<script>alert('Maaf, stok buku ini sedang kosong.'); window.location='index.php?link=dashboard';</script>";
    }
}
?>