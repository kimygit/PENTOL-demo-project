<?php
include '../inc/koneksi.php';

if (isset($_POST['update'])) {
    $id_buku      = $_POST['id_buku'];
    $isbn         = mysqli_real_escape_string($koneksi, $_POST['isbn']);
    $judul        = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang    = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $penerbit     = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $tahun        = $_POST['tahun_terbit'];
    $kategori     = $_POST['kategori'];
    $stok_total   = $_POST['stok_total'];
    $foto_lama    = $_POST['foto_lama'];

    // --- LOGIKA OTOMATIS LOKASI RAK BERDASARKAN KATEGORI (Sesuai Form Tambah) ---
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
            $lokasi_rak = "Rak Umum";
            break;
    }

    // Cek apakah ada file foto baru yang diupload
    if ($_FILES['foto']['name'] != "") {
        $nama_file = $_FILES['foto']['name'];
        $tmp_file  = $_FILES['foto']['tmp_name'];
        $type_file = $_FILES['foto']['type'];

        // Persiapkan nama file baru (WebP)
        $nama_baru = time() . ".webp";
        $folder    = "../asset/img/buku/" . $nama_baru;

        // Proses Konversi ke WebP (Fungsi Original Tetap Dijaga)
        if ($type_file == 'image/jpeg' || $type_file == 'image/jpg') {
            $img = imagecreatefromjpeg($tmp_file);
        } elseif ($type_file == 'image/png') {
            $img = imagecreatefrompng($tmp_file);
        } else {
            $img = @imagecreatefromstring(file_get_contents($tmp_file));
        }

        if ($img) {
            // Simpan file baru
            imagewebp($img, $folder, 80);
            imagedestroy($img);

            // Hapus foto lama agar storage tidak penuh
            if (file_exists("../asset/img/buku/" . $foto_lama)) {
                unlink("../asset/img/buku/" . $foto_lama);
            }
            
            $file_db = $nama_baru;
        } else {
            echo "<script>alert('Gagal memproses gambar baru.'); window.history.back();</script>";
            exit;
        }
    } else {
        // Jika tidak ganti foto, gunakan nama foto yang lama
        $file_db = $foto_lama;
    }

    // Query Update Data (lokasi_rak sekarang menggunakan variabel otomatis)
    $query = mysqli_query($koneksi, "UPDATE buku SET 
                isbn         = '$isbn',
                judul        = '$judul',
                pengarang    = '$pengarang',
                penerbit     = '$penerbit',
                tahun_terbit = '$tahun',
                kategori     = '$kategori',
                lokasi_rak   = '$lokasi_rak',
                stok_total   = '$stok_total',
                stok_tersedia = '$stok_total', 
                foto         = '$file_db'
                WHERE id_buku = '$id_buku'");

    if ($query) {
        echo '
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            ';
        echo "<script>
            setTimeout(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data buku berhasil diperbarui dan dipindahkan ke $lokasi_rak.',
                    icon: 'success'
                }).then(function() {
                    window.location = 'index.php?link=buku';
                });
            }, 100);
        </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>