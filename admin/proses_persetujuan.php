<?php
// proses_setujui_kembali.php
include '../inc/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Ambil Data dari Modal
    $id_kembali = mysqli_real_escape_string($koneksi, $_POST['id_kembali']);
    $id_pinjam  = mysqli_real_escape_string($koneksi, $_POST['id_pinjam']);
    $catatan_admin = mysqli_real_escape_string($koneksi, $_POST['catatan_admin']);

    // Default catatan jika kosong
    $catatan_final = empty(trim($catatan_admin)) ? "Buku telah dikembalikan dan diverifikasi admin." : $catatan_admin;

    $tgl_sekarang = date('Y-m-d');
    // 2. Ambil informasi penting (ID Buku & Qty) dari detail_peminjaman sebelum diupdate
    // Ini penting agar kita tahu buku mana yang stoknya harus ditambah
 $query_info = mysqli_query($koneksi, "SELECT dp.id_buku, dp.Qty, p.tanggal_jatuh_tempo 
                   FROM detail_peminjaman dp 
                   JOIN peminjaman p ON dp.id_pinjam = p.id_pinjam 
                   WHERE dp.id_pinjam = '$id_pinjam'");
    
    $data_detail = mysqli_fetch_array($query_info);
    $id_buku = $data_detail['id_buku'];
    $qty_balik = $data_detail['Qty'];

    $deadline  = $data_detail['tanggal_jatuh_tempo'];
    $denda_final = 0;
    if ($tgl_sekarang > $deadline) {
        $selisih = strtotime($tgl_sekarang) - strtotime($deadline);
        $selisih_hari = floor($selisih / (60*60*24));
        $denda_final = ($selisih_hari * 1000) * $qty_balik;
    }

    // Mulai Transaksi agar jika satu gagal, semua batal (Data Integrity)
    mysqli_begin_transaction($koneksi);

    try {
        // 3. UPDATE TABEL PENGEMBALIAN
        // Set status jadi selesai dan masukkan catatan resmi admin
        mysqli_query($koneksi, "UPDATE pengembalian SET 
            status_kembali = 'selesai', 
            catatan = '$catatan_final',
            denda_total = '$denda_final' 
            WHERE id_kembali = '$id_kembali'");

        // 4. UPDATE TABEL PEMINJAMAN
        // Set status jadi selesai agar tidak muncul di pinjaman aktif siswa
        mysqli_query($koneksi, "UPDATE peminjaman SET 
            status_pinjam = 'selesai' 
            WHERE id_pinjam = '$id_pinjam'");

        // 5. UPDATE TABEL DETAIL_PEMINJAMAN
        // Sesuai struktur DB kamu, ada status_item enum('dipinjam','dikembalikan')
        mysqli_query($koneksi, "UPDATE detail_peminjaman SET 
            status_item = 'dikembalikan' 
            WHERE id_pinjam = '$id_pinjam'");

        // 6. UPDATE TABEL BUKU (Kembalikan Stok)
        // Menambah stok_tersedia sesuai jumlah yang dipinjam (Qty)
        mysqli_query($koneksi, "UPDATE buku SET 
            stok_tersedia = stok_tersedia + $qty_balik 
            WHERE id_buku = '$id_buku'");

        // Jika semua lancar, simpan permanen
        mysqli_commit($koneksi);

        echo "<script>
                alert('Berhasil! Semua data telah diperbarui dan stok buku dikembalikan.');
                window.location='index.php?link=pengembalian'; 
              </script>";

    } catch (Exception $e) {
        // Jika ada error, batalkan semua perubahan di semua tabel
        mysqli_rollback($koneksi);
        echo "<script>
                alert('Gagal memproses data: " . mysqli_error($koneksi) . "');
                window.history.back();
              </script>";
    }

} else {
    header("Location: index.php?link=konfirmasi_admin");
    exit;
}
?>