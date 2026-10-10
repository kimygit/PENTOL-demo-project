<?php
include '../inc/koneksi.php';

// Gunakan $_POST jika di halaman depan tadi kita pakai <form>, 
// atau tetap $_GET jika kamu pakai link <a>. Di sini saya sesuaikan agar fleksibel.
$id_p = mysqli_real_escape_string($koneksi, $_POST['id_pinjam'] ?? $_GET['id']);
$tgl_sekarang = date('Y-m-d');

// 1. Ambil data pinjam & detailnya (Ambil Qty juga)
$query_data = mysqli_query($koneksi, "SELECT p.tanggal_jatuh_tempo, dp.Qty, dp.id_buku 
                FROM peminjaman p
                JOIN detail_peminjaman dp ON p.id_pinjam = dp.id_pinjam 
                WHERE p.id_pinjam = '$id_p'");
$data = mysqli_fetch_array($query_data);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php?link=katalog';</script>";
    exit;
}

$id_buku = $data['id_buku'];
$deadline = $data['tanggal_jatuh_tempo'];
$qty = (int)$data['Qty']; // Ambil Qty buku

// 2. Logika Penentuan Denda
$denda = 0;
if ($tgl_sekarang > $deadline) {
    $selisih = strtotime($tgl_sekarang) - strtotime($deadline);
    $selisih_hari = floor($selisih / (60*60*24));
    
    // PERBAIKAN: Kalikan dengan Qty agar sama dengan tampilan depan
    $denda = ($selisih_hari * 1000) * $qty;
}

// 3. CEK APAKAH SUDAH PERNAH SUBMIT (Mencegah Double Input)
$cek_antrean = mysqli_query($koneksi, "SELECT * FROM pengembalian WHERE id_pinjam = '$id_p'");
if (mysqli_num_rows($cek_antrean) > 0) {
    echo "<script>alert('Buku ini sudah dalam status pending!'); window.location='index.php?link=katalog';</script>";
    exit;
}

// 4. INSERT KE TABEL PENGEMBALIAN
// Catatan: status_kembali diisi 'pending' agar Admin bisa konfirmasi nanti
$catatan = "Siswa mengajukan pengembalian via sistem";
$insert_kembali = mysqli_query($koneksi, "INSERT INTO pengembalian (id_pinjam, tanggal_kembali, denda_total, catatan, status_kembali) 
                                   VALUES ('$id_p', '$tgl_sekarang', '$denda', '$catatan', 'pending')");

if ($insert_kembali) {
    echo "<script>
        alert('Permintaan berhasil dikirim. Silakan serahkan buku ke petugas.');
        window.location='index.php?link=pengembalian'; 
    </script>";
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>