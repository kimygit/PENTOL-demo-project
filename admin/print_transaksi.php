<div class="modal fade" id="modalCetak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-navy mx-auto">Cetak Laporan Pengembalian</h5>
                <button type="button" class="btn-close ms-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <form action="dataprint.php" method="GET" target="_blank">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Mulai Tanggal:</label>
                            <input type="date" name="tgl_mulai" class="form-control shadow-sm" style="border-radius: 10px;" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Sampai Tanggal:</label>
                            <input type="date" name="tgl_selesai" class="form-control shadow-sm" style="border-radius: 10px;" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Filter Kelas (Opsional):</label>
                        <select name="kelas" class="form-select shadow-sm" style="border-radius: 10px;">
                            <option value="">Semua Kelas</option>
                            <?php
                            $k_list = mysqli_query($koneksi, "SELECT DISTINCT kelas FROM anggota ORDER BY kelas ASC");
                            while($k = mysqli_fetch_array($k_list)) {
                                echo "<option value='".$k['kelas']."'>".$k['kelas']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">Buku Spesifik:</label>
                        <select name="id_buku" class="form-select shadow-sm" style="border-radius: 10px;">
                            <option value="">Semua Buku</option>
                            <?php
                            $b_cetak = mysqli_query($koneksi, "SELECT id_buku, judul FROM buku ORDER BY judul ASC");
                            while($bc = mysqli_fetch_assoc($b_cetak)) {
                                echo "<option value='".$bc['id_buku']."'>".$bc['judul']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="d-flex gap-2 justify-content-center">
                        <button type="reset" class="btn btn-outline-secondary px-4 fw-bold" style="border-radius: 10px;">
                            Reset
                        </button>
                        <button type="submit" class="btn text-white px-4 fw-bold shadow-sm" style="border-radius: 10px; background: #ff896c;">
                            <i class="bi bi-printer me-2"></i> Cetak Laporan
                        </button>
                    </div>

                </form>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Data yang dicetak hanya yang sudah dikonfirmasi.</small>
            </div>
        </div>
    </div>
</div>