<div class="container-fluid p-4">
    <div class="row mb-4">
        <div class="col">
            <h3 style="color: #ff896c; padding-bottom: 10px;">Konfirmasi Pengembalian</h3>
            <p class="text-muted">Daftar buku yang diajukan siswa untuk dikembalikan. Periksa fisik buku sebelum konfirmasi.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;" data-aos="fade-up">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Peminjam</th>
                        <th>Buku</th>
                        <th class="text-center">Qty</th>
                        <th>Total Denda</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_list = mysqli_query($koneksi, "SELECT pg.id_kembali, pg.denda_total, p.id_pinjam, a.nama as nama_siswa, a.kelas, b.judul, b.foto, dp.Qty 
                                FROM pengembalian pg
                                JOIN peminjaman p ON pg.id_pinjam = p.id_pinjam
                                JOIN anggota a ON p.id_anggota = a.id_anggota
                                JOIN detail_peminjaman dp ON p.id_pinjam = dp.id_pinjam
                                JOIN buku b ON dp.id_buku = b.id_buku
                                WHERE pg.status_kembali = 'pending'");

                    if (mysqli_num_rows($sql_list) == 0) {
                        echo "<tr><td colspan='5' class='text-center py-5 text-muted'>Tidak ada pengajuan pengembalian baru.</td></tr>";
                    } else {
                        while($row = mysqli_fetch_array($sql_list)) {
                            // Simpan data ke array sementara untuk modal di luar nanti
                            $data_modal[] = $row; 
                    ?>
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold d-block"><?= $row['nama_siswa']; ?></span>
                            <small class="text-muted"><?= $row['kelas']; ?></small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="../asset/img/buku/<?= $row['foto']; ?>" width="40" class="rounded me-2 shadow-sm">
                                <span class="small fw-bold"><?= $row['judul']; ?></span>
                            </div>
                        </td>
                        <td class="text-center"><span class="badge bg-secondary"><?= $row['Qty']; ?></span></td>
                        <td>
                            <?php if($row['denda_total'] > 0): ?>
                                <span class="text-danger fw-bold">Rp <?= number_format($row['denda_total'], 0, ',', '.'); ?></span>
                            <?php else: ?>
                                <span class="text-success small">Tanpa Denda</span>
                            <?php endif; ?>
                        </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">

                                        <button type="button" class="btn text-white btn-sm bg-success rounded-pill px-3 shadow-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalSelesai<?= $row['id_kembali']; ?>"> Setujui
                                        </button>
                                        <a href="proses_tolak_kembali.php?id_kembali=<?= $row['id_kembali']; ?>" 
                                            class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                            onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                                            Tolak
                                        </a>
                                    </div>
                                </div>
                            </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
if(!empty($data_modal)) {
    foreach($data_modal as $data) { 
?>
<div class="modal fade" id="modalSelesai<?= $data['id_kembali']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0 ps-4 pt-4">
                <h5 class="modal-title fw-bold">Konfirmasi Pengembalian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_persetujuan.php" method="POST">
                <div class="modal-body ps-4 pe-4">
                    <p class="text-muted small">Anda akan mengonfirmasi pengembalian buku: <br> 
                       <strong class="text-dark"><?= $data['judul']; ?></strong> oleh <strong><?= $data['nama_siswa']; ?></strong>
                    </p>
                    <input type="hidden" name="id_kembali" value="<?= $data['id_kembali']; ?>">
                    <input type="hidden" name="id_pinjam" value="<?= $data['id_pinjam']; ?>">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Catatan Admin (Opsional)</label>
                        <textarea name="catatan_admin" class="form-control" rows="3" placeholder="Contoh: Buku diterima dalam kondisi baik" style="border-radius: 10px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light btn-sm fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm text-white fw-bold px-4 shadow-sm" style="border-radius: 8px; background: var(--pink-wara);">Konfirmasi & Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } } ?>