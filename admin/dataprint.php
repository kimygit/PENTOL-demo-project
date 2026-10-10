<?php
include '../inc/koneksi.php';

// Ambil data dari filter
$tgl_mulai    = $_GET['tgl_mulai'] ?? '';
$tgl_selesai  = $_GET['tgl_selesai'] ?? '';
$id_anggota   = $_GET['id_anggota'] ?? '';
$filter_denda = $_GET['filter_denda'] ?? '';

// Query Dasar dengan filter status non-pending
$sql_text = "SELECT pengembalian.*, anggota.nama, anggota.kelas, buku.judul 
             FROM pengembalian 
             JOIN peminjaman ON pengembalian.id_pinjam = peminjaman.id_pinjam
             JOIN anggota ON peminjaman.id_anggota = anggota.id_anggota 
             JOIN detail_peminjaman ON peminjaman.id_pinjam = detail_peminjaman.id_pinjam
             JOIN buku ON detail_peminjaman.id_buku = buku.id_buku 
             WHERE pengembalian.status_kembali != 'pending'";

// Logika Filter
if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
    $sql_text .= " AND pengembalian.tanggal_kembali BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
}
if (!empty($id_anggota)) {
    $sql_text .= " AND peminjaman.id_anggota = '$id_anggota'";
}
if ($filter_denda == 'ada') {
    $sql_text .= " AND pengembalian.denda_total > 0";
}

$sql_text .= " ORDER BY pengembalian.tanggal_kembali DESC";
$query = mysqli_query($koneksi, $sql_text);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Print_Laporan_Pengembalian</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        
        .header { border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
        .header h2 { margin: 0; padding: 0; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th { padding: 10px; background-color: #eee; text-transform: uppercase; font-size: 11px; }
        td { padding: 8px; }
        
        .footer-table { width: 100%; margin-top: 30px; border: none; }
        .footer-table td { border: none; }
        
        @media print {
            .no-print { display: none; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header text-center">
        <h2>Laporan Pengembalian Buku</h2>
        <div style="font-size: 14px;">PERPUSTAKAAN PINTAR ONLINE</div>
        <div style="font-size: 11px;">Dicetak pada: <?= date('d/m/Y H:i:s'); ?></div>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Periode:</strong> <?= (!empty($tgl_mulai)) ? $tgl_mulai . " s/d " . $tgl_selesai : "Semua Data"; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Judul Buku</th>
                <th width="15%">Tgl Kembali</th>
                <th width="15%">Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $total_denda = 0;
            if(mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_array($query)) {
                    $total_denda += $row['denda_total'];
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td class="text-center"><?= $row['kelas']; ?></td>
                <td><?= $row['judul']; ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal_kembali'])); ?></td>
                <td class="text-right">Rp <?= number_format($row['denda_total'], 0, ',', '.'); ?></td>
            </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='6' class='text-center'>Data tidak ditemukan</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td colspan="5" class="text-right">TOTAL PENERIMAAN DENDA:</td>
                <td class="text-right">Rp <?= number_format($total_denda, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="no-print text-center" style="margin-top: 20px;">
        <button onclick="window.print()">Klik untuk Cetak</button>
    </div>

</body>
</html>