<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/login.css">
    <link rel="stylesheet" href="asset/css/base.css"> 
    <link rel="icon" type="image/svg+xml" href="asset/img/logo/logo.svg">
</head>
<body>

<div class="login-container">
    <div class="login-header">
        <div class="row" >
            <div class="col-md-12">
            <img src="asset/img/logo/logo.svg" class="me-2 center" style="width: 100px;">
            </div>
            <div class="col-md-12">
            <span class="fw-bold fs-1" style="font-family: 'Gveret Levin', cursive; color: var(--pink-wara);">PENTOL</span>
            </div>
        </div>

        <h4><b>Perpustakaan Online</b></h4>
    </div>
    
    <form action="inc/proslog.php" method="POST">
        <div class="mb-3">
            <label for="Username" class="form-label">Username</label>
            <input type="text" class="form-control" id="Username" name="Username" placeholder="masukan username" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
        </div>
        
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Masuk Sekarang</button>
        </div>
        
        <div class="text-center mt-4">
            <p class="small mb-0">Belum punya akun? <a href="tambah_akunsiswa.php" class="text-decoration-none fw-bold" style="color: #764ba2;">Daftar</a></p>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>