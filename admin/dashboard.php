<?php
include '../inc/koneksi.php';

$hari_ini = date('Y-m-d');

// 1. Total Koleksi Buku
$query_buku = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM buku");
$data_buku = mysqli_fetch_assoc($query_buku);
$total_buku = $data_buku['total'] ?? 0;

// 2. Peminjaman Hari Ini
$query_pinjam = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peminjaman WHERE tanggal_pinjam = '$hari_ini'");
$data_pinjam = mysqli_fetch_assoc($query_pinjam);
$peminjaman_hari_ini = $data_pinjam['total'] ?? 0;

// 3. Total Anggota
$query_anggota = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM anggota");
$data_anggota = mysqli_fetch_assoc($query_anggota);
$total_anggota = $data_anggota['total'] ?? 0;

// 4. Buku Sedang Dipinjam
$query_status = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM detail_peminjaman WHERE status_item = 'dipinjam'");
$data_status = mysqli_fetch_assoc($query_status);
$sedang_dipinjam = $data_status['total'] ?? 0;
?>

<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold" style="color: #ff896c;">Dashboard Admin</h2>
            <p class="text-muted small">Selamat datang kembali! Berikut ringkasan perpustakaan hari ini.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-light text-dark shadow-sm p-2 border">
                <i class="bi bi-calendar3 me-2"></i><?php echo date('d F Y'); ?>
            </span>
        </div>
    </div>

    <div class="row g-4 mb-5" data-aos="fade-up">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-white h-100" style="background:var(--pink-wara); border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-25 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-book fs-4"></i>
                    </div>
                    <p class="mb-1 small opacity-75 text-uppercase fw-bold">Koleksi Buku</p>
                    <h3 class="fw-bold mb-0"><?php echo number_format($total_buku, 0, ',', '.'); ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-white h-100" style="background:var(--pink-wara); border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-25 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-cart-plus fs-4"></i>
                    </div>
                    <p class="mb-1 small opacity-75 text-uppercase fw-bold">Pinjam Hari Ini</p>
                    <h3 class="fw-bold mb-0"><?php echo $peminjaman_hari_ini; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-white h-100" style="background:var(--pink-wara); border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-25 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <p class="mb-1 small opacity-75 text-uppercase fw-bold">Anggota</p>
                    <h3 class="fw-bold mb-0"><?php echo $total_anggota; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-white h-100" style="background:var(--pink-wara); border-radius: 20px;">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-25 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-arrow-repeat fs-4"></i>
                    </div>
                    <p class="mb-1 small opacity-75 text-uppercase fw-bold">Aktif Dipinjam</p>
                    <h3 class="fw-bold mb-0"><?php echo $sedang_dipinjam; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row" data-aos="fade-up" data-aos-delay="200">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="me-2 text-warning"></i>Monitoring Pinjaman Aktif</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">
                            <tr>
                                <th class="ps-4">Siswa</th>
                                <th>Buku</th>
                                <th class="text-center">Tgl Pinjam</th>
                                <th class="text-center">Jatuh Tempo</th>
                                <th class="text-center">Denda Estimasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Query menampilkan semua yang statusnya 'dipinjam' (Tanpa filter ID Siswa)
                            $sql_admin = mysqli_query($koneksi, "SELECT * FROM peminjaman 
                                        JOIN detail_peminjaman ON peminjaman.id_pinjam = detail_peminjaman.id_pinjam
                                        JOIN buku ON detail_peminjaman.id_buku = buku.id_buku
                                        JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota
                                        WHERE peminjaman.status_pinjam = 'dipinjam'
                                        ORDER BY peminjaman.tanggal_jatuh_tempo ASC LIMIT 10");
                            
                            if(mysqli_num_rows($sql_admin) > 0) {
                                while($row = mysqli_fetch_array($sql_admin)){
                                    $tgl_kembali = $row['tanggal_jatuh_tempo'];
                                    $is_telat = ($hari_ini > $tgl_kembali);
                                    $denda = 0;
                                    if($is_telat) {
                                        $selisih = floor((strtotime($hari_ini) - strtotime($tgl_kembali)) / (60*60*24));
                                        $denda = $selisih * 1000;
                                    }
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark"><?php echo $row['nama']; ?></div>
                                    <small class="text-muted"><?php echo $row['kelas']; ?></small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="../asset/img/buku/<?php echo $row['foto']; ?>" width="30" height="40" class="rounded me-2 shadow-sm" style="object-fit: cover;">
                                        <div class="text-truncate" style="max-width: 180px; font-size: 0.85rem;"><?php echo $row['judul']; ?></div>
                                    </div>
                                </td>
                                <td class="text-center small"><?php echo date('d/m/y', strtotime($row['tanggal_pinjam'])); ?></td>
                                <td class="text-center small">
                                    <span class="<?php echo $is_telat ? 'text-danger fw-bold' : ''; ?>">
                                        <?php echo date('d/m/y', strtotime($tgl_kembali)); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if($is_telat): ?>
                                        <span class="badge bg-danger rounded-pill">Rp <?php echo number_format($denda, 0, ',', '.'); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-success border border-success rounded-pill small">Lancar</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                                } 
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-4 text-muted small'>Tidak ada buku yang sedang dipinjam.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-stat {
        transition: transform 0.3s ease;
    }
    .card-stat:hover {
        transform: translateY(-5px);
    }
    .table thead th {
        border-top: none;
        color: #7f8c8d;
    }
    .table tbody td {
        border-bottom: 1px solid #f8f9fa;
        padding: 12px 8px;
    }
</style>