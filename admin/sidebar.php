<?php
$page = isset($_GET['link']) ? $_GET['link'] : 'dashboard';
?>

<aside class="bg-white border-end vh-100 shadow-sm" id="sidebar" style="width: 250px;">
  <div class="sidebar-header p-3 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <img src="../asset/img/logo/logo.svg" class="me-2" style="width: 30px;">
      <span class="brand-name fw-bold">PENTOL</span>
    </div>
  </div>
  
  <nav class="sidebar-nav mt-3">
    <div class="list-group list-group-flush">
      
      <a href="?link=dashboard" class="nav-link list-group-item list-group-item-action border-0 py-3 px-4 <?= ($page == 'dashboard') ? 'active' : ''; ?>">
        <i class="bi bi-grid me-3"></i>
        <span class="nav-text">Dashboard</span>
      </a>

      <span class="menu-label px-4 mt-3 mb-2 d-block text-muted small text-uppercase">Pages</span>

     <a href="?link=buku" class="list-group-item list-group-item-action border-0 py-3 px-4 <?= ($page == 'buku') ? 'active' : ''; ?>">
        <i class="bi bi-book me-3"></i>
        <span class="nav-text">kelola buku</span>
      </a>

      <a href="?link=anggota" class="list-group-item list-group-item-action border-0 py-3 px-4 <?= ($page == 'anggota') ? 'active' : ''; ?>">
        <i class="bi bi-person me-3"></i>
        <span class="nav-text">anggota</span>
      </a>

      <a href="?link=peminjaman" class="list-group-item list-group-item-action border-0 py-3 px-4 <?= ($page == 'peminjaman') ? 'active' : ''; ?>">
        <i class="bi bi-cart-plus me-3"></i>
        <span class="nav-text">peminjaman</span>
      </a>

      <a href="?link=pengembalian" class="list-group-item list-group-item-action border-0 py-3 px-4 <?= ($page == 'pengembalian') ? 'active' : ''; ?>">
        <i class="bi bi-arrow-return-left me-3"></i>
        <span class="nav-text">pengembalian</span>
      </a>

      <a href="?link=transaksi" class="list-group-item list-group-item-action border-0 py-3 px-4 <?= ($page == 'transaksi') ? 'active' : ''; ?>">
        <i class="bi bi-wallet2 me-3"></i>
        <span class="nav-text">Transaksi</span>
      </a>


    </div>
  </nav>
</aside>