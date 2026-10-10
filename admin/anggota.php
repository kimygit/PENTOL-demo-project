<h3 style="color: #ff896c; padding-bottom: 10px;">Manajemen Anggota</h3>

<div class="card border-0 shadow-sm p-4" data-aos="fade-up" style="border-radius: 20px;">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <h5 class="fw-bold text-navy mb-0">Daftar Anggota</h5>

        <div class="d-flex align-items-center gap-2">
            <div class="input-group input-group-sm" style="width: 250px;">
                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="customSearchAnggota" class="form-control border-start-0" placeholder="Cari nama Anggota..." style="border-radius: 0 10px 10px 0;">
            </div>
                <button data-bs-toggle="modal" data-bs-target="#anggotaTambah" class="btn btn-sm bg-pink text-white px-3 shadow-sm" style="border-radius: 10px; height: 31px; background-color: #ff896c; border: none;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="tabelAnggota" class="table table-hover align-middle" style="width:100%">
            <thead class="table-light">
                <tr>
                    <th width="30">No</th>
                    <th>No. Anggota</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>No. HP</th>
                    <th>Status</th>
                    <th class="text-center">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                // Query disesuaikan dengan nama tabel 'anggota'
                $query = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id_anggota DESC");
                while($row = mysqli_fetch_assoc($query)) {
                    // Logika warna badge status
                    $badgeColor = ($row['status'] == 'Aktif') ? 'bg-success' : 'bg-danger';
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><code class="text-primary fw-bold"><?= $row['no_anggota']; ?></code></td>
                    <td>
                        <div class="fw-bold text-navy"><?= $row['nama']; ?></div>
                        <small class="text-muted"><i class="bi bi-geo-alt me-1"></i><?= $row['alamat']; ?></small>
                    </td>
                    <td><span class="badge bg-light text-dark border"><?= $row['kelas']; ?></span></td>
                    <td><small><?= $row['no_hp']; ?></small></td>
                    <td><span class="badge <?= $badgeColor; ?> opacity-75"><?= $row['status']; ?></span></td>
                    <td class="text-center">
                        <a href="index.php?link=editanggota&id=<?= $row['id_anggota']; ?>" class="text-primary me-2 fs-5" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="hapusangggota.php?id=<?= $row['id_anggota']; ?>" class="text-danger fs-5" title="Hapus" onclick="return confirm('Hapus anggota <?= $row['nama']; ?>?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'tambahanggota.php';?>
<script>
$(document).ready(function() {
    var table = $('#tabelAnggota').DataTable({
        "responsive": true,
        "paging": true,
        "pageLength": 10,
        "info": true,
        "dom": "rti", // Menghilangkan filter & lengthMenu bawaan agar pakai custom search di atas
        "language": {
            "info": "Menampilkan _TOTAL_ Anggota",
            "zeroRecords": "Data anggota tidak ditemukan"
        }
    });

    // Custom Search: Fokus ke kolom Nama (index 2) dan No Anggota (index 1)
    $('#customSearchAnggota').on('keyup', function() {
        table.search($(this).val()).draw();
    });
});
</script>

<style>
    .bg-pink { background-color: #ff896c !important; }
    .bg-pink:hover { background-color: #e87b60 !important; }
    .text-navy { color: #2c3e50; }
    #tabelAnggota thead th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(255, 137, 108, 0.05);
    }
</style>