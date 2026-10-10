<?php
include '../inc/koneksi.php'; 

if (isset($_POST['simpan_lengkap'])) {
    
    // --- 1. DATA UNTUK TABEL USERS ---
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password     = md5($_POST['password']); 
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama']); // Dari name="nama"
    $status_aktif = $_POST['status_aktif']; // Dari name="status_aktif" (0/1)

    // --- 2. DATA UNTUK TABEL ANGGOTA ---
    $no_agt       = $_POST['no_anggota']; // Dari hidden input name="no_anggota"
    $tgl_daftar   = $_POST['tanggal_daftar']; // Dari hidden input name="tanggal_daftar"
    $kelas        = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $no_hp        = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    
    // Samakan status teks untuk tabel anggota (karena di modal pilihannya 0/1)
    $status_teks  = ($status_aktif == 1) ? 'aktif' : 'nonaktif';

    // --- 3. CEK USERNAME DUPLIKAT ---
    $cek = mysqli_query($koneksi, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah ada!'); window.history.back();</script>";
        exit;
    }

    // --- 4. INSERT KE TABEL USERS ---
    $sql_user = "INSERT INTO users (nama, username, password, email, role, status_aktif) 
                 VALUES ('$nama_lengkap', '$username', '$password', '$email', 'user', '$status_aktif')";
    
    if (mysqli_query($koneksi, $sql_user)) {
        
        // Ambil id_user yang barusan tercipta
        $id_user_baru = mysqli_insert_id($koneksi);

        // --- 5. INSERT KE TABEL ANGGOTA (Sesuai Struktur Tabelmu) ---
        $sql_agt = "INSERT INTO anggota (id_user, no_anggota, nama, kelas, no_hp, alamat, status, tanggal_daftar) 
                    VALUES ('$id_user_baru', '$no_agt', '$nama_lengkap', '$kelas', '$no_hp', '$alamat', '$status_teks', '$tgl_daftar')";
        
        if (mysqli_query($koneksi, $sql_agt)) {
            echo "<script>
                    alert('Berhasil! Anggota dan Akun Login sudah terdaftar.');
                    window.location.href='index.php?link=anggota'; 
                  </script>";
        } else {
            // Jika gagal di anggota, hapus user-nya supaya nggak jadi sampah
            $error = mysqli_error($koneksi);
            mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id_user_baru'");
            echo "Gagal di Tabel Anggota: " . $error;
        }

    } else {
        echo "Gagal di Tabel Users: " . mysqli_error($koneksi);
    }

} else {
    header("location:index.php?link=anggota");
}
?>