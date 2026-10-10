<?php
include 'inc/koneksi.php';

// Pastikan tombol submit di form daftar.php bernama "submit_daftar"
if (isset($_POST['submit_daftar'])) {
    
    // 1. Ambil Data & Proteksi (Anti SQL Injection)
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); // Menggunakan MD5 sesuai standar umum UKK
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas    = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $no_hp    = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat   = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    
    // Data Otomatis
    $role         = 'user'; // Otomatis Role Siswa
    $status_aktif = 1;      // Akun Langsung Aktif
    $tgl_sekarang = date('Y-m-d');
    $no_agt       = "AGT" . date('His'); // Membuat No Anggota Unik (Contoh: AGT104522)

    // 2. Cek apakah Username sudah ada agar tidak duplikat
    $cek_dulu = mysqli_query($koneksi, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek_dulu) > 0) {
        echo "<script>alert('Username sudah dipakai, cari yang lain!'); window.history.back();</script>";
        exit;
    }

    // 3. PROSES INSERT KE TABEL 'users' (Akun Login)
    // id_user tidak dimasukkan karena AUTO_INCREMENT
    $sql_user = "INSERT INTO users (nama, username, password, email, role, status_aktif) 
                 VALUES ('$nama', '$username', '$password', '$email', '$role', '$status_aktif')";
    
    if (mysqli_query($koneksi, $sql_user)) {
        
        // Ambil ID yang baru saja dibuat di tabel users
        $id_user_baru = mysqli_insert_id($koneksi);

        // 4. PROSES INSERT KE TABEL 'anggota' (Biodata)
        // id_anggota tidak dimasukkan karena AUTO_INCREMENT
        // id_user di sini diambil dari hasil insert di atas
        $sql_agt = "INSERT INTO anggota (id_user, no_anggota, nama, kelas, alamat, no_hp, tanggal_daftar, status) 
                    VALUES ('$id_user_baru', '$no_agt', '$nama', '$kelas', '$alamat', '$no_hp', '$tgl_sekarang', 'aktif')";
        
        if (mysqli_query($koneksi, $sql_agt)) {
            // JIKA KEDUANYA BERHASIL
            echo "<script>
                    alert('Selamat! Pendaftaran Berhasil. Silakan Login.');
                    window.location.href='index.php'; 
                  </script>";
        } else {
            // JIKA TABEL ANGGOTA GAGAL (Hapus User agar tidak jadi data sampah)
            $pesan_error = mysqli_error($koneksi);
            mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id_user_baru'");
            echo "Gagal Simpan Anggota: " . $pesan_error;
        }

    } else {
        // JIKA TABEL USERS GAGAL
        echo "Gagal Simpan Akun: " . mysqli_error($koneksi);
    }

} else {
    // Jika mencoba akses file ini langsung tanpa klik tombol daftar
    header("location:../daftar.php");
}
?>