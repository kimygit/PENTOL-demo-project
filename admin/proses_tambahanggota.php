<?php
include '../inc/koneksi.php';

// Pastikan tombol simpan diklik
if (isset($_POST['simpan'])) {
    
    // 1. Tangkap data dari POST (sesuaikan name di form modal)
    $no_anggota     = $_POST['no_anggota'];
    $nama           = mysqli_real_escape_with_htmlspecialchars($koneksi, $_POST['nama']);
    $kelas          = $_POST['kelas'];
    $no_hp          = $_POST['no_hp'];
    $alamat         = $_POST['alamat'];
    $tanggal_daftar = $_POST['tanggal_daftar']; // Data dari input hidden
    $status         = $_POST['status'];

    // 2. Query Insert ke tabel anggota (Pastikan nama tabel & kolom sesuai DB-mu)
    // Jika tabelmu namanya 'pelanggan', ganti 'anggota' jadi 'pelanggan'
    $query = "INSERT INTO anggota (no_anggota, nama, kelas, no_hp, alamat, tanggal_daftar, status) 
              VALUES ('$no_anggota', '$nama', '$kelas', '$no_hp', '$alamat', '$tanggal_daftar', '$status')";

    $simpan = mysqli_query($koneksi, $query);

    // 3. Notifikasi dan Redirect
    if ($simpan) {
        echo "<script>
                alert('Berhasil! Anggota baru dengan nomor $no_anggota telah terdaftar.');
                window.location.href='index.php?link=anggota'; 
              </script>";
    } else {
        // Jika error, tampilkan pesan error dari database
        echo "<script>
                alert('Gagal menyimpan data: " . mysqli_error($koneksi) . "');
                window.history.back();
              </script>";
    }
} else {
    // Jika akses file langsung tanpa klik tombol simpan
    header("location:index.php?link=anggota");
}

// Fungsi tambahan untuk keamanan input agar tidak kena SQL Injection
function mysqli_real_escape_with_htmlspecialchars($koneksi, $data) {
    return mysqli_real_escape_string($koneksi, htmlspecialchars($data));
}
?>