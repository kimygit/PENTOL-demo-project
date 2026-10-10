<?php
ob_start();
session_start();
include '../inc/koneksi.php';

if($_SESSION['role']!="admin"){
    //header("location:../index.php");
    echo "<script>
            alert('Akses ditolak. Anda bukan owner!'); 
            window.location.href='../index.php';
          </script>";
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include '../inc/header.php'; ?>


<link rel="icon" type="image/svg+xml" href="../asset/img/logo/logo.svg">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
     
<link rel="stylesheet" href="../asset/css/base.css" />
<link rel="stylesheet" href="../asset/css/sidebar.css" />
<link rel="stylesheet" href="../asset/css/topbar.css" />
<link rel="stylesheet" href="../asset/css/admin/table_pengguna.css" />
    <title>Kasir Dashboard</title>
  </head>
  <body>
<div class="container-fluid p-0">
  <div class="d-flex" id="main-wrapper">

  <?php include 'sidebar.php'; ?>

    <main class="flex-grow-1 bg-light">

    <?php include 'topbar.php'; ?>

      <section class="p-4">

    <?php 
    switch (@$_GET['link']) {

          /* anggota */

        case 'anggota':
            include 'anggota.php';
            break;

        case 'editanggota':
            include 'editanggota.php';
            break;

        /* buku */
          case 'buku':
            include 'buku.php';
            break;

        case 'editbuku':
            include 'editbuku.php';
            break;

      /* transaksi */
          case 'transaksi':
            include 'transaksi.php';
            break;

          case 'pengembalian':
            include 'pengembalian.php';
            break;

          case 'peminjaman':
            include 'peminjaman.php';
            break;

        /* dashboard */
        default:   
        case 'dashboard': 
            include 'dashboard.php';
            break;
    }
    ?>
    
      </section>
    </main>

  </div>
</div>

    <?php include '../inc/footer.php'; ?>
    <script src="../asset/js/navbar.js"></script>

  </body>
</html>
