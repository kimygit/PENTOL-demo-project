<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/login.css">
    <link rel="stylesheet" href="asset/css/base.css"> 
        <link rel="icon" type="image/svg+xml" href="asset/img/logo/logo.svg">
    <style>
        /* Tambahan CSS agar container lebih lebar tapi tetap rapi */
        .login-container {
            max-width: 800px; /* Diperlebar dari biasanya 400px */
            margin: 50px auto;
            padding: 40px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #555; }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-header text-center mb-4">
        <h2 class="fw-bold">Daftar Akun Baru</h2>
        <p class="text-muted">Lengkapi data untuk akses perpustakaan</p>
    </div>
    
    <form action="proses_tambahakunsiswa.php" method="POST">
        <div class="row">
            <div class="col-md-6 border-end pe-md-4">
                <h6 class=" mb-3 fw-bold small text-uppercase" style="color: var(--pink-wara);">Informasi Akun</h6>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Masukan username" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
                </div>
            </div>

            <div class="col-md-6 ps-md-4">
                <h6 class=" mb-3 fw-bold small text-uppercase" style="color: var(--pink-wara);">Data Diri</h6>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" placeholder="Nama lengkap" required>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-control" name="kelas" placeholder="Contoh: XIIRPL" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="number" class="form-control" name="no_hp" placeholder="08xxx" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="1" placeholder="Alamat rumah" required style="height: 58px;"></textarea>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" name="submit_daftar" class="btn btn-primary rounded-pill">Daftar Sekarang</button>
                </div>
                <div class="text-center mt-3">
                    <p class="small mb-0">Sudah punya akun? <a href="index.php" class="text-decoration-none fw-bold" style="color: #764ba2;">Masuk di sini</a></p>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>