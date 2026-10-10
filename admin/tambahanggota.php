<div class="modal fade" id="anggotaTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header bg-pink text-white pb-3">
                <h6 class="modal-title fw-bold">
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Anggota & Akun Login
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="proses_tambahanggota.php" method="POST">
                <div class="modal-body py-4 px-4">
                    
                    <?php
                        // Logika nomor otomatis
                        $q_id = mysqli_query($koneksi, "SELECT max(id_anggota) as id FROM anggota");
                        $d_id = mysqli_fetch_array($q_id);
                        $next_id = ($d_id['id'] ?? 0) + 1;
                        $no_baru = "AG-" . date('ymd') . "-" . sprintf("%03s", $next_id);
                    ?>

                    <input type="hidden" name="no_anggota" value="<?= $no_baru; ?>">
                    <input type="hidden" name="tanggal_daftar" value="<?= date('Y-m-d'); ?>">

                    <div class="row">
                        <div class="col-md-6 border-end pe-md-4">
                            <h6 class="mb-3 fw-bold small text-uppercase" style="color: #ff896c;">1. Informasi Login</h6>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Username</label>
                                <input type="text" name="username" class="form-control form-control-sm border-pink" placeholder="Buat username siswa" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Kata Sandi</label>
                                <input type="password" name="password" class="form-control form-control-sm border-pink" placeholder="Minimal 6 karakter" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Email</label>
                                <input type="email" name="email" class="form-control form-control-sm border-pink" placeholder="siswa@sekolah.com" required>
                            </div>
                            
                            <div class="mb-0">
                                <label class="form-label small fw-bold">Status Akun</label>
                                <select name="status_aktif" class="form-select form-select-sm border-pink" required>
                                    <option value="1" selected>Aktif (Bisa Login)</option>
                                    <option value="0">Nonaktif (Blokir)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-4 mt-4 mt-md-0">
                            <h6 class="mb-3 fw-bold small text-uppercase" style="color: #ff896c;">2. Data Pribadi</h6>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control form-control-sm border-pink" placeholder="Sesuai Akta/Ijazah" required>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small fw-bold">Kelas</label>
                                    <input type="text" name="kelas" class="form-control form-control-sm border-pink" placeholder="XII RPL 1" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold">No. HP</label>
                                    <input type="number" name="no_hp" class="form-control form-control-sm border-pink" placeholder="08..." required>
                                </div>
                            </div>

                            <div class="mb-0">
                                <label class="form-label small fw-bold">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control form-control-sm border-pink" rows="4" placeholder="Alamat lengkap rumah..." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light py-3">
                    <button type="button" class="btn btn-sm btn-light fw-bold text-muted px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan_lengkap" class="btn btn-sm btn-primary fw-bold px-4 shadow-sm rounded-pill" style="background-color: #ff896c; border: none;">
                        <i class="bi bi-check-lg me-1"></i> Daftarkan Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>