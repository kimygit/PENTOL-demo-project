<?php
// Ambil data buku
$query_buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE stok_tersedia > 0");
?>

<div class="container-fluid mt-4">
    <div class="row justify-content-center mb-5" data-aos="fade-down">
        <div class="col-md-8 text-center">
            <h2 class="fw-bold mb-3">Katalog Buku Perpustakaan</h2>
            <div class="search-container shadow-sm">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="searchInput" class="form-control-search" placeholder="Cari judul buku atau penulis...">
            </div>
        </div>
    </div>

    <div class="row px-3" id="bookContainer">
        <?php while($row = mysqli_fetch_array($query_buku)) { ?>
        
        <div class="col-md-4 col-md-4 col-lg-3 col-xl-2 mb-5 book-item" data-aos="fade-up">
            <div class="card-book-wrapper">
                <div class="card-book shadow">
                    <div class="badge-stok"><?php echo $row['stok_tersedia']; ?> Qty</div>
                    
                    <div class="cover-wrapper">
                        <img src="../asset/img/buku/<?php echo $row['foto']; ?>" alt="Cover">
                        <div class="overlay-pinjam">
                            <button type="button" class="btn-pinjam border-0" data-bs-toggle="modal" data-bs-target="#modalPinjam<?php echo $row['id_buku']; ?>">
                                <i class="bi bi-plus-lg"></i> Pinjam
                            </button>
                        </div>
                    </div>

                    <div class="book-info text-center p-3">
                        <h6 class="book-title mb-1 text-dark fw-bold"><?php echo $row['judul']; ?></h6>
                        <p class="book-author text-muted small mb-0"><?php echo $row['pengarang']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPinjam<?php echo $row['id_buku']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="tambahpinjam.php" method="POST">
                        <div class="modal-body text-center pb-4">
                            <img src="../asset/img/buku/<?php echo $row['foto']; ?>" width="100" class="rounded shadow-sm mb-3">
                            <h5 class="fw-bold mb-1"><?php echo $row['judul']; ?></h5>
                            <p class="text-muted small mb-4">Maksimal peminjaman adalah 7 hari.</p>
                            
                            <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">

                            <label class="fw-bold mb-2 small text-uppercase text-secondary">stok tersedia</label>
                            <div class="form-group px-4">
                            <label class="fw-bold mb-2 small text-uppercase text-dark"><?php echo $row['stok_tersedia']; ?></label>
                            </div>
                            <div class="form-group px-4">
                                <label class="fw-bold mb-2 small text-uppercase text-secondary">Durasi Pinjam</label>
                                <select name="durasi" class="form-select form-select-lg text-center" style="border-radius: 15px; border: 2px solid #ff6363;" required>
                                    <option value="1">1 Hari</option>
                                    <option value="2">2 Hari</option>
                                    <option value="3">3 Hari</option>
                                    <option value="4">4 Hari</option>
                                    <option value="5">5 Hari</option>
                                    <option value="6">6 Hari</option>
                                    <option value="7">7 Hari</option>
                                </select>
                            </div>
                        </div>
                            <div class="modal-footer border-0 justify-content-center pb-5">
                                <button type="submit" name="submit_pinjam" class="btn btn-custom text-white px-5 py-2 rounded-pill fw-bold shadow" style="background-color:#ff6363">
                                    Ajukan Peminjaman Sekarang
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<style>
    /* Style yang kamu punya tetap dipakai, tambahkan sedikit untuk modal */
    body { background-color: #f0f2f5; font-family: 'Poppins', sans-serif; }
    .card-book-wrapper { perspective: 1000px; }
    .card-book {
        background: #fff; border-radius: 12px; overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .cover-wrapper {
        position: relative; width: 100%; aspect-ratio: 2 / 3;
        overflow: hidden; background: #e9ecef;
    }
    .cover-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .card-book:hover { transform: translateY(-10px) rotateY(5deg); box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important; }
    .card-book:hover img { transform: scale(1.1); }
    .overlay-pinjam {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.4); display: flex; justify-content: center; align-items: center;
        opacity: 0; transition: opacity 0.3s ease;
    }
    .card-book:hover .overlay-pinjam { opacity: 1; }
    .btn-pinjam { background: #fff; color: #ff6363; padding: 8px 20px; border-radius: 25px; text-decoration: none; font-weight: 600; transition: 0.3s; }
    .btn-pinjam:hover { background: #ff6363; color: #fff; }
    .badge-stok {
        position: absolute; top: 10px; left: 10px;
        background: #ff6363; color: white; padding: 2px 10px;
        border-radius: 20px; font-size: 0.7rem; z-index: 5;
    }
    .search-container { position: relative; max-width: 500px; margin: 0 auto; background: #fff; border-radius: 50px; padding: 5px; }
    .search-icon { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #ff6363; }
    .form-control-search { border: none; padding: 12px 20px 12px 50px; border-radius: 50px; width: 100%; outline: none; }
</style>

<script>
    // Live Search Tetap Berjalan
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let items  = document.querySelectorAll('.book-item');
        items.forEach(function(item) {
            let title  = item.querySelector('.book-title').innerText.toLowerCase();
            let author = item.querySelector('.book-author').innerText.toLowerCase();
            if (title.includes(filter) || author.includes(filter)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });
</script>