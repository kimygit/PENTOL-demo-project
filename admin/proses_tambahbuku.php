<?php
include '../inc/koneksi.php';

// --- PROSES TAMBAH BUKU ---
if (isset($_POST['simpan'])) {
    // 1. Tangkap semua data dari form
    $isbn           = mysqli_real_escape_string($koneksi, $_POST['isbn']);
    $judul          = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang      = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $penerbit       = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $tahun          = $_POST['tahun_terbit'];
    $kategori       = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $stok_total     = $_POST['stok_tersedia']; 
    $stok_tersedia  = $_POST['stok_tersedia']; 

    // --- LOGIKA OTOMATIS LOKASI RAK BERDASARKAN KATEGORI ---
    switch ($kategori) {
        case 'Novel':
            $lokasi_rak = "A1";
            break;
        case 'Pelajaran':
            $lokasi_rak = "B2";
            break;
        case 'Sains':
            $lokasi_rak = "C3";
            break;
        case 'Komik':
            $lokasi_rak = "D4";
            break;
        default:
            $lokasi_rak = "Umum";
            break;
    }

    // 2. Persiapan Upload Foto
    $nama_file = $_FILES['foto']['name'];
    $tmp_file  = $_FILES['foto']['tmp_name'];
    $type_file = $_FILES['foto']['type'];
    
    // Rename file agar unik dan paksa ekstensi .webp
    $nama_baru = time() . ".webp"; 
    $folder    = "../asset/img/buku/" . $nama_baru;

    // 3. Logika Optimasi Gambar ke WebP
    if ($type_file == 'image/jpeg' || $type_file == 'image/jpg') {
        $img = imagecreatefromjpeg($tmp_file);
    } elseif ($type_file == 'image/png') {
        $img = imagecreatefrompng($tmp_file);
    } else {
        $img = @imagecreatefromstring(file_get_contents($tmp_file));
    }

    if ($img) {
        // Simpan sebagai WebP
        imagewebp($img, $folder, 80); 
        imagedestroy($img);
        
        // 4. Query INSERT (Variabel $lokasi_rak sekarang otomatis)
        $query = mysqli_query($koneksi, "INSERT INTO buku 
                 (isbn, judul, pengarang, penerbit, tahun_terbit, kategori, lokasi_rak, stok_total, stok_tersedia, foto) 
                 VALUES 
                 ('$isbn', '$judul', '$pengarang', '$penerbit', '$tahun', '$kategori', '$lokasi_rak', '$stok_total', '$stok_tersedia', '$nama_baru')");
        
        if ($query) {
            echo "<script>
                alert('Berhasil! Data buku telah tersimpan di $lokasi_rak.');
                window.location.href = 'index.php?link=buku';
            </script>";
        } else {
            $error = mysqli_error($koneksi);
            echo "<script>
                alert('Gagal Simpan! Error: $error');
                window.history.back();
            </script>";
        }
    } else {
        echo "<script>
            alert('Gagal memproses gambar. Pastikan format JPG/PNG.');
            window.history.back();
        </script>";
    }
}
?>