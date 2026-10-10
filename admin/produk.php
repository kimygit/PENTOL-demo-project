
<h3 style="color: #ff896c; padding-bottom: 10px;">Produk</h3>
<div class="card border-0 shadow-sm p-4" data-aos="fade-up" style="border-radius: 20px;">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <h5 class="fw-bold text-navy mb-0">Data Produk</h5>

        <div class="d-flex align-items-center gap-2">
            <div class="input-group input-group-sm" style="width: 250px;">
                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="searchProduk" class="form-control border-start-0" placeholder="Cari produk..." style="border-radius: 0 10px 10px 0;">
            </div>
  
        </div>
    </div>

    <table id="tabelProduk" class="table table-hover" style="width:100%">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Foto</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            // Sesuaikan nama tabel database kamu, misal: 'produk'
            $query = mysqli_query($koneksi, "SELECT * FROM produk");
            while($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr class="align-middle">
                <td><?= $no++; ?></td>
                <td><?= $row['ProdukID']; ?></td>
                <td>
                    <img src="../asset/img/produk/<?= $row['foto']; ?>" width="80" height="80" style="border-radius: 5px; object-fit: cover;">
                </td>
                <td><?= $row['NamaProduk']; ?></td>
                <td>Rp <?= number_format($row['Harga'], 0, ',', '.'); ?></td>
                <td>
                    <span class="badge bg-light text-dark border"><?= $row['Stok']; ?></span>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
$(document).ready(function() {
    var tableProduk = $('#tabelProduk').DataTable({
        "responsive": true,
        "paging": false,
        "info": true,
        "dom": "rti",
        "bFilter": true,
        "language": {
            "info": "Showing _TOTAL_ products",
            "zeroRecords": "Produk tidak ditemukan"
        }
    });

    $('#searchProduk').on('keyup', function() {
        tableProduk.column(3).search($(this).val()).draw(); // Column index 2 adalah Nama Produk
    });
});
</script>