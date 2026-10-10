<div class="modal fade" id="modalCetak" tabindex="-1" aria-labelledby="modalCetakLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> 
        <div class="modal-content" style="border-radius: 20px; border: none; shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalCetakLabel">Filter Laporan Pengembalian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="dataprint.php" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">BERDASARKAN TANGGAL</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="date" name="tgl_mulai" class="form-control" style="border-radius: 10px;">
                            </div>
                            <div class="col-6">
                                <input type="date" name="tgl_selesai" class="form-control" style="border-radius: 10px;">
                            </div>
                        </div>
                        <div class="form-text" style="font-size: 0.7rem;">Kosongkan jika ingin cetak semua tanggal.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">NAMA ANGGOTA</label>
                        <select name="id_anggota" class="form-select" style="border-radius: 10px;">
                            <option value="">-- Semua Anggota --</option>
                            <?php 
                            $agt = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY nama ASC");
                            while($a = mysqli_fetch_array($agt)){
                                echo "<option value='".$a['id_anggota']."'>".$a['nama']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" style="border-radius: 10px; background-color: #ff896c; border: none;">Proses Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>