<?php
$id_agt = $_SESSION['id_anggota'];
$tgl_sekarang = date('Y-m-d');

// 1. Hitung Buku Sedang Dipinjam (Tetap di tabel peminjaman)
$sql_pinjam = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_anggota='$id_agt' AND status_pinjam='dipinjam'");
$jml_pinjam = mysqli_num_rows($sql_pinjam);

// 2. HITUNG BUKU SUDAH KEMBALI
$sql_kembali = mysqli_query($koneksi, "SELECT * FROM pengembalian 
               JOIN peminjaman ON pengembalian.id_pinjam = peminjaman.id_pinjam 
               WHERE peminjaman.id_anggota='$id_agt'");
$jml_kembali = mysqli_num_rows($sql_kembali);

// 3. Logika Hitung Total Denda
$total_denda = 0;
$sql_denda = mysqli_query($koneksi, "SELECT tanggal_jatuh_tempo FROM peminjaman WHERE id_anggota='$id_agt' AND status_pinjam='dipinjam'");

while($d = mysqli_fetch_array($sql_denda)) {
    $tgl_deadline = $d['tanggal_jatuh_tempo'];
    if($tgl_sekarang > $tgl_deadline) {
        $detik_sekarang = strtotime($tgl_sekarang);
        $detik_deadline = strtotime($tgl_deadline);
        $selisih_hari = floor(($detik_sekarang - $detik_deadline) / (60*60*24));
        $total_denda += ($selisih_hari * 1000); 
    }
}
?>

<div class="container-fluid p-4">
    <div class="row mb-4" data-aos="fade-down">
        <div class="col">
            <h2 class="fw-bold text-dark">Ringkasan Aktivitas</h2>
            <p class="text-muted">Pantau status peminjaman dan tanggungan denda kamu di sini.</p>
        </div>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-white" style="border-left: 5px solid #0d6efd; border-radius: 15px;">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-light text-primary me-3"><i class="bi bi-book fs-4"></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold"><?php echo $jml_pinjam; ?></h4>
                        <small class="text-muted">Sedang Dipinjam</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 bg-white" style="border-left: 5px solid #198754; border-radius: 15px;">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-light text-success me-3"><i class="bi bi-arrow-return-left fs-4"></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold"><?php echo $jml_kembali; ?></h4>
                        <small class="text-muted">Sudah Kembali</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 <?php echo ($total_denda > 0) ? 'bg-danger text-white' : 'bg-white'; ?>" style="border-radius: 15px;">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-light text-danger me-3"><i class="bi bi-exclamation-triangle fs-4"></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold text-<?php echo ($total_denda > 0) ? 'white' : 'danger'; ?>">Rp <?php echo number_format($total_denda, 0, ',', '.'); ?></h4>
                        <small class="<?php echo ($total_denda > 0) ? 'text-white' : 'text-muted'; ?>">Total Denda</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" data-aos="fade-up">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-header bg-white py-3 text-center border-0">
                    <h5 class="mb-0 fw-bold">Riwayat Peminjaman Terbaru</h5>
                </div>
                <div class="table-responsive p-0">
                    <table class="table table-hover mb-0 align-middle text-center">
                        <thead class="table-light text-uppercase" style="font-size: 0.75rem;">
                            <tr>
                                <th class="ps-4 text-start">Judul Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Info Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql_list = mysqli_query($koneksi, "SELECT * FROM peminjaman 
                                        JOIN detail_peminjaman ON peminjaman.id_pinjam = detail_peminjaman.id_pinjam
                                        JOIN buku ON detail_peminjaman.id_buku = buku.id_buku
                                        WHERE peminjaman.id_anggota = '$id_agt'
                                        ORDER BY peminjaman.id_pinjam DESC LIMIT 5");
                            
                            while($row = mysqli_fetch_array($sql_list)){
                                $status_raw = strtolower($row['status_pinjam']); // Memastikan case-insensitive
                                $is_telat = ($tgl_sekarang > $row['tanggal_jatuh_tempo'] && $status_raw == 'dipinjam');
                            ?>
                            <tr>
                                <td class="ps-4 text-start">
                                    <div class="d-flex align-items-center">
                                        <img src="../asset/img/buku/<?php echo $row['foto']; ?>" width="35" class="rounded me-2 shadow-sm">
                                        <span class="fw-bold"><?php echo $row['judul']; ?></span>
                                    </div>
                                </td>
                                <td><?php echo $row['tanggal_pinjam']; ?></td>
                                <td><?php echo $row['tanggal_jatuh_tempo']; ?></td>
                                <td>
                                    <?php if($status_raw == 'dipinjam'): ?>
                                        <span class="badge rounded-pill bg-primary px-3">Dipinjam</span>
                                    <?php elseif($status_raw == 'pending'): ?>
                                        <span class="badge rounded-pill bg-warning text-dark px-3">Pending</span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill bg-success px-3">Dikembalikan</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($is_telat): 
                                        $s_hari = floor((strtotime($tgl_sekarang) - strtotime($row['tanggal_jatuh_tempo'])) / (60*60*24));
                                        $denda_row = $s_hari * 1000;
                                    ?>
                                        <span class="text-danger fw-bold small">
                                            <i class="bi bi-x-circle"></i> Rp <?php echo number_format($denda_row, 0, ',', '.'); ?>
                                            <br><small>(<?php echo $s_hari; ?> Hari)</small>
                                        </span>
                                    <?php elseif($status_raw == 'pending'): ?>
                                        <span class="text-muted small">Menunggu Approval</span>
                                    <?php elseif($status_raw == 'kembali' || $status_raw == 'dikembalikan'): ?>
                                        <span class="text-muted small">-</span>
                                    <?php else: ?>
                                        <span class="text-success small">Aman</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>