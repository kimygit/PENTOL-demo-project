<?php
include '../inc/koneksi.php';

// --- PROSES TAMBAH BUKU (DENGAN OPTIMASI WEBP) ---
if (isset($_POST['simpan'])) {
    $judul      = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang  = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $penerbit   = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $tahun      = $_POST['tahun_terbit'];
    $stok       = $_POST['stok_tersedia'];

    // Logika Upload & Konversi WebP
    $nama_file = $_FILES['foto']['name'];
    $tmp_file  = $_FILES['foto']['tmp_name'];
    $type_file = $_FILES['foto']['type'];
    
    $ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
    $nama_baru = time() . ".webp"; // Rename ke .webp
    $folder    = "../asset/img/buku/" . $nama_baru;

    if ($type_file == 'image/jpeg' || $type_file == 'image/jpg') {
        $img = imagecreatefromjpeg($tmp_file);
    } elseif ($type_file == 'image/png') {
        $img = imagecreatefrompng($tmp_file);
    }

    if (isset($img)) {
        imagewebp($img, $folder, 80); // Konversi ke WebP kualitas 80%
        imagedestroy($img);
        
        $query = mysqli_query($koneksi, "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok_tersedia, foto) 
                  VALUES ('$judul', '$pengarang', '$penerbit', '$tahun', '$stok', '$nama_baru')");
        
        if ($query) {
            echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Buku baru telah ditambahkan',
                        icon: 'success'
                    }).then(function() {
                        window.location = 'index.php?link=buku';
                    });
                }, 100);
            </script>";
        }
    }
}

// --- PROSES HAPUS BUKU ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $ambil = mysqli_query($koneksi, "SELECT foto FROM buku WHERE id_buku = '$id'");
    $data = mysqli_fetch_assoc($ambil);
    
    if ($data['foto'] != "") {
        unlink("../asset/img/buku/" . $data['foto']);
    }
    
    mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku = '$id'");
    echo "<script>window.location='index.php?link=buku';</script>";
}
?>

<div class="d-flex justify-content-between align-items-center mb-4" >
<h3 style="color: #ff896c; padding-bottom: 10px;">Kelola Data Buku</h3>
    <button class="btn bg-pink text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#bukuTambah">
        <i class="bi bi-plus-circle"></i> Tambah Buku
    </button>
</div>

<div class="table-responsive p-3" data-aos="fade-up">
    <table id="tableBuku" class="table table-hover align-middle" style="width:100%">
        <thead style="background-color: #ffffff; color: white;"> 
            <tr>
                <th class="py-3 px-3">No</th>
                <th class="py-3">Sampul</th>
                <th class="py-3">Judul Buku</th>
                <th class="py-3">Pengarang</th>
                <th class="py-3">Tahun</th>
                <th class="py-3">Stok</th>
                <th class="py-3">ISBN</th>
                <th class="py-3">Kategori</th>
                <th class="py-3">Rak</th>                
                <th class="py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sql = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
            while ($row = mysqli_fetch_array($sql)) {
            ?>
            <tr>
                <td class="px-3"><?= $no++; ?></td> <td> <img src="../asset/img/buku/<?= $row['foto']; ?>" class="rounded shadow-sm" width="50" height="70" style="object-fit: cover;">
                </td>
                <td><span class="fw-bold"><?= $row['judul']; ?></span></td> 
                <td><?= $row['pengarang']; ?></td> <td><?= $row['tahun_terbit']; ?></td> 
                <td><span class="badge bg-light text-dark border"><?= $row['stok_tersedia']; ?></span></td> 
                <td><small class="text-muted"><?= $row['isbn']; ?></small></td> <td><?= $row['kategori']; ?></td> 
                <td><span class="badge bg-light text-dark border"><?= $row['lokasi_rak']; ?></span></td> <td class="text-center"> 
                <a href="hapusbuku.php?id=<?= $row['id_buku']; ?>" class="text-danger me-2" onclick="return confirm('Yakin ingin menghapus buku <?= $row['judul']; ?>?')">
                <i class="bi bi-trash"></i>
                </a>
                <a href="index.php?link=editbuku&id=<?= $row['id_buku']; ?>" class="text-primary me-2"><i class="bi bi-pencil-square"></i></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<style>
    /* Agar header tabel kelihatan teksnya (Putih di atas Pink) */
    #tableBuku thead th {
        color: #000000 !important;
        font-weight: 600;
        border: none;
    }
</style>

<?php include 'tambahbuku.php';?>

<script>
    $(document).ready(function() {
        var table = $('#tableBuku').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari judul buku...",
                lengthMenu: "Tampilkan _MENU_ data",
            },
            // Mengatur agar pencarian hanya fokus ke kolom Judul Buku (Index kolom ke-2)
            columnDefs: [
                {
                    targets: [2], // Target kolom Judul Buku
                    searchable: true
                },
                {
                    targets: '_all',
                    searchable: true // Set false jika ingin kolom lain tidak bisa di-search
                }
            ]
        });

        // Contoh: Jika ingin membuat input search custom sendiri di luar DataTables
        $('.dataTables_filter input').addClass('form-control shadow-sm border-pink');
    });
</script>