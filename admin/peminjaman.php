<?php
// Query mengambil data yang statusnya pending saja
$query_pending = mysqli_query($koneksi, "SELECT * FROM peminjaman 
    JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota
    JOIN detail_peminjaman ON peminjaman.id_pinjam = detail_peminjaman.id_pinjam
    JOIN buku ON detail_peminjaman.id_buku = buku.id_buku
    WHERE peminjaman.status_pinjam = 'pending'
    ORDER BY peminjaman.id_pinjam ASC");
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
<h3 style="color: #ff896c; padding-bottom: 10px;">Persetujuan Peminjaman</h3>
        <span class="badge text-white px-3 py-2 rounded-pill" style="background:var(--pink-wara);">
            <?php echo mysqli_num_rows($query_pending); ?> Menunggu Persetujuan
        </span>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;" data-aos="fade-up">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Siswa</th>
                            <th>Buku</th>
                            <th>Tgl Pengajuan</th>
                            <th>Durasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(mysqli_num_rows($query_pending) > 0) {
                            while($p = mysqli_fetch_array($query_pending)) { 
                        ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold"><?php echo $p['nama']; ?></div>
                                <small class="text-muted"><?php echo $p['kelas']; ?></small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="../asset/img/buku/<?php echo $p['foto']; ?>" width="40" class="rounded me-2">
                                    <div>
                                        <div class="small fw-bold text-truncate" style="max-width: 200px;"><?php echo $p['judul']; ?></div>
                                        <small class="text-muted">Stok: <?php echo $p['stok_tersedia']; ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($p['tanggal_pinjam'])); ?></td>
                            <td>
                                <?php 
                                    $tgl1 = new DateTime($p['tanggal_pinjam']);
                                    $tgl2 = new DateTime($p['tanggal_jatuh_tempo']);
                                    $jarak = $tgl1->diff($tgl2);
                                    echo $jarak->d . " Hari";
                                ?>
                            </td>
                            <td class="text-center pe-4">
                                <a href="proses_setuju.php?id=<?php echo $p['id_pinjam']; ?>&id_buku=<?php echo $p['id_buku']; ?>" 
                                   class="btn btn-success btn-sm rounded-pill px-3" 
                                   onclick="return confirm('Setujui peminjaman ini? Stok buku akan berkurang.')">
                                    <i class="bi bi-check-lg"></i> Setujui
                                </a>
                                <a href="proses_tolak.php?id=<?php echo $p['id_pinjam']; ?>" 
                                   class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                    Tolak
                                </a>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else {
                            echo "<tr><td colspan='5' class='text-center py-5 text-muted'>Tidak ada antrean peminjaman.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>