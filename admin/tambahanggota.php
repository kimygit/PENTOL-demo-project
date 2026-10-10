<div class="modal fade" id="anggotaTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered"> 
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header bg-pink text-white pb-3">
                <h6 class="modal-title fw-bold">
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Anggota Baru
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="proses_tambahanggota.php" method="POST">
                <div class="modal-body py-4 px-4">
                    
                    <?php
                        // Logika nomor otomatis tetap dipertahankan
                        $q_id = mysqli_query($koneksi, "SELECT max(id_anggota) as id FROM anggota");
                        $d_id = mysqli_fetch_array($q_id);
                        $no_baru = "AG-" . date('ymd') . "-" . sprintf("%03s", ($d_id['id'] + 1));
                    ?>

                    <input type="hidden" name="no_anggota" value="<?= $no_baru; ?>">
                    <input type="hidden" name="tanggal_daftar" value="<?= date('Y-m-d'); ?>">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-sm border-pink" placeholder="Masukkan nama lengkap siswa" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Kelas</label>
                            <input type="text" name="kelas" class="form-control form-control-sm border-pink" placeholder="XII RPL 1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Nomor HP</label>
                            <input type="number" name="no_hp" class="form-control form-control-sm border-pink" placeholder="08..." required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control form-control-sm border-pink" rows="2" placeholder="Alamat rumah..." required></textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold">Status Keanggotaan</label>
                        <select name="status" class="form-select form-select-sm border-pink" required>
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light py-2">
                    <button type="button" class="btn btn-sm btn-light fw-bold text-muted px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" class="btn btn-sm bg-pink text-white fw-bold px-4 shadow-sm rounded-pill">
                        <i class="bi bi-check-lg me-1"></i> Simpan Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Gunakan class yang sama dengan form buku untuk konsistensi */
    .border-pink {
        border-color: #ff896c44 !important;
        border-radius: 8px !important;
    }
    .border-pink:focus {
        border-color: #ffffff !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 137, 108, 0.25);
        background-color: #fff;
    }
    .bg-pink {
        background-color: #ffffff !important;
    }
</style>