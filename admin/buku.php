<?php
include '../inc/koneksi.php';

// --- PROSES TAMBAH BUKU (DENGAN OPTIMASI WEBP & DATA LENGKAP) ---
if (isset($_POST['simpan'])) {
    $judul      = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang  = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $penerbit   = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $tahun      = $_POST['tahun_terbit'];
    $stok       = $_POST['stok_tersedia'];
    $isbn       = mysqli_real_escape_string($koneksi, $_POST['isbn']);
    $kategori   = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $rak        = mysqli_real_escape_string($koneksi, $_POST['lokasi_rak']);

    // Logika Upload & Konversi WebP
    $nama_file = $_FILES['foto']['name'];
    $tmp_file  = $_FILES['foto']['tmp_name'];
    $type_file = $_FILES['foto']['type'];
    
    $nama_baru = time() . ".webp"; 
    $folder    = "../asset/img/buku/" . $nama_baru;

    if ($type_file == 'image/jpeg' || $type_file == 'image/jpg') {
        $img = imagecreatefromjpeg($tmp_file);
    } elseif ($type_file == 'image/png') {
        $img = imagecreatefrompng($tmp_file);
    }

    if (isset($img)) {
        imagewebp($img, $folder, 80); 
        imagedestroy($img);
        
        $query = mysqli_query($koneksi, "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok_tersedia, foto, isbn, kategori, lokasi_rak) 
                  VALUES ('$judul', '$pengarang', '$penerbit', '$tahun', '$stok', '$nama_baru', '$isbn', '$kategori', '$rak')");
        
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
    
    if ($data['foto'] != "" && file_exists("../asset/img/buku/" . $data['foto'])) {
        unlink("../asset/img/buku/" . $data['foto']);
    }
    
    mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku = '$id'");
    echo "<script>window.location='index.php?link=buku';</script>";
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
<h3 style="color: #ff896c; padding-bottom: 10px;">Kelola Data Buku</h3>
    <button class="btn bg-pink text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#bukuTambah">
        <i class="bi bi-plus-circle"></i> Tambah Buku Baru
    </button>
</div>

<div class="card shadow-sm border-0" data-aos="fade-up">
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="tableBuku" class="table table-hover align-middle w-100">
                <thead class="bg-light"> 
                    <tr>
                        <th class="text-center">No</th>
                        <th>Sampul</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>ISBN</th>
                        <th>Kategori</th>
                        <th>Rak</th>                
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
                    while ($row = mysqli_fetch_array($sql)) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td> 
                            <img src="../asset/img/buku/<?= $row['foto']; ?>" class="rounded shadow-sm" width="50" height="70" style="object-fit: cover;">
                        </td>
                        <td><span class="fw-bold text-dark"><?= $row['judul']; ?></span></td> 
                        <td><?= $row['pengarang']; ?></td> 
                        <td><?= $row['tahun_terbit']; ?></td> 
                        <td><span class="badge bg-soft-pink text-pink border"><?= $row['stok_tersedia']; ?></span></td> 
                        <td><small class="text-muted font-monospace"><?= $row['isbn']; ?></small></td> 
                        <td><span class="badge bg-light text-secondary"><?= $row['kategori']; ?></span></td> 
                        <td><span class="badge bg-light text-dark border"><?= $row['lokasi_rak']; ?></span></td> 
                        <td class="text-center"> 
                            <div class="btn-group">
                                <a href="index.php?link=editbuku&id=<?= $row['id_buku']; ?>" class="text-primary me-2"><i class="bi bi-pencil-square"></i></a>
                                <a href="?link=buku&hapus=<?= $row['id_buku']; ?>" class="text-danger me-2" onclick="return confirm('Hapus buku ini?')"><i class="bi bi-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'tambahbuku.php';?>

<script>
    $(document).ready(function() {
        var table = $('#tableBuku').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Cari judul...",
                lengthMenu: "_MENU_ data per halaman",
            },
            columnDefs: [
                { targets: [1, 9], orderable: false },
                { targets: '_all', className: 'dt-head-center' }
            ]
        });

        $(window).on('resize', function() {
            table.columns.adjust().responsive.recalc();
        });

        $('.dataTables_filter input').addClass('form-control shadow-sm mb-3').css('width', '300px');
    });
</script>

<style>
    .bg-pink { background-color: #ff896c; }
    .text-pink { color: #ff896c; }
    .bg-soft-pink { background-color: #fff0ed; }
    .border-pink { border-color: #ff896c; }
    
    #tableBuku thead th {
        background-color: #f8f9fa;
        color: #333;
        font-size: 14px;
        white-space: nowrap;
    }
</style>