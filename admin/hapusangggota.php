<?php
include '../inc/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Proteksi ID 1 (Jika ID 1 adalah akun default/umum)
    if ($id == 1) {
        echo "<script>alert('Data utama tidak boleh dihapus!'); window.location.href='admin.php?link=member';</script>";
        exit;
    }

    // 2. Cek riwayat di tabel peminjaman (sesuai gambar: id_anggota)
    $cek = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_anggota = '$id'");

    $query_agt = mysqli_query($koneksi, "SELECT id_user FROM anggota WHERE id_anggota = '$id'");
    $data_agt  = mysqli_fetch_assoc($query_agt);
    $id_user   = $data_agt['id_user'];

    if (mysqli_num_rows($cek) > 0) {
        // JIKA SUDAH PERNAH PINJAM BUKU -> SET NONAKTIF
        // Di gambar kamu ada kolom 'status', kita update itu
        $update = mysqli_query($koneksi, "UPDATE anggota SET status = 'nonaktif' WHERE id_anggota = '$id'");
        $update2 = mysqli_query($koneksi, "UPDATE users SET status_aktif = '0' WHERE id_user = '$id_user'");
        
        echo "<script>
                alert('Anggota ini memiliki riwayat peminjaman. Status diubah menjadi NONAKTIF.');
                window.location.href='index.php?link=anggota';
              </script>";
    } else {
        // JIKA BELUM PERNAH PINJAM -> HAPUS PERMANEN
        $hapus = mysqli_query($koneksi, "DELETE FROM anggota WHERE id_anggota = '$id'");
        $hapus2 = mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id_user'");

        if ($hapus) {
            echo "<script>
                    alert('Anggota berhasil dihapus permanen!');
                    window.location.href='index.php?link=anggota';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal hapus: " . mysqli_error($koneksi) . "');
                    window.history.back();
                  </script>";
        }
    }
}
?>