<?php
include '../inc/koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php?link=buku';</script>";
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold" style="color: #ff896c;">
            <i class="bi bi-pencil-square me-2"></i>Edit Data Buku
        </h3>
        <a href="index.php?link=buku" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="proses_editbuku.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_buku" value="<?= $data['id_buku']; ?>">
                <input type="hidden" name="foto_lama" value="<?= $data['foto']; ?>">

                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Nomor ISBN</label>
                                <input type="text" name="isbn" class="form-control form-control-lg fs-6 shadow-none" value="<?= $data['isbn']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Kategori Buku</label>
                                <select name="kategori" class="form-select form-select-lg fs-6 shadow-none" required>
                                    <option value="Novel" <?= ($data['kategori'] == 'Novel') ? 'selected' : ''; ?>>Novel</option>
                                    <option value="Pelajaran" <?= ($data['kategori'] == 'Pelajaran') ? 'selected' : ''; ?>>Pelajaran</option>
                                    <option value="Sains" <?= ($data['kategori'] == 'Sains') ? 'selected' : ''; ?>>Sains</option>
                                    <option value="Komik" <?= ($data['kategori'] == 'Komik') ? 'selected' : ''; ?>>Komik</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Judul Lengkap Buku</label>
                            <input type="text" name="judul" class="form-control form-control-lg fs-6 shadow-none" value="<?= $data['judul']; ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Nama Pengarang</label>
                                <input type="text" name="pengarang" class="form-control shadow-none" value="<?= $data['pengarang']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Penerbit</label>
                                <input type="text" name="penerbit" class="form-control shadow-none" value="<?= $data['penerbit']; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control shadow-none" value="<?= $data['tahun_terbit']; ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-secondary">Total Stok</label>
                                <input type="number" name="stok_total" class="form-control shadow-none" value="<?= $data['stok_total']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 border-start ps-lg-4">
                        <label class="form-label fw-semibold text-secondary d-block">Sampul Buku Saat Ini</label>
                        <div class="text-center mb-3">
                            <img src="../asset/img/buku/<?= $data['foto']; ?>" class="rounded-3 shadow-sm border p-1 mb-3" style="width: 180px; height: 250px; object-fit: cover;">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Ganti Sampul (PNG/JPG)</label>
                            <input type="file" name="foto" class="form-control shadow-none" accept="image/*">
                            <div class="form-text mt-2 text-muted small">
                                *Kosongkan jika tidak ingin mengganti gambar.<br>
                                *Sistem otomatis mengoptimasi ke format <b>WebP</b>.
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-25">

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-light rounded-pill px-4">Reset</button>
                    <button type="submit" name="update" class="btn bg-pink text-white rounded-pill px-5 shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom style sesuai tema */
    .bg-pink {
        background-color: #ff896c !important;
        border: none;
    }
    .bg-pink:hover {
        background-color: #e87b60 !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #ff896c;
        box-shadow: 0 0 0 0.25rem rgba(255, 137, 108, 0.1);
    }
    .card {
        border-radius: 15px;
    }
    input::placeholder {
        font-size: 0.9rem;
        opacity: 0.6;
    }
</style>