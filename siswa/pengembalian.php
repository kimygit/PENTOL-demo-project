<?php
// pengembalian.php
// Pastikan koneksi sudah disertakan di file utama/index
// $id_agt ambil dari session yang login
$id_agt = $_SESSION['id_anggota'];
$tgl_sekarang = date('Y-m-d');
?>

<div class="container-fluid p-4">
    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold text-dark" data-aos="fade-down">Pinjaman Aktif</h3>
            <p class="text-muted" data-aos="fade-down">Buku yang sedang kamu bawa. Jika terlambat, denda akan muncul otomatis.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;" data-aos="fade-up">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Buku</th>
                        <th class="text-center">Qty</th>
                        <th>Deadline Kembali</th>
                        <th class="text-center">Status / Denda</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // QUERY UTAMA: Join ke pengembalian untuk cek kolom status_kembali
                    $sql = mysqli_query($koneksi, "SELECT 
                        p.id_pinjam, 
                        p.tanggal_jatuh_tempo, 
                        p.status_pinjam,
                        dp.Qty, 
                        b.judul, 
                        b.foto, 
                        pg.status_kembali 
                        FROM peminjaman p
                        JOIN detail_peminjaman dp ON p.id_pinjam = dp.id_pinjam
                        JOIN buku b ON dp.id_buku = b.id_buku
                        LEFT JOIN pengembalian pg ON p.id_pinjam = pg.id_pinjam
                        WHERE p.id_anggota = '$id_agt' AND p.status_pinjam = 'dipinjam'");

                    if (!$sql) {
                        echo "<tr><td colspan='5' class='text-center py-4 text-danger'>Kesalahan Query: " . mysqli_error($koneksi) . "</td></tr>";
                    } elseif (mysqli_num_rows($sql) == 0) {
                        echo "<tr><td colspan='5' class='text-center py-5 text-muted'>Tidak ada pinjaman aktif.</td></tr>";
                    } else {
                        while($data = mysqli_fetch_array($sql)) {
                            $qty = (int)$data['Qty'];
                            $denda = 0;
                            $selisih = 0;
                            $tgl_deadline = $data['tanggal_jatuh_tempo'];
                            
                            // Cek apakah status di tabel pengembalian adalah 'pending'
                            $is_pending = ($data['status_kembali'] == 'pending');

                            // Hitung denda HANYA jika status belum pending
                            if(!$is_pending && $tgl_sekarang > $tgl_deadline) {
                                $t1 = strtotime($tgl_sekarang);
                                $t2 = strtotime($tgl_deadline);
                                $selisih = floor(($t1 - $t2) / (60*60*24));
                                $denda = ($selisih * 1000) * $qty; 
                            }
                        ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <?php 
                                        $path_foto = "../asset/img/buku/" . $data['foto'];
                                        $foto = (!empty($data['foto']) && file_exists($path_foto)) ? $path_foto : "../asset/img/no-book.jpg";
                                    ?>
                                    <img src="<?= $foto; ?>" width="45" class="rounded me-3 shadow-sm">
                                    <div>
                                        <span class="fw-bold d-block"><?= $data['judul']; ?></span>
                                        <small class="badge bg-secondary" style="font-size: 0.6rem;">ID: #<?= $data['id_pinjam']; ?></small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold"><?= $qty; ?></span>
                            </td>
                            <td>
                                <span class="text-dark fw-bold"><?= date('d M Y', strtotime($tgl_deadline)); ?></span>
                            </td>
                            <td class="text-center">
                                <?php if($is_pending): ?>
                                    <div class="badge bg-warning text-dark px-3 py-2">
                                        <i class="bi bi-clock-history"></i> MENUNGGU KONFIRMASI
                                    </div>
                                    <div class="text-muted small mt-1">Bawa buku ke petugas perpus</div>
                                <?php elseif($denda > 0): ?>
                                    <div class="badge bg-danger px-3 py-2 mb-1">
                                        <i class="bi bi-exclamation-triangle-fill"></i> TERLAMBAT <?= $selisih ?> HARI
                                    </div>
                                    <div class="text-danger fw-bold d-block">Denda: Rp <?= number_format($denda, 0, ',', '.'); ?></div>
                                <?php else: ?>
                                    <div class="badge bg-success px-3 py-2">
                                        <i class="bi bi-check-circle-fill"></i> SEDANG DIPINJAM
                                    </div>
                                    <div class="text-success small mt-1 d-block">Kembalikan tepat waktu</div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($is_pending): ?>
                                    <button class="btn btn-secondary btn-sm fw-bold px-3 shadow-sm" style="border-radius: 10px;" disabled>
                                        Diproses...
                                    </button>
                                <?php else: ?>
                                    <form action="proses_kembali.php" method="POST">
                                        <input type="hidden" name="id_pinjam" value="<?= $data['id_pinjam']; ?>">
                                        <input type="hidden" name="denda_total" value="<?= $denda; ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm fw-bold px-3 shadow-sm" 
                                                style="border-radius: 10px;"
                                                onclick="return confirm('Apakah kamu ingin mengajukan pengembalian buku ini?')">
                                           Kembalikan
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php 
                        } 
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<link rel="stylesheet" href="../asset/css/peminjaman.css" />