<?php
include '../inc/koneksi.php'; // Sesuaikan path koneksi kamu

// Tombol submit di Modal tadi namanya "simpan_lengkap"
if (isset($_POST['simpan_lengkap'])) {
    
    // 1. Ambil Data & Proteksi (Anti SQL Injection)
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']); 
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas    = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $no_hp    = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat   = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    
    // Ambil status dari Modal (0 atau 1)
    $status_aktif = $_POST['status_aktif'];
    
    // Konversi angka status_aktif ke teks 'aktif' atau 'nonaktif' untuk tabel anggota
    $status_teks = ($status_aktif == 1) ? 'aktif' : 'nonaktif';

    // Data Otomatis dari Hidden Input Modal
    $role         = 'user'; 
    $tgl_sekarang = $_POST['tanggal_daftar'];
    $no_agt       = $_POST['no_anggota']; 

    // 2. Cek apakah Username sudah ada
    $cek_dulu = mysqli_query($koneksi, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek_dulu) > 0) {
        echo "<script>alert('Username sudah dipakai, cari yang lain!'); window.history.back();</script>";
        exit;
    }

    // 3. PROSES INSERT KE TABEL 'users' (Akun Login)
    $sql_user = "INSERT INTO users (nama, username, password, email, role, status_aktif) 
                 VALUES ('$nama', '$username', '$password', '$email', '$role', '$status_aktif')";
    
    if (mysqli_query($koneksi, $sql_user)) {
        
        // Ambil ID yang baru saja dibuat di tabel users
        $id_user_baru = mysqli_insert_id($koneksi);

        // 4. PROSES INSERT KE TABEL 'anggota' (Biodata)
        $sql_agt = "INSERT INTO anggota (id_user, no_anggota, nama, kelas, alamat, no_hp, tanggal_daftar, status) 
                    VALUES ('$id_user_baru', '$no_agt', '$nama', '$kelas', '$alamat', '$no_hp', '$tgl_sekarang', '$status_teks')";
        
        if (mysqli_query($koneksi, $sql_agt)) {
            // JIKA KEDUANYA BERHASIL
            echo "<script>
                    alert('Data Anggota Baru Berhasil Disimpan!');
                    window.location.href='index.php?link=anggota'; 
                  </script>";
        } else {
            // JIKA TABEL ANGGOTA GAGAL (Hapus User agar tidak jadi data sampah)
            $pesan_error = mysqli_error($koneksi);
            mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id_user_baru'");
            echo "<script>alert('Gagal Simpan Anggota: $pesan_error'); window.history.back();</script>";
        }

    } else {
        // JIKA TABEL USERS GAGAL
        echo "<script>alert('Gagal Simpan Akun: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
    }

} else {
    header("location:index.php?link=anggota");
}
?>