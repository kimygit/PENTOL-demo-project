<?php
include '../inc/koneksi.php';

// Cek koneksi
if (!$koneksi) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 style="color: #ff896c;">Data Transaksi Pengembalian</h3>
    <div>
        <button data-bs-toggle="modal" data-bs-target="#modalCetak" class="btn btn-dark px-3 py-2 shadow-sm" style="border-radius: 10px;">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
</button>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;" data-aos="fade-up">
    <div class="table-responsive p-4">
        <table class="table table-hover align-middle">
            <thead class="bg-light text-muted small text-uppercase">
                <tr>
                    <th class="border-0">No</th>
                    <th class="border-0">Nama Anggota</th>
                    <th class="border-0">Judul Buku</th>
                    <th class="border-0">Tgl Kembali</th>
                    <th class="border-0">Denda</th>
                    <th class="border-0">Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                
                // Query disesuaikan dengan struktur tabel pengembalian Anda
                    $sql = "SELECT 
                                pengembalian.*, 
                                anggota.nama, 
                                buku.judul 
                            FROM pengembalian 
                            JOIN peminjaman ON pengembalian.id_pinjam = peminjaman.id_pinjam
                            JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota 
                            JOIN detail_peminjaman ON peminjaman.id_pinjam = detail_peminjaman.id_pinjam
                            JOIN buku ON detail_peminjaman.id_buku = buku.id_buku 
                            WHERE pengembalian.status_kembali != 'pending' 
                            ORDER BY pengembalian.id_kembali DESC";

                $query = mysqli_query($koneksi, $sql);

                if (!$query) {
                    echo "<tr><td colspan='6' class='text-danger fw-bold text-center py-4'>";
                    echo "Terjadi Kesalahan Query: " . mysqli_error($koneksi);
                    echo "</td></tr>";
                } else if (mysqli_num_rows($query) == 0) {
                    echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada data pengembalian.</td></tr>";
                } else {
                    while($row = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <div class="fw-bold text-navy"><?= $row['nama']; ?></div>
                        <small class="text-muted">ID Pinjam: #<?= $row['id_pinjam']; ?></small>
                    </td>
                    <td style="max-width: 200px;"><?= $row['judul']; ?></td>
                    <td><?= date('d/m/Y', strtotime($row['tanggal_kembali'])); ?></td>
                    <td>
                        <?php if($row['denda_total'] > 0): ?>
                            <span class="text-danger fw-bold">Rp <?= number_format($row['denda_total'], 0, ',', '.'); ?></span>
                        <?php else: ?>
                            <span class="text-success fw-bold">Rp 0</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge bg-light text-muted border px-2 py-1" style="font-weight: normal;">
                            <?= $row['catatan'] ? $row['catatan'] : 'Tidak ada catatan'; ?>
                        </span>
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
<?php include 'cetak_laporan.php';?>
<style>
    .text-navy { color: #2c3e50; }
    .table thead th { font-weight: 600; font-size: 11px; letter-spacing: 0.5px; }
    .table tbody td { font-size: 14px; padding: 15px 10px; }
</style>