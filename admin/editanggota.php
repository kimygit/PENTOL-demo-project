<?php
include '../inc/koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='admin.php?link=member';</script>";
}
?>

<h3 style="color: #ff896c; padding-bottom: 10px; font-weight: bold;">Edit Anggota</h3>

<div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
    <form action="proses_editanggota.php" method="POST">
        <input type="hidden" name="id_anggota" value="<?= $data['id_anggota']; ?>">

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">NAMA LENGKAP</label>
                    <input type="text" name="nama" class="form-control py-2 shadow-none" value="<?= $data['nama']; ?>" required style="border-radius: 10px;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">KELAS / JABATAN</label>
                    <input type="text" name="kelas" class="form-control py-2 shadow-none" value="<?= $data['kelas']; ?>" required style="border-radius: 10px;">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">NOMOR HP</label>
                    <input type="number" name="no_hp" class="form-control py-2 shadow-none" value="<?= $data['no_hp']; ?>" required style="border-radius: 10px;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">ALAMAT</label>
                    <textarea name="alamat" class="form-control shadow-none" rows="1" required style="border-radius: 10px;"><?= $data['alamat']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">STATUS</label>
                    <select name="status" class="form-select py-2 shadow-none" style="border-radius: 10px;">
                        <option value="aktif" <?= $data['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                        <option value="nonaktif" <?= $data['status'] == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" name="update" class="btn text-white px-4 py-2" style="background-color: #ff896c; border-radius: 10px;">
                <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
            <a href="admin.php?link=member" class="btn btn-light px-4 py-2" style="border-radius: 10px;">Batal</a>
        </div>
    </form>
</div>