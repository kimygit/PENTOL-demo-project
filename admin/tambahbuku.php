<div class="modal fade" id="bukuTambah" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered"> 
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header bg-pink text-white pb-3">
                <h6 class="modal-title fw-bold"><i class="bi bi-book-half me-2"></i>Tambah Buku Baru</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="proses_tambahbuku.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body py-4">
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">ISBN</label>
                            <input type="text" name="isbn" class="form-control form-control-sm border-pink" placeholder="Nomor ISBN" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select form-select-sm border-pink" required>
                                <option value="" selected disabled>Pilih...</option>
                                <option value="Novel">Novel</option>
                                <option value="Pelajaran">Pelajaran</option>
                                <option value="Sains">Sains</option>
                                <option value="Komik">Komik</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul Lengkap</label>
                        <input type="text" name="judul" class="form-control form-control-sm border-pink" placeholder="Masukkan judul buku" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Pengarang</label>
                            <input type="text" name="pengarang" class="form-control form-control-sm border-pink" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control form-control-sm border-pink" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control form-control-sm border-pink" value="<?= date('Y'); ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Jumlah Stok</label>
                            <input type="number" name="stok_tersedia" class="form-control form-control-sm border-pink" placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold">Sampul Buku</label>
                        <input type="file" name="foto" class="form-control form-control-sm border-pink" accept="image/*" required>
                        <div style="font-size: 0.65rem;" class="mt-1 text-muted italic">Format: JPG/PNG. Otomatis konversi ke <strong>WebP</strong>.</div>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light py-2">
                    <button type="button" class="btn btn-sm btn-light fw-bold text-muted px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" class="btn btn-sm bg-pink text-white fw-bold px-4 shadow-sm" style="border-radius: 8px;">
                        <i class="bi bi-plus-lg me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Styling tambahan untuk menjaga konsistensi */
    .border-pink {
        border-color: #ff896c44 !important;
    }
    .border-pink:focus {
        border-color: #ff896c !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 137, 108, 0.25);
    }
    .bg-pink {
        background-color: #ff896c !important;
    }
</style>